@if (session('success') || session('error'))
    <div id="flash-message" 
         class="fixed bottom-5 right-5 z-100 p-4 rounded-lg shadow-2xl {{ session('success') ? 'bg-green-600' : 'bg-red-600' }} text-white transition-all duration-500 ease-out translate-y-0 opacity-100 border border-white/20">
        {{ session('success') ?? session('error') }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('flash-message');
            if (el) {
                // Fade out and slide down effect
                setTimeout(function() {
                    el.classList.replace('translate-y-0', 'translate-y-10');
                    el.classList.replace('opacity-100', 'opacity-0');
                    setTimeout(function() { el.remove(); }, 500);
                }, 3000);
            }
        });
    </script>
@endif
