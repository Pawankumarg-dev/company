
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header" style="margin-top:0;">
                <span>Malpractice Report</span>
                <a class="btn btn-sm btn-success pull-right" href="{{ url('/nber/malpractice/add') }}">Add</a>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">

               @if(request()->success)

                    <div class="alert alert-success alert-dismissible">
                        <button type="button"  class="close"  data-dismiss="alert"  aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ request()->success }}
                    </div>
                @endif

                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr class="bg-primary">
                            <th >Sr. No.</th>
                                                        <th>Exam</th>

                            <th>Enrolment No</th>
                            <th>Candidate Name</th>
                            <th>Programme</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Clo Details</th>

                            <th>Report</th>
                            <th>Status</th>
                            <th>Committee Decision</th>

                        </tr>
                    </thead>

                    <tbody>

                        @if(count($malpractices) > 0)

                            @foreach($malpractices as $index => $malpractice)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>
<td>
                                        {{ $malpractice->exam_name }}
                                    </td>
                                    <td>
                                        {{ $malpractice->enrolmentno }}
                                    </td>

                                    <td>
                                        {{ $malpractice->name }}
                                    </td>

                                    <td>
                                        {{ $malpractice->abbreviation }}
                                       
                                    </td>
                                    <td>
                                        {{ $malpractice->title }}
                                    </td>

                                    <td width="25%">
                                        {{ $malpractice->description }}
                                    </td>
                                    <td>
                                                                  {{ $malpractice->clo }}

                                    </td>

                                    <td>
                                        @if($malpractice->malpractice_report)
                                            <a href="{{ url('/files/malpractice/'.$malpractice->malpractice_report) }}"
                                               target="_blank"
                                               class="btn btn-info btn-xs">
                                                View Report
                                            </a>
                                        @else
                                            <span class="text-danger">
                                                Not Uploaded
                                            </span>
                                        @endif
                                    </td>

                                 

                                    <td>
                                        @if($malpractice->active == 1)
                                            <span class="label label-danger">
                                                Active
                                            </span>
                                        @else
                                            <span class="label label-success">
                                                Malpractice Clear
                                            </span>
                                        @endif
                                    </td>
                                      <td>
                                        @if($malpractice->malpractice_committee_decision)
                                            <a href="{{ url('/files/malpractice/'.$malpractice->malpractice_committee_decision) }}"
                                            target="_blank"
                                            class="btn btn-info btn-xs">
                                                View Decision
                                            </a>
                                        @else
                                            <span class="btn btn-warning btn-xs">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                               
                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="10" class="text-center text-danger">
                                    No Records Found
                                </td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection