<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantDenomMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "denom_master_merchant";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'acquiring_code',
        'feature_code',
        'denom_group_name'
    ];
}
