@extends('layouts.app')

@section('content')

    <div class="container">
        <h2 class="mb-4">Practical Exam Report</h2>

        @php
            $institutes = collect($data)->unique('institute_id');
            $faculties = collect($data)->unique('faculty_id');
            $nbers = collect($data)->unique('nber_id');

        @endphp
        <div class="table-responsive">

            <form method="GET" action="{{ url('/nber/practical_exam_report_today') }}" style="margin-bottom:30px;">

                <div class="row">
                    @if (Auth::user()->id == 88387 || Auth::user()->id == 239776)
                        <div class="col-md-2">
                            <label>NBER</label>
                            <select name="nber" id="nber" class="form-control">
                                <option value="">All Nbers</option>
                                @foreach ($nbers as $item)
                                    <option value="{{ $item->nber_id }}"
                                        {{ Request::get('nber') == $item->nber_id ? 'selected' : '' }}>
                                        {{ $item->name_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-md-3">
                        <label>Institute</label>

                        <select name="institute" id="institute" class="form-control">
                            <option value="">All Institutes</option>

                            @foreach ($institutes as $item)
                                <option value="{{ $item->institute_id }}"
                                    {{ Request::get('institute') == $item->institute_id ? 'selected' : '' }}>
                                    {{ $item->rci_code }} - {{ $item->tti_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Faculty</label>

                        <select name="faculty" id="faculty" class="form-control">
                            <option value="">All Faculties</option>

                            @foreach ($faculties as $item)
                                <option value="{{ $item->faculty_id }}"
                                    {{ Request::get('faculty') == $item->faculty_id ? 'selected' : '' }}>
                                    {{ $item->faculty_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-2">
                        <label>GeoTagged</label>
                        <select name="geotagged" id="geotagged" class="form-control">
                            <option value="">All</option>
                            <option value="1" {{ Request::get('geotagged') == '1' ? 'selected' : '' }}>Uploaded
                            </option>
                            <option value="0" {{ Request::get('geotagged') == '0' ? 'selected' : '' }}>Not Uploaded
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Marksheet</label>
                        <select name="marksheets" id="marksheets" class="form-control">
                            <option value="">All</option>
                            <option value="1" {{ Request::get('marksheets') == '1' ? 'selected' : '' }}>Uploaded
                            </option>
                            <option value="0" {{ Request::get('marksheets') == '0' ? 'selected' : '' }}>Not Uploaded
                            </option>
                        </select>
                    </div>
                    {{-- <div class="col-md-2">
                <label>Date</label>
                <input type="date" name='date' class="form-control" value="{{ Request::get('date')}}">
               
            </div> --}}

                    <div class="col-md-2">
                        <label>Min Date</label>
                        <input type="date" name='date' class="form-control" value="{{ Request::get('date') }}">

                    </div>




                    <div class="col-md-2" style="margin-top:25px;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Search
                        </button>

                        <a href="{{ url('/nber/practical_exam_report_today') }}" class="btn btn-danger btn-sm">
                            Reset
                        </a>
                    </div>

                </div>

            </form>


            <button class="btn btn-success" onclick="exportTableToExcel('reportTable', 'Practical_Exam_Report')">
                <i class="glyphicon glyphicon-download-alt"></i> Export Excel
            </button>
            <table id="reportTable" class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nber Name</th>
                        <th>Slot</th>
                        <th>TTI Details</th>
                        <th width="10%">Start and End Date</th>
                        <th width="15%">Faculty Details</th>
                        <th>Subject Code </th>
                        <th width="10%">geotaggedphotos</th>
                        <th width="10%">Comments</th>
                        <th width="10%">Upload marksheet</th>
                        {{-- <th>Longitude and latitude</th> --}}

                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $row->name_code }}</td>

                            <td>{{ $row->slot }}</td>

                            <td><strong>RCI Code:</strong> {{ $row->rci_code }} <br> <strong>TTI Name:</strong>
                                {{ $row->tti_name }} <br> {{ $row->coordinate }}
                                <br>
                                <strong>Contact No:</strong> {{ $row->contact_number }}
                            </td>
                            <td>
                                {{ $row->start_date }}
                                <br>
                                <strong>To</strong>
                                <br>
                                {{ $row->end_date }}
                            </td>

                            <td>
                                <strong>Name:</strong> {{ $row->examiner_name }} <br>
                                <strong>CRR No:</strong> {{ $row->crr_no }} <br>
                                <strong>Mobile:</strong> {{ $row->examiner_number }} <br>
                                <strong>Last Login:</strong> {{ $row->last_log }}

                            </td>

                            <td>


                                @foreach (explode(',', $row->scode ?? '') as $subject)
                                    <span class="badge bg-primary">{{ trim($subject) }}</span><br>
                                @endforeach
                            </td>
                            <td>
                                @foreach (explode(',', $row->file_data ?? '') as $photo)
                                    @if (trim($photo))
                                        <a href="{{ url('files/geotaggedphotos') }}/{{ $photo }}" target="_blank">
                                            {{-- <img src="{{ url('files/externalpractical') }}/{{ $photo }}" width="80" class="img-thumbnail mb-1"> --}}
                                            GeoTagged
                                        </a><br>
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                @foreach (explode(',', $row->comments ?? '') as $comment)
                                    @if (trim($comment))
                                        <small>{{ $comment }}</small> <br>
                                    @endif
                                @endforeach
                            </td>
                            <td>

                                @foreach (explode(',', $row->marksheet ?? '') as $file)
                                    @if (trim($file))
                                        <a href="{{ url('files/externalpractical') }}/{{ $file }}"
                                            target="_blank">
                                            View Marksheet
                                        </a><br>
                                    @endif
                                @endforeach
                            </td>
                            {{-- 
                            <td>

                                        {{ $row->longitude_latitude }}<br>
                            </td> --}}


                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-danger">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script src="{{ url('/') }}/js/xlsx.full.min.js"></script>

    <script>
        function exportTableToExcel(tableID, filename = '') {
            // 1. Get the HTML table element
            var table = document.getElementById(tableID);

            // 2. Clone the table so we can strip out elements we DON'T want in Excel (like links)
            var tableClone = table.cloneNode(true);

            // Optional: If you don't want the actual "View Marksheet" or "GeoTagged" text links 
            // cluttering your Excel sheet, you can clean them up here. Otherwise, leave this out.

            // 3. Convert the HTML table to a SheetJS worksheet object
            var wb = XLSX.utils.table_to_book(tableClone, {
                sheet: "Report"
            });

            // 4. Set the filename
            filename = filename ? filename + '.xlsx' : 'Practical_Exam_Report.xlsx';

            // 5. Trigger the download
            XLSX.writeFile(wb, filename);
        }
    </script>

    <script>
        $(document).ready(function() {

            $('#institute').select2({
                placeholder: 'Select Institute',
                allowClear: true
            });

            $('#faculty').select2({
                placeholder: 'Select Faculty',
                allowClear: true
            });

        });
    </script>


@endsection
