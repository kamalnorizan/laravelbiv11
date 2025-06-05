@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Larave BI Shop</h1>
        <div class="row">
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
            url: "{{ route('metabase.embed') }}",
            dataType: "json",
            success: function(response) {
                $('#metabaseFrame').attr('src', response.embedUrl);
            }
        });
    </script>
@endsection
