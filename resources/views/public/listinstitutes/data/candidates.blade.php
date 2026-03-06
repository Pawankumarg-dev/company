<h3 class="text-muted">
    <b>Students</b>
</h3>
@foreach($candidates as $candidate)
    <?php $slno = 1; ?>
    <h4>
        {{ $candidate->batch }} Batch
        <br />
        <span style="font-size: 14px;">
            Maximum Intake: {{ $candidate->maxintake }}, Admitted Students: {{ $candidate->admitted }}
        </span>
    </h4>
    <div class="container fcontainer">
        <div class="row">
            @foreach (json_decode("[".$candidate->candidates."]",true) as $key => $value)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6" style="padding-bottom: 10px;">
                    <table>
                        <tr>
                            <td style="vertical-align:top!important;">
                                <img  onerror="handleError(this)" src="{{ url('/files/enrolment/photos/') }}/{{ $value['photo'] }}" alt="" style="height: 100px;">
                            </td>
                            <td style="padding-left:6px;vertical-align:top!important;">
                                {{ $value['name'] }} <br />
                                <span class="text-muted float-left" style="font-size: 10px;">
                                    PNR: {{ $value['enrolmentno'] }} <br />
                                    Aadhar: {{ $value['aadhar'] }} <br />
                                    Mobile: {{ $value['mobile'] }} 
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach    
        </div>
      </div>
@endforeach

