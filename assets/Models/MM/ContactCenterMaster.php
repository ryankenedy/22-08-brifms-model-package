<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactCenterMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "master_contact_center";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
        'company_code'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-contact-center.update'),
                'link' => route('contact-center.edit',$this),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-contact-center.delete'),
                'link' => route('contact-center.destroy',$this)
            ]
        ];
    }

    public function company()
    {
        return $this->hasOne(CompanyMaster::class, 'company_code', 'company_code')->withDefault([
            'company_code' => null,
            'company_name' => null
        ]);
    }
}
