@props(['event', 'candidate'])
<div class="modal fade" id="editModalCandidate{{ $candidate->id }}" tabindex="-1"
    aria-labelledby="editModalCandidateLabel{{ $candidate->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalCandidateLabel{{ $candidate->id }}">
                    Edit Candidate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('candidates.update', ['candidate' => $candidate->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="candidate_picture" class="form-label">Candidate Picture</label>

                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ $candidate->candidate_picture ? asset('storage/' . $candidate->candidate_picture) : asset('/images/no-image.png') }}"
                                    alt="" class="rounded-circle" style="width: 100px; height: 80px;">
                            </div>

                            <div class="ml-3">
                                <input type="file" class="form-control" id="candidate_picture"
                                    name="candidate_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="candidate_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="candidate_name" name="candidate_name"
                            value="{{ $candidate->candidate_name }}" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled {{ old('type', $candidate->type) == '' ? 'selected' : '' }}>
                                Select Type</option>
                            <option value="mr" {{ old('type', $candidate->type) == 'mr' ? 'selected' : '' }}>Mr
                            </option>
                            <option value="ms" {{ old('type', $candidate->type) == 'ms' ? 'selected' : '' }}>Ms
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="candidate_number" class="form-label">Candidate
                            Number</label>
                        <input type="text" class="form-control" id="candidate_number" name="candidate_number"
                            value="{{ $candidate->candidate_number }}" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="candidate_address" class="form-label">Representing</label>
                        <input type="text" class="form-control" id="candidate_address" name="candidate_address"
                            value="{{ $candidate->candidate_address }}" required autocomplete="off">
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
