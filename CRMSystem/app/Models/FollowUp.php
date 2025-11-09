<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'user_id', 'due_at', 'notes', 'done'
    ];

    // العميل المرتبط بالمتابعة
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // من قام بإنشاء المتابعة
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
