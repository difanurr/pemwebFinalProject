<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['id_barang', 'nama_barang', 'harga'];
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    // public $timestamps = false;
}
