<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigureMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "master_configure";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'mk',
        'wk',
        'aid',
        'capk',
        'ltmk_acq_id',
        'acq_id',
        'vendor_id',
        'ltwk_id',
        'merchant_code',
        'acquiring_code',
    ];
    
}
