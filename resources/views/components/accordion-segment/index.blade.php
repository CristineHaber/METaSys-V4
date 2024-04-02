@props(['event'])
<div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
    <div class="accordion-body">
        <!-- EVENT SEGMENTS CARD -->
        <div class="card mb-4" id="segment-content">
            <div class="card-header bg-gradient text-center text-white">
                <div class="row align-items-center">
                    <div class="col text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addSegmentModal">
                            <i class="fas fa-plus"></i> Add Segment
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="segments-table">
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
                            @foreach ($event->segments as $segment)
                                <tr>
                                    <td class="text-center">{{ $segment->segment_name }}</td>
                                    <td class="text-center">{{ $segment->percentage }}</td>
                                    <td class="text-center">{{ ucwords($segment->status) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">            
                                            <a href="{{ route('events.segments.index', [
                                                'segment' => $segment->id,
                                                'event' => $segment->event->id,
                                            ]) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
            
                                            <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModalSegment{{ $segment->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
            
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModalSegment{{ $segment->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('events.results.index', [
                                            'event' => $event->id,
                                            'segment' => $segment->id,
                                        ]) }}" class="btn btn-warning">
                                            <i class="fas fa-chart-bar"></i> Results
                                        </a>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <x-modal-segment.edit :event="$event" :segment="$segment" />
                                <!-- Delete Modal -->
                                <x-modal-segment.delete :event="$event" :segment="$segment" />
                            @endforeach
                            <!-- Add Segment Modal -->
                            <x-modal-segment.create :event="$event" :segment_percentage_sum="$event->segments->sum('percentage')" />
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
