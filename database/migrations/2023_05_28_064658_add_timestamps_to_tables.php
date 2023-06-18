<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->timestamps();
        });

        DB::table('barang')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customer')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('transaksi')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_transaksi')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang,customer,transaksi,detail_transaksi', function (Blueprint $table) {
            //
        });
    }
};
