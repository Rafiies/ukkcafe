<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mejaModel extends Model
{
    use HasFactory;
    protected $table="meja";
    protected $primaryKey="id_meja";
    protected $fillable = [
        'nomor_meja'
    ];
    public $timestamps=false;
}
