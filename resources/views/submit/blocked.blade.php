@extends('layouts.app')

@section('title', 'Daftarkan Properti — Huniku')

@section('page-style')
  .blocked-wrap{min-height:calc(100vh - 200px);display:flex;align-items:center;justify-content:center;padding:60px 20px;}
  .blocked-card{background:var(--surface);border:1px solid var(--border);border-radius:22px;padding:44px;max-width:460px;text-align:center;}
  .blocked-card .icon-badge{width:56px;height:56px;border-radius:16px;background:var(--surface-alt);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;}
  .blocked-card h1{font-size:22px;font-weight:700;}
  .blocked-card p{color:var(--text-soft);font-size:14.5px;margin-top:10px;line-height:1.6;}
  .blocked-card .btn{margin-top:24px;}
  .rejection-box{background:rgba(194,69,69,0.08);color:#C24545;border-radius:12px;padding:14px;font-size:13px;margin-top:18px;text-align:left;}
@endsection

@section('content')
<div class="wrap">
  <div class="blocked-wrap">
    <div class="blocked-card">
      @if (auth()->user()->isPendingDeveloper())
        <div class="icon-badge">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--text)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <h1>Akun kamu lagi ditinjau</h1>
        <p>Tim Huniku lagi verifikasi akun developer kamu. Biasanya diproses 1x24 jam — begitu disetujui, kamu langsung bisa daftarkan properti.</p>
      @elseif (auth()->user()->isRejectedDeveloper())
        <div class="icon-badge">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#C24545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
        </div>
        <h1>Pendaftaran developer ditolak</h1>
        <p>Akun developer kamu belum bisa diverifikasi. Hubungi tim Huniku buat info lebih lanjut atau perbaikan data.</p>
        @if (auth()->user()->developer_rejection_reason)
          <div class="rejection-box">Alasan: {{ auth()->user()->developer_rejection_reason }}</div>
        @endif
      @else
        <div class="icon-badge">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--text)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg>
        </div>
        <h1>Fitur ini khusus developer</h1>
        <p>Akun kamu terdaftar sebagai pembeli/penyewa. Buat daftarkan properti sendiri, kamu perlu bikin akun developer dulu (data tambahan + verifikasi tim Huniku).</p>
      @endif

      <a href="{{ route('home') }}" class="btn btn-ghost">Kembali ke Beranda</a>
    </div>
  </div>
</div>
@endsection