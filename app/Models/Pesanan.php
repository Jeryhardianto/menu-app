<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Pesanan extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'string',
        'id_pengguna' => 'string',
        'id_status' => 'integer',
        'nomor_meja' => 'integer',
        'total' => 'integer',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}