<div class="modal fade" id="addModalJudge" tabindex="-1" aria-labelledby="addJudgeModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJudgeModalLabel">Add Judge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('judges.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required
                            autocomplete="off" value="{{ old('first_name') }}">
                        <input type="hidden" class="form-control" id="event_id" name="event_id"
                            value="{{ $event->id }}">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required
                            autocomplete="off" value="{{ old('last_name') }}">
                    </div>


                    <div class="mb-3">
                        <label for="is_chairman" class="form-label">Judge Role</label>
                        <select class="form-select" name="is_chairman">
                            <option value="1" {{ old('is_chairman') == 1 ? 'selected' : '' }}>Judge</option>
                            <option value="0" {{ old('is_chairman') == 0 ? 'selected' : '' }}>Chairman</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- @if ($errors->any())
    <!-- Clear old validation errors -->
    {{ $errors->clear() }}
@endif --}}
