@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $title }}
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover">
                        <tr>
                            <th class="right-text" colspan="8">
                                <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#newDetails">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Add Details
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th>S. No.</th>
                            <th>Folio Number</th>
                            <th>Enrolment No</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Course<br>Percentage</th>
                            <th>Class</th>
                            <th>Links</th>
                        </tr>

                        @if($provisionalCertifcates->count() == '0')

                        @else
                            @php $sno = '1'; @endphp
                            @foreach($provisionalCertifcates as $pc)
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">
                                        @if(!is_null($pc->folio_number))
                                            {{ $pc->folio_number }}
                                        @endif
                                    </td>
                                    <td class="center-text">{{ $pc->candidate->enrolmentno }}</td>
                                    <td>{{ $pc->candidate->name }}</td>
                                    <td>{{ $pc->candidate->fathername }}</td>
                                    <td class="left-text">
                                        @if(is_null($pc->candidate->course_percentage))

                                        @else
                                            {{ $pc->candidate->course_percentage }} %
                                        @endif

                                    </td>
                                    <td class="left-text">
                                        @if(is_null($pc->candidate->class))

                                        @else
                                            {{ $pc->candidate->class }}
                                        @endif

                                    </td>
                                    <td class="center-text">
                                        <a href="{{ url('/nber/provisionalcertificate/download/'.$pc->id) }}"
                                           class="btn btn-primary btn-xs" target="_blank" >
                                            Print Provisional Certificate
                                        </a>
                                    </td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>

    @include('nber.provisionalcertificate.add_candidate');
    
    <script>
        $('document').ready(function () {

        });
    </script>
@endsection