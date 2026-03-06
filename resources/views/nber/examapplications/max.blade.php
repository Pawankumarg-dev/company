@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Exam Applications  - Progress
                </div>
            </div>
        </div>
    </section>

    <section class="container">
     
    </form>
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
          
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr class="grey-background">
                                <th class="center-text">SlNo</th>
                                <th class="center-text">Date</th>
                                <th class="center-text">NIEPMD</th>
                                <th class="center-text">AYJ</th>
                                <th class="center-text">NIEPVD</th>
                                <th class="center-text">Total</th>
                            </tr>
                            @php $sno = '1'; @endphp
                            @foreach($datewise as $r)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text blue-text">{{ $r->date }}</td>
                                    <td class="center-text blue-text">{{ $r->niepmd }}</td>
                                    <td class="center-text blue-text">{{ $r->ayjshd }}</td>
                                    <td class="center-text blue-text">{{ $r->niepvd }}</td>
                                    <td class="center-text blue-text">{{ $r->totoal }}</td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection