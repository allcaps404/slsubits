@extends('layouts.alumni.index')

@section('content')
<div class="container mt-4 p-4">
    <!-- Top Section: Add Button on Left, Title Centered -->
    <!-- <h3 class="text-center flex-grow-1">WORK EXPERIENCE</h3> -->

    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('work_experiences.create') }}" class="btn btn-primary d-flex align-items-center px-4">
        <i class="fas fa-plus-circle me-2 "></i> &nbsp; Add Work Experience
    </a>
</div>


    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10 col-sm-12">
            <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Work Experience List -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10 col-sm-12">
            @if($workExperiences->isEmpty())
                <div class="card shadow-sm p-4 text-center bg-light">
                    <h5 class="text-muted">No work experiences found.</h5>
                </div>
            @else
                @foreach($workExperiences as $workExperience)
                    <div class="card shadow-sm mb-3 border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <!-- Left Side: Work Experience Details -->
                            <div>
                                <h5 class="mb-1 text-primary">{{ $workExperience->company_name }}</h5>
                                <p class="mb-1"><strong>Job Position:</strong> {{ $workExperience->position }}</p>
                                <p class="mb-1"><strong>Company Contact Number:</strong> {{ $workExperience->contact_number }}</p>
                                <p class="mb-1"><strong>Start Date:</strong> {{ $workExperience->start_date }}</p>
                                <p class="mb-1">
                                    <strong>End Date:</strong> 
                                    @if($workExperience->currently_working)
                                        <span class="badge bg-success">Present</span>
                                    @else
                                        {{ $workExperience->end_date }}
                                    @endif
                                </p>
                                <p class="mb-1">
                                <p style="display" id="description-{{ $workExperience->id }}"> 
                                    <strong>Description:</strong> 
                                    {{ Str::limit($workExperience->description, 100) }} 
                                    @if(strlen($workExperience->description) > 100)
                                        <a href="#" class="see-more" data-id="{{ $workExperience->id }}">See More</a>
                                    @endif
                                </p>
                                <p id="full-description-{{ $workExperience->id }}" style="display: none;">
                                    {{ $workExperience->description }} 
                                    <a href="#" class="see-less" data-id="{{ $workExperience->id }}">See Less</a>
                                </p>
                                </p>

                                <p class="mb-1">
                                    <strong>Type of Organition:</strong> 
                                    <span class="badge {{ $workExperience->respondent_affiliation == 'Government' ? 'bg-info' : 'bg-secondary' }}">
                                        {{ $workExperience->respondent_affiliation }}
                                    </span>
                                </p>
                            </div>

                            <!-- Right Side: Edit & Delete Buttons -->
                            <div>
                                <a href="{{ route('work_experiences.edit', $workExperience->id) }}" class="btn btn-warning btn-sm me-2">✏️ Edit</a>
                                
                                <form action="{{ route('work_experiences.destroy', $workExperience->id) }}" method="POST" class="d-inline delete-btn">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".see-more").forEach(function (btn) {
        btn.addEventListener("click", function (event) {
            event.preventDefault();
            let id = this.getAttribute("data-id");
            document.getElementById("description-" + id).style.display = "none";
            document.getElementById("full-description-" + id).style.display = "block";
        });
    });

    document.querySelectorAll(".see-less").forEach(function (btn) {
        btn.addEventListener("click", function (event) {
            event.preventDefault();
            let id = this.getAttribute("data-id");
            document.getElementById("description-" + id).style.display = "block";
            document.getElementById("full-description-" + id).style.display = "none";
        });
    });
});

 // SweetAlert Delete Confirmation
 document.querySelectorAll(".delete-btn").forEach(function (button) {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                let form = this.closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
</script>

@endsection