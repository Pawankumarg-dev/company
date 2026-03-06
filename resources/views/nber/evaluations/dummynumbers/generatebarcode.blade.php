<style>
    .common-style {
        font-family: "Times New Roman";
        font-size: 11px;
    }
</style>
@php
    use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
    use Maatwebsite\Excel\Facades\Excel;
@endphp

<table>
    <tr>
        <th>Dummy Numbers</th>
    </tr>

    @for($i=1, $j=$starting_value; $i<=$quantity; $i++, $j++)
        <tr>
            <td>
                {
                @php
                    $data = $data_format_prefix.$j;
                @endphp

                {{ $data }}
            </td>
            <td>
                @php
                     $barcode = new BarcodeGenerator();
                     $barcode->setText("0123456789");
                     $barcode->setType(BarcodeGenerator::Code128);
                     $barcode->setScale(2);
                     $barcode->setThickness(25);
                     $barcode->setFontSize(10);
                     $code = $barcode->generate();

                     echo '<img src="{{ data:image/png;base64,'.$code.' }}" />';
                @endphp
            </td>
        </tr>
    @endfor
</table>
