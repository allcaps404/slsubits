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
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $yearbook->grad_pic) }}" alt="Graduation Picture" class="img-fluid rounded" style="max-width: 300px;">
                            <p class="mt-3"><strong>Motto:</strong> {{ $yearbook->motto }}</p>
                            <p><strong>Graduation Year:</strong> {{ $yearbook->grad_year }}</p>
                        </div>
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
@endsection
