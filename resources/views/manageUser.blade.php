@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Manage Users</h1>

        <!-- Button to Create User -->
        <button id="createUserBtn" class="mb-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Buat User
        </button>

        <!-- User Table -->
        <div class="bg-white text-black p-4 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">PFP</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Role</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="p-2">
                                <img src="{{ asset('icon/graduated.png') }}" alt="PFP" class="w-10 h-10 rounded-full">
                            </td>
                            <td class="p-2">{{ $user->name }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2">{{ $user->role }}</td>
                            <td class="p-2">
                                <button class="editUserBtn text-indigo-600 hover:text-indigo-800 mr-2" data-user-id="{{ $user->user_id }}">
                                    <ion-icon name="create"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Create User Popup -->
        <div id="createUserPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-2xl font-bold mb-4">Buat User Baru</h2>
                <form id="createUserForm" method="POST" action="{{ route('admin.createUser') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 p-2 w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 p-2 w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 p-2 w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 p-2 w-full border rounded" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="himpunan">Himpunan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeCreatePopup" class="mr-2 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit User Popup -->
        <div id="editUserPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-2xl font-bold mb-4">Edit User</h2>
                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="editUserId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="editName" class="mt-1 p-2 w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="editEmail" class="mt-1 p-2 w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="editPassword" class="mt-1 p-2 w-full border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="editRole" class="mt-1 p-2 w-full border rounded" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="himpunan">Himpunan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeEditPopup" class="mr-2 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="mr-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            Simpan
                        </button>
                        <button type="button" id="deleteUserBtn" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Ensure CSRF token is available
            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            document.getElementById('createUserBtn').addEventListener('click', function() {
                document.getElementById('createUserPopup').classList.remove('hidden');
            });

            document.getElementById('closeCreatePopup').addEventListener('click', function() {
                document.getElementById('createUserPopup').classList.add('hidden');
                document.getElementById('createUserForm').reset();
            });

            document.querySelectorAll('.editUserBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    fetch(`/admin/getUser/${userId}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editUserId').value = data.user_id;
                        document.getElementById('editName').value = data.name;
                        document.getElementById('editEmail').value = data.email;
                        document.getElementById('editRole').value = data.role;
                        document.getElementById('editUserPopup').classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

            document.getElementById('closeEditPopup').addEventListener('click', function() {
                document.getElementById('editUserPopup').classList.add('hidden');
                document.getElementById('editUserForm').reset();
            });

            document.getElementById('deleteUserBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    const userId = document.getElementById('editUserId').value;
                    fetch(`/admin/deleteUser/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('editUserPopup').classList.add('hidden');
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });

            document.getElementById('createUserForm').addEventListener('submit', function(e) {
                e.preventDefault();
                fetch('/admin/createUser', {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('createUserPopup').classList.add('hidden');
                        document.getElementById('createUserForm').reset();
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            document.getElementById('editUserForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const userId = document.getElementById('editUserId').value;
                fetch(`/admin/updateUser/${userId}`, {
                    method: 'PUT',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('editUserPopup').classList.add('hidden');
                        document.getElementById('editUserForm').reset();
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        </script>
    @endpush
@endsection