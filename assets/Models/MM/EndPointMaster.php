<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EndPointMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_endpoint";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'url_server',
        'port'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-endpoint.update'),
                'link' => route('endpoint.edit',$this->id),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-endpoint.delete'),
                'link' => route('endpoint.destroy',$this->id)
            ]
        ];
    }
}
