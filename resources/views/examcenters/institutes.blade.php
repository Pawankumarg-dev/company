@extends('layouts.app')
@section('content')
<style>
      .center-text{
            text-align: center !important;
        }
</style>
<div class="container">
	<div class="row">
		<div class="col-12">
            
            <h3>Sep-Oct 2023 Examinations - Student Strength</h3>
            <?php $strength = 0; ?>
            <table class="table table-bordered table-striped table-hover">
              
                <th>
                    Course Code
                </th>
                <th>
                    Course
                </th>
                <th>
                    Batch
                </th>
                <th>
                    Institute Code
                </th>
                <th>
                    Institute Namme
                </th>
                <th>
                    NBER
                </th>
                <th>
                    Number of Students
                </th>
                @foreach($approvedprogrammes as $ap)
                    <?php 
                        $count  = DB::select("select  applied_candidate_count  from examstats where approvedprogramme_id = ".$ap->id);
                    ?>
                    @if(implode(array_pluck($count,'applied_candidate_count')) > 0)
                        <tr>
                           
                            <td>
                                {{$ap->programme->course_name}}
                            </td>
                            <td>
                                {{$ap->programme->name}}
                            </td>
                            <td style="width:100px;">
                                {{$ap->academicyear->year}}
                            </td>
                            <td>
                                {{$ap->institute->rci_code}}
                            </td>
                            <td>
                                {{$ap->institute->name}}
                            </td>
                            <td>
                                {{$ap->programme->nber->name_code}}
                            </td>
                            
                            <td class="center-text">
                            <?php print_r(implode(array_pluck($count,'applied_candidate_count')))  ?>
                            <?php $strength += implode(array_pluck($count,'applied_candidate_count')); ?>
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan='6'>Total</td>
                    <th class="center-text">{{$strength}}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection