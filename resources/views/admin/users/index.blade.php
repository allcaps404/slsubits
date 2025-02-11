@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h5 mb-2 text-gray-800">User  Management</h1> <!-- Changed h3 to h5 for smaller text -->

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('usersmanagement.create') }}" class="btn btn-primary btn-sm">Create New User</a> <!-- Made button smaller -->
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="small">Email</th> <!-- Added small class -->
                            <th class="small">First Name</th>
                            <th class="small">Last Name</th>
                            <th class="small">Middle Name</th>
                            <th class="small">Date of Birth</th>
                            <th class="small">Role</th>
                            <th class="small">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr data-toggle="collapse" data-target="#userInfo{{ $user->id }}" class="accordion-toggle">
                                <td class="small">{{ $user->email }}</td> <!-- Added small class -->
                                <td class="small">{{ $user->firstname }}</td>
                                <td class="small">{{ $user->lastname }}</td>
                                <td class="small">{{ $user->middlename ?? 'N/A' }}</td>
                                <td class="small">{{ \Carbon\Carbon::parse($user->dateofbirth)->format('F j, Y') }}</td>
                                <td class="small"><span class="badge badge-info">{{ $user->role->role_name }}</span></td>
                                <td>
                                    <a href="{{ route('usersmanagement.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('usersmanagement.destroy', $user->id) }}" method="POST" style="display:inline;">
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
                                        <h6 class="small"><strong>User Information</strong></h6> <!-- Added small class -->
                                        <p class="small"><strong>Course:</strong> {{ $user->OtherDetail->course ?? 'N/A' }}</p>
                                        <p class="small"><strong>Year:</strong> {{ $user->OtherDetail->year ?? 'N/A' }}</p>
                                        <p class="small"><strong>Section:</strong> {{ $user->OtherDetail->section ?? 'N/A' }}</p>
                                        <p class="small"><strong>Semester:</strong> {{ $user->OtherDetail->semester ?? 'N/A' }}</p>
                                        <p class="small"><strong>Academic Year:</strong> {{ $user->OtherDetail->academic_year ?? 'N/A' }}</p>
                                        <p class="small"><strong>Birthplace:</strong> {{ $user->OtherDetail->birthplace ?? 'N/A' }}</p>
                                        <p class="small"><strong>Address:</strong> {{ $user->OtherDetail->address ?? 'N/A' }}</p>
                                        <p class="small"><strong>Photo:</strong>
                                            @if(isset($user->OtherDetail->photo) && !empty($user->OtherDetail->photo))
                                                <img alt="Profile picture of the user" 
                                                     class="w-24 h-24 rounded-full" 
                                                     height="100" 
                                                     src="data:image/jpeg;base64,{{ $user->OtherDetail->photo }}" 
                                                     width="100" />
                                            @else
                                                <img id="previewImage" 
                                                     height="100"
                                                     width="100"
                                                     src="https://storage.googleapis.com/a1aa/image/-sIyLA5A4mz6xqurmkfc_ic3NQ0nQ6u4WJJZtIN-zJo.jpg" 
                                                     alt="Default profile picture" 
                                                     class="w-24 h-24 rounded-full">
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
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