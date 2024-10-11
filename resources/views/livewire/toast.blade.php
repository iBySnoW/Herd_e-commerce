<div
    x-data="{ show: @entangle('show') }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    @show-toast.window="show = true; setTimeout(() => { show = false }, 3000)"
    @close-toast-timer.window="setTimeout(() => { show = false }, 5000)"
    class="fixed bottom-4 right-4 z-50"
>
    <div class="bg-slate-500 text-white px-4 py-2 rounded shadow-lg">
        {{ $message }}
    </div>
</div>
