<script>
    $(document).ready(function () {
        $('#state_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname + "?type=state&filter=1&course_id=0";
            window.location.replace(reload+"&state_id="+$('#state_id').val());
        });
        $('#course_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname  + "?type=state&filter=1";
            window.location.replace(reload+"&state_id="+$('#state_id').val()+"&course_id="+$('#course_id').val());
        });
        $('#institute_id').on('change',function(){
            var reload = location.protocol + '//' + location.host + location.pathname  + "?type=state&filter=1";
            window.location.replace(reload+"&state_id="+$('#state_id').val()+"&course_id="+$('#course_id').val()+"&institute_id="+$('#institute_id').val());
        });
    });
</script>