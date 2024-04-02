<x-layout-judge>
    @unless ($doesAllJudgeScores)
        @php $waitForAnotherSegment = $segments->where('status', '!=', 'show')->count(); @endphp
        @foreach ($segments as $segment)
            @php
                $segmentStatus = $segment->status;
                $HasJudgeScoreMr = auth()
                    ->user()
                    ->judge->scores()
                    ->whereHas('criteria.segment', function ($query) use ($segment) {
                        $query->where('id', $segment->id);
                    })
                    ->whereHas('candidate', function ($query) {
                        $query->where('type', 'mr');
                    })
                    ->exists();

                $HasJudgeScoreMs = auth()
                    ->user()
                    ->judge->scores()
                    ->whereHas('criteria.segment', function ($query) use ($segment) {
                        $query->where('id', $segment->id);
                    })
                    ->whereHas('candidate', function ($query) {
                        $query->where('type', 'ms');
                    })
                    ->exists();
                if ($waitForAnotherSegment && ($segmentStatus == 'show' && (!$HasJudgeScoreMr || !$HasJudgeScoreMs))) {
                    $waitForAnotherSegment = false;
                }
                $centeredClass = $candidates->where('type', 'mr')->count() && $candidates->where('type', 'ms')->count() ? '' : 'mx-auto';
            @endphp
            {{-- @unless ($HasJudgeScoreMr) disabled @endunless --}}
            @if ($segmentStatus == 'show' && (!$HasJudgeScoreMr || !$HasJudgeScoreMs))
                <div class="container-fluid">
                    <div class="row">
                        @if ($candidates->where('type', 'mr')->count())
                            <div class="col-md-6 {{ $centeredClass }}">
                                <div class="accordion accordion-flush mt-3" id="accordionSegment{{ $segment->id }}_mr">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSegment{{ $segment->id }}_mr">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseSegment{{ $segment->id }}_mr"
                                                aria-expanded="false"
                                                aria-controls="flush-collapseSegment{{ $segment->id }}_mr">
                                                Mr. {{ $segment->segment_name }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSegment{{ $segment->id }}_mr"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingSegment{{ $segment->id }}_mr"
                                            data-bs-parent="#accordionSegment{{ $segment->id }}_mr">
                                            <div class="accordion-body">
                                                <form action="/submit_scores" method="POST">
                                                    @csrf
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Picture</th>
                                                                    <th class="text-center">Name</th>
                                                                    <th class="text-center">Criteria's</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($candidates->where('type', 'mr') as $candidate)
                                                                    <tr>
                                                                        <td class="align-middle text-center">
                                                                            {{ $candidate->candidate_number }}
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <img src="{{ asset('storage/' . $candidate->candidate_picture) }}"
                                                                                alt="{{ $candidate->candidate_name }}"
                                                                                style="width: 200px; height: 300px"
                                                                                class="container">
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <strong>{{ $candidate->candidate_name }}
                                                                            </strong> <br>
                                                                            <i> {{ $candidate->candidate_address }}</i>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <div class="d-flex flex-column">
                                                                                @foreach ($segment->criterias as $criteria)
                                                                                    @php

                                                                                        $score = $candidate
                                                                                            ->scores()
                                                                                            ->where('criteria_id', $criteria->id)
                                                                                            ->where('judge_id', auth()->user()->judge->id)
                                                                                            ->first();

                                                                                        // dump($score);

                                                                                    @endphp

                                                                                    <div class="criteria-container mb-2">
                                                                                        <span
                                                                                            class="criteria-name">{{ $criteria->criteria_name }}
                                                                                            ({{ $criteria->percentage }}%)
                                                                                        </span>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <input type="range"
                                                                                                name="score[]"
                                                                                                class="form-range w-75 me-2"
                                                                                                min="0"
                                                                                                max="{{ $criteria->percentage }}"
                                                                                                step=".5"
                                                                                                value="{{ $score ? $score->score : '' }}"
                                                                                                @if ($score) disabled @endif
                                                                                                oninput="updateRangeValue(this, {{ $segment->id }}, {{ $candidate->id }}, {{ $criteria->id }})">
                                                                                            <input type="number"
                                                                                                name=""
                                                                                                class="form-control short-input w-25 ms-2"
                                                                                                step=".5"
                                                                                                max="{{ $criteria->percentage }}"
                                                                                                oninput="updateInputValue(this, {{ $segment->id }}, {{ $candidate->id }}, {{ $criteria->id }})"
                                                                                                value="{{ $score ? $score->score : '' }}"
                                                                                                @if ($score) disabled @endif>
                                                                                        </div>

                                                                                        <input type="hidden"
                                                                                            name="segment_id[]"
                                                                                            value="{{ $segment->id }}">
                                                                                        <input type="hidden"
                                                                                            name="candidate_id[]"
                                                                                            value="{{ $candidate->id }}">
                                                                                        <input type="hidden"
                                                                                            name="criteria_id[]"
                                                                                            value="{{ $criteria->id }}">
                                                                                        <input type="hidden"
                                                                                            name="event_id[]"
                                                                                            value="{{ $segment->event->id }}">
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        @unless ($HasJudgeScoreMr)
                                                            <button type="button" class="btn btn-primary float-end"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#previewModal{{ $segment->id }}"
                                                                id="btnPreview_{{ $segment->id }}">
                                                                Preview
                                                            </button>
                                                        @endunless

                                                        <div class="modal right fade" id="previewModal{{ $segment->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="previewModalLabel{{ $segment->id }}"
                                                            aria-hidden="true" data-bs-backdrop="static">
                                                            <div
                                                                class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content modal-content-scrollable">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="previewModalLabel{{ $segment->id }}">
                                                                            Preview Scores (Mr.)
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-bordered">
                                                                            <thead class="text-center">
                                                                                <tr>
                                                                                    <th>Candidate</th>
                                                                                    @foreach ($segment->criterias as $criteria)
                                                                                        <th>{{ $criteria->criteria_name }}
                                                                                        </th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($candidates->where('type', 'mr') as $candidate)
                                                                                    {{-- Display only 'mr' candidates --}}
                                                                                    <tr>
                                                                                        <td>#{{ $candidate->candidate_number }}
                                                                                            {{ $candidate->candidate_name }}
                                                                                        </td>
                                                                                        @foreach ($segment->criterias as $criteria)
                                                                                            <td class="text-center">
                                                                                                <!-- Display the corresponding score for this candidate and criteria -->
                                                                                                <span
                                                                                                    id="score_{{ $segment->id }}_{{ $candidate->id }}_{{ $criteria->id }}">0</span>
                                                                                            </td>
                                                                                        @endforeach
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <p class="text-center">Are you sure you want to
                                                                            submit?</p>
                                                                        <div class="d-flex justify-content-center mt-3">
                                                                            <button type="button"
                                                                                class="btn btn-secondary mr-2"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary"
                                                                                style="margin-left: 5px;">Yes,
                                                                                Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function updateRangeValue(input, segmentId, candidateId, criteriaId) {
                                                                console.log('updateRangeValue')
                                                                // Find the adjacent span element to display the value
                                                                const rangeValue = input.nextElementSibling;
                                                                rangeValue.value = input.value; // Update the text content with the selected value

                                                                // Update the corresponding score in the modal
                                                                const scoreSpan = document.getElementById(`score_${segmentId}_${candidateId}_${criteriaId}`);
                                                                scoreSpan.textContent = input.value;
                                                            }

                                                            function updateInputValue(input, segmentId, candidateId, criteriaId) {
                                                                console.log('updateInputValue')
                                                                // Find the adjacent span element to display the value
                                                                const rangeValue = input.previousElementSibling;
                                                                console.log('input', input)
                                                                console.log('rangeValue', rangeValue)
                                                                console.log('rangeValue.value', rangeValue.value)
                                                                rangeValue.value = input.value; // Update the text content with the selected value

                                                                // Update the corresponding score in the modal
                                                                const scoreSpan = document.getElementById(`score_${segmentId}_${candidateId}_${criteriaId}`);
                                                                scoreSpan.textContent = input.value > 100 ? 100 : input.value;
                                                            }
                                                        </script>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($candidates->where('type', 'ms')->count())
                            <div class="col-md-6 {{ $centeredClass }}">
                                <div class="accordion accordion-flush mt-3" id="accordionSegment{{ $segment->id }}_ms">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSegment{{ $segment->id }}_ms">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseSegment{{ $segment->id }}_ms"
                                                aria-expanded="false"
                                                aria-controls="flush-collapseSegment{{ $segment->id }}_ms">
                                                Ms. {{ $segment->segment_name }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSegment{{ $segment->id }}_ms"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingSegment{{ $segment->id }}_ms"
                                            data-bs-parent="#accordionSegment{{ $segment->id }}_ms">
                                            <div class="accordion-body">
                                                <form action="/submit_scores" method="POST">
                                                    @csrf
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Picture</th>
                                                                    <th class="text-center">Name</th>
                                                                    <th class="text-center">Criteria's</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($candidates->where('type', 'ms') as $candidate)
                                                                    <tr>
                                                                        <td class="align-middle text-center">
                                                                            {{ $candidate->candidate_number }}
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <img src="{{ asset('storage/' . $candidate->candidate_picture) }}"
                                                                                alt="{{ $candidate->candidate_name }}"
                                                                                style="width: 200px; height: 300px"
                                                                                class="container">
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <strong>{{ $candidate->candidate_name }}
                                                                            </strong> <br>
                                                                            <i> {{ $candidate->candidate_address }}</i>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <div class="d-flex flex-column">
                                                                                @foreach ($segment->criterias as $criteria)
                                                                                    @php

                                                                                        $score = $candidate
                                                                                            ->scores()
                                                                                            ->where('criteria_id', $criteria->id)
                                                                                            ->where('judge_id', auth()->user()->judge->id)
                                                                                            ->first();

                                                                                        // dump($score);

                                                                                    @endphp

                                                                                    <div class="criteria-container mb-2">
                                                                                        <span
                                                                                            class="criteria-name">{{ $criteria->criteria_name }}
                                                                                            ({{ $criteria->percentage }}%)
                                                                                        </span>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <input type="range"
                                                                                                name="score[]"
                                                                                                class="form-range w-75 me-2"
                                                                                                min="0"
                                                                                                max="{{ $criteria->percentage }}"
                                                                                                step=".5"
                                                                                                value="{{ $score ? $score->score : '' }}"
                                                                                                @if ($score) disabled @endif
                                                                                                oninput="updateRangeValue(this, {{ $segment->id }}, {{ $candidate->id }}, {{ $criteria->id }})">
                                                                                            <input type="number"
                                                                                                name=""
                                                                                                class="form-control short-input w-25 ms-2"
                                                                                                step=".5"
                                                                                                max="{{ $criteria->percentage }}"
                                                                                                oninput="updateInputValue(this, {{ $segment->id }}, {{ $candidate->id }}, {{ $criteria->id }})"
                                                                                                value="{{ $score ? $score->score : '' }}"
                                                                                                @if ($score) disabled @endif>
                                                                                        </div>

                                                                                        <input type="hidden"
                                                                                            name="segment_id[]"
                                                                                            value="{{ $segment->id }}">
                                                                                        <input type="hidden"
                                                                                            name="candidate_id[]"
                                                                                            value="{{ $candidate->id }}">
                                                                                        <input type="hidden"
                                                                                            name="criteria_id[]"
                                                                                            value="{{ $criteria->id }}">
                                                                                        <input type="hidden"
                                                                                            name="event_id[]"
                                                                                            value="{{ $segment->event->id }}">
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @unless ($HasJudgeScoreMs)
                                                            <button type="button" class="btn btn-primary float-end"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#previewModal{{ $segment->id }}_ms"
                                                                id="btnPreview_{{ $segment->id }}_ms">
                                                                Preview
                                                            </button>
                                                        @endunless

                                                        <!-- Preview Modal -->
                                                        <div class="modal right fade"
                                                            id="previewModal{{ $segment->id }}_ms" tabindex="-1"
                                                            aria-labelledby="previewModalLabel{{ $segment->id }}_ms"
                                                            aria-hidden="true" data-bs-backdrop="static">
                                                            <div
                                                                class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                                                <div class="modal-content modal-content-scrollable">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="previewModalLabel{{ $segment->id }}_ms">
                                                                            Preview Scores (Ms.)
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-bordered">
                                                                            <thead class="text-center">
                                                                                <tr>
                                                                                    <th>Candidate</th>
                                                                                    @foreach ($segment->criterias as $criteria)
                                                                                        <th>{{ $criteria->criteria_name }}
                                                                                        </th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($candidates->where('type', 'ms') as $candidate)
                                                                                    {{-- Display only 'mr' candidates --}}
                                                                                    <tr>
                                                                                        <td>#{{ $candidate->candidate_number }}
                                                                                            {{ $candidate->candidate_name }}
                                                                                        </td>
                                                                                        @foreach ($segment->criterias as $criteria)
                                                                                            <td class="text-center">
                                                                                                <!-- Display the corresponding score for this candidate and criteria -->
                                                                                                <span
                                                                                                    id="score_{{ $segment->id }}_{{ $candidate->id }}_{{ $criteria->id }}">0</span>
                                                                                            </td>
                                                                                        @endforeach
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <p class="text-center">Are you sure you want to
                                                                            submit?</p>
                                                                        <div class="d-flex justify-content-center mt-3">
                                                                            <button type="button"
                                                                                class="btn btn-secondary mr-2"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary"
                                                                                style="margin-left: 5px;">Yes,
                                                                                Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <script>
                                                            function updateRangeValue(input, segmentId, candidateId, criteriaId) {
                                                                console.log('updateRangeValue')
                                                                // Find the adjacent span element to display the value
                                                                const rangeValue = input.nextElementSibling;
                                                                rangeValue.value = input.value; // Update the text content with the selected value

                                                                // Update the corresponding score in the modal
                                                                const scoreSpan = document.getElementById(`score_${segmentId}_${candidateId}_${criteriaId}`);
                                                                scoreSpan.textContent = input.value;
                                                            }

                                                            function updateInputValue(input, segmentId, candidateId, criteriaId) {
                                                                console.log('updateInputValue')
                                                                // Find the adjacent span element to display the value
                                                                const rangeValue = input.previousElementSibling;
                                                                console.log('input', input)
                                                                console.log('rangeValue', rangeValue)
                                                                console.log('rangeValue.value', rangeValue.value)
                                                                rangeValue.value = input.value; // Update the text content with the selected value

                                                                // Update the corresponding score in the modal
                                                                const scoreSpan = document.getElementById(`score_${segmentId}_${candidateId}_${criteriaId}`);
                                                                scoreSpan.textContent = input.value > 100 ? 100 : input.value;
                                                            }
                                                        </script>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach

        @if ($waitForAnotherSegment)
            <style>
                .thicker-outline {
                    border: 4px solid #fff;
                    /* Adjust the border thickness and color as needed */
                    background: none;
                    /* Remove the background color */
                }
            </style>

            <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="card thicker-outline">
                    <div class="text-center card-body">
                        <h1 class="text-light">WAIT FOR ANOTHER SEGMENT...</h1>
                    </div>
                </div>
            </div>
        @endif

    @endunless


    @if ($doesAllJudgeScores)

        @unless ($finalists->count())
            <style>
                .thicker-outline {
                    border: 4px solid #fff;
                    /* Adjust the border thickness and color as needed */
                    background: none;
                    /* Remove the background color */
                }
            </style>
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="card thicker-outline">
                    <div class="text-center card-body">
                        <h1 class="text-light">WAIT FOR FINAL SEGMENT...</h1>
                    </div>
                </div>
            </div>
        @endunless

        @foreach ($finalists as $finalist)
            {{-- @php
                $HasJudgeScoreFinal = auth()
                    ->user()
                    ->judge->final_score()
                    ->whereHas('final_criteria.finalist', function ($query) use ($finalist) {
                        $query->where('id', $finalist->id);
                    })
                    ->exists();
            @endphp --}}

            @php
                $finalistStatus = $finalist->status;
                $HasJudgeScoreMrFinal = auth()
                    ->user()
                    ->judge->final_score()
                    ->whereHas('final_criteria.finalist', function ($query) use ($finalist) {
                        $query->where('id', $finalist->id);
                    })
                    ->whereHas('candidate', function ($query) {
                        $query->where('type', 'mr');
                    })
                    ->exists();

                $HasJudgeScoreMsFinal = auth()
                    ->user()
                    ->judge->final_score()
                    ->whereHas('final_criteria.finalist', function ($query) use ($finalist) {
                        $query->where('id', $finalist->id);
                    })
                    ->whereHas('candidate', function ($query) {
                        $query->where('type', 'ms');
                    })
                    ->exists();
                // if ($waitForAnotherFinalist && ($finalistStatus == 'show' && (!$HasJudgeScoreMr || !$HasJudgeScoreMs))) {
                //     $waitForAnotherFinalist = false;
                // }
                $centeredClass = $candidates->where('type', 'mr')->count() && $candidates->where('type', 'ms')->count() ? '' : 'mx-auto';
            @endphp
            @if ($finalistStatus == 'show' && (!$HasJudgeScoreMrFinal || !$HasJudgeScoreMsFinal))
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="accordion accordion-flush mt-3" id="accordionFinalist{{ $finalist->id }}_mr">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFinalist{{ $finalist->id }}_mr">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseFinalist{{ $finalist->id }}_mr"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseFinalist{{ $finalist->id }}_mr">
                                            Mr. TOP {{ $finalist->finalist_name }} FINALIST
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFinalist{{ $finalist->id }}_mr"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingFinalist{{ $finalist->id }}_mr"
                                        data-bs-parent="#accordionFinalist{{ $finalist->id }}_mr">
                                        <div class="accordion-body">
                                            <form action="{{ route('judge.finalist.score') }}" method="POST">
                                                @csrf
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">Picture</th>
                                                                <th class="text-center">Name</th>
                                                                <th class="text-center">Criteria's</th>
                                                            </tr>
                                                        </thead>
                                                        @php
                                                            usort($topCandidatesMr, function ($a, $b) {
                                                                return $a['candidate_number'] - $b['candidate_number'];
                                                            });
                                                        @endphp

                                                        <tbody>
                                                            @foreach ($topCandidatesMr as $candidate)
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $candidate['candidate_number'] }}
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        <img src="{{ asset('storage/' . $candidate['candidate_picture']) }}"
                                                                            alt="{{ $candidate['candidate_name'] }}"
                                                                            style="width: 210px; height: 300px"
                                                                            class="" class="container">
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        <strong>{{ $candidate['candidate_name'] }}
                                                                        </strong> <br>
                                                                        <i> {{ $candidate['candidate_address'] }}</i>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <div class="d-flex flex-column">
                                                                            @foreach ($finalist->final_criterias as $final_criteria)
                                                                                @php
                                                                                    $final_score = \App\Models\Candidate::find($candidate['candidate_id'])
                                                                                        ->final_scores()
                                                                                        ->where('final_criteria_id', $final_criteria->id)
                                                                                        ->where('judge_id', auth()->user()->judge->id)
                                                                                        ->first();
                                                                                @endphp

                                                                                <div class="criteria-container mb-2">
                                                                                    <span
                                                                                        class="final_criteria-name">{{ $final_criteria->final_criteria_name }}
                                                                                        ({{ $final_criteria->percentage }}%)
                                                                                    </span>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <input type="range"
                                                                                            name="final_score[]"
                                                                                            class="form-range"
                                                                                            min="0"
                                                                                            max="{{ $final_criteria->percentage }}"
                                                                                            step=".5"
                                                                                            oninput="updateRangeValue(this, {{ $finalist->id }}, {{ $candidate['candidate_id'] }}, {{ $final_criteria->id }})"
                                                                                            value="{{ $final_score ? $final_score->final_score : '' }}"
                                                                                            @if ($final_score) disabled @endif>
                                                                                        <input type="number"
                                                                                            name=""
                                                                                            class="form-control short-input w-25 ms-2"
                                                                                            step=".5"
                                                                                            max="{{ $final_criteria->percentage }}"
                                                                                            oninput="updateInputValue(this, {{ $finalist->id }}, {{ $candidate['candidate_id'] }}, {{ $final_criteria->id }})"
                                                                                            value="{{ $final_score ? $final_score->final_score : '' }}"
                                                                                            @if ($final_score) disabled @endif>
                                                                                    </div>

                                                                                    <input type="hidden"
                                                                                        name="finalist_id[]"
                                                                                        value="{{ $finalist->id }}">
                                                                                    <input type="hidden"
                                                                                        name="candidate_id[]"
                                                                                        value="{{ $candidate['candidate_id'] }}">
                                                                                    <input type="hidden"
                                                                                        name="final_criteria_id[]"
                                                                                        value="{{ $final_criteria->id }}">
                                                                                    <input type="hidden"
                                                                                        name="event_id[]"
                                                                                        value="{{ $finalist->event->id }}">
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>

                                                    @unless ($HasJudgeScoreMrFinal)
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#previewModal{{ $finalist->id }}_mr"
                                                            id="btnPreview_{{ $finalist->id }}_ms">
                                                            Preview
                                                        </button>
                                                    @endunless
                                                    <!-- Preview Modal -->
                                                    <div class="modal fade" id="previewModal{{ $finalist->id }}_mr"
                                                        tabindex="-1"
                                                        aria-labelledby="previewModalLabel{{ $finalist->id }}_ms"
                                                        aria-hidden="true" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="previewModalLabel{{ $finalist->id }}_mr">
                                                                        Preview Scores
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered">
                                                                        <thead class="">
                                                                            <tr>
                                                                                <th>Candidate</th>
                                                                                @foreach ($finalist->final_criterias as $final_criteria)
                                                                                    <th class="text-center">
                                                                                        {{ $final_criteria->final_criteria_name }}
                                                                                    </th>
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="">
                                                                            @foreach ($topCandidatesMr as $candidate)
                                                                                <tr>
                                                                                    <td>#{{ $candidate['candidate_number'] }}
                                                                                        {{ $candidate['candidate_name'] }}
                                                                                    </td>
                                                                                    @foreach ($finalist->final_criterias as $final_criteria)
                                                                                        <td class="text-center">
                                                                                            <!-- Display the corresponding score for this candidate and criteria -->
                                                                                            <span
                                                                                                id="final_score_{{ $finalist->id }}_{{ $candidate['candidate_id'] }}_{{ $final_criteria->id }}">0%</span>
                                                                                        </td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <p class="text-center">Are you sure you want to
                                                                        submit?
                                                                    </p>
                                                                    <div class="d-flex justify-content-center mt-3">
                                                                        <button type="button"
                                                                            class="btn btn-secondary mr-2"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-primary"
                                                                            style="margin-left: 5px;">Yes,
                                                                            Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        function updateRangeValue(input, finalId, candidateId, final_criteriaId) {
                                                            console.log('updateRangeValue')
                                                            // Find the adjacent span element to display the value
                                                            const rangeValue = input.nextElementSibling;
                                                            rangeValue.value = input.value; // Update the text content with the selected value

                                                            // Update the corresponding score in the modal
                                                            const scoreSpan = document.getElementById(`final_score_${finalId}_${candidateId}_${final_criteriaId}`);
                                                            scoreSpan.textContent = input.value;
                                                        }

                                                        function updateInputValue(input, finalistId, candidateId, final_criteriaId) {
                                                            console.log('updateInputValue')
                                                            // Find the adjacent span element to display the value
                                                            const rangeValue = input.previousElementSibling;
                                                            console.log('input', input)
                                                            console.log('rangeValue', rangeValue)
                                                            console.log('rangeValue.value', rangeValue.value)
                                                            rangeValue.value = input.value; // Update the text content with the selected value

                                                            // Update the corresponding score in the modal
                                                            const scoreSpan = document.getElementById(`final_score_${finalistId}_${candidateId}_${final_criteriaId}`);
                                                            scoreSpan.textContent = input.value > 100 ? 100 : input.value;
                                                        }
                                                    </script>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="accordion accordion-flush mt-3"
                                id="accordionFinalist{{ $finalist->id }}_ms">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFinalist{{ $finalist->id }}_ms">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseFinalist{{ $finalist->id }}_ms"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseFinalist{{ $finalist->id }}_ms">
                                            Ms. TOP {{ $finalist->finalist_name }} FINALIST
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFinalist{{ $finalist->id }}_ms"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingFinalist{{ $finalist->id }}_ms"
                                        data-bs-parent="#accordionFinalist{{ $finalist->id }}_ms">
                                        <div class="accordion-body">
                                            <form action="{{ route('judge.finalist.score') }}" method="POST">
                                                @csrf
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">Picture</th>
                                                                <th class="text-center">Name</th>
                                                                <th class="text-center">Criteria's</th>
                                                            </tr>
                                                        </thead>
                                                        @php
                                                            usort($topCandidatesMs, function ($a, $b) {
                                                                return $a['candidate_number'] - $b['candidate_number'];
                                                            });
                                                        @endphp

                                                        <tbody>
                                                            @foreach ($topCandidatesMs as $candidate)
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $candidate['candidate_number'] }}
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        <img src="{{ asset('storage/' . $candidate['candidate_picture']) }}"
                                                                            alt="{{ $candidate['candidate_name'] }}"
                                                                            style="width: 210px; height: 300px"
                                                                            class="" class="container">
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        <strong>{{ $candidate['candidate_name'] }}
                                                                        </strong> <br>
                                                                        <i> {{ $candidate['candidate_address'] }}</i>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <div class="d-flex flex-column">
                                                                            @foreach ($finalist->final_criterias as $final_criteria)
                                                                                @php
                                                                                    $final_score = \App\Models\Candidate::find($candidate['candidate_id'])
                                                                                        ->final_scores()
                                                                                        ->where('final_criteria_id', $final_criteria->id)
                                                                                        ->where('judge_id', auth()->user()->judge->id)
                                                                                        ->first();
                                                                                @endphp

                                                                                <div class="criteria-container mb-2">
                                                                                    <span
                                                                                        class="final_criteria-name">{{ $final_criteria->final_criteria_name }}
                                                                                        ({{ $final_criteria->percentage }}%)
                                                                                    </span>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <input type="range"
                                                                                            name="final_score[]"
                                                                                            class="form-range"
                                                                                            min="0"
                                                                                            max="{{ $final_criteria->percentage }}"
                                                                                            step=".5"
                                                                                            oninput="updateRangeValue(this, {{ $finalist->id }}, {{ $candidate['candidate_id'] }}, {{ $final_criteria->id }})"
                                                                                            value="{{ $final_score ? $final_score->final_score : '' }}"
                                                                                            @if ($final_score) disabled @endif>
                                                                                        <input type="number"
                                                                                            name=""
                                                                                            class="form-control short-input w-25 ms-2"
                                                                                            step=".5"
                                                                                            max="{{ $final_criteria->percentage }}"
                                                                                            oninput="updateInputValue(this, {{ $finalist->id }}, {{ $candidate['candidate_id'] }}, {{ $final_criteria->id }})"
                                                                                            value="{{ $final_score ? $final_score->final_score : '' }}"
                                                                                            @if ($final_score) disabled @endif>
                                                                                    </div>

                                                                                    <input type="hidden"
                                                                                        name="finalist_id[]"
                                                                                        value="{{ $finalist->id }}">
                                                                                    <input type="hidden"
                                                                                        name="candidate_id[]"
                                                                                        value="{{ $candidate['candidate_id'] }}">
                                                                                    <input type="hidden"
                                                                                        name="final_criteria_id[]"
                                                                                        value="{{ $final_criteria->id }}">
                                                                                    <input type="hidden"
                                                                                        name="event_id[]"
                                                                                        value="{{ $finalist->event->id }}">
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>

                                                    @unless ($HasJudgeScoreMsFinal)
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#previewModal{{ $finalist->id }}_ms"
                                                            id="btnPreview_{{ $finalist->id }}_ms">
                                                            Preview
                                                        </button>
                                                    @endunless
                                                    <!-- Preview Modal -->
                                                    <div class="modal fade" id="previewModal{{ $finalist->id }}_ms"
                                                        tabindex="-1"
                                                        aria-labelledby="previewModalLabel{{ $finalist->id }}_ms"
                                                        aria-hidden="true" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="previewModalLabel{{ $finalist->id }}_ms">
                                                                        Preview Scores
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered">
                                                                        <thead class="">
                                                                            <tr>
                                                                                <th>Candidate</th>
                                                                                @foreach ($finalist->final_criterias as $final_criteria)
                                                                                    <th class="text-center">
                                                                                        {{ $final_criteria->final_criteria_name }}
                                                                                    </th>
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="">
                                                                            @foreach ($topCandidatesMs as $candidate)
                                                                                <tr>
                                                                                    <td>#{{ $candidate['candidate_number'] }}
                                                                                        {{ $candidate['candidate_name'] }}
                                                                                    </td>
                                                                                    @foreach ($finalist->final_criterias as $final_criteria)
                                                                                        <td class="text-center">
                                                                                            <!-- Display the corresponding score for this candidate and criteria -->
                                                                                            <span
                                                                                                id="final_score_{{ $finalist->id }}_{{ $candidate['candidate_id'] }}_{{ $final_criteria->id }}">0%</span>
                                                                                        </td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <p class="text-center">Are you sure you want to
                                                                        submit?
                                                                    </p>
                                                                    <div class="d-flex justify-content-center mt-3">
                                                                        <button type="button"
                                                                            class="btn btn-secondary mr-2"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-primary"
                                                                            style="margin-left: 5px;">Yes,
                                                                            Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <script>
                                                        function updateRangeValue(input, finalId, candidateId, final_criteriaId) {
                                                            console.log('updateRangeValue')
                                                            // Find the adjacent span element to display the value
                                                            const rangeValue = input.nextElementSibling;
                                                            rangeValue.value = input.value; // Update the text content with the selected value

                                                            // Update the corresponding score in the modal
                                                            const scoreSpan = document.getElementById(`final_score_${finalId}_${candidateId}_${final_criteriaId}`);
                                                            scoreSpan.textContent = input.value;
                                                        }

                                                        function updateInputValue(input, finalistId, candidateId, final_criteriaId) {
                                                            console.log('updateInputValue')
                                                            // Find the adjacent span element to display the value
                                                            const rangeValue = input.previousElementSibling;
                                                            console.log('input', input)
                                                            console.log('rangeValue', rangeValue)
                                                            console.log('rangeValue.value', rangeValue.value)
                                                            rangeValue.value = input.value; // Update the text content with the selected value

                                                            // Update the corresponding score in the modal
                                                            const scoreSpan = document.getElementById(`final_score_${finalistId}_${candidateId}_${final_criteriaId}`);
                                                            scoreSpan.textContent = input.value > 100 ? 100 : input.value;
                                                        }
                                                    </script>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        @endforeach
    @endif
    {{-- @if ($doesAllJudgeScores)
        <div class="d-flex justify-content-center align-items-center">
            <div class="card border-0 rounded-0 text-center shadow-lg">
                <div class="card-body">
                    <img src="{{ asset('/images/logos/logo-last-final.png') }}" width="60" alt=""
                        class="mb-2" />
                    <h4 class="text-dark">Thank you very much!</h4>
                    <p class="lead text-muted">We appreciate your valuable participation.</p>
                </div>
            </div>
        </div>
    @else
    @endif --}}

    <x-flash-message />
</x-layout-judge>
