<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'detail_pesanans';
    protected $guarded = ['id'];


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

}
