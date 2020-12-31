<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SaldoUser extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['user_id','number_card','amount'];

    protected static $logAttributes = ['user_id','number_card','amount','created_at'];

    protected static $logName = 'Update_Saldo';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Success {$eventName} Saldo ";
    }

    public function user() {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
