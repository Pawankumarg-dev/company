@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 8 - Known Languages
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="row">
                    <div class="col-sm-8 right-text">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text green-text">Application No.</th>
                                <td class="center-text blue-text bold-text">{{ $expert->application_no }}</td>
                                <th class="center-text green-text">Name</th>
                                <td class="center-text blue-text bold-text">{{ $expert->title }} {{ $expert->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4 right-text">
                        <a href="{{ url('/expert/application/new/displaystage8form/'.$expert->id) }}" class="btn btn-primary btn-sm">Add Languages</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-bordered table-condensed table-responsive">
                    <tr class="grey-background">
                        <th class="center-text">S. No</th>
                        <th class="center-text">Languages</th>
                        <th class="center-text">Speak</th>
                        <th class="center-text">Read</th>
                        <th class="center-text">Write</th>
                    </tr>

                    @php $sno='1'; @endphp
                    @foreach($expert->expertlanguages as $el)
                        <tr>
                            <td class="center-text">{{ $sno }}</td>
                            <td class="center-text">{{ $el->language->language }}</td>
                            <td class="center-text">{{ $el->speak_status }}</td>
                            <td class="center-text">{{ $el->read_status }}</td>
                            <td class="center-text">{{ $el->write_status }}</td>
                        </tr>

                        @php $sno++; @endphp
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/addstage8')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="expert_id" value="{{ $expert->id }}"/>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"
                                    @if($expert->expertlanguages->count() == 0) disabled @endif>
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection