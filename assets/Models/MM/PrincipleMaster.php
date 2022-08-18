<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrincipleMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_principle";
    protected $primaryKey = 'principle_id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'principle_id',
        'principle_name'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-principle.update'),
                'link' => route('principle.edit',[
                    'principle' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-principle.delete'),
                'link' => route('principle.destroy',[
                    'principle' => $this
                ])
            ]
        ];
    }
}
