@extends('layouts.app')
@section('content')
    <form class="form-horizontal" method="POST"
          onsubmit="return validateForm()"
          role="form">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

        <main>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li class="active">CLO</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="panel-group">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        CLO
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" role="table">
                                                            <thead>
                                                            <tr>
                                                                <th class="right-text" colspan="7">
                                                                    <a class="btn btn-info btn-success" href="{{ url('/nber/theoryexams/clo/addclo/'.$exam->id) }}">
                                                                        <span class="glyphicon glyphicon-plus"></span> Add CLO details
                                                                    </a>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text orange-text" width="1%">S.No.</th>
                                                                <th class="center-text orange-text" width="10%">CLO Name</th>
                                                                <th class="center-text orange-text" width="10%">Contact Details</th>
                                                                <th class="center-text orange-text" width="15%">Nodal Officer</th>
                                                                <th class="center-text orange-text" width="15%">Exam Centre</th>
                                                                <th class="center-text orange-text" width="5%">Status</th>
                                                                <th class="center-text orange-text" width="5%">Action</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @php $sno = 1; $count = 0; @endphp
                                                            @foreach($clos as $clo)
                                                                <tr>
                                                                    <td class="center-text blue-text">{{ $sno }}</td>
                                                                    <td class="center-text blue-text">{{ $clo->title->title }} {{ $clo->name }}</td>
                                                                    <td class="center-text blue-text">
                                                                        Email: {{ $clo->email1 }} @if(!is_null($clo->email2))/ {{ $clo->email2 }}@endif<br>
                                                                        Mob.No.:{{ $clo->contactnumber1 }} @if(!is_null($clo->contactnumber2))/ {{ $clo->contactnumber2 }}@endif
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        {{ $clo->nodalofficer->name }}<br>
                                                                        {{ $clo->nodalofficer->email1 }}
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        {{ $clo->externalexamcenter->code }} - {{ $clo->externalexamcenter->name }}
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        @if($clo->active_status == 1)
                                                                            <span class="label label-success">Active</span>
                                                                        @else
                                                                            <span class="label label-danger">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        <input type="hidden" id="clo_id{{ $count }}" value="{{ $clo->id }}">
                                                                        <p>
                                                                            <a href="{{ url('/nber/theoryexams/clo/updateclo/'.$exam->id.'/'.$clo->id) }}" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-pencil"> </span> details
                                                                            </a>
                                                                        </p>
                                                                        <p>
                                                                            <button id="sendbutton{{ $count }}" type="button" class="btn btn-primary btn-sm" onclick="sendemailtoclo({{ $count }})">
                                                                                <span class="glyphicon glyphicon-envelope "> </span> Send
                                                                            </button>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                @php $sno++; $count++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </form>

    <script>
        function sendemailtoclo(count) {
            var clo_id = $('#clo_id'+count).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/nber/theoryexams/clo/ajaxrequest/sendemailtoclo/') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: token, clo_id: clo_id},
                success:function(data) {
                    if(data == 1)
                        swal("Email Sent Confirmation", "Email has been sent to the CLO successfully", "success");
                    else
                        swal("Error Occurred!!!", "Email not send. Please check the email of the CLO", "error");
                }
            });
        }
    </script>
@endsection
