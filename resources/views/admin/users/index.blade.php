@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h5 mb-2 text-gray-800">User  Management</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('usersmanagement.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3 mb-2">
                <input type="text" name="firstName" class="form-control" placeholder="Filter by First Name" value="{{ request('firstName') }}">
            </div>
            <div class="col-md-3 mb-2">
                <input type="text" name="lastName" class="form-control" placeholder="Filter by Last Name" value="{{ request('lastName') }}">
            </div>
            <div class="col-md-3 mb-2">
                <select name="academicYear" class="form-control">
                    <option value="">Filter by Academic Year</option>
                    @for($year = 2021; $year <= 2030; $year++)
                        <option value="{{ $year }}" {{ request('academicYear') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-control" name="role" id="role" required>
                    <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>Filter by Role</option>
                    @php
                        $roles = \App\Models\Role::all();
                    @endphp
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="year" class="form-control">
                    <option value="">Filter by Year</option>
                    <option value="1st Year" {{ request('year') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                    <option value="2nd Year" {{ request('year') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3rd Year" {{ request('year') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4th Year" {{ request('year') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="section" class="form-control">
                    <option value="">Filter by Section</option>
                    <option value="A" {{ request('section') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ request('section') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ request('section') == 'C' ? 'selected' : '' }}>C</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="semester" class="form-control">
                    <option value="">Filter by Semester</option>
                    <option value="1st Semester" {{ request('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd Semester" {{ request('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('usersmanagement.create') }}" class="btn btn-primary btn-sm">Create New User</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="small">Email</th>
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
                            <td class="small">{{ $user->email }}</td>
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
                                    <h6 class="small"><strong>User Information</strong></h6>
                                    <p class="small"><strong>Course:</strong> {{ $user->OtherDetail->course ?? 'N/A' }}</p>
                                    <p class="small"><strong>Year:</strong> {{ $user->OtherDetail->year ?? 'N/A' }}</p>
                                    <p class="small"><strong>Section:</strong> {{ $user->OtherDetail->section ?? 'N/A' }}</p>
                                    <p class="small"><strong>Gender:</strong> {{ $user->OtherDetail-> gender ?? 'N/A' }}</p>
                                    <p class="small"><strong>Semester:</strong> {{ $user->OtherDetail->semester ?? 'N/A' }}</p>
                                    <p class="small"><strong>Academic Year:</strong> {{ $user->OtherDetail->academic_year ?? 'N/A' }}</p>
                                    <p class="small"><strong>Birthplace:</strong> {{ $user->OtherDetail->birthplace ?? 'N/A' }}</p>
                                    <p class="small"><strong>Address:</strong> {{ $user->OtherDetail->address ?? 'N/A' }}</p>
                                    <p class="small"><strong>Photo:</strong>
                                        @if(isset($user->OtherDetail->photo) && !empty($user->OtherDetail->photo))
                                            <img alt="Profile picture of the user" 
                                                 class="w-24 h-24 rounded-full" 
                                                 height="100" 
                                                 src="{{ $user->OtherDetail->photo }}" 
                                                 width="100" />
                                        @else
                                            <img id="previewImage" 
                                                 height="100"
                                                 width="100"
                                                 src="https://www.gravatar.com/avatar/?d=mp" 
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

        $('.accordion-toggle').on('click', function() {
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });

    document.getElementById('photoUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                const base64String = reader.result.split(',')[1];
                document.getElementById('photoBase64').value = base64String;
                document.getElementById('previewImage').src = reader.result;
                document.getElementById('previewImage').style.display = 'block';
            };
        }
    });


    $('#applyFilters').on('click', function() {
            const role = $('#filterRole').val().toLowerCase();
            const year = $('#filterYear').val().toLowerCase();
            const section = $('#filterSection').val().toLowerCase();

            table.rows().every(function() {
                const row = $(this.node());
                const rowRole = row.find('.role').text().toLowerCase();
                const rowYear = row.find('td:nth-child(4)').text().toLowerCase();
                const rowSection = row.find('td:nth-child(5)').text().toLowerCase();

                if (
                    (role === "" || rowRole.includes(role)) &&
                    (year === "" || rowYear.includes(year)) &&
                    (section === "" || rowSection.includes(section))
                ) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
</script>
@endsection