<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $table      = 'members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'rfid_card_id',
        'join_date',
        'status',
        'total_months_paid',
        'notes',
        'img',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(MemberSubscription::class, 'member_id');
    }

    public function latestSubscription()
    {
        return $this->hasOne(MemberSubscription::class, 'member_id')
            ->latestOfMany('end_date');
    }
}
