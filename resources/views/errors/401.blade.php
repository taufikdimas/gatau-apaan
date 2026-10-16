@extends('errors.layout')

@section('title', '401 · Otentikasi Diperlukan')
@section('code', '401')
@section('status_badge', 'SEC_AUTH // CREDENTIALS_REQUIRED')
@section('accent_color', '#6366f1')
@section('accent_color_rgb', '99, 102, 241')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
    <circle cx="12" cy="7" r="4"/>
</svg>
@endsection

@section('heading', 'Otentikasi Identitas Diperlukan')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Akses ke sumber daya ini mewajibkan otentikasi identitas yang sah. Sesi login Anda mungkin telah berakhir atau Anda belum memasukkan kredensial yang tepat.' }}
@endsection

@section('humor')
"Halt, penjelajah siber! Sentinel keamanan kami tidak mengizinkan tamu tanpa kartu tanda pengenal melintas. Silakan login terlebih dahulu di gerbang depan."
@endsection
