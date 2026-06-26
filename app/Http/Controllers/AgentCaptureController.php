<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentCaptureController extends Controller
{
    private $apiUrl = 'https://rciregistration.nic.in/rehabcouncil/api/captureAgentInfo.jsp';

    public function showForm()
    {
        return view('agentcapture');
    }

    public function capture(Request $request)
    {
        $clientIp = $request->getClientIp();
        $ip = $request->input('ip_address', $clientIp);
        $hostname = $request->input('hostname', gethostname());
        $username = $request->input('username', 'N/A');
        $os_name = $request->input('os_name', 'N/A');
        $os_version = $request->input('os_version', 'N/A');
        $os_arch = $request->input('os_arch', 'N/A');
        $all_ips = $request->input('all_ips', $ip);
        $captured_on = date('Y-m-d H:i:s');
        // Prevent sending overly long strings which may cause DB errors on remote API
        $truncate = function ($s, $len) {
            if ($s === null) return 'N/A';
            $s = (string) $s;
            if (mb_strlen($s) <= $len) return $s;
            return mb_substr($s, 0, $len);
        };

        $hostname   = $truncate($hostname, 150);
        $username   = $truncate($username, 100);
        $os_name    = $truncate($os_name, 150);
        $os_version = $truncate($os_version, 100);
        $os_arch    = $truncate($os_arch, 50);
        $all_ips    = $truncate($all_ips, 1000);
        // Fetch public IP details (country, city, isp, etc.) automatically if not provided by client
        $ipInfo = null;
        $fields = 'status,country,countryCode,region,regionName,city,zip,lat,lon,timezone,isp,org,as,query';

        // If client IP is loopback or private, ask ip-api for the caller's public IP (no IP param)
        $isLocal = false;
        if (empty($ip) || in_array($ip, ['127.0.0.1', '::1', '0.0.0.0']) || preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|169\.254\.)/', $ip)) {
            $isLocal = true;
        }

        $lookupUrl = 'http://ip-api.com/json' . ($isLocal ? '/' : '/' . urlencode($ip) . '/') . '?fields=' . $fields;
        try {
            $ch2 = curl_init($lookupUrl);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch2, CURLOPT_TIMEOUT, 5);
            $ipResp = curl_exec($ch2);
            curl_close($ch2);
            if ($ipResp !== false) {
                $decoded = json_decode($ipResp, true);
                if (is_array($decoded)) {
                    $ipInfo = $decoded;
                }
            }
        } catch (\Exception $e) {
            $ipInfo = null;
        }

        // Prepare public IP fields (fall back to client ip)
        $public_ip   = $ipInfo['query'] ?? $ip;
        $country     = $truncate($ipInfo['country'] ?? 'N/A', 100);
        $countryCode = $truncate($ipInfo['countryCode'] ?? 'N/A', 10);
        $region      = $truncate($ipInfo['region'] ?? 'N/A', 20);
        $regionName  = $truncate($ipInfo['regionName'] ?? 'N/A', 150);
        $city        = $truncate($ipInfo['city'] ?? 'N/A', 100);
        $zip         = $truncate($ipInfo['zip'] ?? 'N/A', 20);
        $lat         = isset($ipInfo['lat']) ? (string)$ipInfo['lat'] : 'N/A';
        $lon         = isset($ipInfo['lon']) ? (string)$ipInfo['lon'] : 'N/A';
        $timezone    = $truncate($ipInfo['timezone'] ?? 'N/A', 50);
        $isp         = $truncate($ipInfo['isp'] ?? 'N/A', 200);
        $org         = $truncate($ipInfo['org'] ?? 'N/A', 200);
        $as          = $truncate($ipInfo['as'] ?? 'N/A', 200);
        $status      = $ipInfo['status'] ?? 'fail';

        // Compose an `os` field similar to the example: "os_name os_version (os_arch)"
        $os_combined = trim($os_name . ' ' . $os_version . ' (' . $os_arch . ')');

        $payload = [
            // Prefer public IP in `ip_address` when available, fall back to client IP
            'ip_address'       => $public_ip ?: $ip,
            'local_ip'         => $ip,
            'public_ip'        => $public_ip,
            'status'           => $status,
            'country'          => $country,
            'city'             => $city,
            'timezone'         => $timezone,
            'isp'              => $isp,
            'latitude'         => $lat,
            'longitude'        => $lon,
            'region'           => $region,
            'mac_address'      => $request->input('mac_address', 'N/A'),
            'hostname'         => $hostname,
            'os'               => $truncate($os_combined, 200),
            'username'         => $username,
            'all_ips'          => $all_ips,
            'server_received_on'=> $captured_on,
        ];

        $json = json_encode($payload);

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=UTF-8',
            'Accept: application/json',
            'User-Agent: RCI-AgentCapture/1.0'
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return redirect()->back()->with('error', 'Registration failed: ' . $err)->with('api_response', $err);
        }

        if (strpos($response, '"success"') !== false) {
            return redirect()->back()->with('success', 'Device registered successfully!')->with('api_response', $response);
        }

        return redirect()->back()->with('warning', 'Registration completed with a warning: ' . $response)->with('api_response', $response);
    }
}
