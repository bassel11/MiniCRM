<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FollowUp;
use App\Notifications\FollowUpDueNotification;


class SendDueFollowUps extends Command
{
    protected $signature = 'followups:send-due';
    protected $description = 'Send notifications for follow-ups due today';


    public function handle()
    {
        $todayFollowUps = FollowUp::whereDate('due_at', today())
            ->where('done', false)
            ->with(['client', 'user'])
            ->get();

        foreach ($todayFollowUps as $followUp) {
            $followUp->user->notify(new FollowUpDueNotification($followUp));
        }

        $this->info('Follow-up notifications sent: ' . $todayFollowUps->count());
    }
}
