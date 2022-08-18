<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLogChange extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "activity_log_change";
    protected $primaryKey = 'id';

    protected $fillable = [
        'version',
        'summary',
        'description',
        'date',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('log-change.update'),
                'link' => route('activity-change.edit',$this),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('log-change.delete'),
                'link' => route('activity-change.destroy',$this)
            ]
        ];
    }
}
