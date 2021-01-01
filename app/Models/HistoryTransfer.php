<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class HistoryTransfer extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['penerima','pengirim','amount','saldo_user_id','created_at',
    'saldo_pengirim','saldo_penerima'
    ];

    protected static $logName = 'Transfer_Saldo';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Transfer Success / {$eventName} ";
    }

    protected $fillable = ['penerima','pengirim','amount','saldo_user_id'];

    public function saldo_pengirim() {
        return $this->hasMany('App\Models\SaldoUser','user_id','pengirim');
    }

    public function saldo_penerima() {
        return $this->hasMany('App\Models\SaldoUser','number_card','penerima');
    }

}
