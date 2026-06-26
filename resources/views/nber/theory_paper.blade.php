@extends('layouts.app')
@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header">
                Theory Exam Report June 2026
            </h3>
        </div>
    </div>
    
        @php
        $institutes = collect($theory_papers)->unique('institute_id');
        $nbers      = collect($theory_papers)->unique('nber_id');
        $examdates = collect($theory_papers)->unique('description');
        $examcenters = collect($theory_papers)->unique('code');
        @endphp

            <div class="table-responsive">
                <form method="GET" action="{{ url('/nber/theory_paper') }}" style="margin-bottom:30px;">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Examcenter Name</label>
                            <select name="examcenter" id="examcenter" class="form-control">
                                <option value="">All examcenters</option>

                                @foreach($examcenters as $examcenter)
                                    <option value="{{$examcenter->exam_center_ids }}"
                                        {{ Request::get('examcenter') == $examcenter->exam_center_ids ? 'selected' : '' }}>
                                         <strong>{{$examcenter->code }} : </strong> {{$examcenter->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Exam Day</label>
                            <select name="examday" id="examday" class="form-control">
                                <option value="">--Select Exam Day--</option>
                                {{-- <option value="94,120" {{ Request::get('examday') == '94,120' ? 'selected' : '' }}>
                                    Day1 (Morning)
                                </option>
                                <option value="95,111" {{ Request::get('examday') == '95,111' ? 'selected' : '' }}>
                                    Day1 (Afternoon)
                                </option> --}}


                            <option value="192,193" {{ Request::get('examday') == '192,193' ? 'selected' : '' }}>Day1 (Morning)</option>
                            <option value="238,196" {{ Request::get('examday') == '238,196' ? 'selected' : '' }}>Day1 (Afternoon)</option>
                            <option value="197,239" {{ Request::get('examday') == '197,239' ? 'selected' : '' }}>Day2 (Morning)</option>
                            <option value="199,200" {{ Request::get('examday') == '199,200' ? 'selected' : '' }}>Day2 (Afternoon)</option>
                            <option value="202,203" {{ Request::get('examday') == '202,203' ? 'selected' : '' }}>Day3 (Morning)</option>
                            <option value="232,205" {{ Request::get('examday') == '232,205' ? 'selected' : '' }}>Day3 (Afternoon)</option>
                            <option value="206,209" {{ Request::get('examday') == '206,209' ? 'selected' : '' }}>Day4 (Morning)</option>
                            <option value="234,210" {{ Request::get('examday') == '234,210' ? 'selected' : '' }}>Day4 (Afternoon)</option>
                            <option value="211,213" {{ Request::get('examday') == '211,213' ? 'selected' : '' }}>Day5 (Morning)</option>
                            <option value="235,215" {{ Request::get('examday') == '235,215' ? 'selected' : '' }}>Day5 (Afternoon)</option>
                            <option value="216,217" {{ Request::get('examday') == '216,217' ? 'selected' : '' }}>Day6 (Morning)</option>
                            <option value="236,219" {{ Request::get('examday') == '236,219' ? 'selected' : '' }}>Day6 (Afternoon)</option>
                            <option value="220,221" {{ Request::get('examday') == '220,221' ? 'selected' : '' }}>Day7 (Morning)</option>
                            <option value="237,224" {{ Request::get('examday') == '237,224' ? 'selected' : '' }}>Day7 (Afternoon)</option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Download Status</label>
                            <select name="downloads" id="downloads" class="form-control">
                                <option value="">All</option>
                                <option value="1" {{ Request::get('downloads') == '1' ? 'selected' : '' }}>Download</option>
                                <option value="0" {{ Request::get('downloads') == '0' ? 'selected' : '' }}>Not Download</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="margin-top:25px;">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Search
                            </button>
                            <a href="{{ url('/nber/theory_paper') }}" class="btn btn-danger btn-sm">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <table id="reportTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th >Exam Days</th>
                            <th >Exam Date</th>
                            <th>Exam Center</th>
                            <th>RCI Code </th>
                            <th>Subjects</th>
                            <th>Status</th>
                            <th>Languages</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($theory_papers as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->examdate)) }}</td>
                                <td> <strong>{{ $row->code }} : </strong> {{ $row->name }} <br>
                                    <strong>Contact No.</strong> {{$row->contact_number}}
                                </td>
                                <td>
                                   
                                    @foreach(explode(',', $row->rci_code ?? '') as $rci_code)
                                        <span>
                                            {{ trim($rci_code) ?? '-' }} <br>
                                        </span>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach(explode(',', $row->subjects ?? '') as $subject)
                                        <span class="label label-primary">
                                            {{ trim($subject) ?? '-' }} <br>
                                        </span>
                                    @endforeach
                                </td>

                                <td>
                                    @if (!empty($row->agents))
                                        @foreach(explode(',', $row->agents) as $i => $agent)
                                            <span class="label label-success">
                                                 Downloaded:{{$i+1}}<br>
                                            </span>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    @if($row->languages != null)
                                       @foreach(explode(',', $row->languages ?? '') as $language)
                                        <span class="label label-success">
                                            {{ trim($language) ?? '-'}} <br>
                                        </span>
                                    @endforeach
                                        
                                    @endif
                                   
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-danger">
                                    No data found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        
</div>

<script>
$(document).ready(function () {

    $('#institute').select2({
        placeholder: 'Select Institute',
        allowClear: true,
         width: '100%'
    });

    $('#examcenter').select2({
        placeholder: 'Select Examcenter',
        allowClear: true,
         width: '100%'
    });

});
</script>
@endsection

{{-- 56419 --}}
{{-- @foreach($examdates as $examdate)
<option value="{{$examdate->examsechdule_id }}"
    {{ Request::get('examday') == $examdate->examsechdule_id ? 'selected' : '' }}>
    {{$examdate->description}}
</option>
@endforeach --}}