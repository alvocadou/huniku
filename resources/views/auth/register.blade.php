@extends('layouts.app')

@section('title', 'Daftar — Huniku')

@section('page-style')
  .login-wrap{min-height:calc(100vh - 200px);display:flex;align-items:center;justify-content:center;padding:60px 20px;}
  .login-card{background:var(--surface);border:1px solid var(--border);border-radius:22px;padding:40px;width:100%;max-width:400px;}
  .login-card h1{font-size:24px;font-weight:700;text-align:center;}
  .login-card p.sub{color:var(--text-soft);font-size:14px;text-align:center;margin-top:6px;}
  .field-group{margin-top:22px;}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=text], input[type=email], input[type=password]{
    width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);
    background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;
  }
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .login-card .btn{width:100%;margin-top:24px;}
  .switch-link{text-align:center;margin-top:20px;font-size:13.5px;color:var(--text-soft);}
  .switch-link a{color:var(--accent-text);font-weight:700;}
@endsection

@section('content')
<div class="wrap">
  <div class="login-wrap">
    <div class="login-card">
      <h1>Buat Akun Huniku</h1>
      <p class="sub">Buat kelola listing propertimu.</p>

      <form action="{{ route('register.attempt') }}" method="POST">
        @csrf
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

        <div class="field-group">
          <label>Nama</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" autofocus>
          @error('name') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="kamu@email.com">
          @error('email') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Minimal 8 karakter">
          @error('password') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="field-group">
          <label>Konfirmasi Password</label>
          <input type="password" name="password_confirmation" placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
      </form>

      <div class="switch-link">
        Udah punya akun? <a href="{{ route('login') }}{{ request('redirect') ? '?redirect=' . urlencode(request('redirect')) : '' }}">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection