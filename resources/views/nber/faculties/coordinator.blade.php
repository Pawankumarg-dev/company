@extends('layouts.app')
@section('content')
    <script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { 
                name: `facultiesDetails.xlsx`, 
                sheet: {
                    name: 'Sheet 1'
                }
                });
            });
        });
    </script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php $slno = 1; ?>
            <h3 class="mb-4">Faculties</h3>
            @include('common.errorandmsg')
            
            <form action="{{url('/')}}/nber/course-list" method="get" class="mb-4">
                {{csrf_field()}}
                <div class="form-group row">
                    <div class="col-md-4 mb-3">
                        <label for="course">Courses:</label>
                        <select id="course" name="course_id" class="form-control">
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $i)
                                <option <?php if($id==$i->id){echo "selected";}?> value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="institute_id"> </label>

                        <button type="submit" class="btn btn-primary btn-block">Show</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right mb-3">Download</button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Institute Name</th>
                            <th>RCI Code</th>
                            <th>Total Faculty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $slno = 1; ?>

                        @foreach($institutes as $institute)
                            <tr>
                                <td>{{ $slno++ }}</td>
                                <td>{{ $institute->name }}</td>
                                <td>{{ $institute->rci_code }}</td>
                                <td>{{ $institute->total_faculty }}</td>
                                <td>
                                    <form action="{{url('/nber/faculties/verify')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="course_id" value="{{$institute->course_id}}">
                                        <input type="hidden" name="institute_id" value="{{$institute->institute_id}}">
                                        <button type="submit" class="btn btn-primary btn-block">Show</button>

                                    </form>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
