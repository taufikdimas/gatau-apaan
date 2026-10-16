@extends('errors.layout')

@section('title', '500 · Gangguan Server')
@section('code', '500')
@section('status_badge', 'SEC_CORE // KERNEL_PANIC_ANOMALY')
@section('accent_color', '#a855f7')
@section('accent_color_rgb', '168, 85, 247')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"/>
    <rect x="2" y="14" width="20" height="8" rx="2" ry="2"/>
    <line x1="6" y1="6" x2="6.01" y2="6"/>
    <line x1="6" y1="18" x2="6.01" y2="18"/>
    <path d="M13 6l-3 6h4l-3 6"/>
</svg>
@endsection

@section('heading', 'Terjadi Malfungsi Pada Inti Server')

@section('description')
{{ (app()->environment('local') && !empty($exception?->getMessage())) ? $exception->getMessage() : 'Server kami baru saja mengalami korsleting logika atau unhandled exception. Sistem pencatatan otomatis kami telah menandai kejadian ini dan tim teknisi sedang memperbaikinya.' }}
@endsection

@section('humor')
"CPU overheat, memori terfragmentasi, dan seorang developer baru saja berteriak 'Tapi kemarin di localhost lancar jaya!'. Tetap santai, kami sedang memperbaikinya."
@endsection
