<x-layout title="Segment">
    <div class="card">
        <div class="card-header bg-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-white">{{ $segment->event->event_name }}</span>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i>Add
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">New Criteria</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('segments.store_criteria') }}" method="POST" id="criteria-form">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-3">
                                        <label for="criteria_name" class="form-label">Criteria</label>
                                        <input type="text" class="form-control" id="criteria_name"
                                            name="criteria_name" value="{{ old('criteria_name') }}" autocomplete="off">
                                        <input type="hidden" name="event_id" id=""
                                            value="{{ $event->id }}">
                                        <input type="hidden" name="segment_id" id=""
                                            value="{{ $segment->id }}">
                                        @error('criteria_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="percentage" class="form-label">Percentage</label>
                                        <input type="number" class="form-control" id="percentage" name="percentage"
                                            autocomplete="off" value="{{ old('percentage') }}">
                                        <input type="hidden" id="existing-percentages"
                                            value="{{ $segment->criterias->pluck('percentage')->sum() }}">
                                        @error('percentage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                        </th>
                        <th scope="col">{{ $segment->segment_name }}</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($segment->criterias as $criteria)
                        <tr>
                            <th scope="row">
                                <button class="btn btn-danger mx-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteModalCriteria{{ $criteria->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <button class="btn btn-success mx-1" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModalCriteria{{ $criteria->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <div class="modal fade" id="deleteModalCriteria{{ $criteria->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalCriteria{{ $criteria->id }}"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalCriteria{{ $criteria->id }}">
                                                    Confirm Deletion
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this
                                                    <strong>{{ $criteria->criteria_name }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form
                                                    action="{{ route('criteria.destroy', ['criteria' => $criteria->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="editModalCriteria{{ $criteria->id }}" tabindex="-1"
                                    aria-labelledby="editModalCriteria{{ $criteria->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalCriteria">Edit Criteria</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('criteria_update') }}" method="POST"
                                                    id="criteria-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="criteria_name" class="form-label">Criteria</label>
                                                        <input type="text" class="form-control" id="criteria_name"
                                                            name="criteria_name"
                                                            value="{{ $criteria->criteria_name }}"
                                                            autocomplete="off">
                                                        <input type="hidden" name="event_id" id=""
                                                            value="{{ $event->id }}">
                                                        <input type="hidden" name="segment_id" id=""
                                                            value="{{ $segment->id }}">
                                                        @error('criteria_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="percentage" class="form-label">Percentage</label>
                                                        <input type="text" class="form-control" id="percentage"
                                                            name="percentage" value="{{ $criteria->percentage }}"
                                                            autocomplete="off">
                                                        <input type="hidden" id="existing-percentages"
                                                            value="{{ $segment->criterias->pluck('percentage')->sum() }}">
                                                        @error('percentage')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <td>{{ $criteria->criteria_name }}</td>
                            <td>{{ $criteria->percentage }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total Percentage:</th>
                        <td></td>
                        <td>{{ $segment->criterias->sum('percentage') }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn btn-primary">Back</a>
        </div>
    </div>
    <x-error-flash-message />
    <x-flash-message />
</x-layout>
