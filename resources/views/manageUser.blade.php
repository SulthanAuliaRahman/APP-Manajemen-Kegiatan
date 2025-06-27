@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Manage Users</h1>

        <!-- Button to Create User -->
        <button id="createUserBtn" class="mb-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors">
            Buat User
        </button>

        <!-- User Table -->
        <div class="bg-white text-black rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-full">
                    <thead>
                        <tr class="bg-indigo-200 border-b">
                            <th class="p-4 text-center w-20">PFP</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4 text-center w-32">Role</th>
                            <th class="p-4 text-center w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center">
                                    <div class="flex justify-center">
                                        <img src="{{ asset('icon/graduated.png') }}" alt="PFP" class="w-10 h-10 rounded-full object-cover">
                                    </div>
                                </td>
                                <td class="p-4 font-medium">{{ $user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'dosen') bg-blue-100 text-blue-800
                                        @elseif($user->role === 'himpunan') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <button class="editUserBtn text-indigo-600 hover:text-indigo-800 p-2 rounded-full hover:bg-indigo-50 transition-colors" 
                                            data-user-id="{{ $user->user_id }}" 
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-role="{{ $user->role }}"
                                            title="Edit User">
                                        <ion-icon name="create-outline" class="text-xl"></ion-icon>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="p-4 border-t bg-gray-50">
                    <div class="flex justify-center">
                        {{ $users->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Buat User Baru</h2>
                    <button id="closeCreateModal" class="text-gray-400 hover:text-gray-600 text-2xl">
                        &times;
                    </button>
                </div>
                
                <form id="createUserForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" id="createName" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="createEmail" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <input type="password" name="password" id="createPassword" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                            <select name="role" id="createRole" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Pilih Role</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="himpunan">Himpunan</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelCreateBtn" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
                    <button id="closeEditModal" class="text-gray-400 hover:text-gray-600 text-2xl">
                        &times;
                    </button>
                </div>
                
                <form id="editUserForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="editUserId">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" id="editName" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="editEmail" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="editPassword" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                            <select name="role" id="editRole" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="himpunan">Himpunan</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <button type="button" id="deleteUserBtn" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                            Hapus User
                        </button>
                        <div class="flex space-x-3">
                            <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                <span class="text-gray-700">Loading...</span>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Modal elements
    const createUserModal = document.getElementById('createUserModal');
    const editUserModal = document.getElementById('editUserModal');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    // Forms
    const createUserForm = document.getElementById('createUserForm');
    const editUserForm = document.getElementById('editUserForm');
    
    // Utility functions
    function showLoading() {
        loadingOverlay.classList.remove('hidden');
    }
    
    function hideLoading() {
        loadingOverlay.classList.add('hidden');
    }
    
    function showModal(modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal(modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function showAlert(message, type = 'info') {
        alert(message); // You can replace this with a better notification system
    }
    
    // Create User Modal
    document.getElementById('createUserBtn').addEventListener('click', function() {
        createUserForm.reset();
        showModal(createUserModal);
    });
    
    document.getElementById('closeCreateModal').addEventListener('click', function() {
        hideModal(createUserModal);
    });
    
    document.getElementById('cancelCreateBtn').addEventListener('click', function() {
        hideModal(createUserModal);
    });
    
    // Edit User Modal
    document.querySelectorAll('.editUserBtn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            const userEmail = this.getAttribute('data-user-email');
            const userRole = this.getAttribute('data-user-role');
            
            // Fill form with user data
            document.getElementById('editUserId').value = userId;
            document.getElementById('editName').value = userName;
            document.getElementById('editEmail').value = userEmail;
            document.getElementById('editRole').value = userRole;
            document.getElementById('editPassword').value = '';
            
            showModal(editUserModal);
        });
    });
    
    document.getElementById('closeEditModal').addEventListener('click', function() {
        hideModal(editUserModal);
    });
    
    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        hideModal(editUserModal);
    });
    
    // Create User Form Submit
    createUserForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        showLoading();
        
        fetch('/admin/createUser', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showAlert('User berhasil dibuat!', 'success');
                hideModal(createUserModal);
                location.reload();
            } else {
                showAlert(data.message || 'Terjadi kesalahan saat membuat user', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan pada server', 'error');
        });
    });
    
    // Edit User Form Submit
    editUserForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('editUserId').value;
        const formData = new FormData(this);
        showLoading();
        
        fetch(`/admin/updateUser/${userId}`, {
            method: 'POST', // Use POST with _method field for Laravel
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showAlert('User berhasil diupdate!', 'success');
                hideModal(editUserModal);
                location.reload();
            } else {
                showAlert(data.message || 'Terjadi kesalahan saat mengupdate user', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan pada server', 'error');
        });
    });
    
    // Delete User
    document.getElementById('deleteUserBtn').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')) {
            const userId = document.getElementById('editUserId').value;
            showLoading();
            
            fetch(`/admin/deleteUser/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showAlert('User berhasil dihapus!', 'success');
                    hideModal(editUserModal);
                    location.reload();
                } else {
                    showAlert(data.message || 'Terjadi kesalahan saat menghapus user', 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showAlert('Terjadi kesalahan pada server', 'error');
            });
        }
    });
    
    // Close modal when clicking outside
    createUserModal.addEventListener('click', function(e) {
        if (e.target === this) {
            hideModal(createUserModal);
        }
    });
    
    editUserModal.addEventListener('click', function(e) {
        if (e.target === this) {
            hideModal(editUserModal);
        }
    });
});
</script>
@endpush