<div class="modal fade" id="restoreModalEvent{{ $event->id }}" tabindex="-1" role="dialog"
    aria-labelledby="restoreModalEvent{{ $event->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalEvent{{ $event->id }}">
                    Confirm Restore
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to restore this <strong>{{ $event->event_name }}</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('events.archives.restore', ['event' => $event->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Restore</button>
                </form>                
            </div>
        </div>
    </div>
</div>
