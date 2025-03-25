@if ($errors->all())
    @foreach ($errors->all() as $error)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif

@if (session()->has("success"))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 relative" role="alert">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 mr-2"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session()->get("success") }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" 
                        data-dismiss="alert" 
                        class="close-alert text-green-500 hover:text-green-600 focus:outline-none">
                    <span class="sr-only">Fermer</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session()->has("warning"))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 relative" role="alert">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 mr-2"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">{{ session()->get("warning") }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" 
                        data-dismiss="alert" 
                        class="close-alert text-yellow-500 hover:text-yellow-600 focus:outline-none">
                    <span class="sr-only">Fermer</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session()->has("error"))
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 relative" role="alert">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">{{ session()->get("error") }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" 
                        data-dismiss="alert" 
                        class="close-alert text-red-500 hover:text-red-600 focus:outline-none">
                    <span class="sr-only">Fermer</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle manual close buttons
        const closeButtons = document.querySelectorAll('.close-alert');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('[role="alert"]');
                alert.remove();
            });
        });
        
        // Auto-hide all alerts after 5 seconds
        const allAlerts = document.querySelectorAll('[role="alert"], .bg-red-50');
        if (allAlerts.length > 0) {
            setTimeout(function() {
                allAlerts.forEach(alert => {
                    // Apply fade-out effect
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    // Remove element after fade completes
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 3000); // 3 seconds delay
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>