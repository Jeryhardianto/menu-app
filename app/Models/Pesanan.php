<?php


namespace App\Models;


use App\Models\User;
use App\Models\Status;
use App\Models\DetailPesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function statusLabel()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}