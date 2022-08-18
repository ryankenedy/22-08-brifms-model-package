<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCicilanMaster extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "cicilan_store_master";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'store_code',
        'acquiring_code',
        'version',
    ];
}
