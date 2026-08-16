@extends('layouts.app')

@section('title', ($listing->exists ? 'Edit Listing' : 'Tambah Listing') . ' — Huniku')

@section('page-style')
  .form-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .form-header h1{font-size:28px;font-weight:700;}
  .form-wrap{max-width:1180px;margin:32px auto 70px;}

  .form-shell{display:flex;background:var(--surface);border:1px solid var(--border);border-radius:24px;overflow:hidden;align-items:stretch;}
  @media(max-width:760px){.form-shell{flex-direction:column;}}

  /* left: image preview panel */
  .form-left{
    width:34%;flex-shrink:0;background:var(--surface-alt);
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    padding:32px;gap:16px;
  }
  @media(max-width:760px){.form-left{width:100%;}}
  .preview-box{
    width:100%;aspect-ratio:1;border-radius:18px;overflow:hidden;
    background:var(--surface);border:1.5px dashed var(--border);
    display:flex;align-items:center;justify-content:center;position:relative;
  }
  .preview-box img{width:100%;height:100%;object-fit:cover;display:block;}
  .preview-placeholder{color:var(--text-soft);font-size:13.5px;font-weight:600;text-align:center;padding:0 20px;}
  .preview-placeholder svg{display:block;margin:0 auto 10px;opacity:.5;}

  .thumb-strip{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;width:100%;}
  .thumb-item{position:relative;width:56px;height:56px;border-radius:10px;overflow:hidden;border:2px solid transparent;cursor:pointer;flex-shrink:0;}
  .thumb-item.active{border-color:var(--teal);}
  .thumb-item img{width:100%;height:100%;object-fit:cover;display:block;}
  .thumb-item.marked-delete img{opacity:.3;}
  .thumb-remove{
    position:absolute;top:2px;right:2px;width:16px;height:16px;border-radius:100px;
    background:rgba(23,24,28,0.8);color:#fff;border:none;font-size:10px;line-height:1;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
  }

  .upload-btn-row{display:flex;align-items:center;gap:10px;width:100%;}
  .upload-btn{
    background:var(--ink);color:var(--cream);border:none;border-radius:100px;
    padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;
  }
  .upload-hint{font-size:12px;color:var(--text-soft);}
  input[type=file]{display:none;}

  /* right: fields */
  .form-right{flex:1;padding:40px 44px;min-width:0;}
  .field-group{margin-bottom:18px;}
  .field-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  @media(max-width:500px){.field-row{grid-template-columns:1fr;}}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=text], input[type=number], select, textarea{
    width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);
    background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;
  }
  textarea{resize:vertical;min-height:90px;}
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .checkbox-row{display:flex;gap:24px;margin-top:6px;flex-wrap:wrap;}
  .checkbox-row label{display:flex;align-items:center;gap:8px;font-weight:600;font-size:14px;margin-bottom:0;}
  .checkbox-row input{width:auto;}
  .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:26px;padding-top:22px;border-top:1px solid var(--border);}
@endsection

@section('content')
<div class="wrap">
  <div class="form-header">
    <h1>{{ $listing->exists ? 'Edit Listing' : 'Tambah Listing Baru' }}</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Isi detail properti di bawah ini.</p>
  </div>

  <div class="form-wrap">
    <form action="{{ $listing->exists ? route('admin.listings.update', $listing) : route('admin.listings.store') }}" method="POST" enctype="multipart/form-data" id="listingForm" onsubmit="return interceptSubmit(event)">
      @csrf
      @if ($listing->exists) @method('PUT') @endif

      <div class="form-shell">
        <!-- LEFT: image preview -->
        <div class="form-left">
          <div class="preview-box" id="previewBox">
            <div class="preview-placeholder" id="previewPlaceholder">
              <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
              Preview Gambar
            </div>
            <img id="mainPreviewImg" style="display:none;" alt="Preview">
          </div>

          <div class="thumb-strip" id="thumbStrip"></div>

          <div class="upload-btn-row">
            <button type="button" class="upload-btn" onclick="document.getElementById('imageInput').click()">Pilih Gambar</button>
            <span class="upload-hint" id="fileCountText">Belum ada file dipilih</span>
          </div>
          <input type="file" name="images[]" id="imageInput" multiple accept="image/*">
          @error('images') <div class="error-text">{{ $message }}</div> @enderror
          @error('images.*') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <!-- RIGHT: fields -->
        <div class="form-right">
          <div class="field-group">
            <label>Judul Listing</label>
            <input type="text" name="title" value="{{ old('title', $listing->title) }}" placeholder="Contoh: Kost Melati Residence">
            @error('title') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Tipe Hunian</label>
              <select name="type">
                @foreach (['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'] as $value => $label)
                  <option value="{{ $value }}" {{ old('type', $listing->type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @error('type') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Jenis Transaksi</label>
              <select name="transaction_type">
                <option value="sewa" {{ old('transaction_type', $listing->transaction_type ?? 'sewa') === 'sewa' ? 'selected' : '' }}>Sewa</option>
                <option value="jual" {{ old('transaction_type', $listing->transaction_type ?? 'sewa') === 'jual' ? 'selected' : '' }}>Jual</option>
              </select>
              @error('transaction_type') <div class="error-text">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Kota</label>
              <input type="text" name="city" value="{{ old('city', $listing->city) }}" placeholder="Contoh: Surabaya">
              @error('city') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Kecamatan (opsional)</label>
              <input type="text" name="district" value="{{ old('district', $listing->district) }}" placeholder="Contoh: Rungkut">
            </div>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Latitude (opsional)</label>
              <input type="text" name="latitude" value="{{ old('latitude', $listing->latitude) }}" placeholder="-6.200000">
              @error('latitude') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Longitude (opsional)</label>
              <input type="text" name="longitude" value="{{ old('longitude', $listing->longitude) }}" placeholder="106.816666">
              @error('longitude') <div class="error-text">{{ $message }}</div> @enderror
            </div>
          </div>
          <p style="font-size:12px;color:var(--text-soft);margin-top:-10px;margin-bottom:18px;">Tips: buka lokasi di Google Maps, klik kanan titiknya, salin koordinat yang muncul. Kalau dikosongin, peta bakal nampilin perkiraan lokasi dari kota/kecamatan aja.</p>

          <div class="field-group">
            <label>Deskripsi</label>
            <textarea name="description" placeholder="Deskripsi singkat properti...">{{ old('description', $listing->description) }}</textarea>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Harga (Rp)</label>
              <input type="number" name="price" value="{{ old('price', $listing->price) }}" placeholder="950000" min="0">
              @error('price') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Satuan Harga</label>
              <select name="price_unit">
                <option value="bulan" {{ old('price_unit', $listing->price_unit ?? 'bulan') === 'bulan' ? 'selected' : '' }}>/ bulan (sewa)</option>
                <option value="tahun" {{ old('price_unit', $listing->price_unit) === 'tahun' ? 'selected' : '' }}>/ tahun (sewa)</option>
                <option value="hari" {{ old('price_unit', $listing->price_unit) === 'hari' ? 'selected' : '' }}>/ hari (sewa)</option>
                <option value="jual" {{ old('price_unit', $listing->price_unit) === 'jual' ? 'selected' : '' }}>Harga total (jual)</option>
              </select>
              @error('price_unit') <div class="error-text">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="field-group">
            <label>Warna Thumbnail (fallback kalau belum ada foto)</label>
            <select name="thumbnail_color">
              <option value="teal" {{ old('thumbnail_color', $listing->thumbnail_color ?? 'teal') === 'teal' ? 'selected' : '' }}>Teal</option>
              <option value="clay" {{ old('thumbnail_color', $listing->thumbnail_color) === 'clay' ? 'selected' : '' }}>Clay</option>
              <option value="dark" {{ old('thumbnail_color', $listing->thumbnail_color) === 'dark' ? 'selected' : '' }}>Dark</option>
            </select>
          </div>

          <div class="field-group">
            <label>Status</label>
            <div class="checkbox-row">
              <label><input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $listing->is_verified) ? 'checked' : '' }}> Terverifikasi</label>
              <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $listing->is_featured) ? 'checked' : '' }}> Tampilkan sebagai unggulan</label>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{ route('admin.listings.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">{{ $listing->exists ? 'Simpan Perubahan' : 'Simpan' }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('page-script')
<script>
  var existingImages = [
    @if ($listing->exists)
      @foreach ($listing->images as $image)
        { id: {{ $image->id }}, url: @json($image->url()), deleted: false },
      @endforeach
    @endif
  ];
  var activeKey = existingImages.length ? 'existing-0' : null;

  var imageInput = document.getElementById('imageInput');
  var mainPreviewImg = document.getElementById('mainPreviewImg');
  var previewPlaceholder = document.getElementById('previewPlaceholder');
  var thumbStrip = document.getElementById('thumbStrip');
  var fileCountText = document.getElementById('fileCountText');
  var form = document.getElementById('listingForm');

  function render() {
    // gabungan thumbnail: foto lama (yang belum ditandai hapus) + foto baru yang baru dipilih (langsung dari imageInput, TIDAK direkonstruksi)
    var thumbs = [];
    existingImages.forEach(function (img, i) {
      thumbs.push({ key: 'existing-' + i, url: img.url, deleted: img.deleted, type: 'existing', index: i });
    });
    Array.from(imageInput.files || []).forEach(function (file, i) {
      thumbs.push({ key: 'new-' + i, url: URL.createObjectURL(file), deleted: false, type: 'new', index: i });
    });

    var current = thumbs.find(function (t) { return t.key === activeKey && !t.deleted; });
    if (!current) {
      current = thumbs.find(function (t) { return !t.deleted; });
      activeKey = current ? current.key : null;
    }

    if (current) {
      mainPreviewImg.src = current.url;
      mainPreviewImg.style.display = 'block';
      previewPlaceholder.style.display = 'none';
    } else {
      mainPreviewImg.style.display = 'none';
      previewPlaceholder.style.display = 'block';
    }

    thumbStrip.innerHTML = '';
    thumbs.forEach(function (t) {
      var el = document.createElement('div');
      el.className = 'thumb-item' + (t.key === activeKey ? ' active' : '') + (t.deleted ? ' marked-delete' : '');

      var img = document.createElement('img');
      img.src = t.url;
      img.alt = 'foto';
      img.addEventListener('click', function () {
        activeKey = t.key;
        render();
      });
      el.appendChild(img);

      // foto lama bisa ditandai hapus; foto baru cukup dilihat (buat hapus, pilih ulang filenya)
      if (t.type === 'existing') {
        var removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'thumb-remove';
        removeBtn.title = 'Tandai hapus';
        removeBtn.textContent = '✕';
        removeBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          existingImages[t.index].deleted = !existingImages[t.index].deleted;
          render();
        });
        el.appendChild(removeBtn);
      }

      thumbStrip.appendChild(el);
    });

    var newCount = (imageInput.files || []).length;
    fileCountText.textContent = newCount ? newCount + ' file baru dipilih' : 'Belum ada file baru dipilih';

    form.querySelectorAll('input[name="delete_images[]"]').forEach(function (el) { el.remove(); });
    existingImages.forEach(function (img) {
      if (img.deleted) {
        var hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'delete_images[]';
        hidden.value = img.id;
        form.appendChild(hidden);
      }
    });
  }

  imageInput.addEventListener('change', render);

  render();

  function interceptSubmit(event) {
    event.preventDefault();
    var isEdit = {{ $listing->exists ? 'true' : 'false' }};
    openConfirmModal(
      isEdit ? 'Yakin mau simpan perubahan listing ini?' : 'Yakin mau tambah listing ini?',
      function () { form.submit(); }
    );
    return false;
  }
</script>
@endsection