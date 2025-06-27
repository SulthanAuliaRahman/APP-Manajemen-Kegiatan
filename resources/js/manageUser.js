// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('ManageUser.js loaded successfully!');
    
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Show Create User Modal
    $('#createUserBtn').on('click', function () {
        console.log('Create user button clicked');
        $('#createUserModal').removeClass('hidden');
        $('#createUserForm')[0].reset(); // Reset form
    });

    // Cancel Create User
    $('#cancelCreateBtn').on('click', function () {
        console.log('Cancel create button clicked');
        $('#createUserModal').addClass('hidden');
    });

    // Create User Form Submission
    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();
        console.log('Create user form submitted');
        
        const formData = $(this).serialize();
        console.log('Form data:', formData);

        $.ajax({
            url: '/admin/createUser',
            method: 'POST',
            data: formData,
            success: function (response) {
                console.log('User created successfully:', response);
                if (response.success) {
                    alert(response.message);
                    $('#createUserModal').addClass('hidden');
                    location.reload(); // Reload to refresh user list
                }
            },
            error: function (xhr) {
                console.error('Error creating user:', xhr);
                const errors = xhr.responseJSON?.errors || {};
                let errorMessage = 'Error creating user:\n';
                for (const field in errors) {
                    errorMessage += `- ${errors[field][0]}\n`;
                }
                alert(errorMessage);
            }
        });
    });

    // Show Edit User Modal
    $(document).on('click', '.editUserBtn', function () {
        console.log('Edit user button clicked');
        
        const userId = $(this).data('user-id');
        const userName = $(this).data('user-name');
        const userEmail = $(this).data('user-email');
        const userRole = $(this).data('user-role');

        console.log('User data:', { userId, userName, userEmail, userRole });

        $('#editUserId').val(userId);
        $('#editName').val(userName);
        $('#editEmail').val(userEmail);
        $('#editRole').val(userRole);
        $('#editPassword').val(''); // Clear password field
        $('#editUserModal').removeClass('hidden');
    });

    // Cancel Edit User
    $('#cancelEditBtn').on('click', function () {
        console.log('Cancel edit button clicked');
        $('#editUserModal').addClass('hidden');
    });

    // Edit User Form Submission
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
        console.log('Edit user form submitted');
        
        const userId = $('#editUserId').val();
        const formData = $(this).serialize();
        console.log('Edit form data:', formData);

        $.ajax({
            url: `/admin/updateUser/${userId}`,
            method: 'PUT',
            data: formData,
            success: function (response) {
                console.log('User updated successfully:', response);
                if (response.success) {
                    alert(response.message);
                    $('#editUserModal').addClass('hidden');
                    location.reload(); // Reload to refresh user list
                }
            },
            error: function (xhr) {
                console.error('Error updating user:', xhr);
                const errors = xhr.responseJSON?.errors || {};
                let errorMessage = 'Error updating user:\n';
                for (const field in errors) {
                    errorMessage += `- ${errors[field][0]}\n`;
                }
                alert(errorMessage);
            }
        });
    });

    // Delete User
    $('#deleteUserBtn').on('click', function () {
        console.log('Delete user button clicked');
        
        if (confirm('Are you sure you want to delete this user?')) {
            const userId = $('#editUserId').val();
            console.log('Deleting user with ID:', userId);

            $.ajax({
                url: `/admin/deleteUser/${userId}`,
                method: 'DELETE',
                success: function (response) {
                    console.log('User deleted successfully:', response);
                    if (response.success) {
                        alert(response.message);
                        $('#editUserModal').addClass('hidden');
                        location.reload(); // Reload to refresh user list
                    }
                },
                error: function (xhr) {
                    console.error('Error deleting user:', xhr);
                    alert('Error deleting user: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    });

    // Close modal when clicking outside
    $(document).on('click', '.modal-overlay', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
});