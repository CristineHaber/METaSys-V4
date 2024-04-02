<x-layout title="Archive">
    <div class="container-fluid px-4">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Event History</li>
        </ol>
    </div>
    <div class="card mb-4" id="archive-content">
        <div class="card-header bg-gradient text-white">
            <i class="fas fa-archive mr-2"></i> Archives
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="archive-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ ucwords($event->event_name) }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('m/d/Y') }}</td>
                                <td>
                                    <button class="btn btn-success mx-1" type="button" data-bs-toggle="modal"
                                        data-bs-target="#restoreModalEvent{{ $event->id }}">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                    <x-modal-event.restore :event="$event" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <x-flash-message />
    </div>

    <script>
        $(document).ready(function() {
            $('#archive-table').DataTable();
        });
    </script>
</x-layout>
