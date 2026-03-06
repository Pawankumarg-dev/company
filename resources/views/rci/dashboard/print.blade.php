<?php $approvedprogrammes = \App\Approvedprogramme::where('academicyear_id',11)->get(); ?>
<style>
    table, td, th{
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
        font-size: 10px;
        text-align: center;
    }
    .page-break {
        page-break-after: always;
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
                                    <?php $co = $approveprogramme->candidates()->count(); ?>
                                    {{$co}}
                                </td>
                                <td>
                                    <?php $ver = \App\Candidate::where('approvedprogramme_id',$approveprogramme->id)->where('is_mobile_number_verified','Yes')->count(); ?>
                                    {{$ver}}
                                    
                                    <?php 
                                        if($ver < $co){
                                           /*  echo '<tabele><tr><td>Candidate</td><td>Number</td><td>Status</td></tr>';
                                            $notverified = \App\Candidate::where('approvedprogramme_id',$approveprogramme->id)->where('is_mobile_number_verified','!=','Yes')->get();
                                           foreach($notverified as $nv){
                                                $canc = \App\Candidate::where('contactnumber',$nv->contactnumber)->count();
                                                if($canc > 1){
                                                    echo '<tr><td>'.$nv->name.'</td><td>'.$nv->contactnumber.'</td><td> Multiple Candidates </td></tr>';
                                                }
                                                if($canc == 1){
                                                    if($nv->user_id == null){
                                                        $usercount = \App\User::where('username',$nv->contactnumber)->count();
                                                        if($usercount > 1){
                                                            echo '<tr><td>'.$nv->name.'</td><td>'.$nv->contactnumber.'</td><td>  Multiple users in users table. </td></tr>';
                                                        }
                                                        if($usercount == 1){
                                                            $user = \App\User::where('username',$nv->contactnumber)->first();
                                                            $nv->user_id = $user->id;
                                                            $nv->save();
                                                            echo '<tr><td>'.$nv->name.'</td><td>'.$nv->contactnumber.'</td><td>  Mapped user </td></tr>';
                                                        }
                                                        if($usercount == 0){
                                                            echo '<tr><td>'.$nv->name.'</td><td>'.$nv->contactnumber.'</td><td>  User not created. </td></tr>';
                                                        }

                                                    }else{
                                                        echo '<tr><td>'.$nv->name.'</td><td>'.$nv->contactnumber.'</td><td> User already found. Not confirmed. </td></tr>';
                                                    }
                                                }

                                            } 
                                            echo '</table>';*/
                                        }
                                    ?>
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