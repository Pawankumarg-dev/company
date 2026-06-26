
</div>
<div class="modal-footer">
    <button
        type="submit"
        class="btn  btn-primary pull-right"
        id="btn_{{$ap->id}}_{{$term}}"
        target="_blank"
    >
    <img src="{{url('images/loading1.gif')}}" class="hidden loading" style="width: 18px;margin-right: 10px;">
        
    <span class="save">Download</span>

    </button>
    <button  type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
</div>
</div>
</div>
</div>
<script>
    $('#form_{{$ap->id}}_{{$term}}').submit(function(e){
        e.preventDefault();
        if($(".chk_{{$ap->id}}_{{$term}}:checked").length == 0){
            swal({
                type: 'warning',
                title: 'Please select Subjet(s)',
                showConfirmButton: false,
                timer: 4500
                });
            return false;
        }
        if($(".chk_{{$ap->id}}_{{$term}}:checked").length > 3 ){
            swal({
                type: 'warning',
                title: 'Maximum only three subjets can be selected',
                showConfirmButton: false,
                timer: 4500
                });
            return false;
        }
        $('.save').text('Please wait...');
        $('#btn_{{$ap->id}}_{{$term}}').prop('disabled', true);
        $(this).children('a').addClass('hidden');
        $('.loading').removeClass('hidden');
        //alert("Submitting");
        e.currentTarget.submit();
    });
</script>
</form>
