<x-layout title="Final Result">
    <div class="container">
        <div class="card">
            <div class="card-header bg-gradient">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-white">{{ $event->event_name }} - Top {{ $finalist->finalist_name }} | Mr
                        Category</span>
                    <a href="{{ route('generate.pdf.finalist', ['event' => $event->id, 'finalist' => $finalist->id]) }}"
                        class="btn btn-warning float-end" target="_blank">
                        <i class="fas fa-print"></i> Print
                    </a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $mrCandidates = $event->candidates->where('type', 'mr');
                @endphp
                @if ($mrCandidates->count() > 0)

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-4">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    @foreach ($judges as $judge)
                                        <th scope="col">{{ $judge->first_name }} {{ $judge->last_name }}</th>
                                    @endforeach
                                    <th scope="col">Total</th>
                                    <th scope="col">Total with Finalist Percentage</th>
                                    <th scope="col">Rank</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @php
                                    $totalScores = [];

                                    foreach ($mrCandidates as $candidate) {
                                        $judgesCount = $judges->count();
                                        $totalScore =
                                            $judgesCount > 0
                                                ? \App\Models\FinalScore::whereHas('final_criteria', function ($query) use ($finalist) {
                                                        $query->where('finalist_id', $finalist->id);
                                                    })
                                                        ->where('candidate_id', $candidate->id)
                                                        ->sum('final_score') / $judgesCount
                                                : 0;

                                        $totalScore = number_format($totalScore, 2);

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

                                @php
                                    $top_finalist = $finalist->finalist_name;

                                    $totalScores = collect($totalScores)
                                        ->sortByDesc('total_score')
                                        ->take($top_finalist);
                                @endphp
                                @foreach ($totalScores as $totalScore)
                                    @php

                                        $currentCandidate = $event->candidates->firstWhere('id', $totalScore['candidate_id']);

                                        $totalWithFinalistPercentage = $totalScore['total_score'] * $finalist->percentage;

                                        $formattedTotalWithFinalistPercentage = number_format($totalWithFinalistPercentage / 100, 2);

                                    @endphp
                                    <tr>
                                        <td>{{ $currentCandidate->candidate_number }}</td>
                                        @foreach ($judges as $judge)
                                            <td>
                                                {{ number_format(
                                                    \App\Models\FinalScore::whereHas('final_criteria', function ($query) use ($finalist) {
                                                        $query->where('finalist_id', $finalist->id);
                                                    })->where('judge_id', $judge->id)->where('candidate_id', $totalScore['candidate_id'])->sum('final_score'),
                                                    2,
                                                ) }}
                                            </td>
                                        @endforeach
                                        <td>{{ number_format($totalScore['total_score'], 2) }}</td>
                                        <td>{{ $formattedTotalWithFinalistPercentage }}</td>
                                        <td>{{ $rank }}</td>
                                    </tr>
                                    @php
                                        $rank++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a> --}}
            </div>
            @endif
        </div>
    </div>

    <div class="container">
        @php
            $msCandidates = $event->candidates->where('type', 'ms');
        @endphp

        @if ($msCandidates->count() > 0)
            <div class="card">
                <div class="card-header bg-gradient">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white">{{ $event->event_name }} - Top {{ $finalist->finalist_name }} | Ms
                            Category</span>
                        <a href="{{ route('generate.pdf.finalist', ['event' => $event->id, 'finalist' => $finalist->id]) }}"
                            class="btn btn-warning float-end" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-4">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    @foreach ($judges as $judge)
                                        <th scope="col">{{ $judge->first_name }} {{ $judge->last_name }}</th>
                                    @endforeach
                                    <th scope="col">Total</th>
                                    <th scope="col">Total with Finalist Percentage</th>
                                    <th scope="col">Rank</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @php
                                    $totalScores = [];

                                    foreach ($msCandidates as $candidate) {
                                        $judgesCount = $judges->count();
                                        $totalScore =
                                            $judgesCount > 0
                                                ? \App\Models\FinalScore::whereHas('final_criteria', function ($query) use ($finalist) {
                                                        $query->where('finalist_id', $finalist->id);
                                                    })
                                                        ->where('candidate_id', $candidate->id)
                                                        ->sum('final_score') / $judgesCount
                                                : 0;

                                        $totalScore = number_format($totalScore, 2);

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
                                @php
                                    $top_finalist = $finalist->finalist_name;

                                    $totalScores = collect($totalScores)
                                        ->sortByDesc('total_score')
                                        ->take($top_finalist);
                                @endphp
                                @foreach ($totalScores as $totalScore)
                                    @php

                                        $currentCandidate = $event->candidates->firstWhere('id', $totalScore['candidate_id']);

                                        $totalWithFinalistPercentage = $totalScore['total_score'] * $finalist->percentage;

                                        $formattedTotalWithFinalistPercentage = number_format($totalWithFinalistPercentage / 100, 2);

                                    @endphp
                                    <tr>
                                        <td>{{ $currentCandidate->candidate_number }}</td>
                                        @foreach ($judges as $judge)
                                            <td>
                                                {{ number_format(
                                                    \App\Models\FinalScore::whereHas('final_criteria', function ($query) use ($finalist) {
                                                        $query->where('finalist_id', $finalist->id);
                                                    })->where('judge_id', $judge->id)->where('candidate_id', $totalScore['candidate_id'])->sum('final_score'),
                                                    2,
                                                ) }}
                                            </td>
                                        @endforeach
                                        <td>{{ number_format($totalScore['total_score'], 2) }}</td>
                                        <td>{{ $formattedTotalWithFinalistPercentage }}</td>
                                        <td>{{ $rank }}</td>
                                    </tr>
                                    @php
                                        $rank++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a> --}}
                </div>
            </div>
        @endif
    </div>

</x-layout>
