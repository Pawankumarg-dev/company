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
                <h3>{{ $exam->name }} Examinations</h3>
                @include('common.errorandmsg')
                <table class="table">
                    <tr>
                        <th>Course</th>
                        <td>{{ $timetable->subject->programme->course_name }}</td>
                    </tr>
                    <tr>
                        <th>Subject Code</th>
                        <td>{{ $timetable->subject->scode }}</td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $timetable->subject->sname }}</td>
                    </tr>
                    <tr>
                        <th>
                            No Students applied
                        </th>
                        <td>
                            {{ $status->no_of_applications }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            No Students attended
                        </th>
                        <td>
                            {{ $status->no_of_present }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            No of students - pending to mark attendance
                        </th>
                        <td>
                            {{ $status->pending_to_mark_attendance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Verified attendance
                        </th>
                        <td>
                            {{ $status->verified_attendance }}
                        </td>
                    </tr>
                    <tr>
                        <th>QP Set Released</th>
                        <td>{{ $timetable->examschedule->qpset }}</td>
                    </tr>
                    <tr>
                        <th>QP Password</th>
                        <td>{{ $timetable->password }}</td>
                    </tr>
                    <tr>
                        <th>
                            Question Paper
                        </th>
                        <td>
                            @if ($timetable->languages()->count() > 0)
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th>
                                            SlNo
                                        </th>
                                        <th>
                                            Language
                                        </th>
                                        <th>
                                            Question Paper
                                        </th>
                                    </tr>
                                    @foreach ($timetable->languages as $language)
                                        @include('nber.exam.answerkey._parts.tr')
                                        <?php $slno++; ?>
                                    @endforeach
                                </table>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Languages
                        </th>
                        <td>
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <td>SlNo.</td>
                                        <td>Language</td>
                                        <td>No of papers</td>
                                    </tr>
                                    <?php $slno = 1; ?>
                                    @if(!is_null($languages))
                                        @foreach($languages as $l)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $slno }}
                                                    <?php $slno++ ; ?>
                                                </td>
                                                <td>
                                                    {{ $l->language }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $l->no_of_applications }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Answer Key
                        </th>
                        <th>
                            <?php $answerkey = $timetable->answerkeys()->first(); ?>
                            @if (!is_null($answerkey))
                                <a href="{{ url('files/answerkeys') }}/{{ $answerkey->answerkey }}"
                                    target="_blank">Download</a>
                                <br />
                            @endif

                            <form action="{{ url('nber/exam/answerkeys') }}/{{ $timetable->id }}" method="post"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <table class="table">
                                    <tr>
                                        <td>Answer Key</td>
                                        <td>Total Marks</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="upload" type="file" name="answerkey" required
                                                accept="application/pdf">
                                        </td>
                                        <td>
                                            <input style="width:60px;" type="number" required name="total_marks"
                                                @if (!is_null($answerkey)) value="{{ (int) $answerkey->total_marks }}" @endif>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-primary" >Upload</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Evaluators
                    <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#evaluators">
                        Add
                    </button>
                </h3>
                <table class="table table-boardered">
                    <tr>
                        <th>
                            SlNo
                        </th>
                        <th>CRR No</th>
                        <th>
                            Name
                        </th>
                      
                        <th>
                            Language
                        </th>
                    </tr>
                    <?php $slno = 1;  ?>
                    @foreach($evaluators as $e)
                        @if(!is_null($e->faculty))
                            <tr>
                                <td>
                                    {{$slno}}
                                    <?php $slno++; ?>
                                </td>
                                <td>{{ $e->faculty->crr_no }}</td>
                                <td>
                                    {{ $e->faculty->name }}
                                </td>
                                
                            
                                <td>
                                    {{ $e->language->language }}
                                </td>
                                <td>
                                    <form action="{{ url('nber/exam/subjectofevaluator') }}/{{ $e->id }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-xs btn-danger @if($exam->id != 27) hidden @endif">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Question Pattern
                    <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#pattern">
                        Add
                    </button>
                </h3>
                <table class="table table-boardered">
                    <tr>
                        <th>
                            SlNo
                        </th>
                        <th>Page No</th>
                        <th>
                            Heading
                        </th>
                        <th>
                            Number of questions
                        </th>
                        <th>
                            Number of questions to answer
                        </th>
                        <th>
                            Marks per question
                        </th>
                        <th>
                            Marks (Sub total)
                        </th>
                        <th></th>
                    </tr>
                    <?php $slno = 1;  ?>
                    @foreach($patterns as $p)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>{{ $p->pagenumber }}</td>
                            <td>
                                {{ $p->heading }}
                            </td>
                            
                            <td>
                                @if($p->number_of_questions > 0)
                                    {{ $p->number_of_questions }}
                                @endif
                            </td>
                            <td>
                                @if($p->number_of_questions > 0)
                                    {{ $p->number_of_questions_to_answer }}
                                @endif
                            </td>
                            <td>
                                @if($p->number_of_questions > 0)
                                    {{ $p->marks_per_question }}
                                @endif 
                            </td>
                            <td>
                                @if($p->number_of_questions > 0)
                                    {{ $p->marks_per_question *  $p->number_of_questions_to_answer  }}
                                @endif 
                            </td>
                            <td>
                                <form action="{{ url('nber/exam/pattern') }}/{{ $p->id }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-xs btn-danger hidden">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pattern" tabindex="-1" role="dialog" aria-labelledby="modalPattern"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabelSmall">Add Heading / Marks</h4>
                </div>
                <form 
                    action="{{ url('nber/exam/pattern') }}/{{ $timetable->id }}"
                    method="post"
                >
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="examtimetable_id" value="{{ $timetable->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="heading">Heading / Subheading</label>
                            <input type="text" class="form-control" placeholder="Ex: Section A / State True or False / Answer ALL questions in one or two sentences" name="heading">
                        </div>
                        <div class="form-group">
                            <label for="pagenumber">Page Number</label>
                            <input type="text" class="form-control" name="pagenumber"  onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="number_of_questions">Number of questions</label>
                            <small class="text-muted">Leave this  blank to add main heading (Ex: Section A/ Part I etc)</small>
                            <input type="text" class="form-control" name="number_of_questions" id="number_of_questions"  onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="number_of_questions_to_answer">Number of questions to answer</label>
                            <input type="text" class="form-control" name="number_of_questions_to_answer" id="number_of_questions_to_answer"  onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="marks_per_question">Marks / question </label>
                            <input type="text" class="form-control" name="marks_per_question" id="marks_per_question" step=".1"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && $(this).val().indexOf('.') === -1)">
                        </div>
                        <div class="form-group">
                            <label for="marks_per_question">Sub Total</label>
                            <input type="text" id="subtotal" class="form-control" disabled >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="evaluators" tabindex="-1" role="dialog" aria-labelledby="modalEvaluators"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabelSmall">Evaluator</h4>
                </div>
                <form 
                    action="{{ url('nber/exam/subjectofevaluator') }}/{{ $timetable->id }}"
                    method="post"
                >
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="examtimetable_id" value="{{ $timetable->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="heading">Evaluator</label>
                            <select name="evaluator_id" id="evaluator_id" class="form-control" data-live-search="true">
                                @foreach($allevaluators as $e)

                                    <option value="{{ $e->id }}">{{ $e->name }} - CRR: {{ $e->crr_no }}  </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="heading">Language</label>
                            <select name="language_id" id="language_id" class="form-control">
                                @foreach($languages as $l)
                                    <option value="{{ $l->id }}">{{ $l->language }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
        <script>
      
    $(document).ready(function() {
                $('select').selectpicker();
            });
    function subtoal(){
        $('#subtotal').val(parseFloat($('#marks_per_question').val()) * parseInt($('#number_of_questions_to_answer').val()) || 0 );
    }
    $(document).ready(function() {
        subtoal();
        $('#number_of_questions').on('change',function(){
            $('#number_of_questions_to_answer').val($('#number_of_questions').val());
            subtoal();
        });
        $('#number_of_questions_to_answer').on('change',function(){
            if(parseInt($('#number_of_questions_to_answer').val()) > parseInt($('#number_of_questions').val())){
                alert('Number of questions to answer cannot be more than number of questions');
            }
            subtoal();
        });
        $('#marks_per_question').on('change',function(){
            subtoal();
        });
        $('.upload').on('change', function() {
            var sizeInKB = this.files[0].size / 1024;
            if (sizeInKB > 300) {
                swal({
                    type: 'warning',
                    title: 'File size should be less than 300KB',
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
        });
    });
</script>
@endsection
