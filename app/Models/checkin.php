<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table      = 'checkins';
    protected $primaryKey = 'checkin_id';

    protected $fillable = [
        'member_id',
        'checkin_time',
        'checkout_time',
        'rfid_card_id',
    ];

    protected $casts = [
        'checkin_time'  => 'datetime',
        'checkout_time' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
