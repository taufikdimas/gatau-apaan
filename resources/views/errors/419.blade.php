@extends('errors.layout')

@section('title', '419 · Sesi Kedaluwarsa')
@section('code', '419')
@section('status_badge', 'SEC_AUTH // TOKEN_LIFETIME_EXPIRED')
@section('accent_color', '#10b981')
@section('accent_color_rgb', '16, 185, 129')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <polyline points="12 6 12 12 16 14"/>
</svg>
@endsection

@section('heading', 'Sesi Keamanan Telah Kedaluwarsa')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Token otentikasi CSRF pada formulir ini telah kedaluwarsa karena tidak ada aktivitas selama beberapa waktu. Fitur ini sengaja dirancang untuk melindungi Anda dari serangan pemalsuan request (Cross-Site Request Forgery).' }}
@endsection

@section('humor')
"Kunci sesi sementara telah hancur dengan sendirinya demi keamanan akun Anda bak rekaman rahasia Mission: Impossible. Cukup muat ulang halaman untuk membuat kunci baru!"
@endsection
