<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksiModel extends Model
{
    use HasFactory;
    protected $table = "detail_transaksi";
    protected $primaryKey = "id_detail_transaksi"; 
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi', 'id_menu', 'harga'
    ];

    public function transaksi()
    {
        return $this->belongsTo(transaksiModel::class, 'id_transaksi', 'id_transaksi'); 
    }
}
