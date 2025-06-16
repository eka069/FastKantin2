@extends('layout.main')

@section('content')
<div class="row">

    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Menu</h5>
                <h2>{{$menu}}</h2>
                <p>Jumlah Menu</p>
                <div class="progress">
                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                        style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Kategory</h5>
                <h2>{{$category}}</h2>
                <p>Jumlah Category</p>
                <div class="progress">
                    <div class="progress-bar bg-danger progress-bar-striped" role="progressbar"
                        style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection











