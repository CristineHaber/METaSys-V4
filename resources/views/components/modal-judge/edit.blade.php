@props(['event', 'judge'])
<div class="modal fade" id="editModalJudge{{ $judge->id }}" tabindex="-1"
    aria-labelledby="editJudgeModalLabel{{ $judge->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJudgeModalLabel{{ $judge->id }}">Edit
                    Judge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('judges.update', ['judge' => $judge->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ $judge->first_name }}" autocomplete="off">
                        <input type="hidden" class="form-control" id="event_id" name="event_id"
                            value="{{ $event->id }}">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ $judge->last_name }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="is_chairman" class="form-label">Judge
                            Role</label>
                        <select class="form-select" id="is_chairman" name="is_chairman">
                            <option value="1" @if ($judge->is_chairman == 1) selected @endif>
                                Judge</option>
                            <option value="0" @if ($judge->is_chairman == 0) selected @endif>
                                Chairman</option>
                        </select>
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
