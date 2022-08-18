<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabKotMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "regencies";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function provinsi()
    {
        return $this->hasOne(ProvinsiMaster::class, 'id','province_id')->withDefault([
            'name' => null
        ]);
    }
}
