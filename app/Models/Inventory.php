<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventorys';
    protected $fillable = ['tanggal', 'nama_barang', 'kategori', 'jumlah'];
}
