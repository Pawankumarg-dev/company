<h3>
    Candidates
</h3>

@foreach($candidates as $candidate)
    <?php $slno = 1; ?>
    <h4>
        {{ $candidate->batch }} Batch
    </h4>
    <table class="table table-bordered table-condensed">
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Enrolment No</th>
            <th>Photo</th>
            <th>Aadhar</th>
            <th>Mobile </th>
        </tr>        
        @foreach (json_decode("[".$candidate->candidates."]",true) as $key => $value)
            <tr>
                <td>
                    {{ $slno }}
                </td>
                <td>
                    {{ $value['name'] }}
                </td>
                <td>
                    {{ $value['enrolmentno'] }}
                </td>
                <td>
                    <img  onerror="this.style.display='none'" src="{{ url('/files/enrolment/photos/') }}/{{ $value['photo'] }}" alt="" style="height: 60px;">
                </td>
                <td>
                    {{ $value['aadhar'] }}
                </td>
                <td>
                    {{ $value['mobile'] }}
                </td>
                <?php $slno++; ?>
            </tr>
        @endforeach
    </table>
@endforeach