@extends('layouts.app')

@section('title', 'Cari Properti — Huniku')

@section('page-style')
  .search-header{padding:44px 0 28px;border-bottom:1px solid var(--border);}
  .search-header h1{font-size:30px;font-weight:700;}
  .filter-form{display:flex;gap:10px;margin-top:22px;flex-wrap:wrap;align-items:center;}
  .filter-form input, .filter-form select{
    font-family:'Manrope',sans-serif;font-size:14px;font-weight:600;color:var(--text);
    background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:11px 14px;
  }
  .filter-form input{flex:1;min-width:200px;}
  .tab-switch{display:inline-flex;gap:4px;background:var(--surface-alt);border:1px solid var(--border);border-radius:100px;padding:4px;}
  .tab-btn{border:none;background:transparent;color:var(--text-soft);font-family:'Manrope',sans-serif;font-weight:600;font-size:13px;padding:8px 18px;border-radius:100px;cursor:pointer;}
  .tab-btn.active{background:var(--ink);color:var(--cream);}

  .result-meta{padding:24px 0 0;color:var(--text-soft);font-size:14px;}
  .results{padding:24px 0 60px;}
  .result-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media(max-width:900px){.result-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.result-grid{grid-template-columns:1fr;}}

  .empty-state{text-align:center;padding:80px 20px;color:var(--text-soft);}
  .empty-state h3{color:var(--text);margin-bottom:8px;}

  .pagination-wrap{display:flex;justify-content:center;margin-top:40px;}
  .pagination-wrap nav > div{display:flex;gap:6px;flex-wrap:wrap;justify-content:center;}
@endsection

@section('content')

<section class="search-header">
  <div class="wrap">
    <h1>Cari properti</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Filter berdasarkan lokasi, tipe hunian, dan kebutuhanmu.</p>

    <form action="{{ route('listings.index') }}" method="GET" class="filter-form">
      <div class="tab-switch">
        <a href="{{ route('listings.index', array_merge(request()->except(['mode','duration','price_range']), ['mode' => 'sewa'])) }}"
           class="tab-btn {{ $filters['mode'] === 'sewa' ? 'active' : '' }}">Sewa</a>
        <a href="{{ route('listings.index', array_merge(request()->except(['mode','duration','price_range']), ['mode' => 'jual'])) }}"
           class="tab-btn {{ $filters['mode'] === 'jual' ? 'active' : '' }}">Beli</a>
      </div>
      <input type="hidden" name="mode" value="{{ $filters['mode'] }}">

      <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari kota, kecamatan, atau nama properti...">

      <select name="type" class="custom-select">
        <option value="semua" {{ $filters['type'] === 'semua' ? 'selected' : '' }}>Semua Tipe</option>
        <option value="rumah" {{ $filters['type'] === 'rumah' ? 'selected' : '' }}>Rumah</option>
        <option value="kost" {{ $filters['type'] === 'kost' ? 'selected' : '' }}>Kost</option>
        <option value="kontrakan" {{ $filters['type'] === 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
        <option value="apartemen" {{ $filters['type'] === 'apartemen' ? 'selected' : '' }}>Apartemen</option>
      </select>

      @if ($filters['mode'] === 'jual')
        <select name="price_range" class="custom-select">
          <option value="semua" {{ $filters['price_range'] === 'semua' ? 'selected' : '' }}>Semua Harga</option>
          <option value="under_300" {{ $filters['price_range'] === 'under_300' ? 'selected' : '' }}>&lt; Rp 300jt</option>
          <option value="300_1000" {{ $filters['price_range'] === '300_1000' ? 'selected' : '' }}>Rp 300jt - 1M</option>
          <option value="over_1000" {{ $filters['price_range'] === 'over_1000' ? 'selected' : '' }}>&gt; Rp 1M</option>
        </select>
      @else
        <select name="duration" class="custom-select">
          <option value="semua" {{ $filters['duration'] === 'semua' ? 'selected' : '' }}>Semua Durasi</option>
          <option value="bulan" {{ $filters['duration'] === 'bulan' ? 'selected' : '' }}>Bulanan</option>
          <option value="tahun" {{ $filters['duration'] === 'tahun' ? 'selected' : '' }}>Tahunan</option>
          <option value="hari" {{ $filters['duration'] === 'hari' ? 'selected' : '' }}>Harian</option>
        </select>
      @endif

      <button type="submit" class="btn btn-primary">Cari</button>
    </form>
  </div>
</section>

<section class="results">
  <div class="wrap">
    <p class="result-meta">Menampilkan {{ $listings->total() }} hasil{{ $filters['q'] ? ' untuk "' . $filters['q'] . '"' : '' }}.</p>

    @if ($listings->isEmpty())
      <div class="empty-state">
        <h3>Belum ada hasil yang cocok</h3>
        <p>Coba ubah kata kunci lokasi atau longgarkan filternya.</p>
      </div>
    @else
      <div class="result-grid" style="margin-top:20px;">
        @php
          $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
          $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
        @endphp

        @foreach ($listings as $listing)
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

      <div class="pagination-wrap">
        {{ $listings->links() }}
      </div>
    @endif
  </div>
</section>

@endsection