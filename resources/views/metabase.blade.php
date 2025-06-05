@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Larave BI Shop</h1>
        <div class="row">
            <div class="col-md-12">
                <iframe height="400" width="100%" src="" id="frameChart" frameborder="0"></iframe>
            </div>
            <div class="col-md-12">
                <iframe height="600" width="100%" src="" id="metabaseFrame" frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajax({
            type: "GET",
            url: "{{ route('metabase.embed',['type'=>'dashboard', 'id'=>'33']) }}",
            dataType: "json",
            success: function(response) {
                $('#metabaseFrame').attr('src', response.embedUrl);
            }
        });
        $.ajax({
            type: "GET",
            url: "{{ route('metabase.embed',['type'=>'question', 'id'=>'98']) }}",
            dataType: "json",
            success: function(response) {
                $('#frameChart').attr('src', response.embedUrl);
            }
        });
    </script>
@endsection
