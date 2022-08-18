<?php

namespace App\Models\IAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql_iam';
    protected $table = "roledetail";
    protected $primaryKey = 'rd_id';
    public $timestamps = false;

    protected $with = ['form'];

    protected $fillable = [
        'rm_id',
        'form_id',
        'rd_create',
        'rd_read',
        'rd_update',
        'rd_delete',
    ];

    protected $casts = [
        'rd_create'   => 'boolean',
        'rd_read'     => 'boolean',
        'rd_update'   => 'boolean',
        'rd_delete'   => 'boolean',
    ];

    public function form()
    {
        return $this->hasOne(Form::class,'form_id','form_id')->withDefault([
            'form_name' => null
        ]);
    }

    public function role()
    {
        return $this->hasOne(RoleMaster::class, 'rm_id','rm_id')->withDefault([
            'rm_name' => null
        ]);
    }
}
