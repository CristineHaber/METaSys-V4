<x-layout title="Event">
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Logs</li>
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
                <table id="event-logs" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Model</th>
                            {{-- <th>Created By</th> --}}
                            <th>Created At</th>
                        </tr>
                    </thead>
                    @foreach ($auditTrails as $auditTrail)
                        <tr>
                            <td>{{ $auditTrail->id }}</td>
                            <td>{{ $auditTrail->title }}</td>
                            <td>{{ $auditTrail->description }}</td>
                            <td>{{ $auditTrail->model }}</td>
                            {{-- <td>{{ $auditTrail->createdByUser ? $auditTrail->createdByUser->name : 'N/A' }}</td> --}}
                            <td>{{ $auditTrail->created_at }}</td>
                        </tr>
                    @endforeach
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-flash-message />


    <script>
        $(document).ready(function() {
            $('#event-logs').DataTable();
        });
    </script>

</x-layout>
