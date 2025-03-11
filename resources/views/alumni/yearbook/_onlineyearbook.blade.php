@section('content')
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

<div class="container-fluid mt-5 px-md-4"> <!-- Adjust padding to balance spacing -->
    <div class="row justify-content-center gx-2"> <!-- Reduced gaps -->
        @if($alumniUsers->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No alumni found for this graduation year.
                </div>
            </div>
        @else
            @foreach ($alumniUsers as $alumniUser)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 d-flex justify-content-center"> <!-- Ensures 5 per row -->
                    <div class="card shadow-sm">
                        <div class="card-img-wrapper">
                            <img src="{{ $alumniUser->yearbook->grad_pic ?? asset('default-profile.png') }}" 
                                class="alumni-photo img-thumbnail" 
                                alt="Alumni Photo">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">{{ $alumniUser->firstname ?? 'No First Name' }} {{ $alumniUser->middlename ?? '' }} {{ $alumniUser->lastname ?? 'No Last Name' }}</h5>
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
    .container-fluid {
        max-width: 95%;
    }

    .card {
        width: 100%;
        min-height: 200px;
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .card-img-wrapper {
        width: 100%;
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        background-color: #f8f9fa;
        padding: 10px;
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
        padding: 1.5rem;
    }

    h5.card-title {
        font-size: 1.2rem;
    }

    p.card-text {
        font-size: 1rem;
        color: #6c757d;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
</style>
@endsection
