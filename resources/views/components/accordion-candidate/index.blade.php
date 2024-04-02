<div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
    <div class="accordion-body">
        <div class="card mb-4" id="candidate-content">
            <div class="card-header bg-gradient text-center text-white">
                <div class="row align-items-center">
                    <div class="col text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModalCandidate">
                            <i class="fas fa-user-plus"></i> Add Candidate
                        </button>
                    </div>
                </div>
            </div>
            <x-modal-candidate.create :$event />
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="candidates-table">
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Number</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Representing</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->candidates as $candidate)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ $candidate->candidate_picture ? asset('storage/' . $candidate->candidate_picture) : '' }}"
                                            alt="Candidate Image" class="rounded-circle img-fluid"
                                            style="max-width: 100px; max-height: 80px;">
                                    </td>
                                    <td class="text-center">{{ ucwords($candidate->candidate_name) }}</td>
                                    <td class="text-center">{{ $candidate->candidate_number }}</td>
                                    <td class="text-center">{{ $candidate->type }}</td>
                                    <td class="text-center">{{ $candidate->candidate_address }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModalCandidate{{ $candidate->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModalCandidate{{ $candidate->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <x-modal-candidate.edit :event="$event" :candidate="$candidate" />
                                <!-- Delete Modal -->
                                <x-modal-candidate.delete :event="$event" :candidate="$candidate" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
