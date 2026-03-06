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
            @include('institute.exam.markentry._th')
    </tr>
    <tr>
        <?php $codeorname = 'sname'; ?>
        @include('institute.exam.markentry._th')
    </tr>
    <tr>
        <?php $codeorname = 'imax_marks'; ?>
        @include('institute.exam.markentry._th')
    </tr>
</thead>