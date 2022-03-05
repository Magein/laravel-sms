<?php

namespace Magein\Sms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishSmsTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $save_path = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, string $queue = 'resume_word_document_trans_to_pdf')
    {
        $this->onConnection('database');
        $this->onQueue($queue);
        $path = parse_url($path);
        $this->save_path = $path['path'] ?? '';
        if ($this->save_path) {
            $base_path = base_path();
            if (strpos($this->save_path, $base_path) === false) {
                $base_path = base_path() . '/public/';
            }
            $this->save_path = $base_path . $this->save_path;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }

    public function retryUntil()
    {

    }
}
