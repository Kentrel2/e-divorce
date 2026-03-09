<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\DivorceCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    // Citizen Dashboard
    public function dashboard()
    {
        $userId        = Auth::id();
        $totalCases    = DivorceCase::where('user_id', $userId)->count();
        $pendingCases  = DivorceCase::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedCases = DivorceCase::where('user_id', $userId)->where('status', 'approved')->count();
        $recentCases   = DivorceCase::where('user_id', $userId)->with('judge')->latest()->take(5)->get();

        return view('citizen.dashboard', compact(
            'totalCases', 'pendingCases', 'approvedCases', 'recentCases'
        ));
    }

    // My Cases Page
    public function myCases()
    {
        $cases = DivorceCase::where('user_id', Auth::id())
                    ->with('judge')
                    ->latest()
                    ->get();

        return view('citizen.cases', compact('cases'));
    }

    // File New Case Form
    public function create()
    {
        return view('citizen.create');
    }

    // Submit New Case
    public function store(Request $request)
    {
        $request->validate([
            'petitioner_name' => ['required', 'string', 'max:255'],
            'respondent_name' => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string', 'min:20'],
        ]);

        // Auto generate case number
        $caseNumber = 'EDV-' . date('Y') . '-' . str_pad(DivorceCase::count() + 1, 4, '0', STR_PAD_LEFT);

        DivorceCase::create([
            'case_number'     => $caseNumber,
            'petitioner_name' => $request->petitioner_name,
            'respondent_name' => $request->respondent_name,
            'description'     => $request->description,
            'status'          => 'pending',
            'user_id'         => Auth::id(),
        ]);

        return redirect()->route('citizen.cases')->with('success', 'Case filed successfully! Case Number: ' . $caseNumber);
    }

    // View Single Case Detail
    public function show(DivorceCase $divorceCase)
    {
        // Make sure citizen can only see their own cases
        if ($divorceCase->user_id !== Auth::id()) {
            return redirect()->route('citizen.cases')->with('error', 'Unauthorized access.');
        }

        return view('citizen.case-detail', compact('divorceCase'));
    }
}
