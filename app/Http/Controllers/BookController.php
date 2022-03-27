<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Symfony\Component\String\b;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Character;
use App\Models\Author;

class BookController extends Controller {
    
    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function books(Request $request) {
        Log::info('retrieving list of books');
        $books = Book::select('id','title','release_date')
            ->with('authors:id','authors:name')
            ->withCount('comments')
            ->get()->sortBy('release_date')->values()->all();
        return response()->json($books);
    }

    /**
     * 
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse
     */
    public function book($id) {
        $book = Book::select('id','title','release_date')
        ->where('id','=',$id)
        ->with('authors:id','authors:name')
        ->withCount('comments')->get();
        Log::info("book", ['book' => $book]);
        if($book->isEmpty()) {
            return response('book not found',404);
        }
        return response()->json($book);
    }
    
    /**
     *  
     * @param int $id
     * @throws NotFoundHttpException
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function bookComments($id) {
        try {
            $book = Book::find($id);
            if(!$book) {
                throw new NotFoundHttpException('book not found');
            }
            $book->load(['comments' => function($query) {$query->orderBy('updated_at','desc');}]);
            $comments = $book->comments;
            Log::info('comments', ['comments' => $comments]);
            return response()->json($book->comments);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(),404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        }
    }
    
    /** 
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse
     */
    public function bookCharacters(Request $request,$id) {
        try {
            $book = Book::find($id);
            if(!$book) {
               throw new NotFoundHttpException('book not found');
            }
            $book->load(['characters' => function($query){
                $query->orderBy('name');
            },'characters.gender:id,gender_type']);
            /** @var Collection $characters */
            $characters = $book->characters;
            if($request->has('filter')) {
                $filter = $request->input('filter');
                if(!empty($filter)) {
                    Log::info('filtering collection by : ',  ['filter' => $filter]);
                    /** @var $value Character **/
                    $characters = $characters->filter(function($value,$key) use ($filter) {
                        return  $value->gender->gender_type === $filter;
                    });
                }
            }
            $sort = 'name';
            if($request->has('sort')) {
                if(!empty($sort)) {
                    $sort = $request->input('sort');
                    Log::info('sorting collection by : ',  ['sort' => $sort]);
                    $characters = $characters->sortBy(function($query) use ($sort) {
                        return $query->orderBy($sort);
                    });
                }
            }
            $characters = $characters->all();            
            return response()->json($characters);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(),404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        }        
    }
    
    
    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        Log::info('request',['request' => $request->all()]);
        //find if book with same title exists
        $bookQuery = Book::query();
        $book = $bookQuery->where('title','=',$request->input('title'))->first();
        if($book) {
            return response()->json('Conflict Book exists',409);
        }
        /** @var Book $book **/
        $book = Book::create($request->all());        
        $authors = $request->input('authors');
        Log::info('book',['book' => $book, 'authors' => $authors]);
        foreach ($authors as $authorName) {
            $q = Author::query();
            /** @var Author $author **/
            $author = $q->firstWhere('name','=',$authorName);
            Log::info('author',['author' => $author]);
            if(!$author) {
                /** @var Author $author **/
                $author = new Author(['name' => $authorName['name']]);
                $author->save();
                Log::info('author',['author' => $author]);
            }            
            $book->authors()->attach($author->id);
         }
         $book->with('author');
        return response()->json($book, 201);
    }
    
    public function update($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        
        return response()->json($book, 200);
    }
    
    public function delete($id)
    {
        Book::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}