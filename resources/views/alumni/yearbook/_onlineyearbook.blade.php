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

<div class="container mt-5">
    <!-- <div class="row" style="background-image: url('{{ asset('images/background.jpg') }}');"> -->
    <div class="row" style="background-image: url('data:image/jpeg;base64,{{ $yearbook->grad_pic }}');">
        @if($alumniUsers->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No alumni found for this graduation year.
                </div>
            </div>
        @else
            @foreach ($alumniUsers as $alumniUser)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-img-wrapper">
                            <img src="{{ $alumniUser->yearbook->grad_pic ?? asset('default-profile.png') }}" 
                                class="alumni-photo" 
                                alt="Alumni Photo">
                        </div>

                        <!-- Card Body with Alumni Info -->
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $alumniUser->firstname ?? 'No First Name' }}
                                {{ $alumniUser->middlename ?? '' }}
                                {{ $alumniUser->lastname ?? 'No Last Name' }}
                                <!-- <small class="text-muted">
                                    ({{ $alumniUser->role_id == 5 ? 'Alumnus' : 'Alumna' }})
                                </small> -->
                            </h5>
                            <p class="card-text"><em>"{{ $alumniUser->yearbook->motto ?? 'No Motto Provided' }}"</em></p>
                            <p class="card-text"><strong>Graduation Year:</strong> {{ $alumniUser->yearbook->grad_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@section('styles')
<style>
    .card-img-wrapper {
    width: 100%;
    height: 250px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    background-color: #f8f9fa;
    }

    .alumni-photo {
        width: 100%;
        height: 100%;
        object-fit: cover; 
    }

    .card-img-wrapper:hover .alumni-photo {
        transform: scale(1.1); 
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        height: 100%; 
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1.25rem;
        min-height: 150px;
    }

    h5.card-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    p.card-text {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .col-md-4 {
        display: flex;
        align-items: stretch;
    }

    .card-container {
        width: 100%;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
