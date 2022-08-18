<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHelpService extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_company_help";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'company_code',
        'service_code',
        'help_order',
    ];
}
