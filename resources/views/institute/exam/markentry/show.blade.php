@extends('layouts.app')
@section('content')
@include('institute.exam.markentry._style')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <?php $editshow = 'show'; ?>
            @include('common.errorandmsg')
            @include('institute.exam.markentry._alert')
            @include('institute.exam.markentry._heading')
            @include('institute.exam.markentry._uploadmarksheet')


 {{-- @if(($approvedprogramme->institute_id == 'rrr')) --}}
 @include('institute.exam.markentry.buttons._editbtn')
 {{-- @endif --}}





            @if(!is_null($marksheet) && ($marksheet->id > 9655 || $totalmark == 0 ) )



                {{--     @include('institute.exam.markentry.buttons._editbtn') --}}
            @endif
            @include('institute.exam.markentry.buttons._backbtn')
            @if(!is_null($marksheet))
                <table class="table  table-bordered">
                    @include('institute.exam.markentry._thead')
                    
                    @foreach ($marks as $internal)
                    <tr>
                            
                            @include('institute.exam.markentry._commoncolumns')
                            <?php $slno++; ?>
                            @foreach ($subjects as $subject )
                                <td class="text-center">
                                    <?php 
                                        $mark = $internal[$subject->scode]; 
                                        if($mark==0){ $mark = '';}
                                        if($mark==-1){ $mark = 0;}
                                        if($mark==-2){ $mark = 'Absent';}
                                    ?>
                                    {{$mark}}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
                @if($slno == 1)
                    <div class="alert alert-danger">
                        Not applicants found.
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection