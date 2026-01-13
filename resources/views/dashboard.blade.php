@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Dashboard {{ Auth::user()->role === 'admin' ? 'Admin Dinas' : 'Peternak' }}
        </h1>
        @if(Auth::user()->role === 'peternak')
            <span class="badge badge-primary p-2">
                <i class="fas fa-user"></i> {{ $data['peternak']->user->name }}
            </span>
        @endif
    </div>

    @if(Auth::user()->role === 'admin')
        @include('dashboard.partials.admin-stats')
    @elseif (Auth::user()->role === 'peternak')
        @include('dashboard.partials.peternak-stats')
    @else
        <h1>Tidak Ada Data</h1>
    @endif

</div>
<!-- /.container-fluid -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Pesanan
    const ctx = document.getElementById('chartPesanan');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['chartPesanan']['labels']),
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: @json($data['chartPesanan']['data']),
                    borderColor: 'rgb(78, 115, 223)',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: 'rgb(78, 115, 223)',
                    pointBorderColor: 'rgb(78, 115, 223)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgb(78, 115, 223)',
                    pointHoverBorderColor: 'rgb(78, 115, 223)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                        },
                        grid: {
                            color: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyColor: "#858796",
                        titleMarginBottom: 10,
                        titleColor: '#6e707e',
                        titleFont: {
                            size: 14
                        },
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                    }
                }
            }
        });
    }
</script>
@endpush