@extends('layouts.app')
@section('content')
 
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3> Verify the faculties of {{ $institute->rci_code }} - {{ $institute->name }}
                    
                    <a href="{{ url('nber/verify/facultydetails/') }}" class="btn btn-xs btn-secondary pull-right">Back</a>    

                </h3>
                @include('common.errorandmsg')
                @foreach($faculties as $index => $flist)
                    <h4>{{  $flist['course']->name }}
                        
                    </h4>
                    
                    @if($flist['faculties']->count() == 0)
                        <div class="alert alert-warning">
                            Faculties not found.
                        </div>
                    @else
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>Sl No</th>
                                <th>Name</th>
                                <th>CRR No</th>
                                <th>Qualification</th>
                                <th>Core or Guest/Visiting</th>
                                <th>Subjects</th>
                                <th>Course Coordinator</th>
                                <th>Photo</th>
                            </tr>  
                            <?php 
                                $slno = 1; 
                                $course_coordinator = 0;
                                $core = 0;
                                $verified = 0;
                            ?>
                            @foreach($flist['faculties'] as $i => $faculty)
                                <tr>
                                    <td>
                                        {{ $slno }} <?php $slno++; ?>
                                    </td>
                                    <td>
                                        {{ $faculty->name }}
                                    </td>
                                    <td>
                                        @if(!is_null($faculty->crr_no))
                                        {{ $faculty->crr_no }} 
                                        <br />
                                        @if(\Carbon\Carbon::parse($faculty->crr_expiry) > \Carbon\Carbon::now())
                                            <small class="label label-info">
                                                Active
                                            </small>
                                        @else   
                                            <small class="label label-danger">
                                                Not active
                                            </small>
                                        @endif
                                    @endif
                                    </td>
                                    <td>
                                        {{ $faculty->qualification }}
                                    </td>
                                    <td>
                                        @if($faculty->core==1)
                                            <span class="label label-primary " style="font-size: 9px;">Core Faculty</span>
                                            <?php $core++; ?>
                                        @endif
                                        @if($faculty->core==0)
                                            <span class="label label-warning " style="font-size: 9px;">Guest / Visiting Faculty</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($faculty->subjects))
                                                {{ $faculty->subjects }} 
                                        @else
                                        <small class="label label-danger">
                                            Not Added
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($faculty->course_corordinator_for != 0)
                                            Yes
                                            <?php 
                                                $course_coordinator = $faculty->id ;
                                                $verified = $faculty->verified;
                                            ?>
                                        @endif
                                    </td>
                                    <td>
                                        <img  onerror="javascript:handleError(this)" src="{{ $faculty->photo }}" style="height: 60px;">
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8">
                                    @if($course_coordinator == 0)
                                        Course coordinator details not uploaded. 
                                    @endif
                                    @if($core < 4 && $faculty->course_id != 16 && $faculty->course_id != 20 )
                                        Minimum 4 Core Faculty is required. 
                                    @endif
                                    @if($core < 3 && ($faculty->course_id == 16 || $faculty->course_id == 20) )
                                        Minimum 3 Core Faculty is required. 
                                    @endif
                                    @if(($core > 3 || ($core > 2  && ($faculty->course_id == 16 ||  $faculty->course_id == 20 )) ) && $course_coordinator != 0)
                                        <form action="{{ url('/nber/verify/facultydetails/') }}/{{ $course_coordinator }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="PUT"> 
                                            <input type="hidden" name="verified"  value="{{ $verified }}">
                                            <button type="submit" class="btn btn-xs btn-primary">
                                                @if($verified == 0)
                                                    Verify
                                                @else
                                                    Remove Verification
                                                @endif
                                            </button>
                                        </form>
                                        
                                    @endif 

                                </td>
                            </tr>
                        </table>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('select').selectpicker();
        });
        function handleError(image){
            image.onerror = "";
            image.src = "{{ url('/images/dummy.jpg') }}";
            return true;
        }
    </script>
@endsection