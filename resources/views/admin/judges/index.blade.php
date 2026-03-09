@extends('layouts.admin')

@section('title', 'Manage Judges')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Manage Judges 👨‍⚖️</h3>
        <p style="color: #9ca3af; margin-top: 0.25rem;">All users with the Judge role.</p>
    </div>

    @if(session('success'))
        <div style="background: #064e3b; border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Total Judges</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: white;">{{ $judges->count() }}</p>
        </div>
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Active Cases</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: #60a5fa;">{{ $activeCases }}</p>
        </div>
        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Unassigned Cases</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: #facc15;">{{ $unassignedCases }}</p>
        </div>
    </div>

    {{-- Judges Table --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #374151;">
            <h4 style="color: white; font-weight: 600;">All Judges ({{ $judges->count() }})</h4>
        </div>

        @if($judges->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #9ca3af;">
                <p style="font-size: 3rem;">👨‍⚖️</p>
                <p style="margin-top: 1rem;">No judges found.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">Go to Manage Users and assign the Judge role to a user.</p>
                <a href="/admin/users" style="display: inline-block; margin-top: 1rem; background: #4f46e5; color: white; padding: 0.5rem 1.5rem; border-radius: 0.5rem; text-decoration: none;">
                    Go to Manage Users
                </a>
            </div>
        @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #111827;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">#</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Name</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Email</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Cases Assigned</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($judges as $judge)
                <tr style="border-top: 1px solid #374151;">
                    <td style="padding: 1rem 1.5rem; color: #9ca3af;">{{ $judge->id }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: #1e3a5f; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #93c5fd;">
                                {{ strtoupper(substr($judge->name, 0, 1)) }}
                            </div>
                            <span style="color: white; font-weight: 500;">{{ $judge->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #9ca3af;">{{ $judge->email }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="background: #1e3a5f; color: #93c5fd; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                            {{ $judge->assignedCases->count() }} cases
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #9ca3af;">{{ $judge->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

@endsection