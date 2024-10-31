<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    use HasFactory;
    protected $table = "transaksi";
    protected $primaryKey = "id_transaksi"; 
    public $timestamps = false;

    protected $fillable = [
        'tgl_transaksi', 'id_user', 'id_meja', 'nama_pelanggan', 'status'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(detail_transaksiModel::class, 'id_transaksi', 'id_transaksi'); 
    }
}
