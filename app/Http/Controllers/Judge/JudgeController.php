<?php

namespace App\Http\Controllers\Judge;

use App\Http\Controllers\Controller;
use App\Models\DivorceCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JudgeController extends Controller
{
    // Judge Dashboard
    public function dashboard()
    {
        $judgeId       = Auth::id();
        $totalCases    = DivorceCase::where('judge_id', $judgeId)->count();
        $pendingCases  = DivorceCase::where('judge_id', $judgeId)->where('status', 'pending')->count();
        $approvedCases = DivorceCase::where('judge_id', $judgeId)->where('status', 'approved')->count();
        $rejectedCases = DivorceCase::where('judge_id', $judgeId)->where('status', 'rejected')->count();
        $recentCases   = DivorceCase::where('judge_id', $judgeId)->with('user')->latest()->take(5)->get();

        return view('judge.dashboard', compact(
            'totalCases', 'pendingCases', 'approvedCases', 'rejectedCases', 'recentCases'
        ));
    }

    // My Assigned Cases Page
    public function myCases()
    {
        $cases = DivorceCase::where('judge_id', Auth::id())
                    ->with('user')
                    ->latest()
                    ->get();

        return view('judge.cases', compact('cases'));
    }

    // View Single Case Detail
    public function show(DivorceCase $divorceCase)
    {
        // Make sure judge can only see their assigned cases
        if ($divorceCase->judge_id !== Auth::id()) {
            return redirect()->route('judge.cases')->with('error', 'Unauthorized access.');
        }

        return view('judge.case-detail', compact('divorceCase'));
    }

    // Update Case Status
   public function updateStatus(Request $request, DivorceCase $divorceCase)
{
    $request->validate([
        'status' => ['required', 'in:pending,approved,rejected'],
    ]);

    $divorceCase->status = $request->status;
    $divorceCase->save();

    // Send notification to citizen
    $messages = [
        'approved' => [
            'title'   => '✅ Case Approved!',
            'message' => 'Your case ' . $divorceCase->case_number . ' has been approved by the judge.',
            'type'    => 'success',
        ],
        'rejected' => [
            'title'   => '❌ Case Rejected',
            'message' => 'Your case ' . $divorceCase->case_number . ' has been rejected by the judge.',
            'type'    => 'danger',
        ],
        'pending' => [
            'title'   => '⏳ Case Under Review',
            'message' => 'Your case ' . $divorceCase->case_number . ' is currently under review.',
            'type'    => 'warning',
        ],
    ];

    \App\Models\Notification::create([
        'user_id' => $divorceCase->user_id,
        'title'   => $messages[$request->status]['title'],
        'message' => $messages[$request->status]['message'],
        'type'    => $messages[$request->status]['type'],
    ]);

    return redirect()->back()->with('success', 'Case status updated successfully!');
}