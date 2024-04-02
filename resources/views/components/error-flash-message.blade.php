@if (session()->has('error'))
    <div x-data="{ showMessage: true }" x-show="showMessage"
        class="alert alert-danger fade show position-fixed bottom-0 end-0 p-3 text-center" role="alert"
        x-init="setTimeout(() => showMessage = false, 3000)" style="position: relative; z-index: 9999;">
        <div class="container">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ showMessage: true }" x-show="showMessage"
        class="alert alert-danger fade show position-fixed bottom-0 end-0 p-3 text-center" role="alert"
        x-init="setTimeout(() => showMessage = false, 5000)" style="position: relative; z-index: 9999;">
        <div class="container">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif