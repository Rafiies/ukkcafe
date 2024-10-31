<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\menuModel as menu;

class menuController extends Controller
{
    function getMenu(){
        $data=menu::all();

        return response()->json([
        'data_menu' => $data
        ],200);
    }

    function addMenu(Request $req){

        $validator= Validator::make($req->all(),[
            'nama_menu' => 'required',
            'jenis' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,svg,gif|max:10000',
            'harga' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }

        $image = $req->file('gambar');
        $image -> storeAs('public/gambar',$image->hashName());

        $post=menu::create([
            'nama_menu' =>$req->nama_menu,
            'jenis' =>$req->jenis,
            'deskripsi' =>$req->deskripsi,
            'harga' => $req->harga ?? 0,
            'gambar' =>$image->hashName()
        ]);

       

        return response()->json('Menu Berhasil Ditambahkan', 200);
    }

    function updateMenu(Request $req, $id, menu $menuCon){
        
        $validator= Validator::make($req->all(),[
            'nama_menu' => 'required',
            'jenis' => 'required',
            'deskripsi' => 'required',
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,svg,gif|max:10000',
            'harga' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }

        if ($req->hasFile('gambar')) {
            $image = $req->file('gambar');
            $image -> storeAs('public/gambar',$image->hashName());

            Storage::delete(['public/gambar'.$menuCon->gambar]);

            $post=menu::where('id_menu', $id)->update([
                'nama_menu' =>$req->nama_menu,
                'jenis' =>$req->jenis,
                'deskripsi' =>$req->deskripsi,
                'harga' =>$req->harga,
                'gambar' =>$image->hashName()
            ]);
        }
        else{
             $post=menu::where('id_menu', $id)->update([
                'nama_menu' =>$req->nama_menu,
                'jenis' =>$req->jenis,
                'deskripsi' =>$req->deskripsi,
                'harga' =>$req->harga,
            ]);
        }
       
        return response()->json(['message' =>'data berhasil diupdate'], 200);
       
    }

    public function deleteMenu($id){

        $menu = menu::where('id_menu',$id)->delete();

        if ($menu) {
           return response()->json(['message'=>'data berhasil dihapus'], 200);
        }
        else{
            return response()->json(['message'=>'data tidak ditemukan'], 404);
        }
        

        
    }
  
}
