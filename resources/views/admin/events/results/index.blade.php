<x-layout title="Result">
    <div class="container">
        <!-- Mr Category -->
        <div class="card">
            @php
                $mrCandidates = $event->candidates->where('type', 'mr');
            @endphp

            @if ($mrCandidates->count() > 0)
                <div class="card-header bg-gradient">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white">{{ $event->event_name }} {{ $segment->segment_name }} | Mr
                            Category</span> <a
                            href="{{ route('mr.generate.pdf', ['event' => $event->id, 'segment' => $segment->id]) }}"
                            class="btn btn-warning" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="resultTableForMr" class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>Candidate #</th>
                                    @foreach ($judges as $judge)
                                        <th>{{ $judge->last_name }}</th>
                                    @endforeach
                                    <th>Total</th>
                                    <th>Total with Segment Percentage</th>
                                    <th>Rank</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @php
                                    $totalScores = [];

                                    foreach ($mrCandidates as $candidate) {
                                        $totalScore = 0;
                                        $judgesCount = $judges->count();

                                        if ($judgesCount > 0) {
                                            $totalScore =
                                                \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                    $query->where('segment_id', $segment->id);
                                                })
                                                    ->where('candidate_id', $candidate->id)
                                                    ->sum('score') / $judgesCount;

                                            $totalScore = number_format($totalScore, 2);
                                        }

                                        $totalScores[] = [
                                            'candidate_id' => $candidate->id,
                                            'total_score' => $totalScore,
                                        ];
                                    }

                                    usort($totalScores, function ($a, $b) {
                                        return $b['total_score'] > $a['total_score'];
                                    });

                                    $rank = 1;
                                @endphp

                                @foreach ($totalScores as $totalScore)
                                    @php
                                        $currentCandidate = $event->candidates->firstWhere('id', $totalScore['candidate_id']);
                                        $totalWithSegmentPercentage = $totalScore['total_score'] * $segment->percentage;
                                        $formattedTotalScore = number_format($totalScore['total_score'], 2);
                                        $formattedTotalWithSegmentPercentage = number_format($totalWithSegmentPercentage / 100, 2);
                                    @endphp
                                    <tr>
                                        <td>{{ $currentCandidate->candidate_number }}</td>
                                        @foreach ($judges as $judge)
                                            <td>
                                                @php
                                                    $judgeScore = \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                        $query->where('segment_id', $segment->id);
                                                    })
                                                        ->where('judge_id', $judge->id)
                                                        ->where('candidate_id', $totalScore['candidate_id'])
                                                        ->sum('score');
                                                @endphp
                                                {{ number_format($judgeScore, 2) }}
                                            </td>
                                        @endforeach
                                        <td>{{ $formattedTotalScore }}</td>
                                        <td>{{ $formattedTotalWithSegmentPercentage }}</td>
                                        <td>{{ $rank }}</td>
                                    </tr>
                                    @php
                                        $rank++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Ms Category -->
        <div class="card">
            @php
                $msCandidates = $event->candidates->where('type', 'ms');
            @endphp

            @if ($msCandidates->count() > 0)
                <div class="card-header bg-gradient">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white">{{ $event->event_name }} {{ $segment->segment_name }} | Ms
                            Category</span>                        <a href="{{ route('ms.generate.pdf', ['event' => $event->id, 'segment' => $segment->id]) }}"
                            class="btn btn-warning float-end" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="resultTableForMs" class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>Candidate #</th>
                                    @foreach ($judges as $judge)
                                        <th>{{ $judge->last_name }}</th>
                                    @endforeach
                                    <th>Total</th>
                                    <th>Total with Segment Percentage</th>
                                    <th>Rank</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @php
                                    $totalScores = [];

                                    foreach ($msCandidates as $candidate) {
                                        $totalScore = 0;
                                        $judgesCount = $judges->count();

                                        if ($judgesCount > 0) {
                                            $totalScore =
                                                \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                    $query->where('segment_id', $segment->id);
                                                })
                                                    ->where('candidate_id', $candidate->id)
                                                    ->sum('score') / $judgesCount;

                                            $totalScore = number_format($totalScore, 2);
                                        }

                                        $totalScores[] = [
                                            'candidate_id' => $candidate->id,
                                            'total_score' => $totalScore,
                                        ];
                                    }

                                    usort($totalScores, function ($a, $b) {
                                        return $b['total_score'] > $a['total_score'];
                                    });

                                    $rank = 1;
                                @endphp

                                @foreach ($totalScores as $totalScore)
                                    @php
                                        $currentCandidate = $event->candidates->firstWhere('id', $totalScore['candidate_id']);
                                        $totalWithSegmentPercentage = $totalScore['total_score'] * $segment->percentage;
                                        $formattedTotalScore = number_format($totalScore['total_score'], 2);
                                        $formattedTotalWithSegmentPercentage = number_format($totalWithSegmentPercentage / 100, 2);
                                    @endphp
                                    <tr>
                                        <td>{{ $currentCandidate->candidate_number }}</td>
                                        @foreach ($judges as $judge)
                                            <td>
                                                @php
                                                    $judgeScore = \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                                        $query->where('segment_id', $segment->id);
                                                    })
                                                        ->where('judge_id', $judge->id)
                                                        ->where('candidate_id', $totalScore['candidate_id'])
                                                        ->sum('score');
                                                @endphp
                                                {{ number_format($judgeScore, 2) }}
                                            </td>
                                        @endforeach
                                        <td>{{ $formattedTotalScore }}</td>
                                        <td>{{ $formattedTotalWithSegmentPercentage }}</td>
                                        <td>{{ $rank }}</td>
                                    </tr>
                                    @php
                                        $rank++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // $(document).ready(function() {
        //     $('#resultTableForMr').DataTable();
        // });

        // $(document).ready(function() {
        //     $('#resultTableForMs').DataTable();
        // });
    </script>
</x-layout>
