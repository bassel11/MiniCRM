<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'type', 'date', 'notes', 'created_by'
    ];

    // العميل المرتبط بهذا الاتصال
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // من قام بإنشاء هذا الاتصال
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // عند إنشاء الاتصال، تحديث تاريخ آخر تواصل للعميل
    protected static function booted()
    {
        static::created(function($comm){
            $comm->client->update(['last_communication_at' => $comm->date]);
        });
    }
}
