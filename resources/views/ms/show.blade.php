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

            @include('common.errorandmsg')

            <h4> Uploaded Question Papers
                <form action="{{ url('qppublish') }}" method="get">
                    <input type="hidden" name="examschedule_id" value="{{ $examschedule_id }}">
                    <button class="btn btn-xs btn-primary pull-right" style="margin-top: -15px;margin-bottom: 2px;">Back</button>
                </form>
            </h4>
            <table 
                class="table"
            >
                <tr>
                    <th>Course</th>
                    <td>{{$timetable->subject->programme->course_name}}</td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>{{$timetable->subject->scode}} - {{$timetable->subject->sname}}</td>
                </tr>
            </table>
        </div>
    </div>
            
            @if(!is_null($languages))
                @if($languages->count()>0)
              
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
                            @include('ms._parts.tr')
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
            if(sizeInKB > 200){
                swal({
                    type: 'warning',
                    title: 'File size should be less than 200KB',
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
