<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HelpServiceMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "master_help_services";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'help_key',
        'version',
        'is_active'
    ];

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 8, 'prefix' => "HS"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-help-service.update'),
                'link' => route('help-service.edit',$this),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-help-service.delete'),
                'link' => route('help-service.destroy',$this)
            ]
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
