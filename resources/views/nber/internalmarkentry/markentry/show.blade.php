@extends('layouts.app')
@section('content')
@include('nber.internalmarkentry.markentry._style')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <?php $editshow = 'show'; ?>
            @include('common.errorandmsg')
            @include('nber.internalmarkentry.markentry._alert')
            @include('nber.internalmarkentry.markentry._heading')
            @include('nber.internalmarkentry.markentry._uploadmarksheet')
          
                @include('nber.internalmarkentry.markentry.buttons._editbtn')
      
            @include('nber.internalmarkentry.markentry.buttons._backbtn')
                <table class="table  table-bordered">
                    @include('nber.internalmarkentry.markentry._thead')
                    
                    @foreach ($marks as $internal)
                    <tr>
                            
                            @include('nber.internalmarkentry.markentry._commoncolumns')
                            <?php $slno++; ?>
                            @foreach ($subjects as $subject )
                                <td class="text-center">
                                    <?php 
                                        $mark = isset($internal[$subject->scode]) ? $internal[$subject->scode] : 0; 
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

        </div>
    </div>
</div>
@endsection