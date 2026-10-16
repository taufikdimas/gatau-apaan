@extends('errors.layout')

@section('title', '429 · Terlalu Banyak Permintaan')
@section('code', '429')
@section('status_badge', 'SEC_THROTTLE // RATE_LIMIT_TRIGGERED')
@section('accent_color', '#f97316')
@section('accent_color_rgb', '249, 115, 22')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
</svg>
@endsection

@section('heading', 'Terlalu Banyak Permintaan (Rate Limited)')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Sistem proteksi lalu lintas kami mendeteksi lonjakan request yang melampaui batas wajar dari IP Anda. Demi menjaga performa dan melindungi server dari banjir request, akses ditahan sejenak.' }}
@endsection

@section('humor')
"Jari Anda bergerak secepat serangan DDoS multithread! Tarik napas, hembuskan perlahan, nikmati secangkir teh, dan tunggu cooldown beberapa detik."
@endsection
