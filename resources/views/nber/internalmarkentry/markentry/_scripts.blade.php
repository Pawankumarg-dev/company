<script type="text/javascript">
    function minmax(value, min, max) 
    {
        if(parseInt(value) < min || isNaN(parseInt(value))) 
            return ''; 
        else if(parseInt(value) > max) 
            return max; 
        else return value;
    }
</script>