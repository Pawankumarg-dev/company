@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">NI wise Admission</div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>NBER</th>
                            <th>Applications Received</th>
                            <th>Not verified</th>
                            <th>Verified</th>
                            <th>Correction Required</th>
                            <th>Incomplete</th>
                            <th>Rejected</th>
                        </tr>
                        <?php $count = 0; $totalcount = 0;  ?>
                    <?php 
                        $nbers = \App\Nber::all();
                    ?>
                                <?php $approvedprogrammes = \App\Approvedprogramme::where('academicyear_id',Session::get('academicyear_id'))->get(); ?>
                    <?php $fcount = 0; $ftotalcount = 0; $ffilled = 0; $fnotfilled = 0; $mobileverified =0 ; $fmobileverified = 0;  $verified =0 ; $fverified = 0; $pending=0 ; $fpending =0; $totalpendingmobile  = 0;  $ftotalpendingmobile = 0;
                        $incomplete = 0; $fincomplete = 0; $verificationpending =0; $fverificationpending =0; $rejected = 0; $frejected = 0;
                    ?>

{{--                    @foreach($nbers as $nber)
                        <?php $rejected = 0; $verificationpending =0; $incomplete=0; $count = 0; $totalcount = 0; $filled = 0; $notfilled = 0; $mobileverified = 0; $verified=0; $pending = 0; $totalpendingmobile = 0; ?>
                        @foreach($approvedprogrammes as $approvedprogramme)
                            @if($nber->id == $approvedprogramme->programme->nber->id &&  $approvedprogramme->institute_id != 1004)
                                <?php 
                                    $apcount = $approvedprogramme->candidates()->count();
                                    $count += $apcount;
                                    $fcount += $apcount;
                                    $totalcount += $approvedprogramme->maxintake;
                                    $ftotalcount += $approvedprogramme->maxintake;
                                    $mobileverified  += $approvedprogramme->mobileverified($approvedprogramme->id);
                                    $fmobileverified  += $approvedprogramme->mobileverified($approvedprogramme->id);
                                    $verified += $approvedprogramme->approvedcandidatecount($approvedprogramme->id);
                                    $fverified += $approvedprogramme->approvedcandidatecount($approvedprogramme->id);
                                    $pending += $approvedprogramme->pendingcandidatecount($approvedprogramme->id);
                                    $fpending += $approvedprogramme->pendingcandidatecount($approvedprogramme->id);
                                    $incomplete += $approvedprogramme->incomplete($approvedprogramme->id);
                                    $fincomplete += $approvedprogramme->incomplete($approvedprogramme->id);
                                    $verificationpending += $approvedprogramme->verificationpending($approvedprogramme->id);
                                    $fverificationpending += $approvedprogramme->verificationpending($approvedprogramme->id);
                                    $rejected += $approvedprogramme->rejected($approvedprogramme->id);
                                    $frejected += $approvedprogramme->rejected($approvedprogramme->id);
                                    
                                    if($apcount ==0){
                                        $notfilled += 1;
                                        $fnotfilled += 1;
                                    }else{
                                        $filled += 1;
                                        $ffilled += 1;
                                    }
                                ?>
                            @endif
                        @endforeach
                        <tr>
                                    <td>
                                    {{$nber->name_code}}
                                    </td>
                                   
                                    <td>
                                        {{$count}}
                                    </td>
                                    {{--@if(Session::get('academicyear_id')==11)
                                    <td>{{$mobileverified}}</td>
                                    <td>{{$count - $mobileverified}}</td>
                                    @endif --}}
                                    <?php $totalpendingmobile += $count - $mobileverified; ?>
                                    <?php $ftotalpendingmobile += $count - $mobileverified; ?>
                                    <td>{{$verificationpending + $incomplete}}</td>
                                    <td>{{$verified}}</td>
                                    <td>{{$pending}}</td>
                                    <td>{{$incomplete}}</td>
                                    <td>{{$rejected}}</td>
                                </tr>
                    @endforeach
                    <tr>
                        
                    <th>
                                    Total
                                    </th>
                                  
                                    <th>
                                        {{$fcount}}
                                    </th>
                                
                                    <th>
                                        {{$fverificationpending + $fincomplete}}
                                    </th>
                                
                                    <th>{{$fverified}}</th>
                                    <th>{{$fpending}}</th>
                                    <th>{{$fincomplete}}</th>
                                    <th>{{$frejected}}</th>
                    </tr>
                   
                    </table>
--}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Course Admissions </div>
                <div class="panel-body">
                    <?php $count = 0; $totalcount = 0;  ?>
                    <?php $programmes = \App\Programme::where('open_for_admission',1)->get(); ?>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>
                                    Programme
                                </th>
                                <th>Abbreviation</th>
                                <th>NBER</th>
                                <th>Maximum Intake</th>
                                <th>Applications received</th>
                            </tr>
                            @foreach ($programmes as $p)
                                <?php $count = 0; $totalcount = 0;  ?>
                                <?php $approvedprogrammes = \App\Approvedprogramme::where('programme_id',$p->id)->where('academicyear_id',Session::get('academicyear_id'))->get(); ?>
                                @foreach($approvedprogrammes as $approvedprogramme)
                                    <?php 
                                        $count +=  $approvedprogramme->candidates()->count();
                                        $totalcount +=  $approvedprogramme->maxintake;
                                    ?>
                                @endforeach
                                <tr>
                                    <td>{{$p->name}}</td>
                                    <td>{{$p->course_name}}</td>
                                    <td>{{$p->nber->name_code}}</td>
                                    <td>{{$totalcount}}</td>
                                    <td>{{$count}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
</div>
@endsection
