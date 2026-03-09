@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')

    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Manage Users 👥</h3>
            <p style="color: #9ca3af; margin-top: 0.25rem;">View and manage all registered users.</p>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div style="background: #064e3b; border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #7f1d1d; border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Users Table --}}
    <div style="background: #1f2937; border-radius: 0.75rem; border: 1px solid #374151; overflow: hidden;">

        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #374151;">
            <h4 style="color: white; font-weight: 600;">All Users ({{ $users->count() }})</h4>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #111827;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">#</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">Name</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">Email</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">Role</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">Joined</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-top: 1px solid #374151;">

                    {{-- ID --}}
                    <td style="padding: 1rem 1.5rem; color: #9ca3af; font-size: 0.875rem;">{{ $user->id }}</td>

                    {{-- Name --}}
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: #4f46e5; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; color: white;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="color: white; font-weight: 500;">{{ $user->name }}</span>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td style="padding: 1rem 1.5rem; color: #9ca3af; font-size: 0.875rem;">{{ $user->email }}</td>

                    {{-- Role Badge --}}
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $roleColors = [
                                'admin'   => 'background:#312e81; color:#a5b4fc;',
                                'judge'   => 'background:#1e3a5f; color:#93c5fd;',
                                'lawyer'  => 'background:#064e3b; color:#6ee7b7;',
                                'citizen' => 'background:#374151; color:#d1d5db;',
                            ];
                            $roleStyle = $roleColors[$user->role] ?? $roleColors['citizen'];
                        @endphp
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; {{ $roleStyle }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    {{-- Joined Date --}}
                    <td style="padding: 1rem 1.5rem; color: #9ca3af; font-size: 0.875rem;">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>

                    {{-- Actions --}}
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">

                            {{-- Change Role Form --}}
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" style="display: flex; gap: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <select name="role"
                                        style="background: #374151; color: white; border: 1px solid #4b5563; border-radius: 0.375rem; padding: 0.25rem 0.5rem; font-size: 0.875rem;">
                                    <option value="citizen"  {{ $user->role === 'citizen'  ? 'selected' : '' }}>Citizen</option>
                                    <option value="lawyer"   {{ $user->role === 'lawyer'   ? 'selected' : '' }}>Lawyer</option>
                                    <option value="judge"    {{ $user->role === 'judge'    ? 'selected' : '' }}>Judge</option>
                                    <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit"
                                        style="background: #4f46e5; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">
                                    Save
                                </button>
                            </form>

                            {{-- Delete Form --}}
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background: #7f1d1d; color: #fca5a5; border: none; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection