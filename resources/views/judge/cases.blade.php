@extends('layouts.judge')

@section('title', 'My Assigned Cases')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">My Assigned Cases 📁</h3>
        <p style="color: #94a3b8; margin-top: 0.25rem;">Review and update the status of your assigned cases.</p>
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
                <p style="margin-top: 1rem;">No cases assigned to you yet.</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #0f172a;">
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Case #</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Petitioner</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Respondent</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Description</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Status</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $case)
                    <tr style="border-top: 1px solid #334155;">
                       <td style="padding: 1rem 1.5rem; font-weight: 600;">
    <a href="{{ route('judge.cases.show', $case) }}" style="color: #818cf8; text-decoration: none;">
        {{ $case->case_number }}
    </a>
</td>
                        <td style="padding: 1rem 1.5rem; color: white;">{{ $case->petitioner_name }}</td>
                        <td style="padding: 1rem 1.5rem; color: white;">{{ $case->respondent_name }}</td>
                        <td style="padding: 1rem 1.5rem; color: #94a3b8; font-size: 0.875rem; max-width: 200px;">
                            {{ Str::limit($case->description, 60) }}
                        </td>
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
                        <td style="padding: 1rem 1.5rem;">
                            <form method="POST" action="{{ route('judge.cases.updateStatus', $case) }}" style="display: flex; gap: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <select name="status" style="background: #334155; color: white; border: 1px solid #475569; border-radius: 0.375rem; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <option value="pending"  {{ $case->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $case->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $case->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" style="background: #1e3a5f; color: #93c5fd; border: none; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; cursor: pointer;">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection