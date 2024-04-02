@props(['event', 'finalist_percentage_sum'])

<div class="modal fade" id="addFinalistModal" tabindex="-1" aria-labelledby="addFinalistModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFinalistModalLabel">Add Finalist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('finalist.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="finalistCount" class="form-label">Select the number of finalists:</label>
                        <select class="form-select" id="finalistCount" name="finalist_name">
                            <option value="3" {{ old('finalist_name') == 3 ? 'selected' : '' }}>Top 3</option>
                            <option value="5" {{ old('finalist_name') == 5 ? 'selected' : '' }}>Top 5</option>
                            <option value="10" {{ old('finalist_name') == 10 ? 'selected' : '' }}>Top 10</option>
                        </select>
                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" name="percentage" required
                            autocomplete="off" value="100" readonly>

                        <input type="hidden" id="existing-percentages" name="existing-percentages"
                            value="{{ old('existing-percentages', $finalist_percentage_sum) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
