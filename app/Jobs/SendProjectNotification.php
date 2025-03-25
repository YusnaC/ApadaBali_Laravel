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
        $message = "Proyek baru '{$this->project->nama_proyek}' telah dibuat untuk Drafter {$this->project->id_drafter}";
        
        Http::get(url('/api/send-notification'), [
            'title' => 'Proyek Baru',
            'message' => $message,
            'drafter_id' => $this->project->id_drafter
        ]);
    }
}