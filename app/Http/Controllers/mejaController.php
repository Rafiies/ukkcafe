<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\mejaModel as meja;

class mejaController extends Controller
{
    function getMeja(){
        $data=meja::all();

        return response()->json([
        'data_meja' => $data
        ],200);
    }

    function addMeja(Request $req){

        $validator= Validator::make($req->all(),[
            'nomor_meja' => 'required',
    
        ]);
    
        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }
    
    
        $post=meja::create([
            'nomor_meja' => $req->nomor_meja,
        ]);
    
       
    
        return response()->json('Meja Berhasil Ditambahkan', 200);
    }
    
    function updateMeja(Request $req, $id, meja $mejaCon){
        
        $validator= Validator::make($req->all(),[
            'nomor_meja' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }

            $post=meja::where('id_meja', $id)->update([
                'nomor_meja' =>$req->nomor_meja,
            ]);
       
        return response()->json(['message' =>'data berhasil diupdate'], 200);
       
    }

    public function deleteMeja($id){

        $menu = meja::where('id_meja',$id)->delete();

        if ($menu) {
           return response()->json(['message'=>'data berhasil dihapus'], 200);
        }
        else{
            return response()->json(['message'=>'data tidak ditemukan'], 404);
        }
        

        
    }
}

