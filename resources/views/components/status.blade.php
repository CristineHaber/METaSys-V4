@props(['event'])

@php
    $eventStartDate = \Carbon\Carbon::parse($event->event_date)->setTimeFromTimeString($event->start_time);
    $eventEndDate = \Carbon\Carbon::parse($event->event_date)->setTimeFromTimeString($event->end_time);
    $currentDate = \Carbon\Carbon::now();

    if ($currentDate >= $eventEndDate) {
        $status = 'Ended';
        $badgeClass = 'badge bg-danger rounded-pill';
    } elseif ($currentDate >= $eventStartDate && $currentDate < $eventEndDate) {
        $status = 'Happening Now';
        $badgeClass = 'badge bg-success rounded-pill';
    } else {
        $status = 'Upcoming';
        $badgeClass = 'badge bg-primary rounded-pill';
    }
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
