<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivorceCase;
use App\Models\User;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    // All Cases Page
    public function index()
    {
        $cases         = DivorceCase::with(['user', 'judge'])->orderBy('created_at', 'desc')->get();
        $judges        = User::where('role', 'judge')->get();
        $totalCases    = DivorceCase::count();
        $pendingCases  = DivorceCase::where('status', 'pending')->count();
        $approvedCases = DivorceCase::where('status', 'approved')->count();
        $rejectedCases = DivorceCase::where('status', 'rejected')->count();

        return view('admin.cases.index', compact(
            'cases', 'judges', 'totalCases',
            'pendingCases', 'approvedCases', 'rejectedCases'
        ));
    }

    // View Single Case Detail
    public function show(DivorceCase $divorceCase)
    {
        $judges = User::where('role', 'judge')->get();
        return view('admin.cases.show', compact('divorceCase', 'judges'));
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
            'message' => 'Your case ' . $divorceCase->case_number . ' has been approved.',
            'type'    => 'success',
        ],
        'rejected' => [
            'title'   => '❌ Case Rejected',
            'message' => 'Your case ' . $divorceCase->case_number . ' has been rejected.',
            'type'    => 'danger',
        ],
        'pending' => [
            'title'   => '⏳ Case Pending',
            'message' => 'Your case ' . $divorceCase->case_number . ' has been set back to pending.',
            'type'    => 'warning',
        ],
    ];

    \App\Models\Notification::create([
        'user_id' => $divorceCase->user_id,
        'title'   => $messages[$request->status]['title'],
        'message' => $messages[$request->status]['message'],
        'type'    => $messages[$request->status]['type'],
    ]);

    return redirect()->back()->with('success', 'Case status updated!');
}

    // Assign Judge to Case
    public function assignJudge(Request $request, DivorceCase $divorceCase)
    {
        $request->validate([
            'judge_id' => ['required', 'exists:users,id'],
        ]);

        $divorceCase->judge_id = $request->judge_id;
        $divorceCase->save();

        return redirect()->back()->with('success', 'Judge assigned successfully!');
    }

    // Delete Case
    public function destroy(DivorceCase $divorceCase)
    {
        $divorceCase->delete();
        return redirect()->back()->with('success', 'Case deleted successfully!');
    }
}
