@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
    <style>
        .card-icon {
            position: absolute;
            font-size: 70px;
            color: rgba(255, 255, 255, 0.3);
            right: 10px;
            bottom: 10px;
        }
    </style>
@endsection

@section('main')
    <h1>Dynamic Dashboard
        <button class="btn btn-primary btn-sm float-end" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasFilter" aria-controls="offcanvasFilter">
            Filter
        </button>
    </h1>
    <div class="row g-2">
        <div class="col-md-3">
            <div class="card text-bg-primary" id="totalCustomer">
                <div class="card-body">
                    <h5 class="card-title">Total Customer</h5>
                    <p class="card-text display-6">
                        <i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>
                    </p>
                    <i class="fa fa-user card-icon" aria-hidden="true"></i>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-6">
                        <i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>
                    </p>
                    <i class="fa fa-boxes card-icon" aria-hidden="true"></i>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-6">
                        <i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>
                    </p>
                    <i class="fa fa-shopping-cart card-icon" aria-hidden="true"></i>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Employee</h5>
                    <p class="card-text display-6">
                        <i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>
                    </p>
                    <i class="fa fa-users card-icon" aria-hidden="true"></i>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <canvas id="revChart" height="250"></canvas>
        </div>
        <div class="col-md-6">
            <div id="revTableDiv" class="">
                <table class="table" id="revTbl">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="custTableDiv" class="tblDiv d-none">
                <button type="button" class="btn btn-link btn-close float-end"></button>
                <table class="table" id="custTbl">
                    <thead>
                        <tr>
                            <th>customerName #</th>
                            <th>phone</th>
                            <th>salesRep</th>
                            <th>city</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasFilter"
        aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">
                Dashboard Filter
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="form-group {{ $errors->has('office') ? 'has-error' : '' }}">
                <label for="office">Office</label>
                <select id="office" name="office" class="form-control" required>
                    <option value="">Select Office</option>
                    @foreach ($offices as $key => $office)
                        <option value="{{ $key }}">{{ $office }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('office') }}</small>
            </div>
            <div class="form-group {{ $errors->has('year') ? 'has-error' : '' }}">
                <label for="year">Year</label>
                <select id="year" name="year" class="form-control" required>
                    <option value="">Select year</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('year') }}</small>
            </div>
            <button type="button" id="btnFilter" class="btn btn-primary mt-3">Apply Filter</button>
            <button type="button" class="btn btn-danger btn-delete mt-3">Apply Filter</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script>
        $('#totalCustomer').click(function (e) {
            e.preventDefault();
            $('#custTableDiv').removeClass('d-none');
            $('#revTableDiv').addClass('d-none');
            custTbl.ajax.reload();
        });

        $('.btn-close').click(function (e) {
            e.preventDefault();
            $(this).closest('.tblDiv').addClass('d-none');
            $('#revTableDiv').removeClass('d-none');
        });
        loaddata();

        function loaddata() {
            $('.card .card-text').html('<i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>');
            $.ajax({
                type: "post",
                url: "{{ route('dynamicdashboard.loaddata') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "office": $('#office').val(),
                    "year": $('#year').val()
                },
                dataType: "json",
                success: function(response) {
                    setTimeout(function() {
                        $('.card.text-bg-primary .card-text').html(response.card.customer);
                        $('.card.text-bg-success .card-text').html(response.card.product);
                        $('.card.text-bg-danger .card-text').html(response.card.order);
                        $('.card.text-bg-warning .card-text').html(response.card.employee);
                    }, 1000);
                    $('#offcanvasFilter').offcanvas('hide');
                    const labels = response.monthOrder.map(item => `${item.month} ${item.year}`);
                    const data = response.monthOrder.map(item => parseFloat(item.total) || 0);

                    renderMonthlyRevenueChart(labels, data, response.monthOrder);
                }
            });
        }
        var monthlyRevChart;
        var monthyear;

        function renderMonthlyRevenueChart(labels, data, monthRev) {
            const monthlyRevCtx = document.getElementById('revChart').getContext('2d');

            if (monthlyRevChart) {
                monthlyRevChart.destroy();
            }

            monthlyRevChart = new Chart(monthlyRevCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    onClick: function(e, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const selected = monthRev[index];
                            console.log(selected);
                            monthyear = selected.monthyear;
                            const value = parseFloat(selected.total) || 0;
                            renderMonthlyRevenueChart([labels[index]], [value], [monthyear]);
                            revTbl.ajax.reload();
                        }
                    }
                }
            });
        }

        $('#btnFilter').click(function(e) {
            e.preventDefault();
            loaddata();
            revTbl.ajax.reload();
        });

        var revTbl = $('#revTbl').DataTable({
            lengthChange: false,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dynamicdashboard.revenueDetails') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.office = $('#office').val();
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
            ],
        });

        var custTbl = $('#custTbl').DataTable({
            lengthChange: false,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dynamicdashboard.customerDetails') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.office = $('#office').val();
                    d.year = $('#year').val();
                }
            },
            columns: [{
                    data: 'customerName',
                    name: 'customerName'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'salesRep'
                },
                {
                    data: 'city'
                }
            ],
        });
    </script>
@endsection
