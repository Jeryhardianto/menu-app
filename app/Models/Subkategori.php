<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subkategori extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'subkategori';
    protected $guarded = ['id'];

    public function GetKategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

}
