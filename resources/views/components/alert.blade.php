@if (session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg">
        {{ session('warning') }}
    </div>
@endif
