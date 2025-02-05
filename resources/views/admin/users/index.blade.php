@extends('layouts.admin')

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
                <table class="table table-hover table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Date of Birth</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr data-toggle="collapse" data-target="#userInfo{{ $user->id }}" class="accordion-toggle">
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->middlename ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->dateofbirth)->format('F j, Y') }}</td>
                                <td><span class="badge badge-info">{{ $user->role->role_name }}</span></td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="userInfo{{ $user->id }}">
                                <td colspan="7">
                                    <div class="p-3">
                                        <h6><strong>User Information</strong></h6>
                                        <p><strong>Course:</strong> {{ $user->OtherDetail->course ?? 'N/A' }}</p>
                                        <p><strong>Year:</strong> {{ $user->OtherDetail->year ?? 'N/A' }}</p>
                                        <p><strong>Section:</strong> {{ $user->OtherDetail->section ?? 'N/A' }}</p>
                                        <p><strong>Semester:</strong> {{ $user->OtherDetail->semester ?? 'N/A' }}</p>
                                        <p><strong>Academic Year:</strong> {{ $user->OtherDetail->academic_year ?? 'N/A' }}</p>
                                        <p><strong>Birthdate:</strong> {{ $user->OtherDetail->birthdate ?? 'N/A' }}</p>
                                        <p><strong>Birthplace:</strong> {{ $user->OtherDetail->birthplace ?? 'N/A' }}</p>
                                        <p><strong>Address:</strong> {{ $user->OtherDetail->address ?? 'N/A' }}</p>
                                        <p><strong>Photo:</strong> 
                                            @if($user->OtherDetail && $user->OtherDetail->photo)
                                                <img src="{{ asset('storage/' . $user->OtherDetail->photo) }}" alt="Photo" class="img-thumbnail" width="100">
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
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
        $('#dataTable').DataTable({
            "order": [],
            "paging": true,
            "info": false,
            "columnDefs": [
                { "orderable": false, "targets": [5, 6] }
            ]
        });

        // Add a toggle icon to show user information
        $('.accordion-toggle').on('click', function() {
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
</script>
@endsection
