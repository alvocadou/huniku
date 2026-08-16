@extends('layouts.app')

@section('title', 'Masuk — Huniku')

@section('page-style')
  .login-wrap{min-height:calc(100vh - 200px);display:flex;align-items:center;justify-content:center;padding:60px 20px;}
  .login-card{background:var(--surface);border:1px solid var(--border);border-radius:22px;padding:40px;width:100%;max-width:400px;}
  .login-card h1{font-size:24px;font-weight:700;text-align:center;}
  .login-card p.sub{color:var(--text-soft);font-size:14px;text-align:center;margin-top:6px;}
  .field-group{margin-top:22px;}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=email], input[type=password]{
    width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);
    background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;
  }
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .remember-row{display:flex;align-items:center;gap:8px;margin-top:16px;font-size:13.5px;color:var(--text-soft);}
  .remember-row input{width:auto;}
  .login-card .btn{width:100%;margin-top:24px;}
@endsection

@section('content')
<div class="wrap">
  <div class="login-wrap">
    <div class="login-card">
      <h1>Masuk ke Huniku</h1>
      <p class="sub">Khusus buat pengelola listing.</p>

      @if ($errors->any())
        <div class="error-text" style="margin-top:18px;text-align:center;">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

        <div class="field-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="kamu@huniku.test" autofocus>
        </div>

        <div class="field-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="••••••••">
        </div>

        <label class="remember-row">
          <input type="checkbox" name="remember"> Ingat saya
        </label>

        <button type="submit" class="btn btn-primary">Masuk</button>
      </form>

      <div class="switch-link" style="text-align:center;margin-top:20px;font-size:13.5px;color:var(--text-soft);">
        Belum punya akun? <a href="{{ route('register') }}{{ request('redirect') ? '?redirect=' . urlencode(request('redirect')) : '' }}" style="color:var(--accent-text);font-weight:700;">Daftar di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection