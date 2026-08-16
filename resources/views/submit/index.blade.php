@extends('layouts.app')

@section('title', 'Listing Saya — Huniku')

@section('page-style')
  .fav-header{padding:44px 0 24px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap;}
  .fav-header h1{font-size:28px;font-weight:700;}
  .fav-results{padding:32px 0 70px;}
  .my-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media(max-width:900px){.my-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.my-grid{grid-template-columns:1fr;}}
  .empty-state{text-align:center;padding:80px 20px;color:var(--text-soft);}
  .empty-state h3{color:var(--text);margin-bottom:8px;}
  .pagination-wrap{display:flex;justify-content:center;margin-top:40px;}

  .status-badge{position:absolute;top:14px;left:14px;font-size:11px;font-weight:700;padding:6px 12px;border-radius:100px;z-index:2;}
  .status-pending{background:#E8A93A;color:#1a1400;}
  .status-approved{background:var(--teal);color:#fff;}
  .status-rejected{background:#C24545;color:#fff;}
  .rejection-note{font-size:12.5px;color:#C24545;margin-top:8px;padding-top:8px;border-top:1px solid var(--border);}
@endsection

@section('content')
<div class="wrap">
  <div class="fav-header">
    <div>
      <h1>Listing Saya</h1>
      <p style="color:var(--text-soft);margin-top:6px;">Properti yang udah kamu daftarkan, beserta statusnya.</p>
    </div>
    <a href="{{ route('submit.create') }}" class="btn btn-primary">+ Daftarkan Properti</a>
  </div>

  <div class="fav-results">
    @if ($listings->isEmpty())
      <div class="empty-state">
        <h3>Belum ada listing yang kamu daftarkan</h3>
        <p>Klik "Daftarkan Properti" buat mulai jual/sewain propertimu di Huniku.</p>
      </div>
    @else
      <div class="my-grid">
        @php
          $gradients = ['teal' => 'linear-gradient(135deg,var(--teal-soft),var(--teal))', 'clay' => 'linear-gradient(135deg,var(--clay-soft),var(--clay))', 'dark' => 'linear-gradient(135deg,#2A2620,#5B564B)'];
          $typeLabels = ['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'];
          $statusLabels = ['pending' => 'Menunggu Review', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
        @endphp

        @foreach ($listings as $listing)
          <div class="listing-card">
            <div class="listing-thumb" style="background:{{ $gradients[$listing->thumbnail_color] ?? $gradients['teal'] }};{{ $listing->firstImageUrl() ? 'background-image:url(' . $listing->firstImageUrl() . ');background-size:cover;background-position:center;' : '' }}">
              <span class="status-badge status-{{ $listing->status }}">{{ $statusLabels[$listing->status] }}</span>
            </div>
            <div class="listing-body">
              <span class="tag">{{ $typeLabels[$listing->type] }}</span>
              <h3>{{ $listing->title }}</h3>
              <div class="loc">{{ $listing->district ? $listing->district . ', ' : '' }}{{ $listing->city }}</div>
              <div class="listing-foot">
                <div class="price"><b>{{ $listing->formattedPrice() }}</b><span>{{ $listing->unitLabel() }}</span></div>
                @if ($listing->isApproved())
                  <a href="{{ route('listings.show', $listing) }}" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Lihat</a>
                @endif
              </div>
              @if ($listing->isRejected() && $listing->rejection_reason)
                <div class="rejection-note">Alasan ditolak: {{ $listing->rejection_reason }}</div>
              @endif
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