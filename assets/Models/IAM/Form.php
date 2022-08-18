<?php

namespace App\Models\IAM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $connection = 'mysql_iam';
    protected $table = "form";
    protected $primaryKey = 'form_id';
    public $timestamps = false;

    protected $fillable = [
        'form_name',
        'form_description',
        'form_create',
        'form_read',
        'form_update',
        'form_delete',
        'site_id',
    ];

    protected $casts = [
        'form_create'   => 'boolean',
        'form_read'     => 'boolean',
        'form_update'   => 'boolean',
        'form_delete'   => 'boolean',
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('form.update'),
                'link' => route('form.edit',$this->form_id),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('form.delete'),
                'link' => route('form.destroy',$this->form_id)
            ]
        ];
    }
}
