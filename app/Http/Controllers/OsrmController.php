<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// using built-in cURL to avoid extra dependencies

class OsrmController extends Controller
{
    /**
     * Return driving distance and duration between two addresses.
     * GET /osrm/distance?from=...&to=...
     */
    public function distance(Request $request)
    {
        // prefer query parameters but keep reasonable defaults for testing
        $from = $request->query('from', 'Laxmi Nagar, delhi');
        $to = $request->query('to', 'Rehabitation councile of india , delhi');

        if (empty($from) || empty($to)) {
            return response()->json(['error' => 'Provide `from` and `to` query parameters.'], 400);
        }

        $origin = $this->getCoordinates($from);
        if (!$origin) {
            $debug = $this->fetchNominatimDebug($from);
            return response()->json(['error' => 'Geocoding failed for origin address.', 'address' => $from, 'nominatim' => $debug], 500);
        }

        $destination = $this->getCoordinates($to);
        if (!$destination) {
            $debug = $this->fetchNominatimDebug($to);
            return response()->json(['error' => 'Geocoding failed for destination address.', 'address' => $to, 'nominatim' => $debug], 500);
        }

        // By default snap points to the nearest road so we measure driving distance, not straight-line displacement
        $snap = $request->query('snap', 'true');
        if (strtolower($snap) !== 'false') {
            $snappedOrigin = $this->snapToRoad($origin);
            $snappedDestination = $this->snapToRoad($destination);
            if ($snappedOrigin) {
                $origin = $snappedOrigin;
            }
            if ($snappedDestination) {
                $destination = $snappedDestination;
            }
        }

        $route = $this->getDrivingDistance($origin, $destination);

        if (!$route) {
            return response()->json(['error' => 'Routing failed.'], 500);
        }

        return response()->json([
            'origin' => $origin,
            'destination' => $destination,
            'route' => $route,
        ]);
    }

    /**
     * Snap a lat/lng point to the nearest road using OSRM `nearest` service.
     * Returns array with `lat` and `lng` on success, or null on failure.
     */
    protected function snapToRoad(array $point)
    {
        if (!isset($point['lat']) || !isset($point['lng'])) {
            return null;
        }

        $coords = sprintf('%s,%s', $point['lng'], $point['lat']);
        $url = "https://router.project-osrm.org/nearest/v1/driving/{$coords}";

        $data = $this->httpGetJson($url, ['number' => 1]);
        if (empty($data['waypoints'][0]) || !isset($data['waypoints'][0]['location'])) {
            return null;
        }

        $loc = $data['waypoints'][0]['location']; // [lng, lat]
        return ['lat' => $loc[1], 'lng' => $loc[0], 'snapped' => true];
    }

    protected function getCoordinates($address)
    {
        $url = 'https://nominatim.openstreetmap.org/search';
        $headers = ['User-Agent: Laravel App (OSRM integration)'];

        // build a set of query variants to improve matching when the full address is too specific
        $variants = [];
        $variants[] = $address;
        // drop leading unit/house number (e.g. "B-22, ...")
        $variants[] = preg_replace('/^[^,]+,\s*/', '', $address);
        // drop postal code like 110016
        $variants[] = preg_replace('/\b\d{5,6}\b/', '', $address);
        // add country if missing
        if (stripos($address, 'india') === false) {
            $variants[] = $address . ', India';
        }
        // try last 2-3 segments (area, city/state)
        $parts = array_map('trim', explode(',', $address));
        $count = count($parts);
        if ($count >= 2) {
            $variants[] = implode(', ', array_slice($parts, max(0, $count - 2)));
        }
        if ($count >= 3) {
            $variants[] = implode(', ', array_slice($parts, max(0, $count - 3)));
        }

        // dedupe and try each variant
        $seen = [];
        foreach ($variants as $q) {
            $q = trim(preg_replace('/,+$/', '', $q));
            if ($q === '' || isset($seen[$q])) {
                continue;
            }
            $seen[$q] = true;

            $params = [
                'q' => $q,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
                'countrycodes' => 'in',
            ];

            $data = $this->httpGetJson($url, $params, $headers);
            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                return ['lat' => $data[0]['lat'], 'lng' => $data[0]['lon'], 'query' => $q];
            }
        }

        return null;
    }

    protected function getDrivingDistance(array $origin, array $destination)
    {
        $coords = sprintf('%s,%s;%s,%s', $origin['lng'], $origin['lat'], $destination['lng'], $destination['lat']);
        $url = "https://router.project-osrm.org/route/v1/driving/{$coords}";

        $data = $this->httpGetJson($url, ['overview' => 'false']);
        if (empty($data['routes'][0])) {
            return null;
        }

        return [
            'distance_km' => round($data['routes'][0]['distance'] / 1000, 2),
            'duration_min' => round($data['routes'][0]['duration'] / 60, 0),
            'raw' => $data['routes'][0],
        ];
    }

    /**
     * Simple GET helper that returns decoded JSON or null.
     */
    protected function httpGetJson($url, $params = [], $headers = [])
    {
        $query = '';
        if (!empty($params)) {
            $query = '?' . http_build_query($params);
        }

        $ch = curl_init($url . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $body = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($body === false || $err) {
            return null;
        }

        $decoded = json_decode($body, true);
        return $decoded ?: null;
    }

    /**
     * Fetch Nominatim raw response and curl diagnostics for debugging.
     */
    protected function fetchNominatimDebug($address)
    {
        $url = 'https://nominatim.openstreetmap.org/search';
        $query = '?' . http_build_query(['q' => $address, 'format' => 'json', 'limit' => 1]);

        $ch = curl_init($url . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: Laravel App (OSRM integration)']);

        $body = curl_exec($ch);
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($body, true);
        return ['curl_error' => $err ?: null, 'http_code' => $httpCode ?: null, 'body' => $body ?: null, 'decoded' => $decoded ?: null];
    }
}
