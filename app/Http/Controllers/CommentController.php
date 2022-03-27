<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PhpParser\Comment;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller {
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Request $request) {
        Log::info('retrieving list of comments');
        $comments = Comment::select('id','comment','ip','updated_at')
        ->with('book:id','book:title')
        ->get()->sortBy('updated_at',SORT_NATURAL,true)->values()->all();
        return response()->json($comments);
    }    
}