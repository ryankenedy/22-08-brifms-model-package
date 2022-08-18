<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalSettingMaster extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "terminal_setting";

    protected $fillable = [
        'name', 'value'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' =>request()->user()->hasPermission('master-terminal-setting.update'),
                'link' => route('terminal-setting.edit',[
                    'terminal_setting' => $this
                ]),
            ],
            'delete' => [
                'isCan' =>request()->user()->hasPermission('master-terminal-setting.delete'),
                'link' => route('terminal-setting.destroy',[
                    'terminal_setting' => $this
                ]),
            ]
        ];
    }

}
