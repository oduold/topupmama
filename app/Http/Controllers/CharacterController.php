<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;;
use App\Models\Character;

class CharacterController extends Controller {
   
    /**
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function deleteCharacter($id) {
        try {
            Character::findOrFail($id)->delete();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response("resource not found",404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('server error',500);
        }
        return response('Deleted Successfully', 200);
    }
    
    /**
     * TODO update character operation
     *
     * @param integer $id
     */
    public function updateCharacter($id) {
        
    }
}