<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Models\Comment;

class BookController extends Controller {
    
    public function __construct() { 
    }
    
    public function books(Request $request) {
        $books = Book::select('id','title')->with('authors:id','authors:name')->withCount('comments')->get()->sortBy('release_date');
        return response()->json($books);
    }

    public function book($id) {
        $book = Book::select('id','title')->where('id','=',$id)->with('authors:id','authors:name')->withCount('comments')->get()->sortBy('release_date');
        return response()->json($book);
    }
    
    public function bookComments($id) {
        $q = Comment::query();
        $comments = $q->where('book_id','=',$id)->get()->sortByDesc('updated_at');
        return response()->json($comments);
    }
    
    public function bookCharacters(Request $request,$id) {
        $q = Character::query();
        $sort = $request->input('sort');
        $characters = $q->where('book_id','=',$id)->get();        
        return response()->json($characters);
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