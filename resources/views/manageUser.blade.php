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

        <!-- Create User Modal -->
        <div id="createUserModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-black">
                <h2 class="text-2xl font-bold mb-4">Create User</h2>
                <form id="createUserForm">
                    <div class="mb-4">
                        <label for="createName" class="block text-sm font-medium">Name</label>
                        <input type="text" id="createName" name="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="createEmail" class="block text-sm font-medium">Email</label>
                        <input type="email" id="createEmail" name="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="createPassword" class="block text-sm font-medium">Password</label>
                        <input type="password" id="createPassword" name="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="createRole" class="block text-sm font-medium">Role</label>
                        <select id="createRole" name="role" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="himpunan">Himpunan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelCreateBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-black">
                <h2 class="text-2xl font-bold mb-4">Edit User</h2>
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium">Name</label>
                        <input type="text" id="editName" name="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="editEmail" class="block text-sm font-medium">Email</label>
                        <input type="email" id="editEmail" name="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="editPassword" class="block text-sm font-medium">Password (leave blank to keep unchanged)</label>
                        <input type="password" id="editPassword" name="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="editRole" class="block text-sm font-medium">Role</label>
                        <select id="editRole" name="role" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="himpunan">Himpunan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelEditBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="button" id="deleteUserBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection