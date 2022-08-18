<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantHelpService extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_merchant_help";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'client_code',
        'merchant_code',
        'service_code',
        'help_order',
    ];
}
