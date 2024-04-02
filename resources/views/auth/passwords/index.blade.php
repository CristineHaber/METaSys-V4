<x-layout title="My Account">
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('update.profile') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ Auth::user()->first_name }}" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ Auth::user()->last_name }}" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usertype" class="form-label">User Type</label>
                                        <input type="text" class="form-control" id="usertype" name="usertype"
                                            value="{{ Auth::user()->usertype }}" readonly disabled>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Name</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('update.password') }}" method="POST">
                                    @csrf
                                    <h5 class="card-title">Change Password</h5>
                                    <div class="mb-3">
                                        <label for="current-password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current-password"
                                            name="current-password" autocomplete="off">
                                        @if ($errors->has('current-password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('current-password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="new-password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new-password"
                                            name="new-password" autocomplete="off">
                                        @if ($errors->has('new-password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('new-password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="new-password_confirmation" class="form-label">Confirm
                                            Password</label>
                                        <input type="password" class="form-control" id="new-password_confirmation"
                                            name="new-password_confirmation" autocomplete="off">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-flash-message />
        <x-error-flash-message />
    </div>
</x-layout>
