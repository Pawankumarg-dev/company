
@if (!empty($template->id))
  <a href="javascript:uploadms({{ $template->id }})" class="btn btn-xs upload_link_{{ $template->id }}"
    style="margin-bottom:5px;">

    ( Term {{ $term }}) - Upload Singed Scan copy of the marksheet

</a>


<div class=" alert alert-danger pull-right hidden upload_{{ $template->id }}" style="margin-bottom:0px;">
    <h5>Upload Marksheet ( Term {{ $term }}) </b></h5>
    <form id="msupload_form_{{ $template->id }}" action="{{ url('practicalexam/awardlisttemplate') }}" method="POST"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="marksheet" id="fileupms_{{ $template->id }}">
        <input type="hidden" name="practicalexam_id" value="{{ $exam->id }}">
        <input type="hidden" name="approvedprogramme_id" value="{{ $ap->id }}">
        <input type="hidden" name="institute_id" value="{{ $ap->institute_id }}">
        <input type="hidden" name="term" value="{{ $term }}">
        <button type="submit" class="btn btn-xs btn-primary pull-right" id="btnmsu_{{ $template->id }}">
            <img src="{{ url('images/loading1.gif') }}" class="hidden msupload"
                style="width: 18px;margin-right: 10px;">
            <span class="uploadmarksheet">
                @if (!is_null($template->marksheet))
                    Re -
                @endif Upload
            </span>
        </button>
    </form>
</div>

@if (!is_null($template->marksheet))
    <a target="_blank" href="{{ url('files/externalpractical') }}/{{ $template->marksheet }}"> Download (Term
        {{ $term }}) </a>
    {{-- {{$template->id}} --}}
    <div class="alert alert-warning">
        @if ($template->subjects->count() > 0)
            <table class="table table-bordered">
                <tr>
                    <th>Subject Code</th>
                    <th>Marks</th>
                </tr>

                @foreach ($template->subjects as $subject)
                    <tr>
                        <td>
                            {{ $subject->scode }}
                        </td>
                        <td>
                            <a href="{{ url('practicalexam/awardlisttemplate') }}/{{ $template->id }}?subject_id={{ $subject->id }}"
                                class="btn btn-xs btn-primary">
                                Enter Marks
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endif

<script>
    $('#fileupms_{{ $template->id }}').on('change', function() {
        if (this.files[0].size > 1000000) {
            alert("Try to upload file less than 1MB!");
        } else {

        }
    });
    $('#msupload_form_{{ $template->id }}').submit(function(e) {
        e.preventDefault();
        $('.uploadmarksheet').text('Please wait...');
        $('#btnmsu_{{ $template->id }}').prop('disabled', true);
        $('.msupload').removeClass('hidden');
        if ($("#fileupms_{{ $template->id }}").get(0).files[0].size > 1000000) {
            swal({
                type: 'warning',
                title: 'Please choose file size less than 1MB',
                showConfirmButton: false,
                timer: 4500
            });
            $('.uploadfile').text(
                '@if (!is_null($template->marksheet))  Re - @endif Upload'
                );
            $('#btnmsu_{{ $template->id }}').prop('disabled', false);
            $('.msupload').addClass('hidden');
            return false;
        }


        e.currentTarget.submit();
    });
</script>  
@elseif($geotagged == true)

    @foreach(session('download_data') as $key => $data)
        {{-- {{print_r($data)}} --}}
        <a href="javascript:uploadms('{{ $key }}')" 
           class="btn btn-xs upload_link_{{ $key }}"
           style="margin-bottom:5px;">
            ( Term {{ $data['term'] }} ) - Upload Signed Scan copy of the marksheet
        </a>

        <div class="alert alert-danger pull-right hidden upload_{{ $key }}" style="margin-bottom:0px;">
            <h5>Upload Marksheet ( Term {{ $data['term'] }} )</h5>

            <form id="msupload_form_{{ $key }}" 
                  action="{{ url('practicalexam/awardlisttemplate') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="marksheet" id="fileupms_{{ $key }}">

                <input type="hidden" name="practicalexam_id" value="{{ $data['practicalexam_id'] }}">
                <input type="hidden" name="approvedprogramme_id" value="{{ $data['approvedprogramme_id'] }}">
                <input type="hidden" name="institute_id" value="{{ $data['institute_id'] }}">
                <input type="hidden" name="term" value="{{ $data['term'] }}">
                @foreach($data['subject_ids'] as $subject_id)
                <input type="hidden" name="subject_ids[]" value="{{ $subject_id }}">
            @endforeach
                <button type="submit" class="btn btn-xs btn-primary pull-right" id="btnmsu_{{ $key }}">
                    <img src="{{ url('images/loading1.gif') }}" class="hidden msupload" style="width: 18px;margin-right: 10px;">
                    <span class="uploadmarksheet">Upload</span>
                </button>
            </form>
        </div>

    @endforeach

@endif


