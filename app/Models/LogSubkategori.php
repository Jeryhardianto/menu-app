<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSubkategori extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'log_subkategori';

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
