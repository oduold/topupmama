<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PhpParser\Comment;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CharacerController extends Controller {
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCharacter(Request $request) {
    }    
}