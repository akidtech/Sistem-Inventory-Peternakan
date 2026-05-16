@extends('layouts.app')
@section('title', 'Bobot Kriteria SPK')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Bobot Kriteria SPK</h3>
            <h6 class="text-muted">Sesuaikan bobot tiap kriteria (total harus 100%)</h6>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card grid-margin">
                <div class="card-body">

                    @if ($errors->has('bobot'))
                        <div class="alert alert-danger">
                            <i class="ti-alert mr-2"></i> {{ $errors->first('bobot') }}
                        </div>
                    @endif

                    <form action="{{ route('pengaturan.kriteria.update') }}" method="POST">
                        @csrf @method('PUT')

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kriteria</th>
                                    <th>Tipe</th>
                                    <th width="180">Bobot (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $k)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ $k->kode_kriteria }}</span></td>
                                        <td>{{ $k->nama_kriteria }}</td>
                                        <td><span class="badge badge-success">{{ ucfirst($k->tipe) }}</span></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" name="bobot[{{ $k->id }}]"
                                                    class="form-control bobot-input @error('bobot.' . $k->id) is-invalid @enderror"
                                                    value="{{ old('bobot.' . $k->id, $k->bobot * 100) }}" min="1"
                                                    max="100" step="1">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">Total Bobot:</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="total-bobot" class="form-control font-weight-bold"
                                                value="{{ round($totalBobot * 100) }}" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="alert alert-info">
                            <i class="ti-info-alt mr-2"></i>
                            Total bobot <strong>harus tepat 100%</strong>. Jika total berubah, sistem SPK akan menggunakan
                            bobot baru pada perhitungan berikutnya.
                        </div>

                        <button type="submit" class="btn btn-primary" id="btn-simpan">
                            <i class="ti-save mr-1"></i> Simpan Bobot
                        </button>

                    </form>
                </div>
            </div>
        </div>

        {{-- Preview bobot --}}
        <div class="col-md-5">
            <div class="card grid-margin">
                <div class="card-body">
                    <h5 class="card-title">Preview Bobot</h5>
                    @foreach ($kriteria as $k)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>
                                    <span class="badge badge-primary">{{ $k->kode_kriteria }}</span>
                                    {{ $k->nama_kriteria }}
                                </span>
                                <strong id="label-{{ $k->id }}">{{ round($k->bobot * 100) }}%</strong>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-primary" id="bar-{{ $k->id }}"
                                    style="width: {{ $k->bobot * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        const kriteriaIds = @json($kriteria->pluck('id'));

        // Real-time update total & progress bar
        document.querySelectorAll('.bobot-input').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        function updateTotal() {
            let total = 0;
            kriteriaIds.forEach(id => {
                const val = parseFloat(document.querySelector(`[name="bobot[${id}]"]`).value) || 0;
                total += val;

                // Update label & bar
                document.getElementById(`label-${id}`).textContent = val + '%';
                document.getElementById(`bar-${id}`).style.width = Math.min(val, 100) + '%';
            });

            const totalEl = document.getElementById('total-bobot');
            const btnEl = document.getElementById('btn-simpan');
            totalEl.value = total;

            if (total === 100) {
                totalEl.style.color = '#57B657';
                btnEl.disabled = false;
            } else {
                totalEl.style.color = '#E33353';
                btnEl.disabled = true;
            }
        }

        // Konversi input persen → desimal sebelum submit
        document.querySelector('form').addEventListener('submit', function() {
            kriteriaIds.forEach(id => {
                const input = document.querySelector(`[name="bobot[${id}]"]`);
                input.value = (parseFloat(input.value) / 100).toFixed(2);
            });
        });
    </script>
@endpush
