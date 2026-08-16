<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Huniku — Satu Pintu untuk Semua Hunian</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<script>
  // Set tema sebelum halaman render biar nggak ada flash warna salah
  (function () {
    var saved = localStorage.getItem('huniku-theme');
    var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>
<style>
  :root{
    /* brand fixed colors (dipakai buat blok solid: cat-card, cta, dll — nggak ikut ganti tema) */
    --cream:#F3ECE0;
    --ink:#17181C;
    --teal:#0F6E56;
    --teal-deep:#0B5443;
    --teal-soft:#CFE9DF;
    --clay:#B5652E;
    --clay-soft:#EBD3C0;
    --accent-text:var(--teal-deep);

    /* semantic tokens — ini yang berubah pas dark mode */
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
  body{
    margin:0;
    background:var(--bg);
    color:var(--text);
    font-family:'Manrope',sans-serif;
    -webkit-font-smoothing:antialiased;
    transition:background-color .25s ease, color .25s ease;
  }
  h1,h2,h3,.display{
    font-family:'Sora',sans-serif;
    letter-spacing:-0.02em;
    margin:0;
  }
  .mono{
    font-family:'JetBrains Mono',monospace;
    letter-spacing:0.08em;
    text-transform:uppercase;
  }
  a{color:inherit;text-decoration:none;}
  .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}
  @media(max-width:640px){.wrap{padding:0 20px;}}

  /* ---------- Buttons ---------- */
  .btn{
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    padding:14px 26px;border-radius:100px;font-weight:600;font-size:15px;
    border:1px solid transparent;cursor:pointer;transition:transform .15s ease, background .2s ease;
  }
  .btn:hover{transform:translateY(-1px);}
  .btn-primary{background:var(--teal);color:#fff;}
  .btn-primary:hover{background:var(--teal-deep);}
  .btn-ghost{background:transparent;color:var(--text);border-color:var(--border);}
  .btn-ghost:hover{background:var(--hover-tint);}
  .btn-light{background:var(--cream);color:var(--ink);}

  /* ---------- Theme toggle ---------- */
  .theme-toggle{
    width:40px;height:40px;border-radius:100px;border:1px solid var(--border);
    background:transparent;display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--text);flex-shrink:0;
  }
  .theme-toggle:hover{background:var(--hover-tint);}
  .theme-toggle svg{width:18px;height:18px;}
  .theme-toggle .icon-moon{display:none;}
  html[data-theme="dark"] .theme-toggle .icon-sun{display:none;}
  html[data-theme="dark"] .theme-toggle .icon-moon{display:block;}

  /* ---------- Nav ---------- */
  nav{
    position:sticky;top:0;z-index:50;
    background:color-mix(in srgb, var(--bg) 88%, transparent);
    backdrop-filter:blur(10px);
    border-bottom:1px solid var(--border);
    transition:background-color .25s ease, border-color .25s ease;
  }
  .nav-inner{display:flex;align-items:center;justify-content:space-between;padding:18px 0;}
  .logo{display:flex;align-items:center;gap:10px;font-family:'Sora',sans-serif;font-weight:700;font-size:20px;}
  .nav-links{display:flex;gap:32px;font-size:15px;font-weight:500;color:var(--text-soft);}
  .nav-links a:hover{color:var(--text);}
  .nav-actions{display:flex;align-items:center;gap:14px;}
  @media(max-width:860px){.nav-links{display:none;}}

  /* ---------- Hero ---------- */
  .hero{position:relative;overflow:hidden;padding:88px 0 60px;}
  .hero-grid{display:grid;grid-template-columns:1.05fr 0.95fr;gap:56px;align-items:center;}
  @media(max-width:960px){.hero-grid{grid-template-columns:1fr;}}
  .eyebrow{
    display:inline-flex;align-items:center;gap:8px;
    font-size:12px;font-weight:600;color:var(--accent-text);
    background:var(--teal-soft);padding:8px 14px;border-radius:100px;margin-bottom:22px;
  }
  .eyebrow::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--teal);}
  .hero h1{font-size:56px;font-weight:700;line-height:1.05;}
  @media(max-width:640px){.hero h1{font-size:38px;}}
  .hero h1 em{font-style:normal;color:var(--teal);}
  .hero p.lead{margin-top:22px;font-size:18px;line-height:1.6;color:var(--text-soft);max-width:480px;}

  /* search card */
  .search-card{
    margin-top:34px;background:var(--surface);border:1px solid var(--border);
    border-radius:20px;padding:10px;display:flex;gap:8px;
    box-shadow:0 20px 40px -24px rgba(23,24,28,0.25);
    transition:background-color .25s ease, border-color .25s ease;
  }
  @media(max-width:640px){.search-card{flex-direction:column;}}
  .search-field{flex:1;display:flex;flex-direction:column;padding:10px 16px;border-radius:14px;}
  .search-field label{font-size:11px;font-weight:600;color:var(--text-soft);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
  .search-field select,.search-field input{
    border:none;outline:none;font-family:'Manrope',sans-serif;font-size:15px;font-weight:600;
    background:transparent;color:var(--text);
  }
  .search-divider{width:1px;background:var(--border);margin:8px 0;}
  @media(max-width:640px){.search-divider{width:auto;height:1px;margin:0 8px;}}
  .search-card .btn-primary{border-radius:14px;padding:0 26px;}

  .tab-switch{display:inline-flex;gap:4px;background:var(--surface-alt);border:1px solid var(--border);border-radius:100px;padding:4px;margin-top:30px;}
  .tab-btn{border:none;background:transparent;color:var(--text-soft);font-family:'Manrope',sans-serif;font-weight:600;font-size:14px;padding:9px 22px;border-radius:100px;cursor:pointer;transition:background .2s ease, color .2s ease;}
  .tab-btn.active{background:var(--ink);color:var(--cream);}

  .trust-row{display:flex;gap:28px;margin-top:28px;flex-wrap:wrap;}
  .trust-row .stat b{font-family:'Sora',sans-serif;font-size:22px;display:block;}
  .trust-row .stat span{font-size:13px;color:var(--text-soft);}

  /* skyline graphic */
  .skyline{position:relative;height:440px;}
  .skyline svg{width:100%;height:100%;}

  /* ---------- Category (house badges) ---------- */
  .categories{padding:70px 0 40px;}
  .section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;gap:20px;flex-wrap:wrap;}
  .section-head h2{font-size:32px;font-weight:700;}
  .section-head p{color:var(--text-soft);max-width:420px;margin-top:8px;}
  .cat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
  @media(max-width:900px){.cat-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:520px){.cat-grid{grid-template-columns:1fr;}}
  .cat-card{
    background:var(--ink);color:var(--cream);border-radius:20px;padding:28px 24px 24px;
    position:relative;overflow:hidden;transition:transform .2s ease;
    border:1px solid transparent;
  }
  html[data-theme="dark"] .cat-card{border-color:rgba(243,236,224,0.08);}
  .cat-card:hover{transform:translateY(-4px);}
  .cat-card .house-icon{margin-bottom:20px;}
  .cat-card h3{font-size:19px;font-weight:700;}
  .cat-card p{font-size:13.5px;color:rgba(243,236,224,0.65);margin-top:6px;line-height:1.5;}
  .cat-card .count{position:absolute;top:24px;right:24px;font-family:'JetBrains Mono',monospace;font-size:11px;color:rgba(243,236,224,0.5);}
  .cat-card:nth-child(2){background:var(--teal-deep);}
  .cat-card:nth-child(3){background:#2A2620;}
  .cat-card:nth-child(4){background:var(--clay);}

  /* ---------- Listings ---------- */
  .listings{padding:70px 0;}
  .listing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media(max-width:900px){.listing-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.listing-grid{grid-template-columns:1fr;}}
  .listing-card{background:var(--surface);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:box-shadow .2s ease, transform .2s ease, background-color .25s ease, border-color .25s ease;}
  .listing-card:hover{box-shadow:0 20px 40px -28px rgba(23,24,28,0.3);transform:translateY(-3px);}
  .listing-thumb{height:180px;position:relative;}
  .sale-badge{position:absolute;top:14px;right:14px;background:var(--ink);color:var(--cream);font-size:11px;font-weight:700;padding:6px 12px;border-radius:100px;}
  .listing-body{padding:20px;}
  .tag{display:inline-block;font-size:11px;font-weight:700;padding:5px 10px;border-radius:100px;background:var(--teal-soft);color:var(--accent-text);margin-bottom:12px;}
  .listing-body h3{font-size:17px;font-weight:700;}
  .listing-body .loc{font-size:13px;color:var(--text-soft);margin-top:4px;}
  .listing-foot{display:flex;justify-content:space-between;align-items:center;margin-top:16px;padding-top:16px;border-top:1px solid var(--border);}
  .price b{font-family:'Sora',sans-serif;font-size:18px;}
  .price span{font-size:12px;color:var(--text-soft);}

  /* ---------- Why ---------- */
  .why{padding:60px 0 90px;}
  .why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;}
  @media(max-width:860px){.why-grid{grid-template-columns:1fr;}}
  .why-item{padding:30px 26px;border:1px solid var(--border);border-radius:20px;background:var(--surface-alt);transition:background-color .25s ease, border-color .25s ease;}
  .why-item .n{font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--accent-text);margin-bottom:16px;display:block;}
  .why-item h3{font-size:19px;font-weight:700;margin-bottom:8px;}
  .why-item p{font-size:14.5px;color:var(--text-soft);line-height:1.6;}

  /* ---------- CTA ---------- */
  .cta{background:var(--ink);color:var(--cream);border-radius:28px;margin:0 auto 90px;max-width:1180px;padding:64px 56px;position:relative;overflow:hidden;}
  @media(max-width:640px){.cta{padding:44px 28px;border-radius:20px;}}
  .cta-inner{position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;gap:30px;flex-wrap:wrap;}
  .cta h2{font-size:30px;font-weight:700;max-width:480px;}
  .cta p{color:rgba(243,236,224,0.65);margin-top:10px;max-width:420px;}
  .cta-actions{display:flex;gap:12px;flex-wrap:wrap;}

  /* ---------- Footer ---------- */
  footer{border-top:1px solid var(--border);padding:50px 0 34px;transition:border-color .25s ease;}
  .foot-top{display:flex;justify-content:space-between;gap:40px;flex-wrap:wrap;margin-bottom:40px;}
  .foot-cols{display:flex;gap:60px;flex-wrap:wrap;}
  .foot-col h4{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-soft);margin-bottom:14px;}
  .foot-col a{display:block;font-size:14.5px;padding:5px 0;color:var(--text);}
  .foot-col a:hover{color:var(--accent-text);}
  .foot-bottom{display:flex;justify-content:space-between;align-items:center;padding-top:24px;border-top:1px solid var(--border);font-size:13px;color:var(--text-soft);flex-wrap:wrap;gap:10px;}
</style>
</head>
<body>

<nav>
  <div class="wrap nav-inner">
    <div class="logo">
      <svg width="26" height="26" viewBox="0 0 100 100" fill="none">
        <path d="M14 46 L50 16 L86 46" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M24 40 L24 84 L76 84 L76 40" stroke="var(--text)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      huniku
    </div>
    <div class="nav-links">
      <a href="#kategori">Kategori</a>
      <a href="#listing">Cari Properti</a>
      <a href="#kenapa">Kenapa Huniku</a>
      <a href="#daftarkan">Daftarkan Properti</a>
    </div>
    <div class="nav-actions">
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Ganti tema terang/gelap">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
      </button>
      <a href="#" class="btn btn-ghost" style="padding:10px 20px;font-size:14px;">Masuk</a>
      <a href="#" class="btn btn-primary" style="padding:10px 20px;font-size:14px;">Daftar</a>
    </div>
  </div>
</nav>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <div class="eyebrow">Satu pintu untuk semua hunian</div>
      <h1>Cari, sewa, atau beli<br>tempat istirahatmu — <em>semua di satu tempat.</em></h1>
      <p class="lead">Dari kost bulanan sampai rumah dan apartemen buat dimiliki sendiri, Huniku ngumpulin semua pilihan hunian dalam satu platform.</p>

      <div class="tab-switch" id="transactionTabs">
        <button type="button" class="tab-btn active" data-mode="sewa" onclick="setMode('sewa')">Sewa</button>
        <button type="button" class="tab-btn" data-mode="beli" onclick="setMode('beli')">Beli</button>
      </div>

      <div class="search-card">
        <div class="search-field" style="flex:1.3;">
          <label>Lokasi</label>
          <input type="text" placeholder="Cari kota atau kecamatan...">
        </div>
        <div class="search-divider"></div>
        <div class="search-field">
          <label>Tipe Hunian</label>
          <select id="typeField">
            <option>Semua Tipe</option>
            <option>Rumah</option>
            <option>Kost</option>
            <option>Kontrakan</option>
            <option>Apartemen</option>
          </select>
        </div>
        <div class="search-divider"></div>
        <div class="search-field" style="flex:0.8;">
          <label id="durationLabel">Durasi</label>
          <select id="durationField">
            <option>Bulanan</option>
            <option>Tahunan</option>
            <option>Harian</option>
          </select>
        </div>
        <button class="btn btn-primary" id="searchBtn">Cari Hunian</button>
      </div>

      <div class="trust-row">
        <div class="stat"><b>12.400+</b><span>hunian aktif</span></div>
        <div class="stat"><b>86 kota</b><span>tersebar di Indonesia</span></div>
        <div class="stat"><b>4.8/5</b><span>rating dari penyewa</span></div>
      </div>
    </div>

    <div class="skyline">
      <svg viewBox="0 0 480 440" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- back small house - clay -->
        <g>
          <path d="M20 220 L84 172 L148 220" stroke="var(--clay)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="34" y="212" width="100" height="120" rx="10" fill="var(--clay-soft)"/>
        </g>
        <!-- mid house - teal soft -->
        <g>
          <path d="M120 190 L210 118 L300 190" stroke="var(--teal)" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="138" y="182" width="144" height="180" rx="12" fill="var(--teal-soft)"/>
          <rect x="192" y="150" width="26" height="46" rx="4" fill="var(--teal)"/>
        </g>
        <!-- front large house - flips with theme so it stays visible -->
        <g>
          <rect x="252" y="118" width="26" height="46" rx="4" fill="var(--text)"/>
          <path d="M226 226 L346 122 L466 226" stroke="var(--text)" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M244 222 L244 396 Q244 410 258 410 L434 410 Q448 410 448 396 L448 222" stroke="var(--text)" stroke-width="12" stroke-linejoin="round"/>
          <!-- door -->
          <rect x="322" y="330" width="52" height="80" rx="8" fill="var(--text)"/>
          <!-- windows -->
          <rect x="268" y="270" width="34" height="34" rx="6" fill="var(--text)" opacity="0.85"/>
          <rect x="394" y="270" width="34" height="34" rx="6" fill="var(--text)" opacity="0.85"/>
        </g>
        <!-- ground line -->
        <line x1="0" y1="410" x2="480" y2="410" stroke="var(--border)" stroke-width="2"/>
      </svg>
    </div>
  </div>
</section>

<!-- ============ CATEGORY ============ -->
<section class="categories" id="kategori">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Pilih tipe hunianmu</h2>
        <p>Tiap orang punya kebutuhan tinggal yang beda — Huniku nyediain semuanya dalam satu tempat.</p>
      </div>
      <a href="#listing" class="btn btn-ghost">Lihat semua kategori</a>
    </div>

    <div class="cat-grid">
      <div class="cat-card">
        <span class="count">{{ $categoryCounts->get('rumah', 0) }}+</span>
        <svg class="house-icon" width="34" height="34" viewBox="0 0 100 100" fill="none"><path d="M12 48 L50 16 L88 48" stroke="var(--cream)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/><rect x="24" y="42" width="52" height="46" rx="8" stroke="var(--cream)" stroke-width="9"/></svg>
        <h3>Rumah</h3>
        <p>Sewa atau beli — buat keluarga yang butuh ruang lebih luas dan privasi penuh.</p>
      </div>
      <div class="cat-card">
        <span class="count">{{ $categoryCounts->get('kost', 0) }}+</span>
        <svg class="house-icon" width="34" height="34" viewBox="0 0 100 100" fill="none"><path d="M12 48 L50 16 L88 48" stroke="var(--cream)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/><rect x="24" y="42" width="52" height="46" rx="8" stroke="var(--cream)" stroke-width="9"/></svg>
        <h3>Kost</h3>
        <p>Sewa harian-bulanan — cocok buat anak kuliah dan pekerja yang baru pindah kota.</p>
      </div>
      <div class="cat-card">
        <span class="count">{{ $categoryCounts->get('kontrakan', 0) }}+</span>
        <svg class="house-icon" width="34" height="34" viewBox="0 0 100 100" fill="none"><path d="M12 48 L50 16 L88 48" stroke="var(--cream)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/><rect x="24" y="42" width="52" height="46" rx="8" stroke="var(--cream)" stroke-width="9"/></svg>
        <h3>Kontrakan</h3>
        <p>Sewa tahunan dengan harga lebih hemat, cocok buat tinggal jangka panjang.</p>
      </div>
      <div class="cat-card">
        <span class="count">{{ $categoryCounts->get('apartemen', 0) }}+</span>
        <svg class="house-icon" width="34" height="34" viewBox="0 0 100 100" fill="none"><path d="M12 48 L50 16 L88 48" stroke="var(--cream)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/><rect x="24" y="42" width="52" height="46" rx="8" stroke="var(--cream)" stroke-width="9"/></svg>
        <h3>Apartemen</h3>
        <p>Sewa atau beli — fasilitas lengkap dan lokasi strategis di tengah kota besar.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ LISTINGS ============ -->
<section class="listings" id="listing">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Rekomendasi buat kamu</h2>
        <p>Hunian pilihan yang paling banyak dicari minggu ini.</p>
      </div>
      <a href="#" class="btn btn-ghost">Lihat semua listing</a>
    </div>

    <div class="listing-grid">
      @php
        $gradients = [
          'teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))',
          'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))',
          'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)',
        ];
        $typeLabels = [
          'rumah' => 'Rumah',
          'kost' => 'Kost',
          'kontrakan' => 'Kontrakan',
          'apartemen' => 'Apartemen',
        ];
      @endphp

      @forelse ($listings as $listing)
        <div class="listing-card">
          <div class="listing-thumb" style="background:{{ $gradients[$listing->thumbnail_color] ?? $gradients['teal'] }};">
            @if ($listing->isForSale())
              <span class="sale-badge">Dijual</span>
            @endif
          </div>
          <div class="listing-body">
            <span class="tag">{{ $typeLabels[$listing->type] }}</span>
            <h3>{{ $listing->title }}</h3>
            <div class="loc">{{ $listing->district ? $listing->district . ', ' : '' }}{{ $listing->city }}</div>
            <div class="listing-foot">
              <div class="price"><b>{{ $listing->formattedPrice() }}</b><span>{{ $listing->unitLabel() }}</span></div>
              <a href="#" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <p style="color:var(--text-soft);">Belum ada listing unggulan saat ini.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ============ WHY ============ -->
<section class="why" id="kenapa">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Kenapa cari lewat Huniku</h2>
        <p>Bukan cuma daftar iklan — kami pastikan tiap transaksi aman dari awal sampai kamu pegang kunci.</p>
      </div>
    </div>
    <div class="why-grid">
      <div class="why-item">
        <span class="n">/ verifikasi</span>
        <h3>Properti terverifikasi</h3>
        <p>Setiap listing dicek langsung tim kami sebelum tayang, jadi foto dan harga yang kamu lihat sesuai kondisi asli.</p>
      </div>
      <div class="why-item">
        <span class="n">/ transaksi</span>
        <h3>Bayar & booking aman</h3>
        <p>Dana ditahan sistem sampai kamu konfirmasi sudah masuk ke unit — bukan langsung ke pemilik.</p>
      </div>
      <div class="why-item">
        <span class="n">/ dukungan</span>
        <h3>Bantuan tiap saat</h3>
        <p>Ada masalah pas nego atau pindahan? Tim support Huniku siap bantu lewat chat, bukan robot FAQ doang.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="wrap">
  <div class="cta">
    <div class="cta-inner">
      <div>
        <h2>Punya properti kosong? Sewakan lewat Huniku.</h2>
        <p>Pasang listing gratis, jangkau ribuan pencari hunian aktif setiap bulan tanpa biaya komisi di awal.</p>
      </div>
      <div class="cta-actions" id="daftarkan">
        <a href="#" class="btn btn-light">Daftarkan Properti</a>
        <a href="#" class="btn btn-ghost" style="border-color:rgba(243,236,224,0.3);color:var(--cream);">Pelajari caranya</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
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
        <p style="font-size:14px;color:var(--text-soft);max-width:260px;">Satu platform buat cari rumah, kost, kontrakan, dan apartemen di seluruh Indonesia.</p>
      </div>
      <div class="foot-cols">
        <div class="foot-col">
          <h4>Jelajahi</h4>
          <a href="#kategori">Kategori</a>
          <a href="#listing">Cari Properti</a>
          <a href="#kenapa">Kenapa Huniku</a>
        </div>
        <div class="foot-col">
          <h4>Pemilik</h4>
          <a href="#daftarkan">Daftarkan Properti</a>
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

  function setMode(mode) {
    document.querySelectorAll('#transactionTabs .tab-btn').forEach(function (btn) {
      btn.classList.toggle('active', btn.dataset.mode === mode);
    });

    var durationLabel = document.getElementById('durationLabel');
    var durationField = document.getElementById('durationField');
    var searchBtn = document.getElementById('searchBtn');

    if (mode === 'beli') {
      durationLabel.textContent = 'Rentang Harga';
      durationField.innerHTML = '<option>Semua Harga</option><option>&lt; Rp 300jt</option><option>Rp 300jt - 1M</option><option>&gt; Rp 1M</option>';
      searchBtn.textContent = 'Cari Properti Dijual';
    } else {
      durationLabel.textContent = 'Durasi';
      durationField.innerHTML = '<option>Bulanan</option><option>Tahunan</option><option>Harian</option>';
      searchBtn.textContent = 'Cari Hunian';
    }
  }
</script>

</body>
</html>