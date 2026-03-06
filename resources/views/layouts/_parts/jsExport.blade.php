<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
    $(document).ready(function(){
        $('#btnExport').removeClass('hidden');
        $("#btnExport").click(function() {
            let table = document.getElementById("myTable");
            TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
            name: `{{ $title }} {{\Carbon\Carbon::now()->format('Y-M-d')}}.xlsx`, // fileName you could use any name
            sheet: {
                name: '{{ $title }}' // sheetName
            }
            });
        });
    });
</script>