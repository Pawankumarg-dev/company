@extends('layouts.app')
@section('content')
<script>
    $(document).ready(function() { 

        $('.agent').val(window.navigator.userAgent);

     });

</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            @include('common.errorandmsg')
            <h4>{{$timetable->subject->programme->course_name}}</h4>
            <h5>{{$timetable->subject->scode}} = {{$timetable->subject->sname}} </h5>
            <h5> OMR Code: {{ str_pad($timetable->subject->omr_code,5,'0', STR_PAD_LEFT) }}</h5>
        </div>
    </div>
            
            @if(!is_null($languages))
                @if($languages->count()>0)
            	<div class="row">
        		<div class="col-md-12">
                    <h6>Applied:</h6>
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                SlNo
                            </th>
                            <th>
                                Language
                            </th>
                            <th>
                                Question Paper
                            </th>
                            <th>Upload</th>
                            <th>Delete</th>
                        </tr>
                        <?php $english_added = 0; ?>
                        <?php $gujrati_added = 0; ?>
                        <?php $marathi_added = 0; ?>
                        @foreach($languages as $language)
                            @include('nber.exam.timetable._parts.tr')
                        @endforeach
                    </table>
                    <h6>Not Applied</h6>
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                SlNo
                            </th>
                            <th>
                                Language
                            </th>
                            <th>
                                Question Paper
                            </th>
                            <th>Upload</th>
                            <th>Delete</th>
                        </tr>
                        
                        @foreach($notappliedlanguages as $language)
                            @include('nber.exam.timetable._parts.tr')
                        @endforeach
                    </table>
                </div>
                </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                    <div class="alert alert-danger">No Applications found</div>
                </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection