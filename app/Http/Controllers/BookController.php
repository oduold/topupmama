<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookComments($id) {
        try {
            $book = Book::select('id','title','release_date')
            ->where('id','=',$id)->with('comments')->get();
            if($book->isEmpty()) {
                throw new NotFoundHttpException('book not found');
            }
            $comments = $book->pluck('comments')->flatten()->sortByDesc('updated_at')->values()->all();
            return response()->json($comments);
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
            $book = Book::select('id','title','release_date')
            ->where('id','=',$id)->with('characters')->get();
            if($book->isEmpty()) {
                throw new NotFoundHttpException('book not found');
            }
            $sort = 'name';
            if($request->has('sort')) {
                $sort = $request->input('sort');
            }
            $characters = $book->pluck('characters')->flatten()->sortBy($sort)->values()->all();
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