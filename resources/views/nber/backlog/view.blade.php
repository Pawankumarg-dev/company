@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
            
            @if (Session::has('error') )
                <div class="alert alert-danger">
                    {{Session::get('error') }}
                </div>
                <?php Session::forget('error'); ?>

            @endif
            @if (Session::has('messages') )
                <script>
                    $(document).ready(function () {
                        //$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
                        swal({
                            type: 'success',
                            title: '{{Session::get('messages')}}',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                    <?php Session::forget('messages'); ?>
                </script>
            @endif
            <h4>Mark Entry  - {{Session::get('examname')}} Exam</h4>
            <h6>
                {{$approvedprogramme->institute->rci_code}} - 
                {{$approvedprogramme->institute->name}}
            </h6>
            <h5 class="text-muted">
                {{$approvedprogramme->programme->course_name}} - {{$approvedprogramme->programme->name}} - 
                @if($subject->syear==2)
                    II Year
                @else
                    I Year
                @endif
            </h5>
            <h4>
                {{$subject->scode}} - {{$subject->sname}} - ({{$subject->subjecttype->type}})
            </h4>
         
                <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>SlNo</th>
                        <th>
                            Student Name
                        </th>
                        <th>
                            Enrolment Number
                        </th>
                            <th>
                                Internal Mark 
                            </th>
                            <th>
                                External Mark 
                            </th>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($applications as $a)
                        <tr>
                            <td class="text-center">{{$slno}}<?php $slno++; ?></td>
                            <td>
                                {{$a->candidate->name}}
                            </td>
                            <td>
                                {{$a->candidate->enrolmentno}}
                            </td>
                            <td>
                                {{$a->internal_mark}}
                            </td>
                            <td>
                                {{$a->external_mark}}
                            </td>
                        </tr>
                    @endforeach
                </table>
        </div>
    </div>
</div>
@endsection