@extends('layouts.app')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun')

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-primary">{{ $stats['total_user'] }}</div>
            <div class="text-muted small">Total User</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-warning">{{ $stats['total_admin'] }}</div>
            <div class="text-muted small">Total Admin</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $stats['active'] }}</div>
            <div class="text-muted small">Akun Aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-secondary">{{ $stats['inactive'] }}</div>
            <div class="text-muted small">Akun Nonaktif</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('users.manage') }}" class="row g-2 align-items-end">
            <div class="col-md-6">
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
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('users.manage') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel User --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-info"></i>Akun User</h5>
        <span class="badge bg-info">{{ $users->total() }} akun</span>
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
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="{{ !$user->is_active ? 'table-secondary opacity-75' : '' }}">
                        <td class="ps-3 text-muted small">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" class="rounded-circle" width="32" height="32" alt="">
                                @else
                                    <div class="rounded-circle bg-info d-flex align-items-center justify-content-center text-white fw-bold"
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
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- Toggle Active --}}
                                <form action="{{ route('users.toggle-active', $user->id) }}" method="POST"
                                      onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($user->name) }}?')">
                                    @csrf
                                    @if($user->is_active)
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Nonaktifkan">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    @endif
                                </form>
                                {{-- Delete --}}
                                <form action="{{ route('users.delete', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada akun user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->links() }}</div>
    @endif
</div>

{{-- Tabel Admin --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-shield-check me-2 text-warning"></i>Akun Admin</h5>
        <span class="badge bg-warning text-dark">{{ $admins->total() }} akun</span>
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
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr class="{{ !$admin->is_active ? 'table-secondary opacity-75' : '' }}">
                        <td class="ps-3 text-muted small">{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($admin->avatar)
                                    <img src="{{ $admin->avatar }}" class="rounded-circle" width="32" height="32" alt="">
                                @else
                                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark fw-bold"
                                         style="width:32px;height:32px;font-size:0.75rem">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="fw-semibold small">{{ $admin->name }}</div>
                            </div>
                        </td>
                        <td><small>{{ $admin->email }}</small></td>
                        <td><small>{{ $admin->kabupaten_kota ?? '-' }}</small></td>
                        <td>
                            @if($admin->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    <i class="bi bi-slash-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $admin->created_at->format('d M Y') }}</small></td>
                        <td class="text-center pe-3">
                            <div class="d-flex gap-1 justify-content-center">
                                <form action="{{ route('users.toggle-active', $admin->id) }}" method="POST"
                                      onsubmit="return confirm('{{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($admin->name) }}?')">
                                    @csrf
                                    @if($admin->is_active)
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Nonaktifkan">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    @endif
                                </form>
                                <form action="{{ route('users.delete', $admin->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus akun admin {{ addslashes($admin->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada akun admin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($admins->hasPages())
    <div class="card-footer bg-white">{{ $admins->links() }}</div>
    @endif
</div>

@endsection
