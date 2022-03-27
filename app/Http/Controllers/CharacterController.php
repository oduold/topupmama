<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;;
use App\Models\Character;

class CharacterController extends Controller {
   
    
    public function deleteCharacter($id) {
        try {
            Character::findOrFail($id)->delete();
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