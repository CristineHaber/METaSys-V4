<div class="modal fade" id="addModalCandidate" tabindex="-1" aria-labelledby="addCandidateModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCandidateModalLabel">Add Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form fields go here -->
                    <div class="mb-3">
                        <label for="candidate_picture" class="form-label">Picture</label>
                        <input type="file" class="form-control" id="add_candidate_picture" name="candidate_picture"
                            accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="candidate_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="add_candidate_name" name="candidate_name"
                            required autocomplete="off" value="{{ old('candidate_name') }}">
                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled {{ old('type') == '' ? 'selected' : '' }}>Select Type
                            </option>
                            <option value="mr" {{ old('type') == 'mr' ? 'selected' : '' }}>Mr</option>
                            <option value="ms" {{ old('type') == 'ms' ? 'selected' : '' }}>Ms</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="candidate_number" class="form-label">Candidate Number</label>
                        <input type="text" class="form-control" id="add_candidate_number" name="candidate_number"
                            required autocomplete="off" value="{{ old('candidate_number') }}">
                    </div>

                    <div class="mb-3">
                        <label for="candidate_address" class="form-label">Representing</label>
                        <input type="text" class="form-control" id="add_candidate_address" name="candidate_address"
                            required autocomplete="off" value="{{ old('candidate_address') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
