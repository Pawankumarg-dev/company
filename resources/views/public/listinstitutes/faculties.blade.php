<h3>
    Faculties
</h3>


    <?php $slno = 1; ?>
    <table class="table table-bordered table-condensed">
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>CRR No</th>
            <th>Qualification</th>
            <th>Photo</th>
        </tr>        
        @foreach($faculties as $faculty)
            <tr>
                <td>
                    {{ $slno }}
                </td>
                <td>
                    {{ $faculty->name }}
                </td>
                <td>
                    {{ $faculty->crr_no }}
                </td>
                <td>
                    {{ $faculty->qualification }}
                </td>
                <td>
                    <img  onerror="this.style.display='none'" src="{{ $faculty->photo }}" style="height: 60px;">
                </td>
                <?php $slno++; ?>
            </tr>
        @endforeach
    </table>