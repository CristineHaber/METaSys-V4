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
            font-size: 14px;
            margin-top: 5px;
        }

        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        } */

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
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
        <h3>{{ $segment->segment_name }}</h3>
        <h3>RESULTS</h3>
        <table>
            <thead>
                <tr>
                    <th><strong>#</strong></th>
                    <th colspan="1"><strong>Name</strong></th>
                    @foreach ($judges as $judge)
                        <th><strong>{{ $judge->last_name }}</strong></th>
                    @endforeach
                    <th><strong>Total</strong></th>
                    <th class="rank"><strong>Rank</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalScores as $totalScore)
                    @php
                        $currentCandidate = $event->candidates->firstWhere('id', $totalScore['candidate_id']);
                        $formattedTotalScore = number_format($totalScore['total_score'], 2);
                    @endphp
                    <tr>
                        <td>{{ $currentCandidate->candidate_number }}</td>
                        <td colspan="1">{{ $currentCandidate->candidate_name }}</td>
                        @foreach ($judges as $judge)
                            <td>
                                {{ \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                                    $query->where('segment_id', $segment->id);
                                })->where('judge_id', $judge->id)->where('candidate_id', $totalScore['candidate_id'])->sum('score') }}
                            </td>
                        @endforeach
                        <td>{{ $formattedTotalScore }}</td>
                        <td class="rank">{{ $rank }}</td>
                        @php
                            $rank++;
                        @endphp
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
</body>

</html>
