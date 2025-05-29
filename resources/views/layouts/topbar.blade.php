<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('chartjs') }}">Laravel ChartJS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarID" aria-controls="navbarID"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarID">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="{{ route('chartjs') }}">ChartJS Static</a>
            </div>
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="{{ route('dynamicdashboard.index') }}">ChartJS Dynamic</a>
            </div>
        </div>

    </div>
</nav>
