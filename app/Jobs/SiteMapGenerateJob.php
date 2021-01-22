<?php

namespace App\Jobs;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SiteMapGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $webId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($webId)
    {
        $this->webId = $webId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Website::find($this->webId)->generateSiteMap();
    }
}
