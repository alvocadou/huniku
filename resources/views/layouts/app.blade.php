<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Huniku — Satu Pintu untuk Semua Hunian')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<script>
  (function () {
    var saved = localStorage.getItem('huniku-theme');
    var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>
<style>
  :root{
    --cream:#F3ECE0;
    --ink:#17181C;
    --teal:#0F6E56;
    --teal-deep:#0B5443;
    --teal-soft:#CFE9DF;
    --clay:#B5652E;
    --clay-soft:#EBD3C0;
    --accent-text:var(--teal-deep);
    --bg:var(--cream);
    --surface:#ffffff;
    --surface-alt:#EAE1D2;
    --text:var(--ink);
    --text-soft:#5B564B;
    --border: rgba(23,24,28,0.12);
    --hover-tint: rgba(23,24,28,0.05);
  }
  html[data-theme="dark"]{
    --bg:#14151A;
    --surface:#1D1E24;
    --surface-alt:#21222A;
    --text:#F3ECE0;
    --text-soft:#B7B2A6;
    --border: rgba(243,236,224,0.12);
    --hover-tint: rgba(243,236,224,0.08);
    --teal-soft: rgba(51,201,156,0.16);
    --accent-text:#4FD8AE;
  }
  *{box-sizing:border-box;}
  html{scroll-behavior:smooth;}
  body{margin:0;background:var(--bg);color:var(--text);font-family:'Manrope',sans-serif;-webkit-font-smoothing:antialiased;transition:background-color .25s ease, color .25s ease;}
  h1,h2,h3,.display{font-family:'Sora',sans-serif;letter-spacing:-0.02em;margin:0;}
  .mono{font-family:'JetBrains Mono',monospace;letter-spacing:0.08em;text-transform:uppercase;}
  a{color:inherit;text-decoration:none;}
  .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}
  @media(max-width:640px){.wrap{padding:0 20px;}}

  .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 26px;border-radius:100px;font-weight:600;font-size:15px;border:1px solid transparent;cursor:pointer;transition:transform .15s ease, background .2s ease;}
  .btn:hover{transform:translateY(-1px);}
  .btn-primary{background:var(--teal);color:#fff;}
  .btn-primary:hover{background:var(--teal-deep);}
  .btn-ghost{background:transparent;color:var(--text);border-color:var(--border);}
  .btn-ghost:hover{background:var(--hover-tint);}
  .btn-light{background:var(--cream);color:var(--ink);}

  .theme-toggle{width:40px;height:40px;border-radius:100px;border:1px solid var(--border);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text);flex-shrink:0;}
  .theme-toggle:hover{background:var(--hover-tint);}
  .theme-toggle svg{width:18px;height:18px;}
  .theme-toggle .icon-moon{display:none;}
  html[data-theme="dark"] .theme-toggle .icon-sun{display:none;}
  html[data-theme="dark"] .theme-toggle .icon-moon{display:block;}

  nav{position:sticky;top:0;z-index:50;background:color-mix(in srgb, var(--bg) 88%, transparent);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);transition:background-color .25s ease, border-color .25s ease;}
  .nav-inner{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;padding:18px 0;gap:16px;}
  .logo{display:flex;align-items:center;gap:10px;font-family:'Sora',sans-serif;font-weight:700;font-size:20px;justify-self:start;}
  .nav-links{display:flex;gap:32px;font-size:15px;font-weight:500;color:var(--text-soft);justify-self:center;white-space:nowrap;}
  .nav-links a:hover{color:var(--text);}
  .nav-actions{display:flex;align-items:center;justify-self:end;}
  @media(max-width:860px){.nav-links{display:none;}.nav-inner{grid-template-columns:auto 1fr auto;}}

  /* kebab (titik tiga) dropdown menu di navbar */
  .kebab-wrap{position:relative;}
  .kebab-btn{
    width:40px;height:40px;border-radius:100px;border:1px solid var(--border);background:transparent;
    display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text);
  }
  .kebab-btn:hover{background:var(--hover-tint);}
  .kebab-btn svg{width:18px;height:18px;}
  .kebab-menu{
    position:absolute;top:calc(100% + 10px);right:0;min-width:220px;z-index:70;
    background:var(--surface);border:1px solid var(--border);border-radius:16px;
    box-shadow:0 20px 40px -18px rgba(0,0,0,0.35);padding:8px;
    opacity:0;pointer-events:none;transform:translateY(-6px);transition:opacity .15s ease, transform .15s ease;
  }
  .kebab-wrap.open .kebab-menu{opacity:1;pointer-events:auto;transform:translateY(0);}
  .kebab-item{
    display:flex;align-items:center;gap:10px;width:100%;text-align:left;
    padding:10px 12px;border-radius:10px;font-size:14px;font-weight:600;color:var(--text);
    background:none;border:none;cursor:pointer;font-family:'Manrope',sans-serif;
  }
  .kebab-item:hover{background:var(--hover-tint);}
  .kebab-item svg{width:16px;height:16px;flex-shrink:0;}
  .kebab-item .icon-moon{display:none;}
  html[data-theme="dark"] .kebab-item .icon-sun{display:none;}
  html[data-theme="dark"] .kebab-item .icon-moon{display:block;}
  .kebab-item-accent{color:var(--teal);}
  .kebab-item-danger{color:#C24545;}
  .kebab-divider{height:1px;background:var(--border);margin:6px 4px;}

  .tag{display:inline-block;font-size:11px;font-weight:700;padding:5px 10px;border-radius:100px;background:var(--teal-soft);color:var(--accent-text);margin-bottom:12px;}
  .sale-badge{position:absolute;top:14px;right:14px;background:var(--ink);color:var(--cream);font-size:11px;font-weight:700;padding:6px 12px;border-radius:100px;}

  .listing-card{background:var(--surface);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:box-shadow .2s ease, transform .2s ease, background-color .25s ease, border-color .25s ease;}
  .listing-card:hover{box-shadow:0 20px 40px -28px rgba(23,24,28,0.3);transform:translateY(-3px);}
  .listing-thumb{height:180px;position:relative;}
  .listing-body{padding:20px;}
  .listing-body h3{font-size:17px;font-weight:700;}
  .listing-body .loc{font-size:13px;color:var(--text-soft);margin-top:4px;}
  .listing-foot{display:flex;justify-content:space-between;align-items:center;margin-top:16px;padding-top:16px;border-top:1px solid var(--border);}
  .price b{font-family:'Sora',sans-serif;font-size:18px;}
  .price span{font-size:12px;color:var(--text-soft);}

  footer{border-top:1px solid var(--border);padding:50px 0 34px;transition:border-color .25s ease;}
  .foot-top{display:flex;justify-content:space-between;gap:40px;flex-wrap:wrap;margin-bottom:40px;}
  .foot-cols{display:flex;gap:60px;flex-wrap:wrap;}
  .foot-col h4{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-soft);margin-bottom:14px;}
  .foot-col a{display:block;font-size:14.5px;padding:5px 0;color:var(--text);}
  .foot-col a:hover{color:var(--accent-text);}
  .foot-bottom{display:flex;justify-content:space-between;align-items:center;padding-top:24px;border-top:1px solid var(--border);font-size:13px;color:var(--text-soft);flex-wrap:wrap;gap:10px;}

  /* toast notification */
  #toastStack{position:fixed;top:20px;right:20px;z-index:200;display:flex;flex-direction:column;gap:10px;}
  .toast{
    display:flex;align-items:center;gap:10px;background:var(--ink);color:var(--cream);
    padding:14px 18px;border-radius:14px;font-size:14px;font-weight:600;
    box-shadow:0 16px 30px -14px rgba(0,0,0,0.4);
    transform:translateX(120%);opacity:0;transition:transform .3s ease, opacity .3s ease;
    max-width:340px;
  }
  .toast.show{transform:translateX(0);opacity:1;}
  .toast.toast-error{background:#C24545;}
  .toast .toast-icon{flex-shrink:0;}

  /* confirm-style modal (replaces native window.alert) */
  .modal-overlay{
    position:fixed;inset:0;background:rgba(23,24,28,0.55);z-index:300;
    display:flex;align-items:center;justify-content:center;padding:20px;
    opacity:0;pointer-events:none;transition:opacity .2s ease;
  }
  .modal-overlay.show{opacity:1;pointer-events:auto;}
  .modal-card{
    background:var(--surface);border-radius:22px;padding:32px;max-width:360px;width:100%;
    text-align:center;transform:scale(.92);transition:transform .2s ease;
    box-shadow:0 30px 60px -20px rgba(0,0,0,0.35);
  }
  .modal-overlay.show .modal-card{transform:scale(1);}
  .modal-card h3{font-size:20px;font-weight:700;margin-bottom:10px;}
  .modal-card p{font-size:14.5px;color:var(--text-soft);line-height:1.5;}
  .modal-actions{display:flex;gap:10px;margin-top:24px;}
  .modal-actions .btn{flex:1;padding:12px;}

  /* custom select dropdown (replaces native <select> menu styling) */
  .cs-wrap{
    position:relative;display:inline-block;
    background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:11px 14px;
  }
  .search-field .cs-wrap{background:transparent;border:none;padding:0;width:100%;}
  .cs-trigger{
    width:100%;text-align:left;background:transparent;border:none;outline:none;cursor:pointer;
    font-family:'Manrope',sans-serif;font-size:15px;font-weight:600;color:var(--text);
    display:flex;align-items:center;justify-content:space-between;gap:8px;padding:0;
  }
  .cs-trigger svg{flex-shrink:0;width:14px;height:14px;color:var(--text-soft);transition:transform .15s ease;}
  .cs-wrap.open .cs-trigger svg{transform:rotate(180deg);}
  .cs-menu{
    position:absolute;top:calc(100% + 8px);left:0;min-width:160px;z-index:60;
    background:var(--surface);border:1px solid var(--border);border-radius:14px;
    box-shadow:0 20px 40px -20px rgba(0,0,0,0.35);padding:6px;
    opacity:0;pointer-events:none;transform:translateY(-6px);transition:opacity .15s ease, transform .15s ease;
  }
  .cs-wrap.open .cs-menu{opacity:1;pointer-events:auto;transform:translateY(0);}
  .cs-option{
    padding:10px 12px;border-radius:9px;font-size:14px;font-weight:600;color:var(--text);
    cursor:pointer;white-space:nowrap;
  }
  .cs-option:hover{background:var(--teal-soft);color:var(--accent-text);}
  .cs-option.selected{color:var(--accent-text);background:var(--teal-soft);}

  /* favorite heart button */
  .fav-btn{
    position:absolute;top:14px;left:14px;width:34px;height:34px;border-radius:100px;
    background:rgba(23,24,28,0.55);backdrop-filter:blur(4px);border:none;cursor:pointer;
    display:flex;align-items:center;justify-content:center;z-index:2;transition:transform .15s ease;
  }
  .fav-btn:hover{transform:scale(1.08);}
  .fav-btn svg{width:17px;height:17px;stroke:#fff;fill:none;stroke-width:2;transition:fill .15s ease, stroke .15s ease;}
  .fav-btn.is-favorited svg{fill:#E24C6D;stroke:#E24C6D;}
  .fav-btn-large{position:static;width:44px;height:44px;background:var(--surface-alt);}
  .fav-btn-large svg{stroke:var(--text);}
  .fav-btn-large.is-favorited svg{fill:#E24C6D;stroke:#E24C6D;}

  @yield('page-style')
</style>
</head>
<body>

<nav>
  <div class="wrap nav-inner">
    <a href="{{ url('/') }}" class="logo">
      <svg width="26" height="26" viewBox="0 0 100 100" fill="none">
        <path d="M14 46 L50 16 L86 46" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M24 40 L24 84 L76 84 L76 40" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      huniku
    </a>
    <div class="nav-links">
      <a href="{{ url('/') }}#kategori">Kategori</a>
      <a href="{{ route('listings.index') }}">Cari Properti</a>
      <a href="{{ url('/') }}#kenapa">Kenapa Huniku</a>
      <a href="{{ route('submit.create') }}">Daftarkan Properti</a>
    </div>
    <div class="nav-actions">
      <div class="kebab-wrap" id="navKebab">
        <button type="button" class="kebab-btn" onclick="document.getElementById('navKebab').classList.toggle('open')" aria-label="Buka menu">
          <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="19" r="2"/></svg>
        </button>
        <div class="kebab-menu">
          <button type="button" class="kebab-item" onclick="toggleTheme()">
            <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
            <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
            <span>Ganti Tema</span>
          </button>
          @auth
            <a href="{{ route('profile.edit') }}" class="kebab-item">Profil Saya</a>
            @if (auth()->user()->isDeveloper())
              <a href="{{ route('submit.index') }}" class="kebab-item">Listing Saya</a>
            @endif
            <a href="{{ route('favorites.index') }}" class="kebab-item">Favorit</a>
            @if (auth()->user()->is_admin)
              <a href="{{ route('admin.listings.index') }}" class="kebab-item">Kelola Listing</a>
              <a href="{{ route('admin.developers.index') }}" class="kebab-item">Kelola Developer</a>
            @endif
            <div class="kebab-divider"></div>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="kebab-item kebab-item-danger">Keluar</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="kebab-item">Masuk</a>
            <a href="{{ route('register') }}" class="kebab-item kebab-item-accent">Daftar</a>
          @endauth
        </div>
      </div>
    </div>
    </div>
  </div>
</nav>

@yield('content')

<div id="toastStack"></div>

<div class="modal-overlay" id="confirmModal">
  <div class="modal-card">
    <h3>Yakin?</h3>
    <p id="confirmModalMessage"></p>
    <div class="modal-actions">
      <button type="button" class="btn btn-ghost" onclick="confirmModalCancel()">Batal</button>
      <button type="button" class="btn btn-primary" onclick="confirmModalYes()">Iya</button>
    </div>
  </div>
</div>

<footer>
  <div class="wrap">
    <div class="foot-top">
      <div>
        <div class="logo" style="margin-bottom:10px;">
          <svg width="24" height="24" viewBox="0 0 100 100" fill="none">
            <path d="M14 46 L50 16 L86 46" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M24 40 L24 84 L76 84 L76 40" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          huniku
        </div>
        <p style="font-size:14px;color:var(--text-soft);max-width:260px;">Satu platform buat cari, sewa, atau beli rumah, kost, kontrakan, dan apartemen di seluruh Indonesia.</p>
      </div>
      <div class="foot-cols">
        <div class="foot-col">
          <h4>Jelajahi</h4>
          <a href="{{ url('/') }}#kategori">Kategori</a>
          <a href="{{ route('listings.index') }}">Cari Properti</a>
          <a href="{{ url('/') }}#kenapa">Kenapa Huniku</a>
        </div>
        <div class="foot-col">
          <h4>Pemilik</h4>
          <a href="{{ route('submit.create') }}">Daftarkan Properti</a>
          <a href="#">Panduan Pemilik</a>
          <a href="#">Biaya & Komisi</a>
        </div>
        <div class="foot-col">
          <h4>Perusahaan</h4>
          <a href="#">Tentang Kami</a>
          <a href="#">Bantuan</a>
          <a href="#">Kontak</a>
        </div>
      </div>
    </div>
    <div class="foot-bottom">
      <span>&copy; {{ date('Y') }} Huniku. Semua hak dilindungi.</span>
      <span>Dibuat di Indonesia 🇮🇩</span>
    </div>
  </div>
</footer>

<script>
  function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme');
    var next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('huniku-theme', next);
  }

  function showToast(message, type) {
    var stack = document.getElementById('toastStack');
    var toast = document.createElement('div');
    toast.className = 'toast' + (type === 'error' ? ' toast-error' : '');
    toast.innerHTML = '<span class="toast-icon">' + (type === 'error' ? '⚠' : '✓') + '</span><span>' + message + '</span>';
    stack.appendChild(toast);

    requestAnimationFrame(function () { toast.classList.add('show'); });

    setTimeout(function () {
      toast.classList.remove('show');
      setTimeout(function () { toast.remove(); }, 300);
    }, 4000);
  }

  var confirmModalCallback = null;

  function openConfirmModal(message, onConfirm) {
    confirmModalCallback = typeof onConfirm === 'function' ? onConfirm : null;
    document.getElementById('confirmModalMessage').textContent = message;
    document.getElementById('confirmModal').classList.add('show');
  }

  function confirmModalYes() {
    document.getElementById('confirmModal').classList.remove('show');
    if (confirmModalCallback) {
      confirmModalCallback();
    }
    confirmModalCallback = null;
  }

  function confirmModalCancel() {
    document.getElementById('confirmModal').classList.remove('show');
    confirmModalCallback = null;
    showToast('Dibatalkan.', 'error');
  }

  @if (session('status'))
    document.addEventListener('DOMContentLoaded', function () {
      showToast(@json(session('status')), 'success');
    });
  @endif

  @if (session('upload_warning'))
    document.addEventListener('DOMContentLoaded', function () {
      showToast(@json(session('upload_warning')), 'error');
    });
  @endif

  // Custom dropdown: ganti tampilan <select class="custom-select"> jadi menu custom yang bisa di-style
  function enhanceSelects(root) {
    (root || document).querySelectorAll('select.custom-select:not([data-enhanced])').forEach(function (select) {
      select.setAttribute('data-enhanced', '1');
      select.style.display = 'none';

      var wrap = document.createElement('div');
      wrap.className = 'cs-wrap';

      var trigger = document.createElement('button');
      trigger.type = 'button';
      trigger.className = 'cs-trigger';
      trigger.innerHTML = '<span class="cs-trigger-label"></span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>';

      var menu = document.createElement('div');
      menu.className = 'cs-menu';

      function syncLabel() {
        var selectedOpt = select.options[select.selectedIndex];
        trigger.querySelector('.cs-trigger-label').textContent = selectedOpt ? selectedOpt.textContent : '';
      }

      function buildMenu() {
        menu.innerHTML = '';
        Array.from(select.options).forEach(function (opt) {
          var item = document.createElement('div');
          item.className = 'cs-option' + (opt.value === select.value ? ' selected' : '');
          item.textContent = opt.textContent;
          item.addEventListener('click', function () {
            select.value = opt.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            syncLabel();
            buildMenu();
            wrap.classList.remove('open');
          });
          menu.appendChild(item);
        });
      }

      trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        document.querySelectorAll('.cs-wrap.open').forEach(function (w) { if (w !== wrap) w.classList.remove('open'); });
        wrap.classList.toggle('open');
      });

      document.addEventListener('click', function () { wrap.classList.remove('open'); });

      // kalau select-nya diubah dari luar (misal lewat JS lain), ikut update tampilan
      select.addEventListener('change', function () { syncLabel(); buildMenu(); });

      syncLabel();
      buildMenu();

      wrap.appendChild(trigger);
      wrap.appendChild(menu);
      select.insertAdjacentElement('afterend', wrap);
    });
  }

  document.addEventListener('DOMContentLoaded', function () { enhanceSelects(); });

  document.addEventListener('click', function (e) {
    var kebab = document.getElementById('navKebab');
    if (kebab && !kebab.contains(e.target)) {
      kebab.classList.remove('open');
    }
  });

  function toggleFavorite(btn, listingId, isGuest) {
    if (isGuest) {
      var currentUrl = window.location.pathname + window.location.search;
      window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(currentUrl);
      return;
    }

    fetch('/favorit/' + listingId, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
      },
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        btn.classList.toggle('is-favorited', data.favorited);
        document.querySelectorAll('.fav-btn[data-listing-id="' + listingId + '"]').forEach(function (el) {
          el.classList.toggle('is-favorited', data.favorited);
        });
      })
      .catch(function () {
        showToast('Gagal update favorit, coba lagi.', 'error');
      });
  }
</script>
@yield('page-script')
</body>
</html>