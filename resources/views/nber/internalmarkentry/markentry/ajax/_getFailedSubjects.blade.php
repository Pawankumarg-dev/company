<script>
    function getFailedSubjects(candidate_id){
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('candidate_id', candidate_id); 
        formData.append('subjecttype_id', {{$subjecttype->id}} ); 
        formData.append('syear',{{$syear}});
        formData.append('_method','PUT');
        console.log(formData);
        $('#candidatename').text($('#name_'+candidate_id).text());
        $('#enrolmentno').text($('#enrolmentno_'+candidate_id).text());
        $('#failed').text('Please wait..');
        $('#internalfailed').text('Please wait..');
        $('#supplementary').removeClass('hidden');
        $.ajax({
            url: '{{url("/nber/internalmarkentry/")}}/{{$approvedprogramme->id}}',
            method: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            data: formData,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            if (data.status === 422) {
                console.log(data);
            } else {
            }
        }
        }).done(function(response) {
            var html = '<table class="table table-bordered" style="margin-bottom:0;"><tr><th>Subject Code </th><th>Subject</th></tr>';
              response.forEach(function(subject){
                html += '<tr><td>'+subject.scode+'</td><td>'+subject.sname+'</td></tr>';
              });
            html += '</table>';
            $('#failed').html(html);
            getInternalFailedSubjects(candidate_id);
        });
    }

    function getInternalFailedSubjects(candidate_id){
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('candidate_id', candidate_id); 
        formData.append('subjecttype_id', {{$subjecttype->id}} ); 
        formData.append('syear',{{$syear}});
        formData.append('_method','PUT');
        formData.append('internal','Yes');
        $.ajax({
            url: '{{url("/nber/internalmarkentry/")}}/{{$approvedprogramme->id}}',
            method: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            data: formData,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            if (data.status === 422) {
                console.log(data);
            } else {
            }
        }
        }).done(function(response) {
            var html = '';
            if(response.length==0){
                 html = 'Passed in Internals';
            }else{
                html = '<table class="table table-bordered" style="margin-bottom:0;"><tr><th>Subject Code </th><th>Subject</th><th>Internal Mark</th></tr>';
                response.forEach(function(subject){
                    var mark = subject.internal;
                    mark = mark == 0 ? '' : mark;
                    mark = mark == -1 ? 0 : mark;
                    mark = mark == -2 ? '' : mark;
                    mark = mark == null ? '' : mark;
                    html += '<tr><td>'+subject.scode+'</td><td>'+subject.sname+'</td><td> ';
                    html += '<input ';
                    html += ' type="text"';
                    html += ' value="'+mark+'"';
                    html += ' name="'+candidate_id+'_'+subject.id+'"';
                    html += ' class="markentry"';
                    html += ' onkeypress="return event.charCode >= 48 && event.charCode <= 57"';
                    html += ' onkeyup="this.value = minmax(this.value, 0, '+ subject.imax_marks+')" ';
                    html += ' /> &nbsp;&nbsp;&nbsp; ';
                    html += ' <input ';
                    html += ' name="att_'+candidate_id+'_'+subject.id+'"';
                    html += ' type="checkbox"';
                    if(subject.attendance == 2){
                        html += ' checked';
                    }
                    html += ' > Abs </tr>';
                });
                html += '</table>';
            }
            $('#internalfailed').html(html);
            console.log();
        });
    }
</script>
