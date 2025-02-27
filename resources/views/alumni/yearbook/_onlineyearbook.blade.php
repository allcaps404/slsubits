
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
    <div class="row">
        @if($alumniUsers->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No alumni found for this graduation year.
                </div>
            </div>
        @else
            @foreach ($alumniUsers as $alumnus)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <!-- Photo Wrapper (keeps size consistent) -->
                        <div class="card-img-wrapper">
                            <img src="{{ $alumnus->yearbook->grad_pic ?? asset('default-profile.png') }}" 
                                 class="alumni-photo" 
                                 alt="Alumni Photo">
                        </div>

                        <!-- Card Body with Alumni Info -->
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $alumnus->firstname ?? 'No First Name' }}
                                {{ $alumnus->middlename ?? '' }}
                                {{ $alumnus->lastname ?? 'No Last Name' }}
                            </h5>
                            <p class="card-text"><em>"{{ $alumnus->yearbook->motto ?? 'No Motto Provided' }}"</em></p>
                            <p class="card-text"><strong>Graduation Year:</strong> {{ $alumnus->yearbook->grad_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@section('styles')
<style>
    .alumni-photo {
        width: 100%;
        height: 250px; /* Fixed height */
        object-fit: cover; /* Crop to cover the area */
        border-radius: 0.75rem 0.75rem 0 0; /* Rounded top corners only */
        transition: transform 0.3s ease;
    }

    .card-img-wrapper {
        width: 100%;
        height: 250px; /* Match height */
        overflow: hidden;
        border-radius: 0.75rem 0.75rem 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa; /* Optional fallback */
    }

    .card-img-wrapper:hover .alumni-photo {
        transform: scale(1.1); /* Optional zoom effect */
    }

    /* Card styling */
    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden; /* Ensures image rounding works */
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.25rem;
    }

    h5.card-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    p.card-text {
        font-size: 0.95rem;
        color: #6c757d;
    }
</style>
@endsection
