@extends('layouts.app')

@section('title', $listing->title . ' — Huniku')

@section('page-style')
  .breadcrumb{padding:24px 0 0;font-size:13px;color:var(--text-soft);}
  .breadcrumb a:hover{color:var(--text);}

  .detail-wrap{padding:20px 0 70px;display:grid;grid-template-columns:1.6fr 1fr;gap:40px;align-items:start;}
  @media(max-width:960px){.detail-wrap{grid-template-columns:1fr;}}

  /* gallery */
  .gallery-main{width:100%;aspect-ratio:16/10;border-radius:20px;overflow:hidden;position:relative;background:var(--surface-alt);}
  .gallery-main img{width:100%;height:100%;object-fit:cover;display:block;}
  .gallery-main .no-image{display:flex;align-items:center;justify-content:center;height:100%;color:var(--text-soft);font-size:14px;}
  .gallery-thumbs{display:flex;gap:10px;margin-top:12px;overflow-x:auto;padding-bottom:4px;}
  .gallery-thumbs img{width:84px;height:64px;object-fit:cover;border-radius:10px;cursor:pointer;border:2px solid transparent;flex-shrink:0;opacity:.7;transition:opacity .15s ease, border-color .15s ease;}
  .gallery-thumbs img:hover{opacity:1;}
  .gallery-thumbs img.active{opacity:1;border-color:var(--teal);}

  /* info */
  .detail-title-row{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-top:26px;}
  .detail-title-row h1{font-size:28px;font-weight:700;line-height:1.2;}
  .detail-loc{color:var(--text-soft);font-size:14.5px;margin-top:8px;}
  .detail-badges{display:flex;gap:8px;margin-top:14px;flex-wrap:wrap;}

  .spec-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:28px;}
  @media(max-width:500px){.spec-grid{grid-template-columns:repeat(2,1fr);}}
  .spec-item{background:var(--surface-alt);border-radius:14px;padding:16px;}
  .spec-item .spec-label{font-size:11px;color:var(--text-soft);text-transform:uppercase;letter-spacing:.05em;font-weight:700;}
  .spec-item .spec-value{font-family:'Sora',sans-serif;font-size:16px;font-weight:600;margin-top:6px;}

  .detail-desc{margin-top:32px;}
  .detail-desc h3{font-size:18px;font-weight:700;margin-bottom:10px;}
  .detail-desc p{color:var(--text-soft);line-height:1.7;font-size:15px;}

  /* sidebar / contact card */
  .contact-card{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:26px;position:sticky;top:100px;}
  .contact-card .price-big{font-family:'Sora',sans-serif;font-size:30px;font-weight:700;}
  .contact-card .price-unit{font-size:14px;color:var(--text-soft);margin-left:4px;}
  .contact-card .btn{width:100%;margin-top:18px;}
  .contact-card .trust-line{display:flex;align-items:center;gap:8px;margin-top:16px;font-size:13px;color:var(--text-soft);}

  /* related */
  .related-section{padding:20px 0 70px;border-top:1px solid var(--border);}
  .related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:24px;}
  @media(max-width:900px){.related-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.related-grid{grid-template-columns:1fr;}}
@endsection

@section('content')

<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a> /
    <a href="{{ route('listings.index') }}">Cari Properti</a> /
    <span>{{ $listing->title }}</span>
  </div>

  <div class="detail-wrap">
    <div>
      <div class="gallery-main">
        @if ($listing->images->count())
          <img id="mainImage" src="{{ $listing->images->first()->url() }}" alt="{{ $listing->title }}">
        @else
          <div class="no-image">Belum ada foto buat listing ini</div>
        @endif
      </div>

      @if ($listing->images->count() > 1)
        <div class="gallery-thumbs">
          @foreach ($listing->images as $index => $image)
            <img src="{{ $image->url() }}" alt="Foto {{ $index + 1 }}" onclick="switchImage(this)" class="{{ $index === 0 ? 'active' : '' }}">
          @endforeach
        </div>
      @endif

      <div class="detail-title-row">
        <div>
          <h1>{{ $listing->title }}</h1>
          <div class="detail-loc">{{ $listing->district ? $listing->district . ', ' : '' }}{{ $listing->city }}</div>
        </div>
      </div>

      <div class="detail-badges">
        <span class="tag">{{ ucfirst($listing->type) }}</span>
        <span class="tag" style="background:var(--surface-alt);color:var(--text-soft);">{{ $listing->isForSale() ? 'Dijual' : 'Disewakan' }}</span>
        @if ($listing->is_verified)
          <span class="tag">Terverifikasi</span>
        @endif
      </div>

      <div class="spec-grid">
        <div class="spec-item">
          <div class="spec-label">Tipe</div>
          <div class="spec-value">{{ ucfirst($listing->type) }}</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Transaksi</div>
          <div class="spec-value">{{ $listing->isForSale() ? 'Jual' : 'Sewa' }}</div>
        </div>
        <div class="spec-item">
          <div class="spec-label">Lokasi</div>
          <div class="spec-value">{{ $listing->city }}</div>
        </div>
      </div>

      <div class="detail-desc">
        <h3>Deskripsi</h3>
        <p>{{ $listing->description ?: 'Belum ada deskripsi tambahan buat listing ini. Hubungi kami buat info lebih lengkap.' }}</p>
      </div>

      <div class="detail-desc">
        <h3>Lokasi</h3>
        <div style="border-radius:16px;overflow:hidden;border:1px solid var(--border);">
          <iframe src="{{ $listing->mapEmbedUrl() }}" width="100%" height="280" style="border:0;display:block;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <a href="{{ $listing->mapLinkUrl() }}" target="_blank" rel="noopener" style="display:inline-block;margin-top:10px;font-size:13.5px;font-weight:600;color:var(--accent-text);">Buka di Google Maps ↗</a>
        @if (! $listing->hasCoordinates())
          <p style="font-size:12.5px;color:var(--text-soft);margin-top:6px;">Lokasi di peta ini masih perkiraan berdasarkan kota/kecamatan.</p>
        @endif
      </div>
    </div>

    <div>
      <div class="contact-card">
        <div>
          <span class="price-big">{{ $listing->formattedPrice() }}</span>
          @if ($listing->unitLabel())
            <span class="price-unit">{{ $listing->unitLabel() }}</span>
          @endif
        </div>

        <div style="display:flex;gap:10px;margin-top:18px;">
          <a href="#" class="btn btn-primary" style="flex:1;margin-top:0;">Hubungi Pemilik</a>
          <button type="button" class="fav-btn fav-btn-large {{ $isFavorited ? 'is-favorited' : '' }}" data-listing-id="{{ $listing->id }}" onclick="toggleFavorite(this, {{ $listing->id }}, {{ auth()->check() ? 'false' : 'true' }})" aria-label="Simpan ke favorit">
            <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.6-10-9.1C.5 8.4 2.3 5 5.7 5c1.9 0 3.4 1 4.3 2.5C11 6 12.5 5 14.3 5c3.4 0 5.2 3.4 3.7 6.9C19.5 16.4 12 21 12 21z"/></svg>
          </button>
        </div>

        <div class="trust-line">
          <span>{{ $listing->is_verified ? '✓ Properti sudah diverifikasi tim Huniku' : 'Belum diverifikasi — tetap hati-hati saat transaksi' }}</span>
        </div>
      </div>
    </div>
  </div>
</div>

@if ($related->count())
  <section class="related-section">
    <div class="wrap">
      <h2 style="font-size:24px;font-weight:700;">Properti serupa</h2>
      <div class="related-grid">
        @php
          $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
          $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
        @endphp
        @foreach ($related as $item)
          <a href="{{ route('listings.show', $item) }}" class="listing-card">
            <div class="listing-thumb" style="background:{{ $gradients[$item->thumbnail_color] ?? $gradients['teal'] }};{{ $item->firstImageUrl() ? 'background-image:url(' . $item->firstImageUrl() . ');background-size:cover;background-position:center;' : '' }}">
              <button type="button" class="fav-btn {{ in_array($item->id, $favoritedIds) ? 'is-favorited' : '' }}" data-listing-id="{{ $item->id }}" onclick="event.preventDefault(); toggleFavorite(this, {{ $item->id }}, {{ auth()->check() ? 'false' : 'true' }})">
                <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.6-10-9.1C.5 8.4 2.3 5 5.7 5c1.9 0 3.4 1 4.3 2.5C11 6 12.5 5 14.3 5c3.4 0 5.2 3.4 3.7 6.9C19.5 16.4 12 21 12 21z"/></svg>
              </button>
              @if ($item->isForSale())
                <span class="sale-badge">Dijual</span>
              @endif
            </div>
            <div class="listing-body">
              <span class="tag">{{ $typeLabels[$item->type] }}</span>
              <h3>{{ $item->title }}</h3>
              <div class="loc">{{ $item->district ? $item->district . ', ' : '' }}{{ $item->city }}</div>
              <div class="listing-foot">
                <div class="price"><b>{{ $item->formattedPrice() }}</b><span>{{ $item->unitLabel() }}</span></div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>
@endif

@endsection

@section('page-script')
<script>
  function switchImage(el) {
    document.getElementById('mainImage').src = el.src;
    document.querySelectorAll('.gallery-thumbs img').forEach(function (img) {
      img.classList.remove('active');
    });
    el.classList.add('active');
  }
</script>
@endsection