  @extends('layouts.app')
@section('script')




<div class="container">

   <div class="alert alert-success">
                <h4>
                   <strong>Enrollment fee is mandatory to Pay before Exam</strong>
                        <ul>
                              
                               <li>
                                    In case the payment is deducted but not showing paid then wait for 48 hours to auto update by the system.
                                </li>
                                
                            </ul>
                </h4>
            </div>

  <div class="panel panel-danger " style="">
                  <div class="panel-heading">
                     <b>Enrolment Fee</b>
                  </div>
                  <div class="panel-body">
                     <table class="table table-bordered">
                        <tr>
                           <th>Fee</th>
                           <th>Amount</th>
                           <th>Status</th>
                        </tr>
                        <tr>
                           <td>
                              Enrolment Fee 
                           </td>
                           <td>₹ 500</td>
                           <td>
                              @if($c->feepayment_status == 1)
                                 Paid
                              @else
                                 Pending
                                 @include('student.profile.paymentform')
                                 
                              @endif
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
</div>
@endsection