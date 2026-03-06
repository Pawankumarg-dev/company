<script>
    $(document).ready(function () {
        $("input:radio[name='type']").change(function(){
            var reload = location.protocol + '//' + location.host + location.pathname;
            window.location.replace(reload+"?type="+this.value);
        });
    });
</script>