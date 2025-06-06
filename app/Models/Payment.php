<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
