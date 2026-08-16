@extends('layouts.app')

@section('title', 'Huniku — Satu Pintu untuk Semua Hunian')

@section('page-style')
  .hero{position:relative;overflow:hidden;padding:88px 0 60px;}
  .hero-grid{display:grid;grid-template-columns:1.05fr 0.95fr;gap:56px;align-items:center;}
  @media(max-width:960px){.hero-grid{grid-template-columns:1fr;}}
  .eyebrow{display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:600;color:var(--accent-text);background:var(--teal-soft);padding:8px 14px;border-radius:100px;margin-bottom:22px;}
  .eyebrow::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--teal);}
  .hero h1{font-size:56px;font-weight:700;line-height:1.05;}
  @media(max-width:640px){.hero h1{font-size:38px;}}
  .hero h1 em{font-style:normal;color:var(--teal);}
  .hero p.lead{margin-top:22px;font-size:18px;line-height:1.6;color:var(--text-soft);max-width:480px;}

  .tab-switch{display:inline-flex;gap:4px;background:var(--surface-alt);border:1px solid var(--border);border-radius:100px;padding:4px;margin-top:30px;}
  .tab-btn{border:none;background:transparent;color:var(--text-soft);font-family:'Manrope',sans-serif;font-weight:600;font-size:14px;padding:9px 22px;border-radius:100px;cursor:pointer;transition:background .2s ease, color .2s ease;}
  .tab-btn.active{background:var(--ink);color:var(--cream);}

  .search-card{margin-top:16px;background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:10px;display:flex;gap:8px;box-shadow:0 20px 40px -24px rgba(23,24,28,0.25);transition:background-color .25s ease, border-color .25s ease;}
  @media(max-width:640px){.search-card{flex-direction:column;}}
  .search-field{flex:1;display:flex;flex-direction:column;padding:10px 16px;border-radius:14px;}
  .search-field label{font-size:11px;font-weight:600;color:var(--text-soft);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
  .search-field select,.search-field input{border:none;outline:none;font-family:'Manrope',sans-serif;font-size:15px;font-weight:600;background:transparent;color:var(--text);width:100%;}
  .search-divider{width:1px;background:var(--border);margin:8px 0;}
  @media(max-width:640px){.search-divider{width:auto;height:1px;margin:0 8px;}}
  .search-card .btn-primary{border-radius:14px;padding:0 26px;white-space:nowrap;}

  .trust-row{display:flex;gap:28px;margin-top:28px;flex-wrap:wrap;}
  .trust-row .stat b{font-family:'Sora',sans-serif;font-size:22px;display:block;}
  .trust-row .stat span{font-size:13px;color:var(--text-soft);}

  .skyline{position:relative;height:440px;}
  .skyline svg{width:100%;height:100%;}

  .categories{padding:70px 0 40px;}
  .section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;gap:20px;flex-wrap:wrap;}
  .section-head h2{font-size:32px;font-weight:700;}
  .section-head p{color:var(--text-soft);max-width:420px;margin-top:8px;}
  .cat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
  @media(max-width:900px){.cat-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:520px){.cat-grid{grid-template-columns:1fr;}}
  .cat-card{background:var(--ink);color:var(--cream);border-radius:20px;padding:28px 24px 24px;position:relative;overflow:hidden;transition:transform .2s ease;border:1px solid transparent;}
  html[data-theme="dark"] .cat-card{border-color:rgba(243,236,224,0.08);}
  .cat-card:hover{transform:translateY(-4px);}
  .cat-card .house-icon{margin-bottom:20px;}
  .cat-card h3{font-size:19px;font-weight:700;}
  .cat-card p{font-size:13.5px;color:rgba(243,236,224,0.65);margin-top:6px;line-height:1.5;}
  .cat-card .count{position:absolute;top:24px;right:24px;font-family:'JetBrains Mono',monospace;font-size:11px;color:rgba(243,236,224,0.5);}
  .cat-card:nth-child(2){background:var(--teal-deep);}
  .cat-card:nth-child(3){background:#2A2620;}
  .cat-card:nth-child(4){background:var(--clay);}

  .listings{padding:70px 0;}
  .listing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media(max-width:900px){.listing-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.listing-grid{grid-template-columns:1fr;}}

  .why{padding:60px 0 90px;}
  .why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;}
  @media(max-width:860px){.why-grid{grid-template-columns:1fr;}}
  .why-item{padding:30px 26px;border:1px solid var(--border);border-radius:20px;background:var(--surface-alt);transition:background-color .25s ease, border-color .25s ease;}
  .why-item .n{font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--accent-text);margin-bottom:16px;display:block;}
  .why-item h3{font-size:19px;font-weight:700;margin-bottom:8px;}
  .why-item p{font-size:14.5px;color:var(--text-soft);line-height:1.6;}

  .cta{background:var(--ink);color:var(--cream);border-radius:28px;margin:0 auto 90px;max-width:1180px;padding:64px 56px;position:relative;overflow:hidden;}
  @media(max-width:640px){.cta{padding:44px 28px;border-radius:20px;}}
  .cta-inner{position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;gap:30px;flex-wrap:wrap;}
  .cta h2{font-size:30px;font-weight:700;max-width:480px;}
  .cta p{color:rgba(243,236,224,0.65);margin-top:10px;max-width:420px;}
  .cta-actions{display:flex;gap:12px;flex-wrap:wrap;}
@endsection

@section('content')

<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <div class="eyebrow">Satu pintu untuk semua hunian</div>
      <h1>Cari, sewa, atau beli<br>tempat istirahatmu — <em>semua di satu tempat.</em></h1>
      <p class="lead">Dari kost bulanan sampai rumah dan apartemen buat dimiliki sendiri, Huniku ngumpulin semua pilihan hunian dalam satu platform.</p>

      <form action="{{ route('listings.index') }}" method="GET">
        <div class="tab-switch" id="transactionTabs">
          <button type="button" class="tab-btn active" data-mode="sewa" onclick="setMode('sewa')">Sewa</button>
          <button type="button" class="tab-btn" data-mode="beli" onclick="setMode('beli')">Beli</button>
        </div>
        <input type="hidden" name="mode" id="modeField" value="sewa">

        <div class="search-card">
          <div class="search-field" style="flex:1.3;">
            <label>Lokasi</label>
            <input type="text" name="q" placeholder="Cari kota atau kecamatan...">
          </div>
          <div class="search-divider"></div>
          <div class="search-field">
            <label>Tipe Hunian</label>
            <select name="type" id="typeField" class="custom-select">
              <option value="semua">Semua Tipe</option>
              <option value="rumah">Rumah</option>
              <option value="kost">Kost</option>
              <option value="kontrakan">Kontrakan</option>
              <option value="apartemen">Apartemen</option>
            </select>
          </div>
          <div class="search-divider"></div>
          <div class="search-field" style="flex:0.8;">
            <label id="durationLabel">Durasi</label>
            <select name="duration" id="durationField" class="custom-select">
              <option value="bulan">Bulanan</option>
              <option value="tahun">Tahunan</option>
              <option value="hari">Harian</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" id="searchBtn">Cari</button>
        </div>
      </form>

      <div class="trust-row">
        <div class="stat"><b>12.400+</b><span>hunian aktif</span></div>
        <div class="stat"><b>86 kota</b><span>tersebar di Indonesia</span></div>
        <div class="stat"><b>4.8/5</b><span>rating dari penyewa</span></div>
      </div>
    </div>

    <div class="skyline">
      <svg viewBox="0 0 480 440" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g>
          <path d="M20 220 L84 172 L148 220" stroke="var(--clay)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="34" y="212" width="100" height="120" rx="10" fill="var(--clay-soft)"/>
        </g>
        <g>
          <path d="M120 190 L210 118 L300 190" stroke="var(--teal)" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="138" y="182" width="144" height="180" rx="12" fill="var(--teal-soft)"/>
          <rect x="192" y="150" width="26" height="46" rx="4" fill="var(--teal)"/>
        </g>
        <g>
          <rect x="252" y="118" width="26" height="46" rx="4" fill="var(--text)"/>
          <path d="M226 226 L346 122 L466 226" stroke="var(--text)" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M244 222 L244 396 Q244 410 258 410 L434 410 Q448 410 448 396 L448 222" stroke="var(--text)" stroke-width="12" stroke-linejoin="round"/>
          <rect x="322" y="330" width="52" height="80" rx="8" fill="var(--text)"/>
          <rect x="268" y="270" width="34" height="34" rx="6" fill="var(--text)" opacity="0.85"/>
          <rect x="394" y="270" width="34" height="34" rx="6" fill="var(--text)" opacity="0.85"/>
        </g>
        <line x1="0" y1="410" x2="480" y2="410" stroke="var(--border)" stroke-width="2"/>
      </svg>
    </div>
  </div>
</section>

<section class="categories" id="kategori">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Pilih tipe hunianmu</h2>
        <p>Tiap orang punya kebutuhan tinggal yang beda — Huniku nyediain semuanya dalam satu tempat.</p>
      </div>
      <a href="{{ route('listings.index') }}" class="btn btn-ghost">Lihat semua kategori</a>
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

<section class="listings" id="listing">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Rekomendasi buat kamu</h2>
        <p>Hunian pilihan yang paling banyak dicari minggu ini.</p>
      </div>
      <a href="{{ route('listings.index') }}" class="btn btn-ghost">Lihat semua listing</a>
    </div>

    <div class="listing-grid">
      @php
        $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
        $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
      @endphp

      @forelse ($listings as $listing)
        <div class="listing-card">
          <div class="listing-thumb" style="background:{{ $gradients[$listing->thumbnail_color] ?? $gradients['teal'] }};{{ $listing->firstImageUrl() ? 'background-image:url(' . $listing->firstImageUrl() . ');background-size:cover;background-position:center;' : '' }}">
            <button type="button" class="fav-btn {{ in_array($listing->id, $favoritedIds) ? 'is-favorited' : '' }}" data-listing-id="{{ $listing->id }}" onclick="toggleFavorite(this, {{ $listing->id }}, {{ auth()->check() ? 'false' : 'true' }})">
              <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.6-10-9.1C.5 8.4 2.3 5 5.7 5c1.9 0 3.4 1 4.3 2.5C11 6 12.5 5 14.3 5c3.4 0 5.2 3.4 3.7 6.9C19.5 16.4 12 21 12 21z"/></svg>
            </button>
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
              <a href="{{ route('listings.show', $listing) }}" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <p style="color:var(--text-soft);">Belum ada listing unggulan saat ini.</p>
      @endforelse
    </div>
  </div>
</section>

@if ($recentlyViewed->count())
<section class="listings">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Baru kamu lihat</h2>
        <p>Lanjutin lagi dari yang terakhir kamu cek.</p>
      </div>
    </div>

    <div class="listing-grid">
      @php
        $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
        $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
      @endphp
      @foreach ($recentlyViewed as $listing)
        <div class="listing-card">
          <div class="listing-thumb" style="background:{{ $gradients[$listing->thumbnail_color] ?? $gradients['teal'] }};{{ $listing->firstImageUrl() ? 'background-image:url(' . $listing->firstImageUrl() . ');background-size:cover;background-position:center;' : '' }}">
            <button type="button" class="fav-btn {{ in_array($listing->id, $favoritedIds) ? 'is-favorited' : '' }}" data-listing-id="{{ $listing->id }}" onclick="toggleFavorite(this, {{ $listing->id }}, {{ auth()->check() ? 'false' : 'true' }})">
              <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.6-10-9.1C.5 8.4 2.3 5 5.7 5c1.9 0 3.4 1 4.3 2.5C11 6 12.5 5 14.3 5c3.4 0 5.2 3.4 3.7 6.9C19.5 16.4 12 21 12 21z"/></svg>
            </button>
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
              <a href="{{ route('listings.show', $listing) }}" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

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

<section class="wrap">
  <div class="cta">
    <div class="cta-inner">
      <div>
        <h2>Punya properti kosong? Sewakan lewat Huniku.</h2>
        <p>Pasang listing gratis, jangkau ribuan pencari hunian aktif setiap bulan tanpa biaya komisi di awal.</p>
      </div>
      <div class="cta-actions" id="daftarkan">
        <a href="{{ route('submit.create') }}" class="btn btn-light">Daftarkan Properti</a>
        <a href="#" class="btn btn-ghost" style="border-color:rgba(243,236,224,0.3);color:var(--cream);">Pelajari caranya</a>
      </div>
    </div>
  </div>
</section>

@endsection

@section('page-script')
<script>
  function setMode(mode) {
    document.querySelectorAll('#transactionTabs .tab-btn').forEach(function (btn) {
      btn.classList.toggle('active', btn.dataset.mode === mode);
    });
    document.getElementById('modeField').value = mode;

    var durationLabel = document.getElementById('durationLabel');
    var durationField = document.getElementById('durationField');

    if (mode === 'beli') {
      durationLabel.textContent = 'Rentang Harga';
      durationField.name = 'price_range';
      durationField.innerHTML = '<option value="semua">Semua Harga</option><option value="under_300">&lt; Rp 300jt</option><option value="300_1000">Rp 300jt - 1M</option><option value="over_1000">&gt; Rp 1M</option>';
    } else {
      durationLabel.textContent = 'Durasi';
      durationField.name = 'duration';
      durationField.innerHTML = '<option value="bulan">Bulanan</option><option value="tahun">Tahunan</option><option value="hari">Harian</option>';
    }
    durationField.dispatchEvent(new Event('change', { bubbles: true }));
  }
</script>
@endsection