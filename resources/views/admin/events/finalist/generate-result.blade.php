<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <style>
        /* Add minimal styling for the PDF */
        body {
            font-family: 'Courier New', Courier, monospace;
        }

        .container {
            text-align: center;
            margin: 20px auto;
        }

        h2 {
            font-size: 24px;
            margin-top: 10px;
        }

        h4 {
            font-size: 20px;
            margin-top: 10px;
        }

        p {
            font-size: 16px;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
            word-wrap: break-word;
            /* Allow words to break to the next line */
            white-space: nowrap;
            /* Prevent text from wrapping onto the next line */
        }

        th {
            background-color: #f2f2f2;
        }

        .rank {
            font-weight: bold;
            color: #007BFF;
        }

        .underline {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="/images/logos/logo.jpg" alt="Logo" class="logo" width="40">
        <h5>METASYS 4.0</h5>
        <span>Junior Philippine Computer Society - CSPC Chapter</span>
        <h3>{{ $event->event_name }} <br>Mr Category</h3>
        <h3>RESULTS</h3>
        <table>
            <thead>
                <tr>
                    <th><strong>#</strong></th>
                    <th><strong>Name</strong></th>
                    @foreach ($segments as $segment)
                        <th>{{ $segment->segment_name }} ({{ $segment->percentage }}%)</th>
                    @endforeach
                    <th><strong>Total</strong></th>
                    <th class="rank"><strong>Rank</strong></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rank = 1;
                    // Sort candidates based on total scores in descending order
                    $candidates = $candidates->sortByDesc(function ($candidate) use ($segments, $event) {
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
                @endphp

                @foreach ($candidates as $candidate)
                    <tr>
                        <td>{{ $candidate->candidate_number }}</td>
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

                            <td>{{ $score }}</td>
                        @endforeach

                        <td>{{ $totalScores }}</td>
                        <td>{{ $rank++ }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <footer style="display: flex; justify-content: center; align-items: center;">
        <div>
            <table border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                <tr>
                    @foreach ($judges as $index => $judge)
                        <td style="padding: 10px;">
                            <div style="text-align: center;">
                                <span>____________________</span> <br>
                                {{ $judge->first_name }} <br>
                                {{ $judge->last_name }} <br>
                                <span style="font-size: 80%; font-style: italic;">
                                    <!-- Adjust the font size and other styles as needed -->
                                    @if ($judge->is_chairman == 0)
                                        Chairman
                                    @else
                                        Judge
                                    @endif
                                </span>

                            </div>
                        </td>
                        {{-- @if ($loop->index % 3 == 0)
                        <tr>
                        @endif --}}
                    @endforeach
                </tr>
            </table>
        </div>
    </footer>


    </footer>
</body>

</html>
