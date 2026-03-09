<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DivorceCase;

class JudgeController extends Controller
{
    public function index()
    {
        $judges         = User::where('role', 'judge')->with('assignedCases')->get();
        $activeCases    = DivorceCase::whereNotNull('judge_id')->count();
        $unassignedCases = DivorceCase::whereNull('judge_id')->count();

        return view('admin.judges.index', compact('judges', 'activeCases', 'unassignedCases'));
    }
}
