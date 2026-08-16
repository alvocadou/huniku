@extends('layouts.app')

@section('title', 'Favorit Saya — Huniku')

@section('page-style')
  .fav-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .fav-header h1{font-size:28px;font-weight:700;}
  .fav-results{padding:32px 0 70px;}
  .fav-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media(max-width:900px){.fav-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.fav-grid{grid-template-columns:1fr;}}
  .empty-state{text-align:center;padding:80px 20px;color:var(--text-soft);}
  .empty-state h3{color:var(--text);margin-bottom:8px;}
  .pagination-wrap{display:flex;justify-content:center;margin-top:40px;}
@endsection

@section('content')
<div class="wrap">
  <div class="fav-header">
    <h1>Favorit Saya</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Properti yang udah kamu simpan.</p>
  </div>

  <div class="fav-results">
    @if ($listings->isEmpty())
      <div class="empty-state">
        <h3>Belum ada favorit</h3>
        <p>Klik ikon hati di listing yang kamu suka buat nyimpennya di sini.</p>
      </div>
    @else
      <div class="fav-grid">
        @php
          $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
          $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
        @endphp

        @foreach ($listings as $listing)
          <div class="listing-card">
            <div class="listing-thumb" style="background:{{ $gradients[$listing->thumbnail_color] ?? $gradients['teal'] }};{{ $listing->firstImageUrl() ? 'background-image:url(' . $listing->firstImageUrl() . ');background-size:cover;background-position:center;' : '' }}">
              <button type="button" class="fav-btn is-favorited" data-listing-id="{{ $listing->id }}" onclick="toggleFavoriteAndRemove(this, {{ $listing->id }})">
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
</div>
@endsection

@section('page-script')
<script>
  // Di halaman favorit, kalau unfavorite langsung ilangin card-nya dari tampilan
  function toggleFavoriteAndRemove(btn, listingId) {
    fetch('/favorit/' + listingId, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
      },
    })
      .then(function (res) { return res.json(); })
      .then(function () {
        var card = btn.closest('.listing-card');
        card.style.transition = 'opacity .2s ease';
        card.style.opacity = '0';
        setTimeout(function () { card.remove(); }, 200);
      });
  }
</script>
@endsection