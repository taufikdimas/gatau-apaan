@extends('errors.layout')

@section('title', '404 · Halaman Tidak Ditemukan')
@section('code', '404')
@section('status_badge', 'SEC_STATUS // TARGET_NOT_FOUND')
@section('accent_color', '#06b6d4')
@section('accent_color_rgb', '6, 182, 212')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <path d="M16 16s-1.5-2-4-2-4 2-4 2"/>
    <line x1="9" y1="9" x2="9.01" y2="9"/>
    <line x1="15" y1="9" x2="15.01" y2="9"/>
</svg>
@endsection

@section('heading', 'Koordinat Target Tidak Ditemukan')

@section('description')
{{ (!empty($exception?->getMessage())) ? $exception->getMessage() : 'Halaman atau endpoint yang Anda cari sepertinya telah berpindah dimensi, dihapus, atau tersesat di dalam labirin dark web. Radar kami sudah memindai seluruh subnet namun hasilnya nihil.' }}
@endsection

@section('humor')
"Di balik setiap error 404, ada paket data yang sedang tersesat dan bertanya arah jalan pulang ke router tetangga."
@endsection
