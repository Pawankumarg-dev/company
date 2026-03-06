@extends('layouts.expertpool')

@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text">
                        Experts
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text">
                        <table class="table table-condensed table-stripped table-bordered">
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>{{ $expert->name }}</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection