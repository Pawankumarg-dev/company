<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
    $(document).ready(function(){
        $("#btnExport").click(function() {
            swal({
                type: 'success',
                title: 'Downloading',
                showConfirmButton: true,
                timer: 3000
            });
            $('#download').val(1);
            $('#btnExport').removeClass('hidden');
            var perPage = $('#perPage').val();
            $('#perPage').val(0);
            $('#frmFilter').submit();
            $('#perPage').val(perPage);
            $('#download').val(0);
            $('.save').text('Show');
            $(this).children('button[type=submit]').prop('disabled', false);
            $(this).children('a').removeClass('hidden');
            $('.loading').addClass('hidden');
        });
    });
</script>