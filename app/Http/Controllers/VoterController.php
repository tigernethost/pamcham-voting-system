<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateLeaderboardJob;
use App\Models\Candidate;
use App\Models\Voter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoterController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user()->load('voter');

        return Inertia::render('Dashboard', [
            'user' => $user
        ]);
    }

    public function votingBallot($uuid)
    {
        $voter = Voter::where('uuid', $uuid)->with('candidates')->first();        
        $voter->update([
            'is_scanned' => 1
        ]);

        if(env('CANDIDATE_ORDER') === 'alphabetical') {
            $candidates = Candidate::orderBy('name', 'asc')->get();
            
        } else {
            $candidates = Candidate::inRandomOrder()->get();
        }

        $vue = $voter->voting_credits > 0 ? 'Vote' : 'NoCredits';

        
        return Inertia::render($vue, [
            'candidates' => $candidates,
            'voter' => $voter
        ]);

    }

    public function submitVote(Request $request, $uuid)
    {
        $voter = Voter::where('uuid', $uuid)->first();
        $candidatesIds = collect($request->candidates)->pluck('id');

        if($voter->voting_credits < $candidatesIds->count()) {
            return response()->json(['error' => 'Not enough voting credits'], 422);
        }
        
        $voter->candidates()->syncWithoutDetaching($candidatesIds);

        $voter->update([
            'voting_credits' => $voter->voting_credits - $candidatesIds->count(),

        ]);

        
        UpdateLeaderboardJob::dispatch();

       return response()->json(['success' => 'Voted Successfully', 'voter' => $voter]);

    }


}
