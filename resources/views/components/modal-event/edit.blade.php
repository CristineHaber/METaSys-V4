@props(['event'])
<div class="modal fade" id="editModalDetails" tabindex="-1" aria-labelledby="editModalDetailsLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDetailsModalLabel">Edit Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name"
                            value="{{ $event->event_name }}" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="event_place" class="form-label">Event Address</label>
                        <input type="text" class="form-control" id="event_place" name="event_place"
                            value="{{ $event->event_place }}">
                    </div>

                    <div class="mb-3">
                        <label for="event_date" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date"
                            value="{{ $event->event_date }}" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time"
                            value="{{ \Carbon\Carbon::createFromDate($event->start_time)->format('H:i') }}">
                    </div>
                    <div class="mb-3">
                        <label for = "end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time"
                            value="{{ \Carbon\Carbon::createFromDate($event->end_time)->format('H:i') }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
