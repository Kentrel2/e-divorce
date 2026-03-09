@extends('layouts.admin')

@section('title', 'Case Details')

@section('content')

    {{-- Back Button --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.cases.index') }}"
           style="color: #9ca3af; text-decoration: none; font-size: 0.875rem;">
            ← Back to All Cases
        </a>
    </div>

    @if(session('success'))
        <div style="background: #064e3b; border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Case Header --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 2rem; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #a5b4fc;">{{ $divorceCase->case_number }}</h3>
                <p style="color: #9ca3af; margin-top: 0.25rem;">Filed by {{ $divorceCase->user->name ?? 'N/A' }} on {{ $divorceCase->created_at->format('F d, Y') }}</p>
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

    {{-- Details Grid --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">Petitioner</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->petitioner_name }}</p>
        </div>
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">Respondent</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->respondent_name }}</p>
        </div>
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">Assigned Judge</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">
                {{ $divorceCase->judge ? $divorceCase->judge->name : 'Not assigned' }}
            </p>
        </div>
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">Filed By</p>
            <p style="color: white; font-size: 1.125rem; font-weight: 600;">{{ $divorceCase->user->name ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Description --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem; margin-bottom: 1.5rem;">
        <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 1rem;">Case Description</p>
        <p style="color: #e5e7eb; line-height: 1.75;">{{ $divorceCase->description }}</p>
    </div>

    {{-- Admin Actions --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        {{-- Update Status --}}
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 1rem;">Update Status</p>
            <form method="POST" action="{{ route('admin.cases.updateStatus', $divorceCase) }}" style="display: flex; gap: 0.75rem;">
                @csrf
                @method('PATCH')
                <select name="status" style="flex: 1; background: #111827; color: white; border: 1px solid #374151; border-radius: 0.5rem; padding: 0.75rem; font-size: 0.875rem;">
                    <option value="pending"  {{ $divorceCase->status === 'pending'  ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="approved" {{ $divorceCase->status === 'approved' ? 'selected' : '' }}>✅ Approved</option>
                    <option value="rejected" {{ $divorceCase->status === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                </select>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                    Save
                </button>
            </form>
        </div>

        {{-- Assign Judge --}}
        <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; padding: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 1rem;">Assign Judge</p>
            <form method="POST" action="{{ route('admin.cases.assignJudge', $divorceCase) }}" style="display: flex; gap: 0.75rem;">
                @csrf
                @method('PATCH')
                <select name="judge_id" style="flex: 1; background: #111827; color: white; border: 1px solid #374151; border-radius: 0.5rem; padding: 0.75rem; font-size: 0.875rem;">
                    <option value="">Select Judge</option>
                    @foreach($judges as $judge)
                        <option value="{{ $judge->id }}" {{ $divorceCase->judge_id === $judge->id ? 'selected' : '' }}>
                            {{ $judge->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" style="background: #065f46; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                    Assign
                </button>
            </form>
        </div>

    </div>

@endsection