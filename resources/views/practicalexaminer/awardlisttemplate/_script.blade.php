<script>
    $('form').submit(function(){
        $('.save').text('Please wait...');
        $(this).children('button[type=submit]').prop('disabled', true);
        $(this).children('a').addClass('hidden');
        $('.loading').removeClass('hidden');
    });
</script>
