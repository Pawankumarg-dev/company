@extends('layouts.app')

@section('content')
<?php $approvedprogrammes = \App\Approvedprogramme::where('academicyear_id',Session::get('academicyear_id'))->get(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>Code</th>
                    <th>Institute</th>
                    <th>Course</th>
                    <th>Course Code</th>

                    <th>Max Intake</th>
                    <th>Applications Received</th>
                </tr>
                <?php $count = 0; $totalcount = 0;?>
            @foreach($approvedprogrammes as $approveprogramme)
                @if($approveprogramme->candidates()->count()>0 &&  $approveprogramme->institute_id != 1004)
                    <tr>
                        <td>
                        {{$approveprogramme->institute->user->username}}
                        </td>
                        <td>
                            {{$approveprogramme->institute->name}}
                        </td>
                        <td>
                            {{$approveprogramme->programme->course_name}}
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
                    </tr>
                    <?php 
                        $count += $approveprogramme->candidates()->count();
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
        </div>
    </div>
</div>