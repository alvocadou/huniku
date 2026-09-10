@extends('layouts.app')

@section('title', 'Daftar — Huniku')

@section('page-style')
  .select-wrap{min-height:calc(100vh - 200px);display:flex;align-items:center;justify-content:center;padding:60px 20px;}
  .select-inner{max-width:760px;width:100%;text-align:center;}
  .select-inner h1{font-size:28px;font-weight:700;}
  .select-inner p.sub{color:var(--text-soft);margin-top:8px;font-size:15px;}
  .type-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:36px;}
  @media(max-width:600px){.type-grid{grid-template-columns:1fr;}}
  .type-card{
    background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:32px 26px;
    text-align:left;transition:transform .15s ease, border-color .15s ease;
  }
  .type-card:hover{transform:translateY(-3px);border-color:var(--teal);}
  .type-card .icon-badge{
    width:48px;height:48px;border-radius:14px;background:var(--teal-soft);color:var(--accent-text);
    display:flex;align-items:center;justify-content:center;margin-bottom:18px;
  }
  .type-card .icon-badge svg{width:24px;height:24px;}
  .type-card h3{font-size:19px;font-weight:700;margin-bottom:8px;}
  .type-card p{font-size:14px;color:var(--text-soft);line-height:1.6;}
  .type-card .btn{margin-top:20px;width:100%;}
  .switch-link{text-align:center;margin-top:28px;font-size:13.5px;color:var(--text-soft);}
  .switch-link a{color:var(--accent-text);font-weight:700;}
@endsection

@section('content')
<div class="wrap">
  <div class="select-wrap">
    <div class="select-inner">
      <h1>Mau daftar sebagai apa?</h1>
      <p class="sub">Pilih tipe akun yang sesuai — bisa dibedain nanti prosesnya.</p>

      <div class="type-grid">
        <div class="type-card">
          <div class="icon-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h3>Pembeli / Penyewa</h3>
          <p>Cari, sewa, atau beli hunian. Bisa simpan favorit dan lihat riwayat pencarian. Pendaftaran cepat, cukup nama, email, dan password.</p>
          <a href="{{ route('register', ['type' => 'pembeli']) }}" class="btn btn-ghost">Daftar sebagai Pembeli</a>
        </div>

        <div class="type-card">
          <div class="icon-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg>
          </div>
          <h3>Developer / Pemilik Properti</h3>
          <p>Daftarkan dan kelola properti buat dijual/disewakan di Huniku. Butuh data tambahan (kontak, sosmed) dan verifikasi tim Huniku dulu sebelum aktif.</p>
          <a href="{{ route('register', ['type' => 'developer']) }}" class="btn btn-primary">Daftar sebagai Developer</a>
        </div>
      </div>

      <div class="switch-link">
        Udah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection