<?php

namespace App\Models\UM;

use Illuminate\Support\Str;
use App\Models\IAM\RoleMaster;
use App\Models\MS\ServicePoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CI_Admin extends Authenticatable
{
    use HasFactory;

    protected $connection = 'mysql_um';
    protected $table = "ci_admin";
    protected $primaryKey = 'admin_id';

    protected $with = ['role', 'role.details'];

    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'mobile_no',
        'password',
        'password_expired',
        'last_login',
        'invalid_count',
        'is_verify',
        'is_admin',
        'is_active',
        'is_supper',
        'token',
        'token_expired',
        'token_updated_at',
        'password_reset_code',
        'last_ip',
        'created_at',
        'updated_at',
        'id_service_point',
        'rm_id',
        'admin_role_id'
    ];

    protected $casts = [
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'password_expired'  => 'date',
        'last_login'        => 'datetime',
        'is_verify'         => 'boolean',
        'is_admin'          => 'boolean',
        'is_active'         => 'boolean',
        'is_supper'          => 'boolean',
    ];
    
    protected $hidden = [
        'password',
    ];

    public function getFullNameAttribute($value)
    {
        return $this->firstname." ".$this->lastname;
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' =>request()->user()->hasPermission('user.read'),
                'link' => route('user.show',$this),
            ],
            'edit' => [
                'isCan' =>request()->user()->hasPermission('user.update'),
                'link' => route('user.edit',$this),
            ],
            'delete' => [
                'isCan' =>request()->user()->hasPermission('user.delete') && $this->username != "superadmin",
                'link' => route('user.destroy',$this)
            ]
        ];
    }

    public function role()
    {
        return $this->hasOne(RoleMaster::class, 'rm_id','admin_role_id')->withDefault([
            'rm_name' => ''
        ]);
    }

    public function servicePoint()
    {
        return $this->hasOne(ServicePoint::class, 'id', 'id_service_point')->withDefault([
            'name' => '-'
        ]);
    }

    public function hasPermission($guard)
    {
        $guards = explode('.',$guard);
        if(count($guards) == 2){
            if($this->is_supper == true || $this->role->su == true){
                return true;
            }
            $role = $this->role->details->contains(function ($value, $key) use ($guards) {
                $action = false;
                if($guards[1] == 'create'){
                    $action = $value->rd_create;
                }
                else if($guards[1] == 'read'){
                    $action = $value->rd_read;
                }
                else if($guards[1] == 'update'){
                    $action = $value->rd_update;
                }
                else if($guards[1] == 'delete'){
                    $action = $value->rd_delete;
                }
                return Str::replace(" ", "-", Str::upper($value->form->form_name)) == Str::upper($guards[0]) && $action;
            });
            return $role;
        }
        return false;
    }
}
