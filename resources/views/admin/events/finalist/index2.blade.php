<x-layout title="finalist">
    <div class="card">
        <div class="card-header bg-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-white">{{ $event->event_name }}</span>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i>Add
                </button>
            </div>

            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true"
                data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">New Final Criteria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('finalists.store_finalist') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="final_criteria_name" class="form-label">Final
                                        Criteria</label>
                                    <input type="text" class="form-control" id="final_criteria_name"
                                        name="final_criteria_name">
                                    <input type="hidden" name="event_id" id="" value="{{ $event->id }}">
                                    <input type="hidden" name="finalist_id" id="" value="{{ $finalist->id }}">
                                    @error('final_criteria_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Percentage</label>
                                    <input type="text" class="form-control" id="percentage" name="percentage">
                                    <input type="hidden" id="existing-percentages"
                                        value="{{ $finalist->final_criterias->pluck('percentage')->sum() }}">
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
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                        </th>
                        <th scope="col">{{ $finalist->finalist_name }}</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($finalist->final_criterias as $final_criteria)
                        <tr>
                            <th scope="row">
                                {{-- <form method="POST"
                                    action="{{ route('final_criteria.destroy', ['final_criteria' => $final_criteria->id, 'event' => $event->id, 'finalist' => $finalist->id]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this final_criteria?')">Delete</button>
                                </form> --}}

                                <button class="btn btn-danger mx-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteModalFinalCriteria{{ $final_criteria->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <button class="btn btn-success mx-1" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModalFinalCriteria{{ $final_criteria->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>


                                <div class="modal fade" id="editModalFinalCriteria{{ $final_criteria->id }}"
                                    tabindex="-1" aria-labelledby="editModalFinalCriteria{{ $final_criteria->id }}"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalFinalCriteria">Edit Final Criteria
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('final_criteria_update') }}" method="POST"
                                                    id="final_criteria-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="final_criteria_name" class="form-label">Final
                                                            Criteria</label>
                                                        <input type="text" class="form-control"
                                                            id="final_criteria_name" name="final_criteria_name"
                                                            value="{{ $final_criteria->final_criteria_name }}">
                                                        <input type="hidden" name="event_id" id=""
                                                            value="{{ $event->id }}">
                                                        <input type="hidden" name="segment_id" id=""
                                                            value="{{ $finalist->id }}">
                                                        @error('final_criteria_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="percentage" class="form-label">Percentage</label>
                                                        <input type="text" class="form-control" id="percentage"
                                                            name="percentage"
                                                            value="{{ $final_criteria->percentage }}">
                                                        <input type="hidden" id="existing-percentages"
                                                            value="{{ $finalist->final_criterias->pluck('percentage')->sum() }}">
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


                                <div class="modal fade" id="deleteModalFinalCriteria{{ $final_criteria->id }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalFinalCriteria{{ $final_criteria->id }}"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteModalFinalCriteria{{ $final_criteria->id }}">
                                                    Confirm Deletion
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this
                                                    Top <strong>{{ $finalist->finalist_name }}?</strong>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form
                                                    action="{{ route('final_criteria.destroy', ['final_criteria' => $final_criteria->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </th>
                            <td>{{ $final_criteria->final_criteria_name }}</td>
                            <td>{{ $final_criteria->percentage }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total Percentage:</th>
                        <td></td>
                        <td>{{ $finalist->final_criterias->sum('percentage') }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn btn-primary">Back</a>
        </div>
    </div>
    <x-flash-message />
    <x-error-flash-message />
</x-layout>
