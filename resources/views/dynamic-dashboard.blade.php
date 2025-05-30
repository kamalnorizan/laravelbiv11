@extends('layouts.app')

@section('head')
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
        <button class="btn btn-primary btn-sm float-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
            aria-controls="offcanvasFilter">
            Filter
        </button>
    </h1>
    <div class="row g-2">
        <div class="col-md-3">
            <div class="card text-bg-primary">
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



    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasFilter" aria-labelledby="staticBackdropLabel">
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
            <button type="button" id="btnFilter" class="btn btn-primary mt-3">Apply Filter</button>
            <button type="button" class="btn btn-danger btn-delete mt-3">Apply Filter</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        loaddata();

        function loaddata() {
            $('.card .card-text').html('<i class="fa fa-spinner text-muted fa-spin" aria-hidden="true"></i>');
            $.ajax({
                type: "post",
                url: "{{ route('dynamicdashboard.loaddata') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "office": $('#office').val()
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
                }
            });
        }

        $('#btnFilter').click(function(e) {
            e.preventDefault();
            loaddata();
        });
    </script>
@endsection
