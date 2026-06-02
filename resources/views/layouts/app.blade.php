<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IP SDM POLRI')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="min-h-screen">
        <nav class="bg-white border-b border-slate-200 sticky top-0 z-40">
            <div class="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                <div>
                    <h1 class="font-bold text-xl text-blue-600">IP SDM POLRI</h1>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->is('dashboard') ? 'text-blue-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('pegawai.index') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->is('pegawai*') ? 'text-blue-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Pegawai
                    </a>

                    <a href="{{ route('pegawai.import.form') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->is('pegawai-import') ? 'text-blue-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Import
                    </a>

                    @auth
                        <div class="h-6 w-px bg-slate-200 mx-2"></div>

                        <span class="text-sm text-slate-600">
                            {{ auth()->user()->name }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded-lg text-sm font-medium bg-red-50 text-red-700 hover:bg-red-100">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-[1600px] mx-auto px-6 py-8">
            @include('components.alert')

            @yield('content')
        </main>
    </div>

</body>
</html>
