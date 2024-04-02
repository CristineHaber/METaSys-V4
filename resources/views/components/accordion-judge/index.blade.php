<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
    <div class="accordion-body">
        <div class="card mb-4" id="judge-content">
            <div class="card-header bg-gradient text-center text-white">
                <div class="row align-items-center">
                    <div class="col text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModalJudge">
                            <i class="fas fa-user-plus"></i> Add Judge
                        </button>
                    </div>
                </div>
            </div>
            <x-modal-judge.create :$event />
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="judges-table">
                        <thead>
                            <tr>
                                <th class="text-center">Judge</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->judges as $judge)
                                <tr>
                                    <td class="text-center">{{ $judge->first_name }} {{ $judge->last_name }}</td>
                                    <td class="text-center">{{ $judge->user->username }}</td>
                                    <td class="text-center">
                                        {{ $judge->is_chairman === 0 ? 'Chairman' : 'Judge' }}
                                    </td>
                                    <td class="text-center">
                                        @if (str_starts_with($judge->user->online_status, 'Online'))
                                            <span class="badge bg-success">
                                                Online
                                            </span>
                                            <span class="badge bg-info">
                                                IP: {{ substr($judge->user->online_status, 7) }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                {{ $judge->user->online_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModalJudge{{ $judge->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
            
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModalJudge{{ $judge->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <x-modal-judge.edit :event="$event" :judge="$judge" />
                                <!-- Delete Modal -->
                                <x-modal-judge.delete :event="$event" :judge="$judge" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
