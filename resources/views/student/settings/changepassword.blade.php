@extends('layouts.student.index')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">⚙️ Settings</h2>
    
    <div class="bg-gray-100 p-4 rounded-lg">
        <h3 class="text-lg font-semibold">🔑 Change Password</h3>
        <form id="changePasswordForm">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">New Password</label>
                <input type="password" name="new_password" id="new_password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Change Password
            </button>
        </form>
    </div>
</div>

<!-- Include jQuery & SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $("#changePasswordForm").submit(function (e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('settings.change-password.update') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.success,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).flat().join("<br>");
                        
                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            html: errorMessages,
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
