@props(['event', 'segment_percentage_sum'])

<div class="modal fade" id="addSegmentModal" tabindex="-1" aria-labelledby="addSegmentModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSegmentModalLabel">Add Segment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('segments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="segment_name" class="form-label">Segment Name</label>
                        <input type="text" class="form-control"
                            id="segment_name" name="segment_name" value="{{ old('segment_name') }}" required
                            autocomplete="off">
                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
                    </div>

                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" name="percentage" required autocomplete="off" value="{{ old('percentage') }}">
                        
                        <input type="hidden" id="existing-percentages" name="existing-percentages"
                            value="{{ old('existing-percentages', $segment_percentage_sum) }}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
