<div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
    <div class="accordion-body">
        <!-- EVENT RESULTS CARD -->
        <div class="card mb-4" id="result-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="results-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->segments as $segment)
                                <tr>
                                    <td>{{ ucwords($segment->segment_name) }}</td>
                                    <td>
                                        <a href="{{ route('events.results.show', [
                                            'event' => $event->id,
                                            'segment' => $segment->id,
                                        ]) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>

                                        <a href="{{ route('events.results.total', [
                                            'event' => $event->id,
                                            'segment' => $segment->id,
                                        ]) }}"
                                            class="btn btn-warning">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
