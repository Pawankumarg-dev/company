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
          
            <h4>Upload Question Paper
                <form action="{{ url('qp/exam/timetable') }}" method="get">
                    {{ csrf_field() }}
                    <input type="hidden" name="course_id" value="{{ $timetable->subject->programme->course_id }}">
                    <input type="hidden" name="programme_id" value="{{ $timetable->subject->programme_id }}">

                    <button class="btn btn-xs btn-primary pull-right" style="margin-top: -15px;margin-bottom: 2px;">Back</button>
                </form>
            </h4>
            <table 
                class="table"
            >
                <tr>
                    <th>Course</th>
                    <td> @if(strlen($omr_code) == 4) Common @else
                        {{$timetable->subject->programme->course_name}}  @endif
                          </td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>
                        <td> @if(strlen($omr_code) == 4) Multiple @else
                        {{$timetable->subject->scode}} - {{$timetable->subject->sname}}  @endif
                        </td> 
                </tr>
                <tr>
                    <th>OMR Code</th>
                    <td>{{$omr_code}}</td>
                </tr>
            </table>
        </div>
    </div>
            
            @if(!is_null($languages))
                @if($languages->count()>0)
            	<div class="row">
        		<div class="col-md-6">
                    <div class="alert alert-secondary">
                        <form action="{{ url('qp/updatepwd') }}" method="post">
                            <input type="hidden" name="examtimetable_id" value="{{ $timetable->id }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="password">Pdf  password:</label>
                                <input type="text" name="password" id="password" value="{{$timetable->password}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary form-control">
                                    @if(!is_null($timetable->password))
                                        Update 
                                    @else
                                        Save
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
              
                <div class="col-md-12">
                   
                    <div class="alert alert-warning">
                        <ul>
                            <li>
                                Question papers should be in pdf format only.
                            </li>
                            <li>
                                It is mandatory to upload 3 sets.
                            </li>
                            <li>
                                Translated versions of each sets should match.
                            </li>
                            <li>
                                Each pdf uploaded should be encrypted with a strong password.
                            </li>
                            <li>
                                Please save the password in the above box.
                            </li>
                            <li>
                                Maximum file size is 200KB.
                            </li>
                        </ul>
                        
                    </div>
                </div>
                    <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th rowspan="2">
                                SlNo
                            </th>
                            <th rowspan="2">
                                Language
                            </th>
                            <th rowspan="2" class="hidden">
                                Question Paper
                            </th>
                            <th colspan="3">Upload</th>
                            <th rowspan="2" class="hidden">

                            Delete</th>
                        </tr>
                        <tr>
                            <td>Set #1</td>
                            <td>Set #2</td>
                            <td>Set #3</td>
                        </tr>
                        @foreach($languages->sortBy('language') as $language)
                            @if($language->language != 'Not_Applicable')
                            @include('director.exam.timetable._parts.tr')
                            @endif
                            <?php $slno++; ?>
                        @endforeach
                    </table>
                   
                </div>
                </div>
                @else
                	<div class="row hidden">
                        <div class=" col-md-12">
                    <div class="alert alert-danger">No Applications found</div>
                </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
<script>
       function openInput(qpid,lid,set){
            $('#input_'+qpid+'_'+lid+'_'+set).click();
        }
    $(document).ready(function(){
        $('.upload').on('change',function(){
            var sizeInKB = this.files[0].size/1024;
            if(sizeInKB > 800){
                swal({
                    type: 'warning',
                    title: 'File size should be less than 500KB',
                    showConfirmButton: false,
                    timer: 3000
                });
                $(this).val(null);
                return false;
            }
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'pdf':
                    break;
                case 'PDF':
                    break;
                case 'Pdf':
                    break;
                default:
                    swal({
                        type: 'warning',
                        title: 'This is not an allowed file type.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $(this).val(null);
                    return false;
            }
            var timetable = $(this).data('timetable');
            var language = $(this).data('language');
            var set = $(this).data('set');
            var form="form_"+timetable+"_"+language+"_"+set;
            console.log(form);
            $('#'+form).submit(); 
        });
    });
</script>


@endsection
