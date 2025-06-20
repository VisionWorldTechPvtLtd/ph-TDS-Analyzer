<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pump;
use App\Models\HaryanaApi;
use App\Models\HWRAPiezometer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class HaryanaapiController extends Controller
{
    protected $allPumps;

    public function __construct()
    {
        $this->allPumps = Pump::all();
    }

    public function index(Request $request)
    {
        return view('admin.Haryana', ['pump' => $this->allPumps]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'b_id' => 'required|integer|exists:pumps,id',
            'nocnumber' => 'required|string',
            'userkey' => 'required|string',
            'companyname' => 'required|string',
            'abstructionstructurenumber' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'vendorfirmsname' => 'required|string',
            'sensor' => 'required|in:0,1,2',
        ]);
        HaryanaApi::create([
            'b_id' => $request->input('b_id'),
            'nocnumber' => $request->input('nocnumber'),
            'userkey' => $request->input('userkey'),
            'companyname' => $request->input('companyname'),
            'abstructionstructurenumber' => $request->input('abstructionstructurenumber'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'vendorfirmsname' => $request->input('vendorfirmsname'),
            'sensor' => $request->input('sensor'),
        ]);
        return redirect()->back()->with('success', 'API created successfully.');
    }
    
// public function hwraApi()
// {
//     $data = HaryanaApi::with('pump', 'pump.pumpData')->first();
// //  dd($data);   
//     $postData = [
//         'nocnumber' => $data->nocnumber,
//         'userkey' => $data->userkey,
//         'companyname' => $data->companyname,
//         'abstructionstructurenumber' => $data->abstructionstructurenumber,
//         'FLowMeterReading' => $data->pump->pumpData->forward_flow,
//         'latitude' => $data->latitude,
//         'longitude' => $data->longitude,
//         'FLowMeterReadingDatetime' =>date('Y-m-d h:i:s'),
//         'vendorfirmsname' => $data->vendorfirmsname,    
//     ];
// //  dd($postData);
//     try {
//         $response = Http::withHeaders([   
//             'Content-Type' => 'application/json',  
//         ])->timeout(60)->post('https://hwra.org.in/hwraapi/api/flowmeter/AddFlowmeterdata', $postData);

//         Log::info("HRWA API Response :: ". json_encode($response));

//         Log::info("HRWA API Response :: ". json_encode($response->json()));
    
//     //    dd($response->json());

//         $externalData = json_decode($response->getBody()->getContents(), true);

//         return response()->json([
//             'message' => 'Data successfully sent to the HWRA API.',
//             'response' => $response->json()
//         ]);

//     } catch (Exception $e) {
//         Log::error('Error sending data to HWRA API:', [
//             'message' => $e->getMessage(),
//         ]);

//         return response()->json([
//             'message' => $e->getMessage(),
//         ], 500);
//     }
// }
public function hwraApi()
{
    $data = HaryanaApi::with('pump', 'pump.pumpData')->get();
    $allPostData = [];
    $responses = [];

    foreach ($data as $item) {
        $pump = $item->pump;

        // Ensure pump and pumpData exist
        if (!$pump || $pump->pumpData->isEmpty()) {
            Log::warning("Missing pump or pumpData for HaryanaApi ID: {$item->id}");
            continue;
        }

        $latestPumpData = $pump->pumpData->sortByDesc('created_at')->first();

        $postData = [
            'nocnumber' => $item->nocnumber,
            'userkey' => $item->userkey,
            'companyname' => $item->companyname,
            'abstructionstructurenumber' => $item->abstructionstructurenumber,
            'FLowMeterReading' => $latestPumpData->forward_flow,
            'latitude' => $item->latitude,
            'longitude' => $item->longitude,
            'FLowMeterReadingDatetime' => date('Y-m-d H:i:s'),
            'vendorfirmsname' => $item->vendorfirmsname,    
        ];

        $allPostData[] = $postData;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://hwra.org.in/hwraapi/api/flowmeter/AddFlowmeterdata', $postData);

            Log::info("HWRA API Response for ID {$item->id}: " . json_encode($response->json()));
            $responses[] = [
                'response' => $response->json()
            ];

        } catch (Exception $e) {
            Log::error("Error sending data for ID {$item->id}", [
                'message' => $e->getMessage(),
            ]);

        }
    }

    // Return all results after loop
    return response()->json([
        'message' => 'Processed all HaryanaApi records.',
        // 'data_sent' => $allPostData,
        'api_responses' => $responses,
    ]);
}


 public function HWRAPiezometer(){
        return view('admin.HWRAPiezometer',['pump' => $this->allPumps]);
    }

     public function HWARstore(Request $request)
    {
        $request->validate([
            'b_id' => 'required|integer|exists:pumps,id',
            'nocnumber' => 'required|string',
            'userkey' => 'required|string',
            'companyname' => 'required|string',
            'piezostructurenumber' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'vendorfirmsname' => 'required|string',
        ]);
        HWRAPiezometer::create([
            'b_id' => $request->input('b_id'),
            'nocnumber' => $request->input('nocnumber'),
            'userkey' => $request->input('userkey'),
            'companyname' => $request->input('companyname'),
            'piezostructurenumber' => $request->input('piezostructurenumber'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'vendorfirmsname' => $request->input('vendorfirmsname'),
        ]);
        return redirect()->back()->with('success', 'API created successfully.');
    }


    public function piezometer()
{
    $data = HWRAPiezometer::with('pump', 'pump.pumpData')->get();
    $allPostData = [];
    $responses = [];

    foreach ($data as $item) {
        $pump = $item->pump;
        if (!$pump || $pump->pumpData->isEmpty()) {
            Log::warning("Missing pump or pumpData for HaryanaApi ID: {$item->id}");
            continue;
        }

        $latestPumpData = $pump->pumpData->sortByDesc('created_at')->first();

        $postData = [
            'nocnumber' => $item->nocnumber,
            'userkey' => $item->userkey,
            'companyname' => $item->companyname,
            'piezostructurenumber' => $item->piezostructurenumber,
            'PiezoMeterDepth' => $latestPumpData->ground_water_level,
            'latitude' => $item->latitude,
            'longitude' => $item->longitude,
            'PiezoMeterDepthDatetime' => date('Y-m-d H:i:s'),
            'vendorfirmsname' => $item->vendorfirmsname,    
        ];

        $allPostData[] = $postData;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://hwra.org.in/hwraapi/api/Piezometer/AddPiezometerData', $postData);

            Log::info("HWRA API Response for ID {$item->id}: " . json_encode($response->json()));
            $responses[] = [
                'response' => $response->json()
            ];

        } catch (Exception $e) {
            Log::error("Error sending data for ID {$item->id}", [
                'message' => $e->getMessage(),
            ]);

        }
    }

    // Return all results after loop
    return response()->json([
        'message' => 'Processed all HaryanaApi records.',
        'data_sent' => $allPostData,
        'api_responses' => $responses,
    ]);
}

}



