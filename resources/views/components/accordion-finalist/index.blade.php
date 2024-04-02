@props(['event'])
<div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
    <div class="accordion-body">
        <!-- EVENT FINALIST CARD -->
        <div class="card mb-4" id="finalist-content">
            <div class="card-header bg-gradient text-center text-white">
                <div class="row align-items-center">
                    <div class="col text-end">
                        @unless ($event->finalists->isNotEmpty())
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addFinalistModal">
                                <i class="fas fa-plus"></i> Add Finalist
                            </button>
                        @endunless
                    </div>
                </div>                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="finalists-table">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                                <th class="text-center">Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->finalists as $finalist)
                                <tr>
                                    <td class="text-center">Top {{ $finalist->finalist_name }}</td>
                                    <td class="text-center">{{ $finalist->percentage }}</td>
                                    <td class="text-center">{{ ucwords($finalist->status) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('events.finalist.index', ['finalist' => $finalist->id, 'event' => $event->id]) }}"
                                                class="btn btn-secondary">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModalFinalist{{ $finalist->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModalFinalist{{ $finalist->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('finalist.result', ['finalist' => $finalist->id, 'event' => $event->id]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-chart-bar"></i> Results
                                            </a>

                                            <a href="{{ route('finalist.index', ['finalist' => $finalist->id, 'event' => $event->id]) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Finalist
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <x-modal-finalist.edit :event="$event" :finalist="$finalist" />
                                <!-- Delete Modal -->
                                <x-modal-finalist.delete :event="$event" :finalist="$finalist" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <x-modal-finalist.create :event="$event" :finalist_percentage_sum="$event->finalists->sum('percentage')" />
            </div>
    </div>
</div>
