<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\transaksiModel;
use App\Models\detail_transaksiModel;
use App\Models\menuModel; 

class TransksiController extends Controller
{
    public function createTransaction(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'id_user' => 'nullable|exists:user,id_user',  
            'id_meja' => 'required|exists:meja,id_meja',
            'menus' => 'required|array', 
            'menus.*.id_menu' => 'required|exists:menu,id_menu',
        ]);

        // Gunakan DB Transaction
        DB::beginTransaction();

        try {
            // Buat transaksi
            $transaksi = transaksiModel::create([
                'tgl_transaksi' => now(),
                'nama_pelanggan' => $validatedData['nama_pelanggan'],
                'status' => 'belum_bayar',
                'id_user' => $validatedData['id_user'] ?? null,  
                'id_meja' => $validatedData['id_meja'],
            ]);

            // Cek jika transaksi berhasil
            if (!$transaksi) {
                throw new \Exception("Transaksi tidak berhasil dibuat.");
            }

            // Buat detail transaksi
            foreach ($validatedData['menus'] as $menu) {
                // Cari harga dari tabel menu berdasarkan id_menu
                $menuData = menuModel::findOrFail($menu['id_menu']); 

                detail_transaksiModel::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_menu' => $menu['id_menu'],
                    'harga' => $menuData->harga ?? 0,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Transaksi berhasil dibuat', 'transaksi' => $transaksi], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal membuat transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function getbystatus(Request $req){

        $status =$req->input("status");

        $data= transaksiModel::where('status',$status)->get();

        if (!$data) {
            return response()->json(["error"=>"Gagal"]);
        }

        return response()->json($data);
    }

    function updateStatusTransaksi(Request $req, $id){
        
   
        $post=transaksiModel::where('id_transaksi', $id);

        if (!$post) {
          return response()->json(["error"=>"user tidak ditemukan"]);
        }
        else {
           $post->update([
               "status"=>"lunas"
           ]);
        }

       
   return response()->json(['message' =>'data berhasil diupdate'], 200);
  
}
}


