<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHelpService extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_client_help";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'company_code',
        'client_code',
        'service_code',
        'help_order',
    ];
}
