@extends('layouts.citizen')

@section('title', 'My Cases')

@section('content')

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">My Cases 📁</h3>
            <p style="color: #94a3b8; margin-top: 0.25rem;">All your filed divorce cases.</p>
        </div>
        <a href="{{ route('citizen.cases.create') }}"
           style="background: #6366f1; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600;">
            ➕ File New Case
        </a>
    </div>

    @if(session('success'))
        <div style="background: #064e3b; border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; overflow: hidden;">

        @if($cases->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #94a3b8;">
                <p style="font-size: 3rem;">📭</p>
                <p style="margin-top: 1rem;">You haven't filed any cases yet.</p>
                <a href="{{ route('citizen.cases.create') }}"
                   style="display: inline-block; margin-top: 1rem; background: #6366f1; color: white; padding: 0.5rem 1.5rem; border-radius: 0.5rem; text-decoration: none;">
                    File Your First Case
                </a>
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
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Filed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $case)
                    <tr style="border-top: 1px solid #334155;">
                       <td style="padding: 1rem 1.5rem; font-weight: 600;">
    <a href="{{ route('citizen.cases.show', $case) }}" style="color: #818cf8; text-decoration: none;">
        {{ $case->case_number }}
    </a>
</td>
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
                            {{ $case->judge ? $case->judge->name : 'Not assigned yet' }}
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #94a3b8;">{{ $case->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

@endsection