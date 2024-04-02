@props(['event', 'segment'])
<div class="modal fade" id="editModalSegment{{ $segment->id }}" tabindex="-1"
    aria-labelledby="editModalSegmentLabel{{ $segment->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalSegmentLabel{{ $segment->id }}">
                    Edit Segment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('segments.update_segment', ['segment' => $segment->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editSegmentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editSegmentName" name="segment_name"
                            value="{{ $segment->segment_name }}" required autocomplete="off">
                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">

                    </div>
                    <div class="mb-3">
                        <label for="editStatusSegment" class="form-label">Status</label>
                        <select class="form-select" id="editStatusSegment" name="status" required>
                            <option value="show" @if ($segment->status === 'show') selected @endif>Show</option>
                            <option value="hide" @if ($segment->status === 'hide') selected @endif>Hide</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" name="percentage"
                            value="{{ $segment->percentage }}" required autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
