<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';

    public $timestamps = false;

    protected $fillable = [
        'member_id', 'user_id', 'campaign_name', 'channel', 'subject', 'body', 'status', 'sent_at',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function sender()
    { // Người gửi
        return $this->belongsTo(User::class, 'user_id');
    }
}
