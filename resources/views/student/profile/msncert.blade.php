@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            @include('common.errorandmsg')
                <!-- <div class="panel panel-success">
                <div class="panel-heading">
                    Marksheets and Certificate
                </div>
                <div class="panel-body">
                
                @if(!is_null($candidate->currentapplicant))
                @if(!is_null($candidate->currentapplicant->sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->term_one_result_id) && $candidate->currentapplicant->first_year_pappers > 0)
                        <li>
                        <a href="{{url('student/marksheet')}}/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                        </li>
                    @endif
                    @endif
                    @if(!is_null($candidate->currentapplicant))
                    @if(!is_null($candidate->currentapplicant->sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->term_two_result_id))
                        <li>
                        <a href="{{url('student/marksheet')}}/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                        </li>
                    @endif
                    @endif
                    @if(!is_null($candidate->currentapplicant))
                    @if(!is_null($candidate->currentapplicant->slno_certificate) && $candidate->currentapplicant->final_result == 1)
                        <li>
                        <a href="{{url('student/certificate')}}/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                        </li>
                    @endif
                    @endif
                  
                </div>
                </div>
                    -->
                    <H5>Marksheets and Certificate</H5>
                    <div class="alert alert-success">

                        Click <a href="{{url('examapplication')}}"> here </a> to view supplementary examination result.

                    </div>
                <table class="table table-bordered table-condensed ">
                <tr>
                    <th>
                        Exam
                    </th>
                    <th>
                        Marksheet / Certificate
                    </th>
                    <th>
                        Result
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Download
                    </th>
                </tr>
                
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->term_one_result_id) )
                <tr>
                    <td>
                        Sep - Oct 2023
                    </td>
                    <td>
                        Term One Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/marksheet')}}/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->term_two_result_id))
                    <tr>
                        <td>
                            Sep - Oct 2023
                        </td>
                    <td>
                        Term Two Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/marksheet')}}/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->slno_certificate) && is_null($candidate->currentapplicant->reevaluation_slno_certificate))
                    <tr>
                        <td>
                            Sep - Oct 2023
                        </td>
                    <td>
                        Certificate
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/certificate')}}/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                    </td>
                    </tr>
                @endif
                <?php $result = $candidate->supplimentaryresults->first() ; ?>

                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->reevaluation_term_one_result_id) )
                <tr>
                    <td>
                        Sep - Oct 2023
                    </td>
                    <td>
                        Term One Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/marksheet')}}/re/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->reevaluation_term_two_result_id))
                <tr>
                    <td>
                        Sep - Oct 2023
                    </td>
                    <td>
                        Term Two Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/marksheet')}}/re/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_slno_certificate))
                    <tr>
                        <td>
                            Sep - Oct 2023
                        </td>
                    <td>
                        Certificate  (Reevaluated)
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('student/certificate')}}/re/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                    </td>
                    </tr>
                @endif

                
                @if(!is_null($candidate->supplimentaryresults) && $candidate->supplimentaryresults->count() > 0)
                    @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                            <td>
                                April 2024
                            </td>
                            <td>
                                 Term One Marksheet
                            </td>
                            <td>
                                @if($result->first_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif 
                                @if($result->first_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadsupms')}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> 
                            </td>
                        </tr>
                    @endif
                    @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                            <td>
                                April 2024
                            </td>
                            <td>
                                 Term Two Marksheet
                            </td>
                            <td>
                                @if($result->second_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif
                                @if($result->second_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadsupms')}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a>
                            </td>
                        </tr>
                    @endif
                   @if(!is_null($result->slno_certificate))
                    <tr>
                        <td>
                            April 2024
                        </td>
                        <td>
                             Certificate
                        </td>
                        <td>
                            <span style="color:green;">Pass</span>
                        </td>
                        <td>
                            {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}

                        </td>
                        <td><a href="{{url('candidate/downloadsupcert')}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a></td>
                    </tr>
                   @endif
                @endif
                 
                <?php $result = $candidate->newresults->first() ; $newapplicant = \App\Newapplicant::where('candidate_id',$candidate->id)->first(); ?>  
                
                @if( !is_null($newapplicant) && !is_null($candidate->newresults) && $candidate->newresults->count() > 0 && $newapplicant->payment_status==1)
                    @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                            <td>
                                June 2024
                            </td>
                            <td>
                                 Term One Marksheet
                            </td>
                            <td>
                                @if($result->first_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif 
                                @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjuly2024ms')}}/{{$candidate->id}}/1">Download First Year Marksheet</a> 
                            </td>
                        </tr>
                    @endif
                    @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                            <td>
                                June 2024
                            </td>
                            <td>
                                 Term Two Marksheet
                            </td>
                            <td>
                                @if($result->second_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif
                                @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjuly2024ms')}}/{{$candidate->id}}/2">Download Second Year Marksheet</a>



                            </td>
                        </tr>
                    @endif
                   @if(!is_null($result->slno_certificate))
                  
                    <tr>
                        <td>
                            June 2024
                        </td>
                        <td>
                             Certificate
                        </td>
                        <td>
                            <span style="color:green;">Pass</span>
                        </td>
                        <td>
                            {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
    
                        </td>
                        <td><a href="{{url('candidate/downloadjuly2024cert')}}/{{$candidate->id}}">Download Certificate</a></td>
                    </tr>
                   @endif
                
                  

 @if(!is_null($candidate->newresultreevaluations) && $candidate->newresultreevaluations->count() > 0)
                
                 <?php $result = $candidate->newresultreevaluations->first() ; ?>
                
                  @if($result->status_id == 1)
                     @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                           <td>July 2024</td>
                           <td>Term One Marksheet (Reevaluated)</td>
                           <td>
                              @if($result->first_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('student/downloadjuly2024msre')}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> </td>
                        </tr>
                     @endif
                     @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                           <td>July 2024</td>
                           <td>Term Two Marksheet (Reevaluated)</td>
                           <td>
                              @if($result->second_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('student/downloadjuly2024msre')}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a> </td>
                        </tr>
                     @endif
                     @if(!is_null($result->slno_certificate))
                        <tr>
                           <td>July 2024</td>
                           <td>Certificate (Reevaluated)</td>
                           <td>
                              <span style="color:green;">Pass</span>
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
                           </td>
                           <td><a href="{{url('student/downloadjuly2024certre')}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a></td>
                        </tr>
                     @endif
                  @endif
               @endif
        
                   
                @endif
                   
  <?php 
    $display=0; 

  $after_2025_allresults = \App\Allresult::where('candidate_id', $candidate->id)->where('status_id', 1)->get()->groupBy('exam_id'); 

  ?>

@foreach($after_2025_allresults as $examGroup)
    @foreach($examGroup as $result)
                   

                   
                <?php $newapplicant = \App\Allapplicant::where('candidate_id',$candidate->id)->where('exam_id',$result->exam_id)->first(); ?>  
                
                @if($newapplicant->blocked !=1 && $newapplicant->payment_status==1)
                    @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                            <td>
                               {{ $result->exam->name ?? 'Exam' }}
                            </td>
                            <td> 
                                 Term One Marksheet
                            </td>
                            <td>
                                @if($result->first_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif 
                                @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjan2025ms')}}/{{$result->exam_id}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> 
                            </td>
                        </tr>
                    @endif
                    @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                            <td>
                                {{ $result->exam->name ?? 'Exam' }}
                            </td>
                            <td>
                                 Term Two Marksheet
                            </td>
                            <td>
                                @if($result->second_year_result == 1)
                                    <span style="color:green;">Pass</span>
                                @endif
                                @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjan2025ms')}}/{{$result->exam_id}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a>

                            </td>
                        </tr>
                    @endif
                   @if(!is_null($result->slno_certificate) && is_null($result->slno_certificate_re))
                  <?php $display=1; ?>

                    <tr>
                        <td>
                           {{ $result->exam->name ?? 'Exam' }}
                        </td>
                        <td>
                             Certificate
                        </td>
                        <td>
                            <span style="color:green;">Pass</span>
                        </td>
                        <td>
                            {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
    
                        </td>
                        <td>
                            <a href="{{url('candidate/downloadjan2025cert')}}/{{$result->exam_id}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a> <br>
                            @if($result->exam_id > 26)
                            @if(is_null($candidate->crr))
                           
                            <form id="crrForm" action="{{url('/')}}/api/crr/response-data" method="POST">
                                {{ csrf_field() }}
                            <input type="hidden" name="enrollment" value="{{$candidate->enrolmentno}}">
                            <input type="hidden" name="dob" value="{{$candidate->dob}}">

                            <button type="submit" id="submitBtn" class="btn btn-success">Get Your CRR</button>

                            </form>

                            <script>
                                document.getElementById('crrForm').addEventListener('submit', function (e) {
                                    const button = document.getElementById('submitBtn');
                                    button.disabled = true; // disable button
                                    button.textContent = 'Please wait...'; // optional loading text
                                });
                                </script>
                            @else

                            <a href="https://rciregistration.nic.in/rehabcouncil/nber_printing_crr.jsp?crr={{$candidate->crr}}">Download Your CRR</a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    
                   @endif

                    @if(!is_null($result->marksheet_sl_no_first_year_re))
                        <tr>
                            <td>
                               {{ $result->exam->name ?? 'Exam' }}
                            </td>
                            <td> 
                                 Term One Marksheet (Re-evaluation)
                            </td>
                            <td>
                                @if($result->first_year_result_re == 1)
                                    <span style="color:green;">Pass</span>
                                @endif 
                                @if(!is_null($result->first_year_result_re) && $result->first_year_result_re == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date_re)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjan2025msre')}}/{{$result->exam_id}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> 
                            </td>
                        </tr>
                    @endif
                    @if(!is_null($result->marksheet_sl_no_second_year_re))
                        <tr>
                            <td>
                                {{ $result->exam->name ?? 'Exam' }}
                            </td>
                            <td>
                                 Term Two Marksheet (Re-evaluation)
                            </td>
                            <td>
                                @if($result->second_year_result_re == 1)
                                    <span style="color:green;">Pass</span>
                                @endif
                                @if(!is_null($result->second_year_result_re) && $result->second_year_result_re == 0)
                                    <span style="color:red;">Fail</span>
                                @endif
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($result->marksheetissuded_date_re)->toFormattedDateString()}}
                            </td>
                            <td>
                                <a href="{{url('candidate/downloadjan2025msre')}}/{{$result->exam_id}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a>

                            </td>
                        </tr>
                    @endif
                   @if(!is_null($result->slno_certificate_re))
                  <?php $display=1; ?>

                    <tr>
                        <td>
                           {{ $result->exam->name ?? 'Exam' }}
                        </td>
                        <td>
                             Certificate (Re-evaluation)
                        </td>
                        <td>
                            <span style="color:green;">Pass</span>
                        </td>
                        <td>
                            {{\Carbon\Carbon::parse($result->certificate_date_re)->toFormattedDateString()}}
    
                        </td>
                        <td>
                            <a href="{{url('candidate/downloadjan2025certre')}}/{{$result->exam_id}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a> <br>
                            @if($result->exam_id > 26)
                            @if(is_null($candidate->crr))
                           
                            <form id="crrForm" action="{{url('/')}}/api/crr/response-data" method="POST">
                                {{ csrf_field() }}
                            <input type="hidden" name="enrollment" value="{{$candidate->enrolmentno}}">
                            <input type="hidden" name="dob" value="{{$candidate->dob}}">

                            <button type="submit" id="submitBtn" class="btn btn-success">Get Your CRR</button>

                            </form>

                            <script>
                                document.getElementById('crrForm').addEventListener('submit', function (e) {
                                    const button = document.getElementById('submitBtn');
                                    button.disabled = true; // disable button
                                    button.textContent = 'Please wait...'; // optional loading text
                                });
                                </script>
                            @else

                            <a href="https://rciregistration.nic.in/rehabcouncil/nber_printing_crr.jsp?crr={{$candidate->crr}}">Download Your CRR</a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    
                   @endif



           @else
           
           <tr>
                        <td>
                           {{ $result->exam->name ?? 'Exam' }}
                        </td>
                        <td></td>
                        <td>
                             Payment Pending
                        </td>
                        <td>
                           Amount: {{$newapplicant->amount}}
                        </td>
                        <td>

                            <form name="redirect" class="form-horizontal"   action="{{url('/institute/affiliationfee/')}}" method='get'  class="hidden">
    {!! csrf_field() !!}
    <input type="hidden" id="nber_id" name='nber_id' value="{{$candidate->approvedprogramme->programme->nber_id}}" />
    <input type="hidden" id="type" name='type' value="examfee"  />
    <input type="hidden" id="type" name='exam_id' value="{{$result->exam->id}}"  />
    <input type="hidden" id="type" name='exam_name' value="{{$result->exam->name}}"  />

    <input type="hidden" name="billing_name" id="billing_name" value="{{$candidate->name}}">
    <input type="hidden" name="billing_designation" id="billing_designation" value="Student">
    <input type="hidden" name="billing_tel" id="billing_tel" value="{{$candidate->contactnumber}}" >
    <input type="hidden" name="billing_email" id="billing_email" value="{{$candidate->email}}" >
    <input type="hidden" name="applicant_id" value="{{$candidate->id}}">
    <input type="hidden" name="payment" value="{{$newapplicant->amount}}">
    <button class="btn btn-sm btn-primary"  type="submit">Pay Online</button> <br />
</form>
    
                        </td>
                       
                    </tr>
                  
@endif
@endforeach
@endforeach

                </table>
                @if($display==1)
                <table>
                    <tr>
                       <td><strong>Note:If there is any issue in CRR certificate generation, Please contact to CRR department through email regrci-depwd@gov.in</strong></td> 
                    </tr>
                    
                </table>
                @endif
            </div>

    </div>
</div>

@endsection