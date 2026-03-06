<script>
    $('form').submit(function(){
        $('.save').text('Please wait...');
        $(this).children('button[type=submit]').prop('disabled', true);
        $(this).children('a').addClass('hidden');
        $('.loading').removeClass('hidden');
    });
</script>
<button 
    type="submit" 
    class="btn btn-sm btn-primary pull-right" 
    style="margin-bottom: 5px;"
>
    <img src="{{url('images/loading1.gif')}}" class="hidden loading" style="width: 18px;margin-right: 10px;">
    <span class="save">Save</span>
</button>
