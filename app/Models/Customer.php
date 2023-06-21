<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = ['id_customer', 'nama_customer', 'no_telp', 'alamat'];
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    // public function isBeingUsed() {
    //     return Customer::where('id_customer', $this->id_customer)->exists();
    // }
}
