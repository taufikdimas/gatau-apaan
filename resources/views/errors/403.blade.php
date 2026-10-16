@extends('errors.layout')

@section('title', '403 · Akses Ditolak')
@section('code', '403')
@section('status_badge', 'SEC_PERIMETER // ACCESS_FORBIDDEN')
@section('accent_color', '#ef4444')
@section('accent_color_rgb', '239, 68, 68')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
    <circle cx="12" cy="16" r="1.5"/>
</svg>
@endsection

@section('heading', 'Perimeter Terkunci & Akses Ditolak')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Area ini dilindungi firewall tingkat tinggi dan protokol isolasi ketat. Kredensial atau tingkat izin (clearance) akun Anda saat ini tidak mencukupi untuk membuka sektor ini.' }}
@endsection

@section('humor')
"Sistem IDS/IPS mendeteksi Anda mencoba masuk tanpa otorisasi tingkat Alpha. Tenang, kami belum mengirim tim cyber patrol... setidaknya belum untuk hari ini."
@endsection
