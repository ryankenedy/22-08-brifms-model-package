<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalTID extends Model
{
    use HasFactory, ModelTrait;
    
    protected $connection = 'mysql';
    protected $table = "master_terminal_tid";
    protected $primaryKey = 'tid_id';
    public $timestamps = false;

    protected $fillable = [
        'tid_poi',
        'tid_acquiring_code',
        'tid_tid',
        'tid_creted_at',
    ];
}
