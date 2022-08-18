<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDenomMaster extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "denom_master_store";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'store_code',
        'acquiring_code',
        'feature_code',
        'denom_group_name'
    ];
}
