@extends('layouts.citizen')

@section('title', 'Case Details')

@section('content')

    {{-- Back Button --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('citizen.cases') }}"
           style="color: #94a3b8; text-decoration: none; font-size: 0.875rem;">
            ← Back to My Cases
        </a>
    </div>

    {{-- Case Header --}}
    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 2rem; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #818cf8;">{{ $divorceCase->case_number }}</h3>
                <p style="color: #94a3b8; margin-top: 0.25rem; font-size: 0.875rem;">Filed on {{ $divorceCase->created_at->format('F d, Y') }}</p>
            </div>
            @php
                $statusStyles = [
                    'pending'  => 'background:#422006; color:#fde68a;',
                    'approved' => 'background:#064e3b; color:#6ee7b7;',
                    'rejected' => 'background:#7f1d1d; color:#fca5a5;',
                ];
                $s = $statusStyles[$divorceCase->status] ?? $statusStyles['pending'];
            @endphp
            <span style="padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; {{ $s }}">
                {{ ucfirst($divorceCase->status) }}
            </span>
        </div>
    </div>

    {{-- Case Details Grid --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">

        {{-- Petitioner --}}
        <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem;">
            <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Petitioner</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->petitioner_name }}</p>
        </div>

        {{-- Respondent --}}
        <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem;">
            <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Respondent</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->respondent_name }}</p>
        </div>

        {{-- Assigned Judge --}}
        <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem;">
            <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Assigned Judge</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">
                {{ $divorceCase->judge ? $divorceCase->judge->name : 'Not assigned yet' }}
            </p>
        </div>

        {{-- Case Status --}}
        <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem;">
            <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Last Updated</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->updated_at->format('F d, Y') }}</p>
        </div>

    </div>

    {{-- Description --}}
    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem; margin-bottom: 1.5rem;">
        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Case Description</p>
        <p style="color: #e2e8f0; line-height: 1.75;">{{ $divorceCase->description }}</p>
    </div>

    {{-- Status Timeline --}}
    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 1.5rem;">
        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Case Timeline</p>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: #064e3b; display: flex; align-items: center; justify-content: center;">✅</div>
                <div>
                    <p style="color: white; font-weight: 500;">Case Filed</p>
                    <p style="color: #64748b; font-size: 0.75rem;">{{ $divorceCase->created_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: {{ $divorceCase->judge ? '#1e3a5f' : '#374151' }}; display: flex; align-items: center; justify-content: center;">
                    {{ $divorceCase->judge ? '👨‍⚖️' : '⏳' }}
                </div>
                <div>
                    <p style="color: white; font-weight: 500;">Judge Assignment</p>
                    <p style="color: #64748b; font-size: 0.75rem;">
                        {{ $divorceCase->judge ? 'Assigned to ' . $divorceCase->judge->name : 'Pending assignment' }}
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: {{ $divorceCase->status !== 'pending' ? '#064e3b' : '#374151' }}; display: flex; align-items: center; justify-content: center;">
                    {{ $divorceCase->status === 'approved' ? '✅' : ($divorceCase->status === 'rejected' ? '❌' : '⏳') }}
                </div>
                <div>
                    <p style="color: white; font-weight: 500;">Final Decision</p>
                    <p style="color: #64748b; font-size: 0.75rem;">
                        {{ $divorceCase->status !== 'pending' ? ucfirst($divorceCase->status) . ' on ' . $divorceCase->updated_at->format('F d, Y') : 'Awaiting decision' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection