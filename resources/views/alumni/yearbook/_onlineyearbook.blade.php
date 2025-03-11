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
    <div class="row" style="ba7ckground-image: url('data:image/jpeg;base64,{{ $yearbook->grad_pic }}');">
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
                        <div class="card-img-wrapper d-flex justify-content-center">
                            <img src="{{ $alumniUser->yearbook->grad_pic ?? asset('default-profile.png') }}" 
                                class="alumni-photo img-thumbnail" 
                                alt="Alumni Photo">
                        </div>
                        <!-- Card Body with Alumni Info -->
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <h5 class="card-title font-weight-bold text-primary" style="font-size: 18px;">
                                {{ $alumniUser->firstname ?? 'No First Name' }}
                                {{ $alumniUser->middlename ?? '' }}
                                {{ $alumniUser->lastname ?? 'No Last Name' }}
                            </h5>

                            <p class="card-text" style="font-size: 14px;"><em>"{{ $alumniUser->yearbook->motto ?? 'No Motto Provided' }}"</em></p>

                            <p class="card-text" style="font-size: 14px;">
                                <strong>Graduation Year:</strong> {{ $alumniUser->yearbook->grad_year ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- @section('styles')
<style>
    .card-img-wrapper {
        width: 100%;
        height: 200px; /* Adjust height as needed */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        background-color: #f8f9fa;
        position: relative;
    }

    .alumni-photo {
        width: 50%; /* Make the photo fill the width of the container */
        height: 50%;
        object-fit: cover; /* Ensures the image covers the area without distortion */
        object-position: center;
    }

    .card-img-wrapper:hover .alumni-photo {
        transform: scale(1.05);
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
</style> -->
@endsection
