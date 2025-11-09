<?php

namespace App\Listeners;

use App\Events\CommunicationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateClientAfterCommunication implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
   public function handle(CommunicationCreated $event): void
    {
        $client = $event->communication->client;

        // تحديث تاريخ آخر تواصل
        $client->update([
            'last_communication_at' => $event->communication->date,
        ]);

        // حساب عدد الاتصالات في آخر أسبوع
        $recentCount = $client->communications()
            ->where('date', '>=', now()->subWeek())
            ->count();

        // تغيير الحالة بناءً على عدد الاتصالات
        if ($recentCount >= 3) {
            $client->update(['status' => 'Hot']);
        }
    }
}
