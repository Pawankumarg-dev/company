@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <form method="GET" action="{{ url()->current() }}" class="mb-3">
    <div class="row" style="padding-bottom: 10px">

        <div class="col-md-3">
            <label>Status Filter</label>
            <select name="status" class="form-control">
                <option value="">-- All --</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Filter Edit Type</label>
            <select name="edit" class="form-control">
                <option value="">-- All --</option>
                <option value="Attendance" {{ request('edit') == 'Attendance' ? 'selected' : '' }}>Attendance</option>
                <option value="Mark" {{ request('edit') == 'Mark' ? 'selected' : '' }}>Mark</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Internal/External</label>
            <select name="inex" class="form-control">
                <option value="">-- All --</option>
                <option value="In" {{ request('inex') == 'In' ? 'selected' : '' }}>Internal</option>
                <option value="Ex" {{ request('inex') == 'Ex' ? 'selected' : '' }}>External</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary mr-2" type="submit">Apply</button>
            <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
        </div>

    </div>
</form>
     
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Enrollment</th>
            <th>Subject</th>
            <th>Max Mark</th>
            
            <th>Exam</th>
            <th>New Data</th>
            <th>Edit Type</th>
            <th>Internal/External</th>
            <th>Attendance</th>
            <th>Mark</th>
            <th>Internal Attendance ID</th>
            <th>Status</th>
            <th>Request Date</th>
        </tr>
    </thead>

    <tbody>
        <?php $id=1; ?>
        @foreach ($data as $req)
        <tr class="entry_{{ $req->id }}">
            <?php $mark_max=0; ?>
            <td>{{ $id++ }}</td>
            <td>{{ $req->candidate->enrolmentno }}</td>
            <td>{{ $req->subject->scode}}</td>
            @if($req->inex == 'In')
                            <?php $mark_max=$req->subject->imax_marks; ?>

            <td>{{ $req->subject->imax_marks}}
            </td>
            @endif
            @if($req->inex == 'Ex')
            <?php $mark_max=$req->subject->emax_marks; ?>

            <td>{{ $req->subject->emax_marks}}</td>
            @endif

            <td>{{ $req->exam->name }}</td>

            <td>{{ $req->newdata }}</td>
            <td>{{ $req->edit }}</td>

            <td>{{ $req->inex }}</td>

            <!-- Attendance -->
            <td>
                @if($req->edit == 'Attendance')
                    <span class="badge {{ $req->newdata == 1 ? 'badge-success' : 'badge-danger' }}">
                        {{ $req->newdata == 1 ? 'Present' : 'Absent' }}
                    </span>
                @else
                    -
                @endif
            </td>

            <!-- Mark -->
            <td>
                @if($req->edit == 'Mark')
                    <span class="badge badge-info">
                        {{ $req->newdata }}
                    </span>
                @else
                    -
                @endif
            </td>

            <td>{{ $req->internalattendance_id }}</td>

            <td>
                @if($req->status == 1)
                    <span class="badge badge-success">Pending</span>
                @elseif($req->status == 2)
                    <span class="badge badge-danger">Approved</span>
                @elseif($req->status == 3)
                    <span class="badge badge-warning">Rejected</span>
                @endif
            </td>

<td>{{ $req->created_at->format('d/m/y') }}</td>

        </tr>
        @endforeach
    </tbody>
</table>
                    </div>
                </div>
 </div>

@endsection