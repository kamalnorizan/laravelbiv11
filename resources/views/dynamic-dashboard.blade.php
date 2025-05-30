@extends('layouts.app')

@section('head')
    <style>
        .card-icon {
            position: absolute;
            font-size:70px;
            color: rgba(255, 255, 255, 0.3);
            right: 10px;
            bottom: 10px;
        }
    </style>
@endsection

@section('main')
    <h1>Dynamic Dashboard</h1>
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
@endsection

@section('scripts')
    <script>
        loaddata();
        function loaddata(){
            $.ajax({
                type: "post",
                url: "{{ route('dynamicdashboard.loaddata') }}",
                data: {
                    "_token": "{{ csrf_token() }}"

                },
                dataType: "json",
                success: function (response) {
                    $('.card.text-bg-primary .card-text').html(response.customer);
                    $('.card.text-bg-success .card-text').html(response.product);
                    $('.card.text-bg-danger .card-text').html(response.order);
                    $('.card.text-bg-warning .card-text').html(response.employee);
                }
            });
        }
    </script>
@endsection
