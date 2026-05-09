@extends('layouts.app')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
            <div class="text-muted small">Total Akun Aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $stats['active'] }}</div>
            <div class="text-muted small">Akun Aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-secondary">{{ $stats['inactive'] }}</div>
            <div class="text-muted small">Akun Nonaktif</div>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('users.manage') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold">Cari</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Nama, email, atau kabupaten/kota..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status','all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Role</label>
                <select name="role" class="form-select">
                    <option value="all" {{ request('role','all') === 'all' ? 'selected' : '' }}>Semua Role</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('users.manage') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-people me-2 text-primary"></i>Daftar Akun Terdaftar</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kabupaten/Kota</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="{{ !$user->is_active ? 'table-secondary opacity-75' : '' }}">
                        <td class="ps-3 text-muted small">
                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" class="rounded-circle" width="32" height="32" alt="">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                         style="width:32px;height:32px;font-size:0.75rem">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $user->name }}</div>
                                    @if($user->google_id)
                                        <small class="text-muted"><i class="bi bi-google me-1"></i>Google</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><small>{{ $user->email }}</small></td>
                        <td><small>{{ $user->kabupaten_kota ?? '-' }}</small></td>
                        <td>
                            @php
                                $roleColor = ['admin' => 'warning', 'user' => 'info'][$user->role] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    <i class="bi bi-slash-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $user->created_at->format('d M Y') }}</small></td>
                        <td class="text-center pe-3">
                            <form action="{{ route('users.toggle-active', $user->id) }}" method="POST"
                                  onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $user->name }}?')">
                                @csrf
                                @if($user->is_active)
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Nonaktifkan">
                                        <i class="bi bi-slash-circle me-1"></i>Nonaktifkan
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Aktifkan">
                                        <i class="bi bi-check-circle me-1"></i>Aktifkan
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada akun yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
