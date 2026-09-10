@extends('layouts.app')

@section('title', 'Kelola Developer — Huniku')

@section('page-style')
  .admin-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .admin-header h1{font-size:28px;font-weight:700;}
  .status-tabs{display:flex;gap:6px;flex-wrap:wrap;margin:24px 0;}
  .status-tab{font-size:13px;font-weight:600;padding:9px 16px;border-radius:100px;background:var(--surface-alt);color:var(--text-soft);}
  .status-tab.active{background:var(--ink);color:var(--cream);}
  .status-tab .count{opacity:.7;margin-left:4px;}

  .admin-table-wrap{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;}
  table{width:100%;border-collapse:collapse;font-size:14px;}
  thead{background:var(--surface-alt);}
  th{text-align:left;padding:14px 18px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-soft);}
  td{padding:16px 18px;border-top:1px solid var(--border);vertical-align:middle;}
  td .title-cell{font-weight:700;}
  td .sub-cell{font-size:12.5px;color:var(--text-soft);margin-top:2px;}
  .badge{display:inline-block;font-size:11px;font-weight:700;padding:4px 10px;border-radius:100px;}
  .badge-pending{background:#E8A93A;color:#1a1400;}
  .badge-verified{background:var(--teal-soft);color:var(--accent-text);}
  .badge-rejected{background:rgba(194,69,69,0.15);color:#C24545;}
  .row-actions{display:flex;gap:8px;flex-wrap:wrap;}
  .row-actions .btn{padding:8px 14px;font-size:13px;}
  .btn-approve{background:var(--teal);color:#fff;}
  .btn-approve:hover{background:var(--teal-deep);}
  .btn-danger{background:transparent;color:#C24545;border:1px solid rgba(194,69,69,0.35);}
  .btn-danger:hover{background:rgba(194,69,69,0.08);}
  .empty-row{text-align:center;padding:60px 20px;color:var(--text-soft);}
  .pagination-wrap{display:flex;justify-content:center;margin-top:28px;}
@endsection

@section('content')
<div class="wrap">
  <div class="admin-header">
    <h1>Kelola Developer</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Verifikasi akun developer sebelum mereka bisa daftarkan properti.</p>
  </div>

  <div class="status-tabs">
    @foreach (['semua' => 'Semua', 'pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'] as $value => $label)
      <a href="{{ route('admin.developers.index', ['status' => $value]) }}" class="status-tab {{ $statusFilter === $value ? 'active' : '' }}">
        {{ $label }}
        @if ($value === 'pending' && $pendingCount > 0)
          <span class="count">({{ $pendingCount }})</span>
        @endif
      </a>
    @endforeach
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>Developer</th>
          <th>Kontak</th>
          <th>Jumlah Listing</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($developers as $dev)
          <tr>
            <td>
              <div class="title-cell">{{ $dev->company_name ?: $dev->name }}</div>
              <div class="sub-cell">{{ $dev->name }} &middot; {{ $dev->email }}</div>
            </td>
            <td>
              <div class="sub-cell">{{ $dev->phone ?: '-' }}</div>
              @if ($dev->instagram)
                <div class="sub-cell">{{ $dev->instagram }}</div>
              @endif
            </td>
            <td>{{ $dev->listings_count }}</td>
            <td>
              @if ($dev->developer_status === 'pending')
                <span class="badge badge-pending">Menunggu</span>
              @elseif ($dev->developer_status === 'verified')
                <span class="badge badge-verified">Terverifikasi</span>
              @else
                <span class="badge badge-rejected">Ditolak</span>
              @endif
            </td>
            <td>
              <div class="row-actions">
                <a href="{{ route('admin.developers.show', $dev) }}" class="btn btn-ghost">Lihat Listing</a>
                @if ($dev->developer_status === 'pending')
                  <form action="{{ route('admin.developers.verify', $dev) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-approve">Verifikasi</button>
                  </form>
                  <button type="button" class="btn btn-danger" onclick="rejectDeveloper({{ $dev->id }})">Tolak</button>
                  <form action="{{ route('admin.developers.reject', $dev) }}" method="POST" id="reject-dev-form-{{ $dev->id }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="rejection_reason" id="reject-dev-reason-{{ $dev->id }}">
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty-row">Belum ada developer di kategori ini.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $developers->links() }}
  </div>
</div>
@endsection

@section('page-script')
<script>
  function rejectDeveloper(id) {
    var reason = prompt('Alasan penolakan (opsional, bakal keliatan sama developer-nya):', '');
    if (reason === null) return;
    document.getElementById('reject-dev-reason-' + id).value = reason;
    document.getElementById('reject-dev-form-' + id).submit();
  }
</script>
@endsection