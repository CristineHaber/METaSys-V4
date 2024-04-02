<div class="modal fade" id="deleteModalFinalist{{ $finalist->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalFinalist{{ $finalist->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalFinalist{{ $finalist->id }}">
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this <strong>{{ $finalist->finalist_name }}</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('finalists.destroy', ['event' => $event->id, 'finalist' => $finalist->id]) }} "
                    method="POST" class="mx-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
