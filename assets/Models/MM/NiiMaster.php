<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NiiMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_nii";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'issuer_code',
        'nii_key',
        'dev_non_tle',
        'prod_non_tle',
        'dev_tle',
        'prod_tle',
        'description',
        'is_active',
        'is_tle',
        'is_prod',
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-nii.update'),
                'link' => route('nii.edit',['issuer' => $this->issuer, 'nii' => $this]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-nii.delete'),
                'link' => route('nii.destroy',['issuer' => $this->issuer, 'nii' => $this])
            ]
        ];
    }

    public function issuer()
    {
        return $this->hasOne(IssuerMaster::class, 'issuer_code', 'issuer_code')->withDefault([
            'issuer_code' => null
        ]);
    }
}
