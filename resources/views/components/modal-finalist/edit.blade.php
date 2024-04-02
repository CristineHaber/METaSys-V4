@props(['event', 'finalist'])
<div class="modal fade" id="editModalFinalist{{ $finalist->id }}" tabindex="-1"
    aria-labelledby="editModalFinalistLabel{{ $finalist->id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalFinalistLabel{{ $finalist->id }}">
                    Edit Finalist
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('finalists.update_finalist', ['finalist' => $finalist->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="finalistCount" class="form-label">Select the number of finalists:</label>
                        <select class="form-select" id="finalistCount" name="finalist_name">
                            <option value="3"
                                {{ old('finalist_name', $finalist->finalist_name) == 3 ? 'selected' : '' }}>Top 3
                            </option>
                            <option value="5"
                                {{ old('finalist_name', $finalist->finalist_name) == 5 ? 'selected' : '' }}>Top 5
                            </option>
                            <option value="10"
                                {{ old('finalist_name', $finalist->finalist_name) == 10 ? 'selected' : '' }}>Top 10
                            </option>
                        </select>
                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="editStatusFinalist" class="form-label">Status</label>
                        <select class="form-select" id="editStatusFinalist" name="status" required>
                            <option value="show" @if ($finalist->status === 'show') selected @endif>Show</option>
                            <option value="hide" @if ($finalist->status === 'hide') selected @endif>Hide</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" name="percentage"
                            value="{{ $finalist->percentage }}" required autocomplete="off" readonly>
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
