<!DOCTYPE html>
<html>
<head>
    <title>Merchant Payment Status Page</title>
</head>
<body>
    <h1>{{ $message }}</h1>

    <center>
        <font size="4" color="blue"><b>Return url request body params</b></font>
        <table border="1">
            @foreach ($inputParams as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ json_encode($value) }}</td>
                </tr>
            @endforeach
        </table>
    </center>

    <center>
        <font size="4" color="blue"><b>Response received from order status payment server call</b></font>
        <table border="1">
            @forelse ($order as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ json_encode($value) }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No order data available</td></tr>
            @endforelse
        </table>
    </center>
</body>
</html>
