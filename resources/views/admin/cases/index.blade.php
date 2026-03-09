@extends('layouts.admin')

@section('title', 'Manage Cases')

@section('content')

    {{-- Header --}}
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Manage Cases 📁</h3>
        <p style="color: #9ca3af; margin-top: 0.25rem;">View and manage all divorce cases.</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div style="background: #064e3b; border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Stats Row --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Total Cases</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: white;">{{ $totalCases }}</p>
        </div>

        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Pending</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: #facc15;">{{ $pendingCases }}</p>
        </div>

        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Approved</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: #4ade80;">{{ $approvedCases }}</p>
        </div>

        <div style="background: #1f2937; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #374151;">
            <p style="color: #9ca3af; font-size: 0.875rem;">Rejected</p>
            <p style="font-size: 1.875rem; font-weight: 700; color: #f87171;">{{ $rejectedCases }}</p>
        </div>

    </div>

    {{-- Cases Table --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; overflow: hidden;">

        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #374151;">
            <h4 style="color: white; font-weight: 600;">All Cases ({{ $totalCases }})</h4>
        </div>

        @if($cases->count() === 0)
            <div style="padding: 3rem; text-align: center; color: #9ca3af;">
                <p style="font-size: 3rem;">📭</p>
                <p style="margin-top: 1rem; font-size: 1.125rem;">No cases found yet.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">Cases will appear here once citizens file them.</p>
            </div>
        @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #111827;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Case #</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Petitioner</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Respondent</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Status</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Judge</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Filed</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cases as $case)
                <tr style="border-top: 1px solid #374151;">

                  <td style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600;">
    <a href="{{ route('admin.cases.show', $case) }}" style="color: #a5b4fc; text-decoration: none;">
        {{ $case->case_number }}
    </a>
</td>

                    <td style="padding: 1rem 1.5rem; color: white; font-size: 0.875rem;">
                        {{ $case->petitioner_name }}
                    </td>

                    <td style="padding: 1rem 1.5rem; color: white; font-size: 0.875rem;">
                        {{ $case->respondent_name }}
                    </td>

                    {{-- Status Badge --}}
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $statusStyles = [
                                'pending'  => 'background:#422006; color:#fde68a;',
                                'approved' => 'background:#064e3b; color:#6ee7b7;',
                                'rejected' => 'background:#7f1d1d; color:#fca5a5;',
                            ];
                            $statusStyle = $statusStyles[$case->status] ?? $statusStyles['pending'];
                        @endphp
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; {{ $statusStyle }}">
                            {{ ucfirst($case->status) }}
                        </span>
                    </td>

                    <td style="padding: 1rem 1.5rem; color: #9ca3af; font-size: 0.875rem;">
                        {{ $case->judge ? $case->judge->name : 'Not assigned' }}
                    </td>

                    <td style="padding: 1rem 1.5rem; color: #9ca3af; font-size: 0.875rem;">
                        {{ $case->created_at->format('M d, Y') }}
                    </td>

                    {{-- Actions --}}
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">

                            {{-- Update Status --}}
                            <form method="POST" action="{{ route('admin.cases.updateStatus', $case) }}" style="display: flex; gap: 0.25rem;">
                                @csrf
                                @method('PATCH')
                                <select name="status" style="background: #374151; color: white; border: 1px solid #4b5563; border-radius: 0.375rem; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <option value="pending"  {{ $case->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $case->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $case->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; cursor: pointer;">
                                    Save
                                </button>
                            </form>

                            {{-- Assign Judge --}}
                            <form method="POST" action="{{ route('admin.cases.assignJudge', $case) }}" style="display: flex; gap: 0.25rem;">
                                @csrf
                                @method('PATCH')
                                <select name="judge_id" style="background: #374151; color: white; border: 1px solid #4b5563; border-radius: 0.375rem; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <option value="">Assign Judge</option>
                                    @foreach($judges as $judge)
                                        <option value="{{ $judge->id }}" {{ $case->judge_id === $judge->id ? 'selected' : '' }}>
                                            {{ $judge->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" style="background: #065f46; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; cursor: pointer;">
                                    Assign
                                </button>
                            </form>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.cases.destroy', $case) }}"
                                  onsubmit="return confirm('Delete this case?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #7f1d1d; color: #fca5a5; border: none; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; cursor: pointer;">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

@endsection