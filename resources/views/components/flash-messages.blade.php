@if (session('success'))
    <div class="mx-4 mt-4 rounded-xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200 shadow-sm flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="mx-4 mt-4 rounded-xl bg-rose-50 p-4 text-sm font-medium text-rose-800 border border-rose-200 shadow-sm flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 font-bold">&times;</button>
    </div>
@endif

@if (session('status'))
    <div class="mx-4 mt-4 rounded-xl bg-sky-50 p-4 text-sm font-medium text-sky-800 border border-sky-200 shadow-sm flex items-center justify-between">
        <span>{{ session('status') }}</span>
        <button type="button" onclick="this.parentElement.remove()" class="text-sky-600 hover:text-sky-800 font-bold">&times;</button>
    </div>
@endif