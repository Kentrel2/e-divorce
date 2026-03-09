@extends('layouts.lawyer')

@section('title', 'All Cases')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">All Cases 📁</h3>
        <p style="color: #94a3b8; margin-top: 0.25rem;">View all divorce cases in the system.</p>
    </div>

    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; overflow: hidden;">

        @if($cases->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #94a3b8;">
                <p style="font-size: 3rem;">📭</p>
                <p style="margin-top: 1rem;">No cases found in the system.</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #0f172a;">
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Case #</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Petitioner</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Respondent</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Status</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Judge</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Filed By</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $case)
                    <tr style="border-top: 1px solid #334155;">
                        <td style="padding: 1rem 1.5rem; color: #6ee7b7; font-weight: 600;">{{ $case->case_number }}</td>
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
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">
                            {{ $case->judge ? $case->judge->name : 'Not assigned' }}
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">
                            {{ $case->user ? $case->user->name : 'N/A' }}
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">{{ $case->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection