
@php
    use App\Models\YearBook;
    use App\Models\User;
    
    $yearbook = YearBook::find($yearbook_id);
    $year_grad = $yearbook ? $yearbook->grad_year : null;
    
    $alumniUsers = User::whereIn('role_id', [5, 6])
        ->whereHas('yearbook', function ($query) use ($year_grad) {
            $query->where('grad_year', $year_grad);
        })
        ->get();
@endphp

@section('content')
<div class="container-fluid mt-5 px-md-4">
    <div class="row d-flex flex-wrap justify-content-center gx-2 gy-3">
        @if($alumniUsers->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No alumni found for this graduation year.
                </div>
            </div>
        @else
            @foreach ($alumniUsers as $alumniUser)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-4 d-flex justify-content-center">
                    <div class="card shadow-sm">
                        <div class="card-img-wrapper">
                            <img src="{{ $alumniUser->yearbook->grad_pic ?? asset('default-profile.png') }}" 
                                class="alumni-photo" 
                                alt="Alumni Photo">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $alumniUser->firstname ?? 'No First Name' }} {{ $alumniUser->middlename ?? '' }} {{ $alumniUser->lastname ?? 'No Last Name' }}</h5>
                            <p class="card-text"><em>"{{ $alumniUser->yearbook->motto ?? 'No Motto Provided' }}"</em></p>
                            <p class="card-text"><strong>Grad Year:</strong> {{ $alumniUser->yearbook->grad_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    /* body {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSB5PvDSrKPCHmWV_ooFo8wve3Wam4xRbwfVQ&s');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    } */

    .container-fluid {
        max-width: 95%;
    }

    .card {
        min-width: 150px; 
        max-width: 200px;
        min-height: 380px;
        margin: 10px;
        border: 2px solid black !important;
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background-color: royalblue;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.2);
    }

    .card-img-wrapper {
        width: 100%;
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        padding: 10px;   
    }

    .card img {
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        background-color: #3b82f6;
    }

    .alumni-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 10px;
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
    }

    h5.card-title {
        font-size: 1rem;
        color: black;
        font-weight: bold;
    }

    p.card-text {
        font-size: 1rem;
        color:rgb(5, 5, 5);
        margin-bottom: 0.5rem;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .row {
        gap: 30px;
    }
</style>
@endsection
