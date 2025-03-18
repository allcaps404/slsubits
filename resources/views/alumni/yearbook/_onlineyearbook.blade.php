@php
    use App\Models\YearBook;
    use App\Models\User;

    $yearbook = YearBook::find($yearbook_id);
    $year_grad = $yearbook ? $yearbook->grad_year : null;

    $alumniUsers = User::whereIn('role_id', [5, 6])
        ->whereHas('yearbook', function ($query) use ($year_grad) {
            $query->where('grad_year', $year_grad);
        })
        ->orderBy('lastname')
        ->orderBy('firstname')
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
                                alt="Alumni Photo"
                                onclick="showImage('{{ $alumniUser->yearbook->grad_pic ?? asset('default-profile.png') }}')">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                {{ $alumniUser->lastname ?? 'No Last Name' }}, 
                                {{ $alumniUser->firstname ?? 'No First Name' }} 
                                {{ $alumniUser->middlename ? ' ' . $alumniUser->middlename : '' }}
                            </h5>
                            <p class="card-text"><em>"{{ $alumniUser->yearbook->motto ?? 'No Motto Provided' }}"</em></p>
                            <p class="card-text"><strong>Grad Date:</strong> {{ $alumniUser->yearbook->grad_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div id="imageOverlay" class="image-overlay" onclick="hideImage()">
    <img id="overlayImage" class="overlay-image" src="" alt="Zoomed Alumni Photo">
</div>
@endsection

@section('styles')
<style>
    .container-fluid {
        max-width: 95%;
    }

    .card {
        min-width: 150px; 
        max-width: 100px;
        min-height: 300px;
        margin: 10px;
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
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .alumni-photo:hover {
        transform: scale(1.05);
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
    }

    h5.card-title {
        font-size: 15px;
        color: black;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
    }

    p.card-text {
        font-size: 15px;
        color:rgb(5, 5, 5);
        margin-bottom: 0.5rem;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .row {
        gap: 30px;
    }

    /* Image Zoom Overlay */
    .image-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }

    .overlay-image {
        max-width: 90%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
    }

    .image-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    
</style>
@endsection

@section('scripts')
<script>
    function showImage(src) {
        const overlay = document.getElementById("imageOverlay");
        const overlayImage = document.getElementById("overlayImage");

        overlayImage.src = src;
        overlay.classList.add("active");
    }

    function hideImage() {
        document.getElementById("imageOverlay").classList.remove("active");
    }
</script>
@endsection
