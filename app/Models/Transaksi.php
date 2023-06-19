<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['tanggal', 'id_customer'];
    protected $guarded = ['id_transaksi'];
    protected $primaryKey = 'id_transaksi';

    public function isBeingUsed() {
        return Transaksi::where('id_transaksi', $this->id_transaksi)->exists();
    }
}
