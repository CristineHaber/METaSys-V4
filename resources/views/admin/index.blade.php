<x-layout title="Dashboard">
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12 pt-4">
                        <a href="{{ route('events.create') }}" class="card overflow-hidden custom-card">
                            <div class="card-body p-4 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512">
                                    <path
                                        d="M184 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H96c-35.3 0-64 28.7-64 64v16 48V448c0 35.3 28.7 64 64 64H416c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H376V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H184V24zM80 192H432V448c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V192zm176 40c-13.3 0-24 10.7-24 24v48H184c-13.3 0-24 10.7-24 24s10.7 24 24 24h48v48c0 13.3 10.7 24 24 24s24-10.7 24-24V352h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V256c0-13.3-10.7-24-24-24z"
                                        fill="#FFFFFF" />
                                </svg>
                                <span class="mt-2 h5 text-white ms-2">Create Event</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12 pt-4">
                        <a href="{{ route('events.index') }}" class="card overflow-hidden custom-card2">
                            <div class="card-body p-4 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512">
                                    <path
                                        d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192zm176 40c-13.3 0-24 10.7-24 24v48H184c-13.3 0-24 10.7-24 24s10.7 24 24 24h48v48c0 13.3 10.7 24 24 24s24-10.7 24-24V352h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V256c0-13.3-10.7-24-24-24z"
                                        fill="#FFFFFF" />
                                </svg>
                                <span class="mt-2 h5 text-white ms-2">View Events | {{ $event_count }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-flash-message />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    @foreach ($events as $event)
                        {
                            title: '{{ $event->event_name }}',
                            start: '{{ $event->event_date }}T{{ $event->start_time }}',
                            end: '{{ $event->event_date }}T{{ $event->end_time }}',
                            id: '{{ $event->id }}',
                            backgroundColor: (function() {
                                var eventStartDate = new Date(
                                    '{{ $event->event_date }}T{{ $event->start_time }}');
                                var eventEndDate = new Date(
                                    '{{ $event->event_date }}T{{ $event->end_time }}');
                                var currentDate = new Date();

                                if (currentDate >= eventEndDate) {
                                    return "#ff0000"; // Event has ended
                                } else if (currentDate >= eventStartDate && currentDate <
                                    eventEndDate) {
                                    return "#006600"; // Event is in progress
                                } else {
                                    return "#0074e4"; // Upcoming Event
                                }
                            })(),
                            eventStatus: (function() {
                                var eventStartDate = new Date(
                                    '{{ $event->event_date }}T{{ $event->start_time }}');
                                var eventEndDate = new Date(
                                    '{{ $event->event_date }}T{{ $event->end_time }}');
                                var currentDate = new Date();

                                if (currentDate >= eventEndDate) {
                                    return "Ended";
                                } else if (currentDate >= eventStartDate && currentDate <
                                    eventEndDate) {
                                    return "In Progress";
                                } else {
                                    return "Upcoming";
                                }
                            })(),
                            displayTime: (function() {
                                var startTime = new Date(
                                        '{{ $event->event_date }}T{{ $event->start_time }}')
                                    .toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    });
                                var endTime = new Date(
                                        '{{ $event->event_date }}T{{ $event->end_time }}')
                                    .toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    });
                                return `${startTime} to ${endTime}`;
                            })(),
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    var eventId = info.event.id;
                    window.location.href = '/events/' + eventId;
                },
                eventMouseEnter: function(info) {
                    info.el.title =
                        `${info.event.title} (${info.event.extendedProps.eventStatus})\nTime: ${info.event.extendedProps.displayTime}`;
                },
                eventMouseLeave: function(info) {
                    info.el.title = "";
                }
            });
            calendar.render();
        });
    </script>
</x-layout>
