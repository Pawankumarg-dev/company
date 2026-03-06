@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Result Publishing</h4>
            <table class="table">
                <tr>
                    <th>Slno</th>
                    <th>NBER</th>
                    <th>Number of Applications</th>
                    <th>Published</th>
                    <th>Pending</th>
                </tr>
                <?php $applications = 0; $present = 0; $published = 0;$pending=0; $slno = 0; ?>
                @foreach($results as $result)
                    <?php 
                        $slno ++;
                        $applications += $result['no_of_applications']; 
                        $published += $result['published'];
                        $p = $result['no_of_applications'] - $result['published'];
                        $pending += $p;
                    ?>
                    <tr>
                        <td> {{ $slno }} </td>
                        <td> {{ $result['nber'] }}</td>
                        <td> {{ $result['no_of_applications'] }}</td>
                        <td> {{ $result['published'] }} </td>
                        <td> {{ $p }} </td>
                    </tr>
                @endforeach
                <tr>
                    <th>4</th>
                    <th>Total</th>
                    <th>{{ $applications }}</th>
                    <th>{{ $published }}</th>
                    <th>{{ $pending }}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection