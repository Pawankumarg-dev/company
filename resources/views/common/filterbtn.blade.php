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
    class="btn btn-sm btn-primary" 
>
    <img src="{{url('images/loading1.gif')}}" class="hidden loading" style="width: 18px;margin-right: 10px;">
    <span class="save">Show</span>
</button>
<a href="{{  Request::url()  }}"  class="btn btn-warning btn-sm"  name="cancel" id="cancel"> Cancel </a>
