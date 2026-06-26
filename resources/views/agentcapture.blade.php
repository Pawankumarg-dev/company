<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Agent Capture</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}</style>
</head>
<body>
    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div style="color:orange">{{ session('warning') }}</div>
    @endif
    @if(session('error'))
        <div style="color:red">{{ session('error') }}</div>
    @endif
    @if(session('api_response'))
        <h3>API Response</h3>
        <pre style="background:#f6f6f6;border:1px solid #ddd;padding:10px;white-space:pre-wrap;word-wrap:break-word;">{{ session('api_response') }}</pre>
    @endif

    <form method="POST" action="/agent-capture">
        {{ csrf_field() }}
        <div style="margin-top:12px">
            <button type="submit">Find all details</button>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Try to populate some fields using browser values
        document.getElementById('hostname').value = window.location.hostname || '';
        document.getElementById('username').value = '';
        document.getElementById('os_info').value = navigator.userAgent || '';

        // Get public IP using ipify; not all environments allow this
        fetch('https://api.ipify.org?format=json').then(function(r){return r.json();}).then(function(data){
            document.getElementById('ip_address').value = data.ip;
            document.getElementById('all_ips').value = data.ip;
        }).catch(function(){
            // leave blank on failure
        });
    });
    </script>
</body>
</html>
