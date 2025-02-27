@extends('layouts.alumni.index')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Yearbook Information</h3>
                </div>
                <div class="card-body">
                    @if(!empty($message))
                        <div class="alert alert-warning">
                            {{ $message }}
                        </div>
                    @endif

                    @if($yearbook)
                       @include('alumni.yearbook._onlineyearbook')
                    @else
                        <form id="yearbookForm" action="{{ route('yearbook.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="grad_pic">Graduation Picture</label>
                                <input type="file" name="grad_pic" class="form-control" id="grad_pic" required>
                            </div>

                            <div class="form-group">
                                <label for="motto">Motto</label>
                                <textarea name="motto" value="{{ old('motto', auth()->user()->motto) }}" class="form-control" id="motto" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="grad_year">Graduation Year</label>
                                <input type="date" name="grad_year" value="{{ old('grad_year', auth()->user()->grad_year) }}" class="form-control" id="grad_year" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Submit Yearbook</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Select the file input element
    const gradPicInput = document.getElementById('grad_pic');
    
    // Attach event listener to handle the image file selection
    gradPicInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        // Check if a file is selected
        if (file) {
            const reader = new FileReader();

            // Once the file is read, convert it to base64
            reader.onloadend = function() {
                const base64Image = reader.result; // This contains the base64 string

                // You can now log the base64 string or send it to the server with the form
                console.log(base64Image);

                // Optionally, you can preview the image before submitting
                const preview = document.createElement('img');
                preview.src = base64Image;
                preview.style.maxWidth = '300px';
                document.body.appendChild(preview);

                // You can store the base64 string in a hidden input if you want to send it to the server
                // Example:
                let hiddenBase64Input = document.getElementById('hidden_base64');
                if (!hiddenBase64Input) {
                    hiddenBase64Input = document.createElement('input');
                    hiddenBase64Input.type = 'hidden';
                    hiddenBase64Input.id = 'hidden_base64';
                    hiddenBase64Input.name = 'grad_pic_base64';
                    document.getElementById('yearbookForm').appendChild(hiddenBase64Input);
                }
                hiddenBase64Input.value = base64Image;
            };

            // Read the image as base64
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
