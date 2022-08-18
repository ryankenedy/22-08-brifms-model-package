<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "profile";
    protected $primaryKey = 'id_profile';
    public $timestamps = false;

    protected $fillable = [
        'profile_code',
        'profile_name',
        'profile_is_active',
        'profile_order',
        'profile_version',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->acquiringPivots()->delete();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('profile_is_active', 1);
    }

    public function acquiringPivots()
    {
        return $this->hasMany(ProfileAcquiring::class, 'profile_code', 'profile_code');
    }

    public function acquirings()
    {
        return $this->belongsToMany(AcquiringMaster::class, 'profile_data', 'profile_code','acquiring_code', 'profile_code','acquiring_code');
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-profile.update'),
                'link' => route('profile.edit',['profile' => $this]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-profile.delete'),
                'link' => route('profile.destroy',['profile' => $this])
            ]
        ];
    }

}
