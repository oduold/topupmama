<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;
use App\Models\Comment;

class CommentController extends Controller {
    
    
    public function deleteComment($id) {
        try {
            Comment::findOrFail($id)->delete();
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());
            return response("resource not found",404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response("resource not found",404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        }
        return response('Deleted Successfully', 200);
    }    
}