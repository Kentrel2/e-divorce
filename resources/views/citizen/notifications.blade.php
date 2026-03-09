@extends('layouts.citizen')

@section('title', 'Notifications')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: white;">Notifications 🔔</h3>
        <p style="color: #94a3b8; margin-top: 0.25rem;">Stay updated on your case status.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1rem;">

        @if($notifications->count() === 0)
            <div style="background: #1e293b; border-radius: 0.75rem; border: 1px solid #334155; padding: 3rem; text-align: center; color: #94a3b8;">
                <p style="font-size: 3rem;">🔔</p>
                <p style="margin-top: 1rem;">No notifications yet.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">You'll be notified when your case status changes.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                @php
                    $borderColors = [
                        'success' => '#10b981',
                        'danger'  => '#ef4444',
                        'warning' => '#f59e0b',
                        'info'    => '#3b82f6',
                    ];
                    $bgColors = [
                        'success' => '#064e3b',
                        'danger'  => '#7f1d1d',
                        'warning' => '#422006',
                        'info'    => '#1e3a5f',
                    ];
                    $border = $borderColors[$notification->type] ?? $borderColors['info'];
                    $bg     = $bgColors[$notification->type] ?? $bgColors['info'];
                @endphp
                <div style="background: {{ $bg }}; border-radius: 0.75rem; border: 1px solid {{ $border }}; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: white; font-weight: 600; margin-bottom: 0.25rem;">{{ $notification->title }}</p>
                        <p style="color: #94a3b8; font-size: 0.875rem;">{{ $notification->message }}</p>
                        <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.5rem;">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notification->is_read)
                        <span style="background: #ef4444; color: white; font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.5rem; border-radius: 9999px;">
                            NEW
                        </span>
                    @endif
                </div>
            @endforeach
        @endif

    </div>

@endsection