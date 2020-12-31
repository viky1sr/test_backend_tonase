<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class HistoryWithdraw extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['card_id','amount','created_at'];

    protected static $logName = 'Withdraw_Saldo';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Withdraw Success / {$eventName} ";
    }

    protected $fillable = ['card_id','amount'];
}
