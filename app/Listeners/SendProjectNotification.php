<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use Illuminate\Support\Facades\Http;

class SendProjectNotification
{
    public function handle(ProjectCreated $event)
    {
        Http::get(url('/api/send-notification'));
    }
}
