<?php $approvedprogrammes = \App\Approvedprogramme::where('academicyear_id',11)->get(); ?>
<style>
    table, td, th{
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
        font-size: 10px;
        text-align: center;
    }
</style>
<table class="table">
                        <tr>
                            <th>Code</th>
                            <th style="text-align:left;">Institute</th>
                            <th>Contact Number</th>
                            <th>Course</th>
                            <th>Course Code</th>
                            <th>NBER</th>
                            <th>Max Intake</th>
                            <th>Applications Received</th>
                            <th>Application mobile OTP verified</th>
                        </tr>
                        <?php $count = 0; $totalcount = 0;?>
                    @foreach($approvedprogrammes as $approveprogramme)
                        @if($approveprogramme->institute_id != 1004)
                            <tr>
                                <td >
                                {{$approveprogramme->institute->user->username}}
                                </td>
                                <td  style="text-align:left;">
                                    {{$approveprogramme->institute->name}}
                                </td>
                                <td>
                                    {{$approveprogramme->institute->contactnumber1}}
                                </td>
                                <td>
                                    {{$approveprogramme->programme->course_name}}
                                </td>

                                <td>
                                    {{$approveprogramme->programme->nber->name_code}}
                                </td>
                                <td>
                                    {{$approveprogramme->programme->code}}
                                </td>
                                <td>
                                    {{$approveprogramme->maxintake}}
                                </td>
                                <td>
                                    {{$approveprogramme->candidates()->count()}}
                                </td>
                                <td>
                                    {{\App\Candidate::where('approvedprogramme_id',$approveprogramme->id)->where('is_mobile_number_verified','Yes')->count()}}
                                    
                                </td>
                            </tr>
                            <?php 
                                $count += $approveprogramme->candidates()->count();
                               // $approveprogramme->enrolment_count =  $approveprogramme->candidates()->count();
                                //$approveprogramme->save();
                            ?>
                        @endif
                        <?php 
                        $totalcount += $approveprogramme->maxintake;
                        ?>
                    @endforeach
                    <td>
                            <th></th>
                            <th></th>
                            <th>Total Intake: {{$totalcount}}</th>
                            <th>Enrolled: {{$count}}</th>
                        </td>
                    </table>