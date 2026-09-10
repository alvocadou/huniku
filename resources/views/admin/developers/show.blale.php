@extends('layouts.app')

@section('title', $developer->company_name . ' — Huniku')

@section('page-style')
  .dev-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .dev-header h1{font-size:26px;font-weight:700;}
  .dev-meta{display:flex;gap:20px;flex-wrap:wrap;margin-top:12px;color:var(--text-soft);font-size:14px;}
  .my-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin:32px 0 70px;}
  @media(max-width:900px){.my-grid{grid-template-columns:repeat(2,1fr);}}
  @media(max-width:640px){.my-grid{grid-template-columns:1fr;}}
  .status-badge{position:absolute;top:14px;left:14px;font-size:11px;font-weight:700;padding:6px 12px;border-radius:100px;z-index:2;}
  .status-pending{background:#E8A93A;color:#1a1400;}
  .status-approved{background:var(--teal);color:#fff;}
  .status-rejected{background:#C24545;color:#fff;}
  .empty-state{text-align:center;padding:80px 20px;color:var(--text-soft);}
@endsection

@section('content')
<div class="wrap">
  <div class="dev-header">
    <a href="{{ route('admin.developers.index') }}" class="btn btn-ghost" style="margin-bottom:16px;">&larr; Kembali ke Kelola Developer</a>
    <h1>{{ $developer->company_name ?: $developer->name }}</h1>
    <div class="dev-meta">
      <span>{{ $developer->name }}</span>
      <span>{{ $developer->email }}</span>
      @if ($developer->phone)<span>{{ $developer->phone }}</span>@endif
      @if ($developer->instagram)<span>{{ $developer->instagram }}</span>@endif
    </div>
  </div>

  @if ($listings->isEmpty())
    <div class="empty-state">
      <h3>Developer ini belum daftarkan listing apapun.</h3>
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
              <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Kelola</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection