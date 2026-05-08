@extends('layouts.app')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Dokumen</h5>
                <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="category" value="{{ old('category', $announcement->category) }}">

                    {{-- Jenis Dokumen --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-select @error('announcement_type') is-invalid @enderror"
                                name="announcement_type" id="announcement_type" required>
                            @foreach($announcementTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('announcement_type', $announcement->announcement_type) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('announcement_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $announcement->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  required>{{ old('description', $announcement->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Format --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Format <span class="text-danger">*</span></label>
                        <select name="format" class="form-select @error('format') is-invalid @enderror" required>
                            @foreach($formats as $label => $value)
                            <option value="{{ $label }}" {{ old('format', $announcement->format) == $label ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('format')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Dynamic fields --}}
                    <div id="regulasi-fields" style="display:none">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tahun Regulasi</label>
                            <input type="number" name="year" class="form-control"
                                   value="{{ old('year', $announcement->year) }}"
                                   min="1900" max="{{ date('Y') }}">
                        </div>
                    </div>

                    <div id="surat-fields" style="display:none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Surat</label>
                                <input type="text" name="type" class="form-control"
                                       value="{{ old('type', $announcement->type) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Surat</label>
                                <input type="date" name="date" class="form-control"
                                       value="{{ old('date', $announcement->date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                   {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Aktif (tampil di halaman publik)</label>
                        </div>
                    </div>

                    {{-- File saat ini --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File Saat Ini</label>
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded border">
                            <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                            <span class="small">{{ $announcement->file_name }}</span>
                            <span class="badge bg-secondary ms-auto">{{ $announcement->file_size }}</span>
                        </div>
                    </div>

                    {{-- Upload file baru (opsional) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ganti File <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                               accept=".pdf,.doc,.docx,.ppt,.pptx">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti file. Maks 10MB.</div>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('announcement_type');

    function toggleFields() {
        const val = typeSelect.value;
        document.getElementById('regulasi-fields').style.display = val === 'regulasi' ? 'block' : 'none';
        document.getElementById('surat-fields').style.display    = val === 'surat'    ? 'block' : 'none';
        // sync hidden category
        document.querySelector('input[name="category"]').value = val || 'regulasi';
    }

    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // run on load
});
</script>
@endpush
