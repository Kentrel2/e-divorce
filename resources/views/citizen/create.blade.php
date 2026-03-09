@extends('layouts.citizen')

@section('title', 'File New Case')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">File a New Case ➕</h3>
        <p style="color: #94a3b8; margin-top: 0.25rem;">Fill in the details below to submit your divorce case.</p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div style="background: #7f1d1d; border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ❌ Please fix the following errors:
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 2rem; max-width: 700px;">

        <form method="POST" action="{{ route('citizen.cases.store') }}">
            @csrf

            {{-- Petitioner Name --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Petitioner Name (Your Full Name) *
                </label>
                <input
                    type="text"
                    name="petitioner_name"
                    value="{{ old('petitioner_name', auth()->user()->name) }}"
                    style="width: 100%; background: #0f172a; border: 1px solid #334155; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; box-sizing: border-box;"
                    placeholder="Enter your full name"
                />
            </div>

            {{-- Respondent Name --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Respondent Name (Spouse's Full Name) *
                </label>
                <input
                    type="text"
                    name="respondent_name"
                    value="{{ old('respondent_name') }}"
                    style="width: 100%; background: #0f172a; border: 1px solid #334155; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; box-sizing: border-box;"
                    placeholder="Enter spouse's full name"
                />
            </div>

            {{-- Description --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Case Description (Reason for Divorce) *
                </label>
                <textarea
                    name="description"
                    rows="5"
                    style="width: 100%; background: #0f172a; border: 1px solid #334155; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; box-sizing: border-box; resize: vertical;"
                    placeholder="Please describe the reason for filing divorce (minimum 20 characters)...">{{ old('description') }}</textarea>
            </div>

            {{-- Info Box --}}
            <div style="background: #1e3a5f; border: 1px solid #3b82f6; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem;">
                <p style="color: #93c5fd; font-size: 0.875rem;">
                    ℹ️ <strong>What happens next?</strong><br>
                    After submitting, your case will be reviewed by an admin and assigned to a judge.
                    You can track your case status from your dashboard.
                </p>
            </div>

            {{-- Buttons --}}
            <div style="display: flex; gap: 1rem;">
                <button
                    type="submit"
                    style="background: #6366f1; color: white; border: none; padding: 0.75rem 2rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; cursor: pointer;">
                    ➕ Submit Case
                </button>
                <a href="{{ route('citizen.dashboard') }}"
                   style="background: #334155; color: #94a3b8; padding: 0.75rem 2rem; border-radius: 0.5rem; font-size: 0.875rem; text-decoration: none; font-weight: 600;">
                    Cancel
                </a>
            </div>

        </form>

    </div>

@endsection