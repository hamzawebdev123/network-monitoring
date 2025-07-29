<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BandWidthController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    // Run a speed test
    public function runSpeedTest()
    {
        $results = shell_exec('python -m speedtest --json');
        $data = json_decode($results, true);

        if (!$data || !isset($data['download'], $data['upload'], $data['ping'])) {
            return response()->json(['error' => 'Speed test failed.']);
        }

        return response()->json([
            'download' => round($data['download'] / 1e6, 2),
            'upload' => round($data['upload'] / 1e6, 2),
            'ping' => $data['ping']
        ]);
    }


    // Fetch SNMP traffic stats
    // public function getTrafficStats()
    // {
    //     $inTraffic = snmpget('192.168.1.1', 'public', '1.3.6.1.2.1.2.2.1.10.1');
    //     $outTraffic = snmpget('192.168.1.1', 'public', '1.3.6.1.2.1.2.2.1.16.1');

    //     return response()->json([
    //         'incoming' => intval(str_replace('INTEGER: ', '', $inTraffic)),
    //         'outgoing' => intval(str_replace('INTEGER: ', '', $outTraffic)),
    //     ]);
    // }
    public function getTrafficStats()
    {
        $incoming = rand(1000, 5000); // Simulate incoming traffic
        $outgoing = rand(1000, 5000); // Simulate outgoing traffic

        return response()->json([
            'incoming' => $incoming,
            'outgoing' => $outgoing
        ]);
    }
}
