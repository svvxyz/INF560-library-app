{{-- resources/views/partials/alerts.blade.php --}}
@if (session('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-2"
         x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 md:translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-2"
         class="fixed bottom-4 right-4 z-50 max-w-sm w-full bg-white border border-emerald-200 rounded-lg shadow-xl p-4 flex items-start gap-3">
        
        <div class="text-emerald-500 shrink-0 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div class="flex-1">
            <p class="text-sm font-semibold text-slate-900">Operación exitosa</p>
            <p class="text-xs text-slate-600 mt-0.5">{{ session('success') }}</p>
        </div>

        <button @click="show = false" class="text-slate-400 hover:text-slate-600 shrink-0 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-2"
         x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 md:translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-2"
         class="fixed bottom-4 right-4 z-50 max-w-sm w-full bg-white border border-red-200 rounded-lg shadow-xl p-4 flex items-start gap-3">
        
        <div class="text-red-500 shrink-0 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div class="flex-1">
            <p class="text-sm font-semibold text-slate-900">Error</p>
            <p class="text-xs text-slate-600 mt-0.5">{{ session('error') }}</p>
        </div>

        <button @click="show = false" class="text-slate-400 hover:text-slate-600 shrink-0 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

    </div>
@endif