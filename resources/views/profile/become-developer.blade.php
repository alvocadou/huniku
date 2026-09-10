@extends('layouts.app')

@section('title', 'Jadi Developer — Huniku')

@section('page-style')
  .form-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .form-header h1{font-size:28px;font-weight:700;}
  .form-wrap{max-width:520px;margin:32px auto 70px;}
  .form-card{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:32px;}
  .info-banner{background:var(--teal-soft);color:var(--accent-text);padding:14px 18px;border-radius:14px;font-size:13.5px;font-weight:600;margin-bottom:24px;}
  .field-group{margin-bottom:18px;}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=text], input[type=tel]{
    width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);
    background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;
  }
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:26px;padding-top:22px;border-top:1px solid var(--border);}
@endsection

@section('content')
<div class="wrap">
  <div class="form-header">
    <a href="{{ route('profile.edit') }}" class="btn btn-ghost" style="margin-bottom:16px;">&larr; Kembali ke Profil</a>
    <h1>Jadi Developer</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Lengkapi data ini buat mulai daftarkan properti di Huniku.</p>
  </div>

  <div class="form-wrap">
    <div class="info-banner">Akun kamu bakal ditinjau tim Huniku dulu (biasanya 1x24 jam) sebelum bisa daftarkan properti.</div>

    <div class="form-card">
      <form action="{{ route('profile.become-developer.store') }}" method="POST">
        @csrf

        <div class="field-group">
          <label>Nama Perusahaan / Developer</label>
          <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Contoh: PT Griya Sejahtera">
          @error('company_name') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Nomor Telepon / HP</label>
          <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
          @error('phone') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Nomor WhatsApp (opsional)</label>
          <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx">
        </div>

        <div class="field-group">
          <label>Instagram (opsional)</label>
          <input type="text" name="instagram" value="{{ old('instagram') }}" placeholder="@namaakun">
        </div>

        <div class="form-actions">
          <a href="{{ route('profile.edit') }}" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection