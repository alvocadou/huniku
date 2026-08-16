@extends('layouts.app')

@section('title', 'Daftarkan Properti — Huniku')

@section('page-style')
  .form-header{padding:44px 0 24px;border-bottom:1px solid var(--border);}
  .form-header h1{font-size:28px;font-weight:700;}
  .form-wrap{max-width:960px;margin:32px auto 70px;}
  .info-banner{background:var(--teal-soft);color:var(--accent-text);padding:14px 18px;border-radius:14px;font-size:13.5px;font-weight:600;margin-bottom:24px;}

  .form-shell{display:flex;background:var(--surface);border:1px solid var(--border);border-radius:24px;overflow:hidden;align-items:stretch;}
  @media(max-width:760px){.form-shell{flex-direction:column;}}
  .form-left{width:34%;flex-shrink:0;background:var(--surface-alt);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:32px;gap:16px;}
  @media(max-width:760px){.form-left{width:100%;}}
  .preview-box{width:100%;aspect-ratio:1;border-radius:18px;overflow:hidden;background:var(--surface);border:1.5px dashed var(--border);display:flex;align-items:center;justify-content:center;position:relative;}
  .preview-box img{width:100%;height:100%;object-fit:cover;display:block;}
  .preview-placeholder{color:var(--text-soft);font-size:13.5px;font-weight:600;text-align:center;padding:0 20px;}
  .preview-placeholder svg{display:block;margin:0 auto 10px;opacity:.5;}
  .thumb-strip{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;width:100%;}
  .thumb-item{position:relative;width:56px;height:56px;border-radius:10px;overflow:hidden;border:2px solid transparent;cursor:pointer;flex-shrink:0;}
  .thumb-item.active{border-color:var(--teal);}
  .thumb-item img{width:100%;height:100%;object-fit:cover;display:block;}
  .upload-btn-row{display:flex;align-items:center;gap:10px;width:100%;}
  .upload-btn{background:var(--ink);color:var(--cream);border:none;border-radius:100px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;}
  .upload-hint{font-size:12px;color:var(--text-soft);}
  input[type=file]{display:none;}

  .form-right{flex:1;padding:40px 44px;min-width:0;}
  .field-group{margin-bottom:18px;}
  .field-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  @media(max-width:500px){.field-row{grid-template-columns:1fr;}}
  label{display:block;font-size:13px;font-weight:700;margin-bottom:8px;}
  input[type=text], input[type=number], select, textarea{width:100%;font-family:'Manrope',sans-serif;font-size:14.5px;color:var(--text);background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:12px 14px;}
  textarea{resize:vertical;min-height:90px;}
  .error-text{color:#C24545;font-size:12.5px;margin-top:6px;}
  .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:26px;padding-top:22px;border-top:1px solid var(--border);}
@endsection

@section('content')
<div class="wrap">
  <div class="form-header">
    <h1>Daftarkan Properti</h1>
    <p style="color:var(--text-soft);margin-top:6px;">Isi detail propertimu — tim Huniku bakal review dulu sebelum tayang.</p>
  </div>

  <div class="form-wrap">
    <div class="info-banner">Listing yang kamu kirim nggak langsung tayang — bakal ditinjau tim Huniku dulu (biasanya 1x24 jam) buat mastiin datanya valid.</div>

    <form action="{{ route('submit.store') }}" method="POST" enctype="multipart/form-data" id="listingForm">
      @csrf

      <div class="form-shell">
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

        <div class="form-right">
          <div class="field-group">
            <label>Judul Listing</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Kost Melati Residence">
            @error('title') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Tipe Hunian</label>
              <select name="type" class="custom-select">
                @foreach (['rumah' => 'Rumah', 'kost' => 'Kost', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'] as $value => $label)
                  <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @error('type') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Jenis Transaksi</label>
              <select name="transaction_type" class="custom-select">
                <option value="sewa" {{ old('transaction_type', 'sewa') === 'sewa' ? 'selected' : '' }}>Sewa</option>
                <option value="jual" {{ old('transaction_type') === 'jual' ? 'selected' : '' }}>Jual</option>
              </select>
            </div>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Kota</label>
              <input type="text" name="city" value="{{ old('city') }}" placeholder="Contoh: Surabaya">
              @error('city') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Kecamatan (opsional)</label>
              <input type="text" name="district" value="{{ old('district') }}" placeholder="Contoh: Rungkut">
            </div>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Latitude (opsional)</label>
              <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="-6.200000">
            </div>
            <div class="field-group">
              <label>Longitude (opsional)</label>
              <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="106.816666">
            </div>
          </div>

          <div class="field-row">
            <div class="field-group">
              <label>Harga (Rp)</label>
              <input type="number" name="price" value="{{ old('price') }}" placeholder="950000" min="0">
              @error('price') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="field-group">
              <label>Satuan Harga</label>
              <select name="price_unit" class="custom-select">
                <option value="bulan" {{ old('price_unit', 'bulan') === 'bulan' ? 'selected' : '' }}>/ bulan (sewa)</option>
                <option value="tahun" {{ old('price_unit') === 'tahun' ? 'selected' : '' }}>/ tahun (sewa)</option>
                <option value="hari" {{ old('price_unit') === 'hari' ? 'selected' : '' }}>/ hari (sewa)</option>
                <option value="jual" {{ old('price_unit') === 'jual' ? 'selected' : '' }}>Harga total (jual)</option>
              </select>
            </div>
          </div>

          <div class="field-group">
            <label>Deskripsi</label>
            <textarea name="description" placeholder="Ceritain kondisi propertinya...">{{ old('description') }}</textarea>
          </div>

          <div class="form-actions">
            <a href="{{ route('home') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Kirim buat Ditinjau</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('page-script')
<script>
  var imageInput = document.getElementById('imageInput');
  var mainPreviewImg = document.getElementById('mainPreviewImg');
  var previewPlaceholder = document.getElementById('previewPlaceholder');
  var thumbStrip = document.getElementById('thumbStrip');
  var fileCountText = document.getElementById('fileCountText');
  var activeIndex = 0;

  function render() {
    var files = Array.from(imageInput.files || []);

    if (files.length) {
      mainPreviewImg.src = URL.createObjectURL(files[Math.min(activeIndex, files.length - 1)]);
      mainPreviewImg.style.display = 'block';
      previewPlaceholder.style.display = 'none';
    } else {
      mainPreviewImg.style.display = 'none';
      previewPlaceholder.style.display = 'block';
    }

    thumbStrip.innerHTML = '';
    files.forEach(function (file, i) {
      var el = document.createElement('div');
      el.className = 'thumb-item' + (i === activeIndex ? ' active' : '');
      var img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.addEventListener('click', function () { activeIndex = i; render(); });
      el.appendChild(img);
      thumbStrip.appendChild(el);
    });

    fileCountText.textContent = files.length ? files.length + ' file dipilih' : 'Belum ada file dipilih';
  }

  imageInput.addEventListener('change', function () { activeIndex = 0; render(); });
  render();
</script>
@endsection