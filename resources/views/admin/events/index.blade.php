<x-layout title="Event">
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Events</li>
            </ol>
        </nav>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-gradient text-white">
            <i class="fas fa-table me-1"></i>
            Events
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="event-details-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date &amp; Time</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ ucwords($event->event_name) }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('m/d/Y') }}
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                </td>
                                <td><a href="{{ route('events.show', $event->id) }}">See Details</a></td>
                                <td>
                                    <x-status :$event />
                                </td>
                                <td>
                                    <button class="btn mx-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#deleteModalEvent{{ $event->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <x-modal-event.delete :event="$event" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-flash-message />
    <script>
        $(document).ready(function() {
            $('#event-details-table').DataTable();
        });
    </script>
</x-layout>
