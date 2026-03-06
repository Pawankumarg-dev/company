@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-6">
                        @include('common.errorandmsg')

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Dummy</th>
                        <th>Reevaluation Apply</th>
                        <th>Retotalling Apply</th>
                                                <th>Marks</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; 

                    $filename = 'RE27_' . $subjects[0]->evaluationcenter_id . '_' . $subjects[0]->subject_id . '.' . 'pdf';
                    ?>

                    @foreach ($subjects as $data)
                        <tr>
        <td>{{$i++}}</td>
                            <td>{{ $data->dummy_number}}</td>
                            <td>{{ $data->reevaluation_applystatus == 1 ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->retotalling_applystatus == 1 ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $data->reevaluated_marks}} @if($data->no_change==1) Marks No Change {{$data->actual_marks}} @endif</td>

                        </tr>
                    @endforeach
                    <tr>
<td>
                      <form method="POST" action="{{ url('reevaluationcenter/verify') }}">
        {!! csrf_field() !!}

    <input type="hidden" name="filename" value="{{ $filename }}">

    <button type="submit" class="btn btn-primary"> Verify</button>
</form>
</td>
 
                    </tr>
  
                </tbody>
            </table>
        </div>

        <div class="col-md-6">


               
  <iframe 
        src="{{url('/')}}/files/markfiles/{{  $filename }}" 
        style="width:164%;height:900px"
    >
    </iframe>
            {{-- future content --}}
        </div>

           

    </div>



</div>


@endsection
