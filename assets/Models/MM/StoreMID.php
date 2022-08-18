<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreMID extends Model
{
    use HasFactory, ModelTrait;
    protected $connection = 'mysql';
    protected $table = "master_store_mid";
    protected $primaryKey = 'mid_id';
    public $timestamps = false;

    protected $fillable = [
        'mid_store_code',
        'mid_acquiring_code',
        'mid_mid',
        'mid_creted_at',
    ];

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code', 'mid_acquiring_code')->withDefault([
            'acquiring_code' => null,
            'acquiring_name' => null
        ]);
    }
}
