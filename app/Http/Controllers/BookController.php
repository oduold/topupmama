<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Symfony\Component\String\b;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Character;

class BookController extends Controller {
    public function __construct() { 
    }
    
    
    /**
     * @OA\Get(
     *  path="/api/v1/books",
     *  operationId="books",
     *  summary="Get List of Books",
     *  tags={"books"},
     *  @OA\Response(response=200,description="List of books")
     * )
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function books(Request $request) {
        $books = Book::select('id','title','release_date')
            ->with('authors:id','authors:name')
            ->withCount('comments')
            ->get()->sortBy('release_date')->values()->all();
        return response()->json($books);
    }

    /**
     * @OA\Get(path="/api/v1/books/{id}",operationId="book",tags={"book"},
     *  @OA\Parameter(name="id",in="path",required=true,@OA\Schema(type="integer")),
     *  @OA\Response(response="200",description="get book"),
     *  @OA\Response(response=404,description="Book not found"),
     * )
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
     * @OA\Get(path="/api/v1/books/{id}/comments",operationId="bookComments",tags={"book"},
     *  @OA\Parameter(name="id",in="path",required=true,@OA\Schema(type="integer")),
     *  @OA\Response(response="200",description="get book comments"),
     *  @OA\Response(response=404,description="Book not found"),
     * )
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
     * @OA\Get(path="/api/v1/books/{id}/characters",operationId="bookCharacters",tags={"book"},
     *  @OA\Parameter(name="id",in="path",required=true,@OA\Schema(type="integer")),
     *  @OA\Parameter(name="sort",in="query",description="sort according to name,age,gender",required=false,
     *      @OA\Schema(type="array",@OA\Items(type="string",enum={"name","age","gender"}))),
     *  @OA\Parameter(name="filter",in="query",description="filter according to gender",required=false,
     *      @OA\Schema(type="array",@OA\Items(type="string",enum={"Male","Female","Other"}))
     *      ),
     *  @OA\Response(response="200",description="get book characters"),
     *  @OA\Response(response=404,description="Book not found"),
     * )
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
    
    
    public function create(Request $request)
    {
        $book = Book::create($request->all());
        
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