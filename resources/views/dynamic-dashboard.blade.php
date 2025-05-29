@extends('layouts.app')

@section('head')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        .card-icon-bg {
            font-size: 4rem;
            position: absolute;
            right: 1rem;
            bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.2);
        }

        .card-body {
            position: relative;
            min-height: 120px;
        }
    </style>
@endsection
@section('main')
    <h1 class="mb-4">Dynamic Dashboard
        <button class="btn btn-outline-primary float-end" data-bs-toggle="offcanvas" data-bs-target="#filterPanel"
            aria-controls="filterPanel">
            <i class="fas fa-filter"></i> Filter
        </button>
    </h1>

    <p>Welcome to your dynamic dashboard! Here you can manage your content and settings.</p>
    <div class="row g-3 topcards">
        <!-- Total Customers -->
        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <p class="card-text display-6"> <i class="fa fa-spinner fa-spin text-muted" aria-hidden="true"></i> </p>
                    <i class="fas fa-users card-icon-bg"></i>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-6"><i class="fa fa-spinner fa-spin text-muted" aria-hidden="true"></i> </p>
                    <i class="fas fa-boxes card-icon-bg"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-6"><i class="fa fa-spinner fa-spin text-muted" aria-hidden="true"></i> </p>
                    <i class="fas fa-shopping-cart card-icon-bg"></i>
                </div>
            </div>
        </div>

        <!-- Total Employees -->
        <div class="col-md-3">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text display-6"><i class="fa fa-spinner fa-spin text-muted" aria-hidden="true"></i> </p>
                    <i class="fas fa-user-tie card-icon-bg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Monthly Order Revenue <span id="filterTitle"></span></h3>
            <canvas id="monthlyRevenueChart" height="250"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Revenue Details</h3>
            <div class="card">
                <div class="card-body">
                    <table class="table" id="revenueDetailsTable" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <td>Order #</td>
                                <td>Customer</td>
                                <td>Date</td>
                                <td>Revenue</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterPanel" aria-labelledby="filterPanelLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterPanelLabel">Filter Options</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Filter Form Example -->
            <form id="filterForm">

                <div class="mb-3">
                    <label for="office" class="form-label">Office</label>
                    <select id="office" class="form-select">
                        <option value="" selected>All</option>
                        @foreach ($offices as $key => $office)
                            <option value="{{ $key }}">{{ $office }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <select id="year" class="form-select">
                        <option value="" selected>All</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" class="form-select">
                        <option selected>All</option>
                        <option>Electronics</option>
                        <option>Furniture</option>
                        <option>Clothing</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="priceRange" class="form-label">Price Range</label>
                    <input type="range" class="form-range" min="0" max="1000" step="50" id="priceRange">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="filterBtn" class="btn btn-primary w-100">Apply Filter</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" id="resetBtn" class="btn btn-secondary w-100">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        loaddata();

        function loaddata() {
            $('.topcards .card-body .card-text').html(
                '<i class="fa fa-spinner fa-spin text-muted" aria-hidden="true"></i>');
            $.ajax({
                type: "post",
                url: "{{ route('dynamicdashboard.loadData') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    'office': $('#office').val(),
                    'year': $('#year').val(),
                },
                dataType: "json",
                success: function(response) {
                    $('.card-body .card-text').eq(0).text(response.card.totalCustomers);
                    $('.card-body .card-text').eq(1).text(response.card.totalProducts);
                    $('.card-body .card-text').eq(2).text(response.card.totalOrders);
                    $('.card-body .card-text').eq(3).text(response.card.totalEmployees);

                    const labels = response.monthRev.map(item => `${item.month} ${item.year}`);
                    const data = response.monthRev.map(item => parseFloat(item.total));
                    renderMonthlyRevenueChart(labels, data, response.monthRev);
                }
            });
        }
        var monthlyRevenueChart;

        function renderMonthlyRevenueChart(labels, data, rawResponse) {
            $('#revenueDetailsTable').DataTable().ajax.reload();
            const monthlyRevenueChartCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
            if (monthlyRevenueChart) {
                monthlyRevenueChart.destroy();
            }
            monthlyRevenueChart = new Chart(monthlyRevenueChartCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Revenue (USD)',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    onClick: function(evt, activeEls) {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const selected = rawResponse[index];
                            console.log(selected);
                            const label = `${selected.month} ${selected.year}`;
                            monthyear = selected.monthyear;
                            const value = parseFloat(selected.total);
                            renderMonthlyRevenueChart([label], [value], [selected]);
                            $('#filterTitle').append(' - ' + label +
                                '<button class="btn btn-sm btn-warning float-end clearFilterBtn">Clear</button>'
                            );
                        }

                    }
                }
            });

        }

        $(document).on("click", ".clearFilterBtn", function(e) {
            e.preventDefault();
            $('#filterTitle').html('');
            monthyear = '';
            loaddata();
            $('#revenueDetailsTable').DataTable().ajax.reload();
        });

        $('#filterBtn').click(function(e) {
            e.preventDefault();
            loaddata();
            if ($('#office').val() != '') {
                $('#filterTitle').text(' - ' + $('#office option:selected').text());
            } else {
                $('#filterTitle').text('');
            }
            $('#filterPanel').offcanvas('hide');
        });

        $('#resetBtn').click(function(e) {
            e.preventDefault();
            $('#filterForm')[0].reset();
            $('#filterTitle').text('');
            monthyear = '';
            loaddata();
            $('#filterPanel').offcanvas('hide');
        });
        var monthyear;
        $('#revenueDetailsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            lengthChange: false, // hides "Show [10] entries"
            searching: false, // hides the search box
            ajax: {
                url: "{{ route('dynamicdashboard.revenueDetails') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.office = $('#office ').val();
                    d.year = $('#year').val();
                    d.monthyear = monthyear;
                }
            },
            columns: [{
                    data: 'orderNumber',
                    name: 'orderNumber'
                },
                {
                    data: 'customerName'
                },
                {
                    data: 'orderDate',
                    name: 'orderDate'
                },

                {
                    data: 'revenue'
                }
            ]
        });
    </script>
@endsection
