@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    {{-- Welcome --}}
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Welcome back, {{ auth()->user()->name }} 👋</h3>
        <p style="color: #9ca3af; margin-top: 0.25rem;">Here's what's happening in the E-Divorce system today.</p>
    </div>

    {{-- Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

        {{-- Total Cases --}}
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #374151;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #9ca3af; font-size: 0.875rem;">Total Cases</p>
                <span style="font-size: 1.5rem;">📁</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: white;">{{ $totalCases }}</p>
            <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">All divorce cases</p>
        </div>

        {{-- Pending Cases --}}
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #374151;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #9ca3af; font-size: 0.875rem;">Pending Cases</p>
                <span style="font-size: 1.5rem;">⏳</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: #facc15;">{{ $pendingCases }}</p>
            <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">Awaiting review</p>
        </div>

        {{-- Approved Cases --}}
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #374151;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #9ca3af; font-size: 0.875rem;">Approved Cases</p>
                <span style="font-size: 1.5rem;">✅</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: #4ade80;">{{ $approvedCases }}</p>
            <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">Successfully processed</p>
        </div>

        {{-- Total Users --}}
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #374151;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #9ca3af; font-size: 0.875rem;">Total Users</p>
                <span style="font-size: 1.5rem;">👥</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: #60a5fa;">{{ $totalUsers }}</p>
            <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">Registered accounts</p>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #374151; margin-bottom: 2rem;">
        <h4 style="font-size: 1.125rem; font-weight: 600; color: white; margin-bottom: 1rem;">Quick Actions</h4>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">

            <a href="/admin/users"
               style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem; background: #374151; border-radius: 0.5rem; text-decoration: none;"
               onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#374151'">
                <span style="font-size: 1.5rem;">👥</span>
                <span style="font-size: 0.875rem; color: #d1d5db;">Manage Users</span>
            </a>

            <a href="/admin/cases"
               style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem; background: #374151; border-radius: 0.5rem; text-decoration: none;"
               onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#374151'">
                <span style="font-size: 1.5rem;">📁</span>
                <span style="font-size: 0.875rem; color: #d1d5db;">Manage Cases</span>
            </a>

            <a href="/admin/judges"
               style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem; background: #374151; border-radius: 0.5rem; text-decoration: none;"
               onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#374151'">
                <span style="font-size: 1.5rem;">👨‍⚖️</span>
                <span style="font-size: 0.875rem; color: #d1d5db;">Manage Judges</span>
            </a>

            <a href="/admin/lawyers"
               style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem; background: #374151; border-radius: 0.5rem; text-decoration: none;"
               onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#374151'">
                <span style="font-size: 1.5rem;">💼</span>
                <span style="font-size: 0.875rem; color: #d1d5db;">Manage Lawyers</span>
            </a>

        </div>
    </div>

    {{-- Recent Cases --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #374151; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="color: white; font-weight: 600;">Recent Cases</h4>
            <a href="/admin/cases" style="color: #a5b4fc; font-size: 0.875rem; text-decoration: none;">View All →</a>
        </div>

        @php
            $recentCases = \App\Models\DivorceCase::with(['user', 'judge'])->latest()->take(5)->get();
        @endphp

        @if($recentCases->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #9ca3af;">
                <p style="font-size: 3rem;">📭</p>
                <p style="margin-top: 1rem;">No cases filed yet.</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #111827;">
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Case #</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Petitioner</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Respondent</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Status</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Filed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentCases as $case)
                    <tr style="border-top: 1px solid #374151;">
                        <td style="padding: 1rem 1.5rem; color: #a5b4fc; font-weight: 600;">{{ $case->case_number }}</td>
                        <td style="padding: 1rem 1.5rem; color: white;">{{ $case->petitioner_name }}</td>
                        <td style="padding: 1rem 1.5rem; color: white;">{{ $case->respondent_name }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            @php
                                $statusStyles = [
                                    'pending'  => 'background:#422006; color:#fde68a;',
                                    'approved' => 'background:#064e3b; color:#6ee7b7;',
                                    'rejected' => 'background:#7f1d1d; color:#fca5a5;',
                                ];
                                $s = $statusStyles[$case->status] ?? $statusStyles['pending'];
                            @endphp
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; {{ $s }}">
                                {{ ucfirst($case->status) }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #9ca3af;">{{ $case->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection