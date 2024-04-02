<x-layout title="Create Event">
    <div class="container-fluid px-4">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Create Event</li>
        </ol>
    </div>
    <div class="container mb-4">
        <div class="card">
            <div class="card-header bg-gradient text-white">
                <i class="fas fa-table me-1"></i>
                Event Details
            </div>
            {{-- @dump(old()); --}}
            <div class="card-body">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="event_name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name"
                                value="{{ old('event_name') }}" autocomplete="off">
                            @error('event_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="event_place" class="form-label">Event Address</label>
                            <input type="text" class="form-control" id="event_place" name="event_place"
                                value="{{ old('event_place') }}" autocomplete="off">
                            @error('event_place')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="event_date" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="event_date" name="event_date"
                                value="{{ old('event_date') }}" min="{{ date('Y-m-d') }}">
                            @error('event_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time"
                                value="{{ old('start_time') }}">
                            @error('start_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time"
                                value="{{ old('end_time') }}">
                            @error('end_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="event_logo" class="form-label">Event Logo</label>
                            <input type="file" class="form-control" id="event_logo" name="event_logo">
                            @error('event_logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="event_banner" class="form-label">Event banner</label>
                            <input type="file" class="form-control" id="event_banner" name="event_banner">
                            @error('event_banner')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="num_judges" class="form-label">No. of Judges</label>
                            <input type="number" class="form-control" id="num_judges" name="num_judges"
                                value="{{ old('num_judges') }}">
                            @error('num_judges')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="num_candidates" class="form-label">No. of Candidates</label>
                            <input type="number" class="form-control" id="num_candidates" name="num_candidates"
                                value="{{ old('num_candidates') }}">
                            @error('num_candidates')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="num_rounds" class="form-label">No. of Rounds / Segments</label>
                            <input type="number" class="form-control" id="num_rounds" name="num_rounds"
                                value="{{ old('num_rounds') }}">
                            @error('num_rounds')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- @dump(old('num_judges')) --}}
                    <div class="container mt-5" id="judge_container">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamicFieldsContainer">
                                    @for ($i = 1; $i <= old('num_judges'); $i++)
                                        <tr>
                                            <td>
                                                <input class="form-control" name="first_name{{ $i }}"
                                                    value="{{ old('first_name' . $i) }}" placeholder="First Name">
                                            </td>
                                            <td>
                                                <input class="form-control" name="last_name{{ $i }}"
                                                    value="{{ old('last_name' . $i) }}" placeholder="Last Name">
                                            </td>
                                            <td>
                                                <select class="form-control" name="is_chairman{{ $i }}">
                                                    <option value="0"
                                                        @if (old('is_chairman' . $i) == '0') selected @endif>Chairman
                                                    </option>
                                                    <option value="1"
                                                        @if (old('is_chairman' . $i) == '1') selected @endif>Judge</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- @dump(old('num_candidates')) --}}
                    <div class="container mt-5" id="candidate_container">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Candidate Picture</th>
                                        <th>Name</th>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Represent/Place</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamicFieldsContainer1">
                                    @for ($i = 1; $i <= old('num_candidates'); $i++)
                                        <tr>
                                            <td>
                                                <input type="file" class="form-control candidate_picture" name="candidate_picture{{ $i }}" value="{{ old('candidate_picture' . $i) }}">
                                            </td>
                                            <td>
                                                <input class="form-control candidate_name_field" name="candidate_name{{ $i }}" value="{{ old('candidate_name' . $i) }}">
                                            </td>
                                            <td>
                                                <input class="form-control candidate_number_field" name="candidate_number{{ $i }}" value="{{ old('candidate_number' . $i) }}">
                                            </td>
                                            <td>
                                                <select class="form-control" name="type{{ $i }}">
                                                    <option value="mr"
                                                        @if (old('type' . $i) == 'mr') selected @endif>Mr
                                                    </option>
                                                    <option value="ms"
                                                        @if (old('type' . $i) == 'ms') selected @endif>Ms</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control candidate_address_field" name="candidate_address{{ $i }}" value="{{ old('candidate_address' . $i) }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    {{-- @dump(old('num_rounds')) --}}
                    <div class="container mt-5" id="segment_container">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Segment Name</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamicFieldsContainer2">
                                    @for ($i = 1; $i <= old('num_rounds'); $i++)
                                        <tr>
                                            <td>
                                                <input class="form-control segment_field"
                                                    name="segment_name{{ $i }}"
                                                    value="{{ old('segment_name' . $i) }}">
                                            </td>
                                            <td>
                                                <input class="form-control percent_field"
                                                    name="percentage{{ $i }}"
                                                    value="{{ old('percentage' . $i) }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('admin.index') }}" class="btn btn-dark" type="button">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
