<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalActivity extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "terminal_log_user";
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function terminal()
    {
        return $this->hasOne(TerminalMaster::class, 'id_terminal', 'poi');
    }
}
