@php
    use Milon\Barcode\DNS2D;
@endphp
<h2>Two-Dimensional (2D) Barcode Types</h2><br/>
<div>{!!DNS2D::getBarcodeHTML(335553, 'QRCODE')!!}</div></br>
<div>{!!DNS2D::getBarcodeHTML(142535, 'PDF417')!!}</div></br>
<div>{!!DNS2D::getBarcodeHTML(646, 'DATAMATRIX')!!}</div></br>