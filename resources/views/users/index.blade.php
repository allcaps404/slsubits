@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <!-- User Details Row -->
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role->role_name }}</td>
                            <td>**********</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- User Information Row -->
                        <tr>
                            <td colspan="4">
                                <strong>Course:</strong> {{ $user->information->course ?? 'N/A' }}<br>
                                <strong>Year:</strong> {{ $user->information->year ?? 'N/A' }}<br>
                                <strong>Section:</strong> {{ $user->information->section ?? 'N/A' }}<br>
                                <strong>Semester:</strong> {{ $user->information->semester ?? 'N/A' }}<br>
                                <strong>Academic Year:</strong> {{ $user->information->academic_year ?? 'N/A' }}<br>
                                <strong>Birthdate:</strong> {{ $user->information->birthdate ?? 'N/A' }}<br>
                                <strong>Birthplace:</strong> {{ $user->information->birthplace ?? 'N/A' }}<br>
                                <strong>Address:</strong> {{ $user->information->address ?? 'N/A' }}<br>
                                <strong>Photo:</strong> 
                                @if($user->information && $user->information->photo)
                                    <img src="{{ asset('storage/' . $user->information->photo) }}" alt="Photo" class="img-thumbnail" width="50">
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection
