<h3 class="text-muted">
    <b>Faculties</b>
</h3>
<div class="container fcontainer">
    <div class="row">
        @foreach($faculties as $faculty)
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6" style="padding-bottom: 10px;">
                    <table>
                        <tr>
                            <td style="vertical-align:top!important;">
                                @if(!is_null($faculty->crr_no))
                               

                                    <img   onerror="handleError(this)" src="{{$faculty->photo}}" style="height:100px;">
                                @else
                                    <img  onerror="handleError(this)" src="{{ url('/files/faculties') }}/{{ $faculty->photo }}" style="height:100px;">
                                @endif
                            </td>
                            <td style="padding-left:6px;vertical-align:top!important;">
                                <span class="">{{ $faculty->name }} </span>
                                @if($faculty->core==1)
                                    <span class="label label-primary " style="font-size: 9px;">Core Faculty</span>
                                @endif
                                @if($faculty->core==0)
                                    <span class="label label-warning " style="font-size: 9px;">Guest / Visiting Faculty</span>
                                @endif
                                <br>
                                <span class="text-muted " style="font-size: 10px;">
                                    @if(!is_null($faculty->crr_no))
                                        CRR Number: {{ $faculty->crr_no }} 
                                        @if(\Carbon\Carbon::parse($faculty->crr_expiry) >= \Carbon\Carbon::now() )

                                        <small class="label label-info">
                                                Active
                                            </small>


                                        @else

@php
    $crrNo = 'A70186';
    $url = "https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id={$crrNo}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
    } else {
        curl_close($ch);
        $data = json_decode($response, true);
$expiryDate = $data[0]['RegistrationExpiedDate'];
// echo $expiryDate;
//  $data[0] 
//         if (!$data) {
//             $error = 'No record found';
//         }
    }



@endphp

                                        
                                        
                                        @if(\Carbon\Carbon::parse($expiryDate) >= \Carbon\Carbon::now() )
                                            <small class="label label-info">
                                                Active
                                            </small>
                                        @else   
                                            <small class="label label-danger">
                                                Not active
                                            </small>
                                        @endif


                                        @endif
                                    @endif
                                    <br />
                                    Qualification: {{ $faculty->qualification }} 
                                </span>
                        </td>
                        </tr>
                       
                        @if(!is_null($faculty->subjects))
                        <tr>
                            <td colspan="2">
                                <small><b>Subjects:</b>
                                {{ $faculty->subjects }}
                                </small>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
        @endforeach    
    </div>
  </div>