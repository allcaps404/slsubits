@extends('layouts.alumni.index')

@section('content')
<div class="container mt-5 p-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
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
                            <div id="imagePreviewContainer" class="text-center mt-3"></div>
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
    const gradPicInput = document.getElementById('grad_pic');

    const imagePreviewContainer = document.getElementById('imagePreviewContainer');

    gradPicInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onloadend = function() {
                const base64Image = reader.result;

                console.log(base64Image);

                const preview = document.createElement('img');
                preview.src = base64Image;
                preview.style.maxWidth = '300px';

                imagePreviewContainer.innerHTML = ''; 
                imagePreviewContainer.appendChild(preview);

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

            reader.readAsDataURL(file);
        }
    });
</script>
@endsection