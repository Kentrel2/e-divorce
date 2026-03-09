@extends('layouts.citizen')

@section('title', 'My Dashboard')

@section('content')

    {{-- Welcome --}}
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Welcome, {{ auth()->user()->name }} 👋</h3>
        <p style="color: #94a3b8; margin-top: 0.25rem;">Track and manage your divorce cases here.</p>
    </div>

    {{-- Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

        <div style="background: #1e293b; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #334155;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #94a3b8; font-size: 0.875rem;">Total Cases</p>
                <span style="font-size: 1.5rem;">📁</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: white;">{{ $totalCases }}</p>
            <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.5rem;">Cases you have filed</p>
        </div>

        <div style="background: #1e293b; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #334155;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #94a3b8; font-size: 0.875rem;">Pending</p>
                <span style="font-size: 1.5rem;">⏳</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: #facc15;">{{ $pendingCases }}</p>
            <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.5rem;">Awaiting review</p>
        </div>

        <div style="background: #1e293b; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #334155;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <p style="color: #94a3b8; font-size: 0.875rem;">Approved</p>
                <span style="font-size: 1.5rem;">✅</span>
            </div>
            <p style="font-size: 1.875rem; font-weight: 700; color: #4ade80;">{{ $approvedCases }}</p>
            <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.5rem;">Successfully processed</p>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

        <a href="/citizen/cases/create"
           style="background: #6366f1; border-radius: 0.75rem; padding: 1.5rem; text-decoration: none; display: flex; align-items: center; gap: 1rem;">
            <span style="font-size: 2rem;">➕</span>
            <div>
                <p style="color: white; font-weight: 700; font-size: 1.125rem;">File New Case</p>
                <p style="color: #c7d2fe; font-size: 0.875rem; margin-top: 0.25rem;">Start a new divorce filing</p>
            </div>
        </a>

        <a href="/citizen/cases"
           style="background: #1e293b; border: 1px solid #334155; border-radius: 0.75rem; padding: 1.5rem; text-decoration: none; display: flex; align-items: center; gap: 1rem;">
            <span style="font-size: 2rem;">📋</span>
            <div>
                <p style="color: white; font-weight: 700; font-size: 1.125rem;">View My Cases</p>
                <p style="color: #94a3b8; font-size: 0.875rem; margin-top: 0.25rem;">Track your case status</p>
            </div>
        </a>

    </div>

    {{-- Recent Cases --}}
    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #334155;">
            <h4 style="color: white; font-weight: 600;">Recent Cases</h4>
        </div>

        @if($recentCases->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #94a3b8;">
                <p style="font-size: 3rem;">📭</p>
                <p style="margin-top: 1rem;">You haven't filed any cases yet.</p>
                <a href="/citizen/cases/create"
                   style="display: inline-block; margin-top: 1rem; background: #6366f1; color: white; padding: 0.5rem 1.5rem; border-radius: 0.5rem; text-decoration: none;">
                    File Your First Case
                </a>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #0f172a;">
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Case #</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Respondent</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Status</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Judge</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Filed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentCases as $case)
                    <tr style="border-top: 1px solid #334155;">
                        <td style="padding: 1rem 1.5rem; color: #818cf8; font-weight: 600;">{{ $case->case_number }}</td>
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
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">{{ $case->judge ? $case->judge->name : 'Not assigned' }}</td>
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">{{ $case->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection