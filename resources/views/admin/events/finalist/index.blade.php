<x-layout>
    <!-- Mr -->
    <div class="container">
        @php
            $mrCandidates = $event->candidates->where('type', 'mr');
        @endphp
        <div class="card">
            <div class="card-header bg-gradient">
                {{-- <h5 class="text-center text-white">{{ $event->event_name }}</h5> --}}

                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-white">{{ $event->event_name }} Mr
                        Category</span>
                        <a href="{{ route('generate.result', ['event' => $event->id]) }}" class="btn btn-warning float-end" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                        
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <!-- Add an additional column for Rank in the table header -->
                        <thead class="thead-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Candidate</th>
                                @foreach ($segments as $item)
                                    <th>{{ $item->segment_name }} ({{ $item->percentage }}%)</th>
                                @endforeach
                                <th>Total Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $candidates = $mrCandidates->sortByDesc(function ($candidate) use ($segments, $event) {
                                    $totalScores = 0;

                                    foreach ($segments as $segment) {
                                        $score =
                                            \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                $query->where('segment_id', $segment->id);
                                            })
                                                ->where('candidate_id', $candidate->id)
                                                ->sum('score') / $event->judges->count();

                                        $score = number_format($score * ($segment->percentage / 100), 2);
                                        $totalScores += $score;
                                    }

                                    return $totalScores;
                                });

                                $rank = 1;
                            @endphp

                            @foreach ($candidates as $key => $candidate)
                                <tr>
                                    <td>{{ $rank++ }}</td> <!-- Increment the rank for each candidate -->
                                    <td>{{ $candidate->candidate_name }}</td>
                                    @php
                                        $totalScores = 0;
                                    @endphp
                                    @foreach ($segments as $segment)
                                        @php
                                            $score =
                                                \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                    $query->where('segment_id', $segment->id);
                                                })
                                                    ->where('candidate_id', $candidate->id)
                                                    ->sum('score') / $event->judges->count();
                                            $score = number_format($score * ($segment->percentage / 100), 2);
                                            $totalScores += $score;
                                        @endphp
                                        <td>
                                            {{ $score }}
                                        </td>
                                    @endforeach
                                    <td>{{ $totalScores }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Ms -->
    <div class="container">
        @php
            $msCandidates = $event->candidates->where('type', 'ms');
        @endphp
        <div class="card">
            <div class="card-header bg-gradient">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-white">{{ $event->event_name }} Ms
                        Category</span>
                        <a href="{{ route('generate.result1', ['event' => $event->id]) }}" class="btn btn-warning float-end" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>  
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <!-- Add an additional column for Rank in the table header -->
                        <thead class="thead-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Candidate</th>
                                @foreach ($segments as $item)
                                    <th>{{ $item->segment_name }} ({{ $item->percentage }}%)</th>
                                @endforeach
                                <th>Total Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $candidates = $msCandidates->sortByDesc(function ($candidate) use ($segments, $event) {
                                    $totalScores = 0;

                                    foreach ($segments as $segment) {
                                        $score =
                                            \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                $query->where('segment_id', $segment->id);
                                            })
                                                ->where('candidate_id', $candidate->id)
                                                ->sum('score') / $event->judges->count();

                                        $score = number_format($score * ($segment->percentage / 100), 2);
                                        $totalScores += $score;
                                    }

                                    return $totalScores;
                                });

                                $rank = 1;
                            @endphp

                            @foreach ($candidates as $key => $candidate)
                                <tr>
                                    <td>{{ $rank++ }}</td> <!-- Increment the rank for each candidate -->
                                    <td>{{ $candidate->candidate_name }}</td>
                                    @php
                                        $totalScores = 0;
                                    @endphp
                                    @foreach ($segments as $segment)
                                        @php
                                            $score =
                                                \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                    $query->where('segment_id', $segment->id);
                                                })
                                                    ->where('candidate_id', $candidate->id)
                                                    ->sum('score') / $event->judges->count();
                                            $score = number_format($score * ($segment->percentage / 100), 2);
                                            $totalScores += $score;
                                        @endphp
                                        <td>
                                            {{ $score }}
                                        </td>
                                    @endforeach
                                    <td>{{ $totalScores }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
