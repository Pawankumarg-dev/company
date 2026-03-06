@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>    Exam  Application -  
                    {{ $exam->examtype->name }}, 
                    {{$exam->name}}</h4>
                @include('common.errorandmsg')
                <?php $slno = 1; ?>
                
                @if(!is_null($subjects) && $subjects->count()> 0)
                   
                    @if(!is_null($applicant))
                    <div  class="alert alert-danger">
                        <ul>
                                  Please review your exam application details.
                          </ul>  
                    </div>
                    @endif
                    <a href="{{ url('student/exam/applications?view=confirm') }}"   class="btn btn-primary">Confirm and Submit</a>
                    <a href="{{ url('student/exam/applications?view=resubmit') }}"   class="btn btn-danger">Edit Application</a>
                    <br /><br/> 
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th>Name</th>
                            <td>{{ $candidate->name }}</td>
                        </tr>
                        <tr>
                            <th>Enrolment No</th>
                            <td>{{ $candidate->enrolmentno }}</td>
                        </tr>
                        <tr>
                            <th>Father Name</th>
                            <td>{{ $candidate->fathername }}</td>
                        </tr>
                        <tr>
                            <th>DOB</th>
                            <td>{{ $candidate->dob }}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td>
                                <img src="{{ url('files/enrolment/photos') }}/{{ $candidate->photo }}" alt="">
                            </td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td>
                                {{ $candidate->approvedprogramme->programme->course_name }} - {{ $candidate->approvedprogramme->programme->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>Institute</th>
                            <td>
                                {{ $candidate->approvedprogramme->institute->rci_code }} - {{ $candidate->approvedprogramme->institute->name }}
                            </td>
                        </tr>
                    </table>
                    <form action="{{ url('student/exam/applications?view=confirm') }}" method="POST"  enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <?php $notapplied = 0; ?>
                        <h4>Applied:</h4>
                        <ul>
                            @foreach($subjects as $s)
                                @if($s->application_status == 1)
                                    <li>
                                        Term: {{ $s->term }},  {{ $s->type }}  <b>{{ $s->scode }}</b> {{  $s->sname }}  
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <h4>Not Applied:</h4>
                        <ul>
                            @foreach($subjects as $s)
                                @if($s->application_status != 1)
                                    <?php $notapplied +=1; ?>
                                    <li>
                                        <b>{{ $s->scode }}</b> {{  $s->sname }}  
                                    </li>
                                @endif
                            @endforeach
                            @if($notapplied==0)
                                    <li>None</li>
                            @endif
                        </ul>
                            <h4>Preferred Language</h4>
                            <ul>
                                @foreach($languages as $l)
                                        @if(!is_null($applicant) && $applicant->language_id==$l->id)
                                            <li>
                                                {{ $l->language }} 
                                            </li>
                                         @endif
                                @endforeach
                            </ul>
                        
                        <a href="{{ url('student/exam/applications?view=confirm') }}"   class="btn btn-primary">Confirm and Submit</a>
                        <a href="{{ url('student/exam/applications?view=resubmit') }}"   class="btn btn-danger">Edit Application</a>
                @endif
            </div>
        </div>
    </div>

    <style>

        .bg-transparent{
            background: transparent!important;
            border:1px solid #777;
            color: #444;
        }
    </style>

<script>
    $(function() {
        $('#document').on('change',function(){
            var sizeInKB = this.files[0].size/1024;
            if(sizeInKB > 100){
                swal({
                    type: 'warning',
                    title: 'File size should be less than 100KB',
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#document').val(null);
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
                    $('#document').val(null);
                    return false;
            }
        });
    });
</script>
@endsection