<?php

namespace App\Models;

use App\Models\Subkategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return image_url($this->gambar, 'image/menu-default.svg');
    }

    public function GetSubkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori', 'id');
    }
}
