<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecamatanMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "districts";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'regency_id',
        'name'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function kabkot()
    {
        return $this->hasOne(KabKotMaster::class, 'id','regency_id')->withDefault([
            'name'
        ]);
    }
}
