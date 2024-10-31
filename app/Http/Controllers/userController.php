<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    function updateUser(Request $req, $id, User $userCon){
        
        $validator= Validator::make($req->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }

            $post=User::where('id', $id)->update([
                'name' =>$req->name,
                'email' =>$req->email,
                'password' =>$req->password,
                'role' =>$req->role,
            ]);

            
       
        return response()->json(['message' =>'data berhasil diupdate'], 200);
       
    }

    public function deleteUser($id){

        $user = User::where('id',$id)->delete();

        if ($user) {
           return response()->json(['message'=>'data berhasil dihapus'], 200);
        }
        else{
            return response()->json(['message'=>'data tidak ditemukan'], 404);
        }
        

        
    }
  
}
