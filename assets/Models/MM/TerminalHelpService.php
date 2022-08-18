<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalHelpService extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_terminal_help";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'store_code',
        'poi',
        'service_code',
        'help_order',
    ];
}
