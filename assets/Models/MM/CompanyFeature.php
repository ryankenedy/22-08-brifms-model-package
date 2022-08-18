<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyFeature extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_company_features";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'company_code',
        'acquiring_code',
        'features_code',
    ];
}
