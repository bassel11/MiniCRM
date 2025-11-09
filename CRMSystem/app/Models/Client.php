<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'status', 'assigned_to', 'last_communication_at'
    ];

    // العلاقة مع المستخدم المسؤول عن العميل
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // كل الاتصالات الخاصة بهذا العميل
    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

    // كل المتابعات الخاصة بهذا العميل
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    // مثال على علاقة مع آخر اتصال
    public function lastCommunication()
    {
        return $this->hasOne(Communication::class)->latestOfMany('date');
    }
}
