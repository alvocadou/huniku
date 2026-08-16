@extends('layouts.app')

@section('title', 'Kelola Listing — Huniku')

@section('page-style')
  .admin-header{padding:44px 0 24px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap;}
  .admin-header h1{font-size:28px;font-weight:700;}
  .admin-toolbar{display:flex;gap:10px;margin:24px 0;flex-wrap:wrap;align-items:center;}
  .admin-toolbar input{flex:1;min-width:220px;font-family:'Manrope',sans-serif;font-size:14px;font-weight:600;color:var(--text);background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:11px 14px;}

  .status-tabs{display:flex;gap:6px;flex-wrap:wrap;}
  .status-tab{font-size:13px;font-weight:600;padding:9px 16px;border-radius:100px;background:var(--surface-alt);color:var(--text-soft);border:1px solid transparent;}
  .status-tab.active{background:var(--ink);color:var(--cream);}
  .status-tab .count{opacity:.7;margin-left:4px;}

  .alert{background:var(--teal-soft);color:var(--accent-text);padding:14px 18px;border-radius:14px;font-size:14px;font-weight:600;margin-bottom:20px;}

  .admin-table-wrap{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;}
  table{width:100%;border-collapse:collapse;font-size:14px;}
  thead{background:var(--surface-alt);}
  th{text-align:left;padding:14px 18px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-soft);}
  td{padding:16px 18px;border-top:1px solid var(--border);vertical-align:middle;}
  td .title-cell{font-weight:700;}
  td .sub-cell{font-size:12.5px;color:var(--text-soft);margin-top:2px;}
  .badge{display:inline-block;font-size:11px;font-weight:700;padding:4px 10px;border-radius:100px;background:var(--teal-soft);color:var(--accent-text);margin-bottom:4px;}
  .badge-muted{background:var(--surface-alt);color:var(--text-soft);}
  .badge-pending{background:#E8A93A;color:#1a1400;}
  .badge-rejected{background:rgba(194,69,69,0.15);color:#C24545;}
  .row-actions{display:flex;gap:8px;flex-wrap:wrap;}
  .row-actions .btn{padding:8px 14px;font-size:13px;}
  .btn-danger{background:transparent;color:#C24545;border:1px solid rgba(194,69,69,0.35);}
  .btn-danger:hover{background:rgba(194,69,69,0.08);}
  .btn-approve{background:var(--teal);color:#fff;}
  .btn-approve:hover{background:var(--teal-deep);}

  .empty-row{text-align:center;padding:60px 20px;color:var(--text-soft);}
  .pagination-wrap{display:flex;justify-content:center;margin-top:28px;}
@endsection

@section('content')
<div class="wrap">
  <div class="admin-header">
    <div>
      <h1>Kelola Listing</h1>
      <p style="color:var(--text-soft);margin-top:6px;">Tambah, edit, atau tinjau properti yang tayang di Huniku.</p>
    </div>
    <a href="{{ route('admin.listings.create') }}" class="btn btn-primary">+ Tambah Listing</a>
  </div>

  <div class="admin-toolbar">
    <div class="status-tabs">
      @foreach (['semua' => 'Semua', 'pending' => 'Menunggu Review', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $value => $label)
        <a href="{{ route('admin.listings.index', array_merge(request()->except('status'), ['status' => $value])) }}" class="status-tab {{ $statusFilter === $value ? 'active' : '' }}">
          {{ $label }}
          @if ($value === 'pending' && $pendingCount > 0)
            <span class="count">({{ $pendingCount }})</span>
          @endif
        </a>
      @endforeach
    </div>
  </div>

  <form action="{{ route('admin.listings.index') }}" method="GET" class="admin-toolbar">
    <input type="hidden" name="status" value="{{ $statusFilter }}">
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul listing...">
    <button type="submit" class="btn btn-ghost">Cari</button>
  </form>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Listing</th>
          <th>Tipe</th>
          <th>Lokasi</th>
          <th>Harga</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($listings as $listing)
          <tr>
            <td style="width:56px;">
              @if ($listing->firstImageUrl())
                <img src="{{ $listing->firstImageUrl() }}" alt="{{ $listing->title }}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;display:block;">
              @else
                <div style="width:44px;height:44px;border-radius:10px;background:var(--surface-alt);"></div>
              @endif
            </td>
            <td>
              <div class="title-cell">{{ $listing->title }}</div>
              <div class="sub-cell">{{ ucfirst($listing->transaction_type) }} &middot; {{ $listing->submittedBy ? 'dari ' . $listing->submittedBy->name : 'oleh admin' }}</div>
            </td>
            <td>{{ ucfirst($listing->type) }}</td>
            <td>{{ $listing->district ? $listing->district . ', ' : '' }}{{ $listing->city }}</td>
            <td>{{ $listing->formattedPrice() }}{{ $listing->unitLabel() }}</td>
            <td>
              @if ($listing->status === 'pending')
                <span class="badge badge-pending">Menunggu Review</span>
              @elseif ($listing->status === 'rejected')
                <span class="badge badge-rejected">Ditolak</span>
              @endif
              <br>
              @if ($listing->is_verified)
                <span class="badge">Terverifikasi</span>
              @else
                <span class="badge badge-muted">Belum verifikasi</span>
              @endif
              @if ($listing->is_featured)
                <span class="badge" style="margin-left:6px;">Unggulan</span>
              @endif
            </td>
            <td>
              <div class="row-actions">
                @if ($listing->status === 'pending')
                  <form action="{{ route('admin.listings.approve', $listing) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-approve">Setujui</button>
                  </form>
                  <button type="button" class="btn btn-danger" onclick="rejectListing({{ $listing->id }})">Tolak</button>
                  <form action="{{ route('admin.listings.reject', $listing) }}" method="POST" id="reject-form-{{ $listing->id }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="rejection_reason" id="reject-reason-{{ $listing->id }}">
                  </form>
                @endif
                <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-ghost">Edit</a>
                <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" onsubmit="return confirm('Yakin mau hapus listing ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="empty-row">Nggak ada listing di kategori ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $listings->links() }}
  </div>
</div>
@endsection

@section('page-script')
<script>
  function rejectListing(id) {
    var reason = prompt('Alasan penolakan (opsional, bakal keliatan sama user-nya):', '');
    if (reason === null) return; // klik cancel di prompt

    document.getElementById('reject-reason-' + id).value = reason;
    document.getElementById('reject-form-' + id).submit();
  }
</script>
@endsection