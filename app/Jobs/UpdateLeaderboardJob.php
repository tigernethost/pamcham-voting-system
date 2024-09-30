<?php

namespace App\Jobs;

use App\Events\VoteSubmittedEvent;
use App\Models\Candidate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLeaderboardJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $topCandidates = env('TOP_CANDIDATES_NUMBER');
        $candidates = Candidate::withCount('voters')
            ->orderBy('voters_count', 'desc')
            ->take($topCandidates)
            ->get();

        \Log::info($candidates->toArray());

        event(new VoteSubmittedEvent($candidates->toArray()));
    }
}
