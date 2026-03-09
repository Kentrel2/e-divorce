<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\DivorceCase;
use Illuminate\Support\Facades\Auth;

class LawyerController extends Controller
{
    public function dashboard()
    {
        $totalCases    = DivorceCase::count();
        $pendingCases  = DivorceCase::where('status', 'pending')->count();
        $approvedCases = DivorceCase::where('status', 'approved')->count();
        $rejectedCases = DivorceCase::where('status', 'rejected')->count();
        $recentCases   = DivorceCase::with(['user', 'judge'])->latest()->take(5)->get();

        return view('lawyer.dashboard', compact(
            'totalCases', 'pendingCases', 'approvedCases', 'rejectedCases', 'recentCases'
        ));
    }

    public function cases()
    {
        $cases = DivorceCase::with(['user', 'judge'])->latest()->get();
        return view('lawyer.cases', compact('cases'));
    }
}
