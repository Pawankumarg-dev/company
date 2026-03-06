<thead>
    <tr>
            <th rowspan="3">
                Slno.
            </th>
            <th rowspan="3">
                Enrolment No
            </th>
            <th rowspan="3">
                Name
            </th>
            <?php $codeorname = 'scode'; ?>
            @include('institute.exam.practicalmarkentry._th')
    </tr>
    <tr>
        <?php $codeorname = 'sname'; ?>
        @include('institute.exam.practicalmarkentry._th')
    </tr>
    <tr>
        <?php $codeorname = 'emax_marks'; ?>
        @include('institute.exam.practicalmarkentry._th')
    </tr>
</thead>