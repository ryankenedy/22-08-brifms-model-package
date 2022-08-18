<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantCicilanMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "cicilan_merchant_master";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'acquiring_code',
        'version',
    ];
}
