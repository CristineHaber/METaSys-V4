<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
    <div class="accordion-body">
        <div class="card">
            <div class="card-header bg-gradient text-center text-white">
                <div class="row align-items-center">
                    <div class="col text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModalDetails">
                            <i class="fas fa-edit"></i> Edit Details
                        </button>
                    </div>
                </div>
            </div>
            <x-modal-event.edit :$event />
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Event</td>
                                    <td>{{ ucwords($event->event_name) }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $event->event_place }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('m/d/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Start Time</td>
                                    <td>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td>End Time</td>
                                    <td>{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td>Judges</td>
                                    <td>{{ $event->judges->count() }}</td>
                                </tr>
                                <tr>
                                    <td>Participants</td>
                                    <td>{{ $event->candidates->count() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <form action="{{ route('events.update_image', $event->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $event->event_logo) }}" alt="" id="eventLogo"
                                    width="70px">
                            </div>
                            <div class="mb-3">
                                <label for="event_logo" class="btn btn-primary">
                                    <i class="fas fa-image"></i> Change Logo <input type="file" id="event_logo"
                                        name="event_logo" style="display: none;">
                                </label>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $event->event_banner) }}" alt=""
                                    id="eventBanner" width="70px">
                            </div>
                            <div class="mb-3">
                                <label for="event_banner" class="btn btn-primary">
                                    <i class="fas fa-image"></i> Change Banner <input type="file" id="event_banner"
                                        name="event_banner" style="display: none;">
                                </label>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-success" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
