@extends('layouts.app')

@section('title', 'Profil Saya — Huniku')

@section('page-style')
  .profile-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .profile-header h1{font-size:28px;font-weight:700;}
  .profile-wrap{max-width:640px;margin:32px auto 70px;display:flex;flex-direction:column;gap:24px;}

  .profile-card{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:32px;}
  .profile-card h3{font-size:18px;font-weight:700;margin-bottom:6px;}
  .profile-card .card-sub{font-size:13.5px;color:var(--text-soft);margin-bottom:22px;}

  .field-group{margin-bottom:18px;}
  .field-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  @media(max-width:520px){.field-row{grid-template-columns:1fr;}}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=text], input[type=email], input[type=password]{
    width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);
    background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;
  }
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .section-divider{margin-top:22px;padding-top:20px;border-top:1px solid var(--border);}
  .section-divider .label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-soft);margin-bottom:14px;}

  .dev-status-row{display:flex;align-items:center;gap:12px;padding:16px;background:var(--surface-alt);border-radius:14px;}
  .dev-status-row .dot{width:8px;height:8px;border-radius:100px;flex-shrink:0;}
  .dot-pending{background:#E8A93A;}
  .dot-verified{background:var(--teal);}
  .dot-rejected{background:#C24545;}
  .dev-status-row .info{font-size:13.5px;}
  .dev-status-row .info b{display:block;font-size:14.5px;margin-bottom:2px;}

  .upgrade-banner{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;}
  .upgrade-banner p{font-size:13.5px;color:var(--text-soft);max-width:360px;}
@endsection

@section('content')
<div class="wrap">
  <div class="profile-header">
    <h1>Profil Saya</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Kelola informasi akun kamu.</p>
  </div>

  <div class="profile-wrap">
    <div class="profile-card">
      <h3>Informasi Akun</h3>
      <p class="card-sub">Ganti nama, email, atau password kamu.</p>

      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field-group">
          <label>Nama</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}">
          @error('name') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}">
          @error('email') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="section-divider">
          <div class="label">Ganti Password (opsional)</div>
        </div>

        <div class="field-row">
          <div class="field-group">
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Kosongin kalau nggak mau ganti">
            @error('password') <div class="error-text">{{ $message }}</div> @enderror
          </div>
          <div class="field-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </form>
    </div>

    @if ($user->isDeveloper())
      <div class="profile-card">
        <h3>Status Developer</h3>
        <p class="card-sub">{{ $user->company_name }}</p>

        <div class="dev-status-row">
          @if ($user->developer_status === 'pending')
            <span class="dot dot-pending"></span>
            <div class="info"><b>Menunggu Verifikasi</b>Tim Huniku lagi tinjau akun developer kamu.</div>
          @elseif ($user->developer_status === 'verified')
            <span class="dot dot-verified"></span>
            <div class="info"><b>Terverifikasi</b>Kamu udah bisa daftarkan properti di Huniku.</div>
          @else
            <span class="dot dot-rejected"></span>
            <div class="info"><b>Ditolak</b>{{ $user->developer_rejection_reason ?: 'Hubungi tim Huniku buat info lebih lanjut.' }}</div>
          @endif
        </div>
      </div>
    @else
      <div class="profile-card upgrade-banner">
        <div>
          <h3>Punya properti buat dijual/disewakan?</h3>
          <p>Upgrade akun kamu jadi Developer buat mulai daftarkan properti di Huniku.</p>
        </div>
        <a href="{{ route('profile.become-developer') }}" class="btn btn-primary">Jadi Developer</a>
      </div>
    @endif
  </div>
</div>
@endsection