@extends('errors.layout')

@section('title', '503 · Dalam Pemeliharaan')
@section('code', '503')
@section('status_badge', 'SEC_OPS // SCHEDULED_MAINTENANCE')
@section('accent_color', '#eab308')
@section('accent_color_rgb', '234, 179, 8')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
</svg>
@endsection

@section('heading', 'Sistem Sedang Dalam Pemeliharaan Terjadwal')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Kami sedang melakukan patching celah keamanan terbaru, hardening perimeter firewall, dan defragmentasi cluster server. Layanan akan kembali beroperasi normal dalam beberapa saat.' }}
@endsection

@section('humor')
"Sedang mengganti oli server, membersihkan sarang laba-laba di rak data center, dan menyeduh kopi kedua untuk sysadmin. Segera kembali online!"
@endsection
