@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <h3>Approve special request for Supplementary exam</h3>
            <table class="table">
                <tr>
                    <th>
                        Candidate
                    </th>
                    <td>
                        {{ $candidate->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Enrolment No
                    </th>
                    <td>
                        {{ $candidate->enrolmentno }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Institute 
                    </th>
                    <td>
                        {{ $candidate->approvedprogramme->institute->rci_code }} - {{ $candidate->approvedprogramme->institute->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Course 
                    </th>
                    <td>
                        {{ $candidate->approvedprogramme->programme->course_name }} 
                    </td>
                </tr>
                <tr>
                    <th>
                        Exams attended before 
                    </th>
                    <td>
                        <a target="_blank" href="{{ url('nber/candidate') }}/{{ $candidate->id }}"> Click here</a> to see the marks tab in the candidate profile
                    </td>
                </tr>
                <tr>
                    <th>
                        Applied for
                    </th>
                    <td>
                        <table class="table">
                            <tr>
                                <td>Subject Code</td>
                                <td>Subject</td>
                                <td>Term</td>
                            </tr>
                        @foreach($applications as $a)
                        <tr>
                            <td>
                                {{ $a->subject->scode }}
                            </td>
                            <td>
                                {{ $a->subject->sname }}
                            </td>
                            <td>
                                {{ $a->subject->syear }}
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>
                        Exam not attended
                    </th>
                    <td>
                        {{ $exception->exam }} 
                    </td>
                </tr>
                <tr>
                    <th>
                        Reason
                    </th>
                    <td>
                        {{ $exception->reason }} 
                    </td>
                </tr>
                <tr>
                    <th>
                        Document
                    </th>
                    <td>
                        <iframe src="{{ url('files/supplyevidance') }}/{{ $exception->document }}" frameborder="0" style="height: 800px;width:100%;"></iframe>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($exception->status == 1) Approved @endif
                        @if($exception->status == 2) Rejected @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        Approval
                    </th>
                    <th>
                        @if($exception->status != 1)
                        <div class="pull-left">
                            <form action="{{ url('nber/exam/exception') }}/{{ $exception->id }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT"> 
                                <input type="hidden" name="status" value="1">
                                <button class="btn btn-xs btn-primary" disabled>
                                    Approve
                                </button>
                            </form>
                        </div>
                        @endif
                        @if($exception->status != 2)
                        <div class="pull-left" style="margin-left:10px;">
                            <form action="{{ url('nber/exam/exception') }}/{{ $exception->id }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT"> 
                                <input type="hidden" name="status" value="2">
                                <button class="btn btn-xs btn-primary" disabled>
                                    Reject
                                </button>
                            </form>
                        </div>
                        @endif
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection