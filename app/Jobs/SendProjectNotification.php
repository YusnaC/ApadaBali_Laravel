<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Project;

class SendProjectNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function handle()
    {
        try {
            $messaging = app('firebase.messaging');
            
            $notification = [
                'title' => 'Proyek Baru',
                'body' => 'Proyek ' . $this->project->nama_proyek . ' telah dibuat'
            ];

            $tokens = \DB::table('users')
                ->whereNotNull('fcm_token')
                ->pluck('fcm_token')
                ->chunk(500) // Process in chunks
                ->each(function($tokenBatch) use ($messaging, $notification) {
                    $messaging->sendMulticast($notification, $tokenBatch->toArray());
                });

        } catch (\Exception $e) {
            \Log::error('Firebase notification failed: ' . $e->getMessage());
        }
    }
}