<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
	/**
	 * Trigger sending network info to a remote API.
	 * Expects parameters: url (required), token, method (default POST), extra (json string).
	 */
	public function sendAgent(Request $request)
	{
		$url = $request->input('url');
		$token = $request->input('token');
		$method = strtoupper($request->input('method', 'POST'));
		$extra = $request->input('extra');

		if (empty($url)) {
			return response()->json(['error' => '--url is required'], 400);
		}

		$payload = $this->buildPayload($extra);

		try {
			$resp = $this->send(json_encode($payload), $url, $token, $method);
			return response()->json(['status' => 'ok', 'http_code' => $resp['code'], 'body' => $resp['body']]);
		} catch (\Exception $e) {
			return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
		}
	}

	protected function getAllMacs()
	{
		$result = array();

		if (is_dir('/sys/class/net')) {
			$ifaces = @scandir('/sys/class/net');
			if ($ifaces) {
				foreach ($ifaces as $iface) {
					if ($iface === '.' || $iface === '..') continue;
					$path = "/sys/class/net/{$iface}/address";
					if (is_readable($path)) {
						$mac = trim(@file_get_contents($path));
						if ($mac && !preg_match('/^([0:]+)$/', $mac)) {
							$result[] = array('iface' => $iface, 'mac' => $mac);
						}
					}
				}
				if (!empty($result)) return $result;
			}
		}

		$out = @shell_exec('ip link 2>/dev/null');
		if ($out) {
			if (preg_match_all('/^\d+:\s*([^:]+):[\s\S]*?link\/ether\s+([0-9a-f:]{17})/mi', $out, $m)) {
				for ($i = 0; $i < count($m[1]); $i++) {
					$result[] = array('iface' => trim($m[1][$i]), 'mac' => strtolower($m[2][$i]));
				}
				if (!empty($result)) return $result;
			}
		}

		$out = @shell_exec('ifconfig -a 2>/dev/null');
		if ($out) {
			if (preg_match_all('/(^|\n)([A-Za-z0-9_:\-\.]+).*?(?:ether|HWaddr)\s+([0-9a-f:]{17})/mi', $out, $m)) {
				for ($i = 0; $i < count($m[2]); $i++) {
					$result[] = array('iface' => trim($m[2][$i]), 'mac' => strtolower($m[3][$i]));
				}
				if (!empty($result)) return $result;
			}
		}

		if (stripos(PHP_OS, 'WIN') === 0) {
			$out = @shell_exec('getmac');
			if ($out && preg_match_all('/([0-9A-Fa-f]{2}[-:]){5}[0-9A-Fa-f]{2}/', $out, $m)) {
				foreach ($m[0] as $mac) {
					$result[] = array('iface' => 'unknown', 'mac' => strtolower(str_replace('-', ':', $mac)));
				}
				if (!empty($result)) return $result;
			}

			$out = @shell_exec('ipconfig /all');
			if ($out && preg_match_all('/Physical Address[\.\s]*:\s*([0-9A-Fa-f\-]{17})/', $out, $m)) {
				foreach ($m[1] as $mac) {
					$result[] = array('iface' => 'unknown', 'mac' => strtolower(str_replace('-', ':', $mac)));
				}
				if (!empty($result)) return $result;
			}
		}

		return $result;
	}

	protected function getLocalIP()
	{
		if (function_exists('socket_create')) {
			try {
				$sock = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
				if ($sock !== false) {
					@socket_connect($sock, '8.8.8.8', 53);
					@socket_getsockname($sock, $name);
					@socket_close($sock);
					if (!empty($name)) return $name;
				}
			} catch (\Exception $e) {
				// ignore
			}
		}

		$ip = gethostbyname(gethostname());
		return $ip ?: '127.0.0.1';
	}

	protected function getPublicIPInfo()
	{
		$info = array('public_ip' => 'null', 'city' => null, 'country' => null, 'isp' => null, 'org' => null);
		$url = 'http://ip-api.com/json/?fields=status,query,country,city,isp,org';
     
		if (!function_exists('curl_init')) {
			return $info;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		$body = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		if ($body) {
			$json = @json_decode($body, true);
			if (is_array($json)) {
				$info['public_ip'] = isset($json['query']) ? $json['query'] : 'null';
				$info['city'] = isset($json['city']) ? $json['city'] : null;
				$info['country'] = isset($json['country']) ? $json['country'] : null;
				$info['isp'] = isset($json['isp']) ? $json['isp'] : null;
				$info['org'] = isset($json['org']) ? $json['org'] : null;
			}
		}
		return $info;
	}

	protected function buildPayload($extra)
	{
		$macs = $this->getAllMacs();
		$localIp = $this->getLocalIP();
		$pub = $this->getPublicIPInfo();

		$macArr = array();
		foreach ($macs as $m) {
			$macArr[] = array('interface' => $m['iface'], 'mac' => $m['mac']);
		}

		$primaryMac = empty($macs) ? null : $macs[0]['mac'];

		$payload = array(
			'timestamp' => date(DATE_ATOM),
			'hostname' => $this->getHostname(),
			'platform' => PHP_OS,
			'platform_version' => php_uname('v'),
			'php_version' => PHP_VERSION,
			'local_ip' => $localIp,
			'public_ip' => $pub['public_ip'],
			'city' => $pub['city'],
			'country' => $pub['country'],
			'isp' => $pub['isp'],
			'org' => $pub['org'],
			'primary_mac' => $primaryMac,
			'mac_addresses' => $macArr,
		);

		if (!empty($extra)) {
			$trim = trim($extra);
			$decoded = @json_decode($trim, true);
			if (is_array($decoded)) {
				$payload = array_merge($payload, $decoded);
			}
		}

		return $payload;
	}

	protected function getHostname()
	{
		$h = gethostname();
		return $h ?: 'unknown';
	}

	protected function send($payloadJson, $url, $token, $method)
	{
		if (!function_exists('curl_init')) {
			throw new \RuntimeException('PHP cURL extension is required');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$headers = array('Content-Type: application/json');
		if (!empty($token)) {
			$headers[] = "Authorization: Bearer {$token}";
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
		$resp = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);

		if ($resp === false) {
			throw new \RuntimeException('cURL error: ' . $err);
		}

		return array('code' => $code, 'body' => $resp);
	}
}
