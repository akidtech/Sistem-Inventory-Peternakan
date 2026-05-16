@extends('layouts.app')
@section('title', 'Manajemen User')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Manajemen User</h3>
                <h6 class="text-muted">Kelola akun admin & peternak</h6>
            </div>
            <a href="{{ route('pengaturan.user.create') }}" class="btn btn-primary">
                <i class="ti-plus mr-1"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabel-user">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>No HP</th>
                                    <th>Terdaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $i => $u)
                                    <tr class="{{ $u->id == auth()->id() ? 'table-primary' : '' }}">
                                        <td>{{ $users->firstItem() + $i }}</td>
                                        <td>
                                            {{ $u->name }}
                                            @if ($u->id == auth()->id())
                                                <span class="badge badge-info ml-1">Anda</span>
                                            @endif
                                        </td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            @if ($u->role == 'admin')
                                                <span class="badge badge-danger">👑 Admin</span>
                                            @else
                                                <span class="badge badge-success">👨‍🌾 Peternak</span>
                                            @endif
                                        </td>
                                        <td>{{ $u->no_hp ?? '-' }}</td>
                                        <td>{{ $u->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('pengaturan.user.edit', $u) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            @if ($u->id != auth()->id())
                                                <form action="{{ route('pengaturan.user.destroy', $u) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                                        data-nama="{{ $u->name }}">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script>
        $('#tabel-user').DataTable({
            paging: false,
            language: {
                search: "Cari:",
                zeroRecords: "Tidak ada data"
            }
        });
    </script>
@endpush
