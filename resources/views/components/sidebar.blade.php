<div class="w-64 bg-white text-black p-4 rounded-r-lg shadow-lg flex flex-col justify-between h-full">
    <div>
        
        <div class="mb-6">
            <h2 class="rounded-t-lg w-full h-full bg-indigo-600 text-2xl font-bold">{{ ucfirst($user['role']) }}</h2>
            <h2 class="rounded-b-lg w-full h-full bg-indigo-600 text-2xl font-bold">Page Kegiatan</h2>
        </div>

        <nav class="space-y-2">
            @foreach($menuItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs($item['route']) ? 'bg-indigo-100 text-indigo-700 border-r-4 border-indigo-700' : 'text-gray-700' }}">

                    <span class="text-lg">
                        @switch($item['icon'])
                            @case('calendar')
                                📅
                                @break
                            @case('users')
                                👥
                                @break
                            @case('settings')
                                ⚙️
                                @break
                            @case('user-cog')
                                👤⚙️
                                @break
                            @case('check-circle')
                                ✅
                                @break
                            @case('edit')
                                ✏️
                                @break
                            @case('file-text')
                                📄
                                @break
                            @case('plus-circle')
                                ➕
                                @break
                            @case('list')
                                📋
                                @break
                            @default
                                📌
                        @endswitch
                    </span>
                    <span class="font-medium">{{ $item['title'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- User Info & Logout --}}
    <div class="border-t pt-4">
        <div class="mb-3 text-sm">
            <div class="font-semibold">{{ $user['name'] }}</div>
            <div class="text-gray-500">{{ $user['email'] }}</div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Log out
            </button>
        </form>
    </div>
</div>