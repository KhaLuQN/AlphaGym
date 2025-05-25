<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberSubscription extends Model
{
    protected $table      = 'membersubscriptions';
    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'member_id',
        'plan_id',
        'start_date',
        'end_date',
        'actual_price',
        'payment_status',
        'payment_date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class, 'plan_id');
    }
}
