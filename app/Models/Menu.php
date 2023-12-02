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

    public function GetSubkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori', 'id');
    }
}
