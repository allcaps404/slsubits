@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="card p-4 shadow" style="width: 450px;">
            <h2 class="text-center">Edit Role</h2>
            <form action="{{ route('roles.update', $role->id) }}" id="roleForm" method="POST" class="mt-3">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="role_name" class="form-label">Role Name</label>
                    <input type="text" id="role_name" name="role_name" class="form-control" 
                           value="{{ $role->role_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL (optional)</label>
                    <input type="text" id="url" name="url" class="form-control" 
                           value="{{ $role->url }}">
                </div>
                <button type="submit" class="btn btn-success w-100">Update Role</button>
            </form>
            <div class="text-end mt-3">
                <a href="{{ route('roles.index') }}" class="btn btn-link">Back to Roles</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('roleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    });

    unction deleteRole(roleId) {
        fetch(`/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is sent for security
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = "/roles";
            } else {
                return response.json().then(data => {
                    if (data.errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An unexpected error occurred.'
                        });
                    }
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An unexpected error occurred.'
            });
        });
    }
    </script>
@endsection
