<?php

namespace App\Models\IAM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql_iam';
    protected $table = "rolemaster";
    protected $primaryKey = 'rm_id';
    public $timestamps = false;

    protected $with = ['details'];

    protected $fillable = [
        'rm_name',
        'rm_description',
        'owner_code',
        'company_code',
        'client_code',
        'merchant_code',
        'store_code',
        'su',
    ];

    protected $casts = [
        'su' => 'boolean',
    ];

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => Auth::user()->hasPermission('role.read'),
                'link' => route('role.show',$this->rm_id)
            ],
            'edit' => [
                'isCan' => Auth::user()->hasPermission('role.update'),
                'link' => route('role.edit',$this->rm_id),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('role.delete'),
                'link' => route('role.destroy',$this->rm_id)
            ]
        ];
    }

    public function details()
    {
        return $this->hasMany(RoleDetail::class, 'rm_id', 'rm_id');
    }
}
