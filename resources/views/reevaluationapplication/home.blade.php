@extends('layouts.reevaluationapplication')
@section('content')

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{$title}}
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    New Application
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <ul>
                                                    <li style="margin-left: -25px; !important;">
                                                        @if($reevaluation->lastdate->format('Y-m-d') >= date('Y-m-d'))                                                            
                                                        <a href="{{url('/reevaluationapplication/confirmcandidate/'.$exam->id)}}">
                                                            Click here
                                                        </a> to apply for New Application
                                                        @else
                                                        <span class="red-text">Application Link closed</span>
                                                        @endif                                                        
                                                    </li>
                                                    @if($reevaluation->exam_id === 17)
                                                    <li style="margin-left: -25px; !important;">
                                                        <a href="http://www.niepmdexaminationsnber.com/assets/documents/downloads/Instructions-27092021.pdf" target="_blank">General Instructions for Online Re-Evaluation Application</a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Online Re-Evaluation Application (if already applied)
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <form role="form" method="POST"
                                                      action="{{url('/reevaluationapplication/login/checkapplicationnumber/')}}" autocomplete="off" accept-charset="UTF-8">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

                                                    @if (Session::has('messages'))
                                                        @include('common.errorandmsg')
                                                    @endif

                                                    <div class="form-group {{ $errors->has('application_number') ? 'has-error' : '' }}">
                                                        <div class="col-sm-12">
                                                            @if (count($errors) > 0)
                                                                <div class="alert alert-danger">
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="blue-text" for="application_number">Re-Evaluation Application No.:</label>
                                                        <input type="text" class="form-control" id="application_number" name="application_number" placeholder="Re-Evaluation Application No." />
                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#applicationnumber').keyup(function () {
                                                                    $(this).val($(this).val().toUpperCase());
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p class="alert alert-danger">Last date for applying is {{ $reevaluation->lastdate->format('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            Please contact NIEPMD-NBER in case of any queries
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

