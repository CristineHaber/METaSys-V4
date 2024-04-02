@if (session()->has('message'))
    <div x-data="{ showMessage: true }" x-show="showMessage"
        class="alert alert-success fade show position-fixed bottom-0 end-0 p-3 text-center" role="alert"
        x-init="setTimeout(() => showMessage = false, 3000)" style="position: relative; z-index: 9999;">
        <div class="container">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('message') }}
        </div>
    </div>
@endif
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="//unpkg.com/alpinejs" defer></script>
