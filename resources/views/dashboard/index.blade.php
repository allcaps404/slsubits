@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<div class="row">

    <!-- Users Card -->
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">  <!-- Centering the header -->
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body text-center">  <!-- Centering the body -->
                <h5 class="card-title">{{ $userCount }}</h5>
            </div>
        </div>
    </div>

    <!-- Students Card -->
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">  <!-- Centering the header -->
                <h6 class="m-0 font-weight-bold text-primary">Students</h6>
            </div>
            <div class="card-body text-center">  <!-- Centering the body -->
                <p>Manage student information and records.</p>
                <a href="#" class="btn btn-primary btn-block">Go to Students</a>
            </div>
        </div>
    </div>

    <!-- Blank Card -->
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">  <!-- Centering the header -->
                <h6 class="m-0 font-weight-bold text-primary">Blank Card</h6>
            </div>
            <div class="card-body text-center">  <!-- Centering the body -->
                <p>This is a blank card, which you can customize further.</p>
            </div>
        </div>
    </div>

    <!-- 4th Blank Card -->
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">  <!-- Centering the header -->
                <h6 class="m-0 font-weight-bold text-primary">4th Blank Card</h6>
            </div>
            <div class="card-body text-center">  <!-- Centering the body -->
                <p>This is another blank card, customizable as needed.</p>
            </div>
        </div>
    </div>

</div>
@endsection
