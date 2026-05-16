@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 style="font-size: 80px;">🚫</h1>
                    <h3 class="font-weight-bold text-danger">Akses Ditolak!</h3>
                    <p class="text-muted">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                        <i class="ti-home mr-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
