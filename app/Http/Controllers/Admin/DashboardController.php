<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {

        $topCandidates = env('TOP_CANDIDATES_NUMBER');
        $candidates = Candidate::withCount('voters')
            ->orderBy('voters_count', 'desc')
            ->take($topCandidates)
            ->get();

        return Inertia::render('AdminDashboard', [
            'candidates' => $candidates,
        ]);

    }
}
