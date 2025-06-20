<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApiErrors;
use App\Models\Pump;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;
use PgSql\Lob;
use ZipArchive;

class APIController extends Controller
{

    public function siteApi(){
        try{ 
            $timeStamp = strtotime(now());
            $metadataHeadings = [
                "SITE_ID",	
                "SITE_UID",	
                "MONITORING_UNIT_ID", 
                "ANALYZER_ID", 
                "PARAMETER_ID",
                "PARAMETER_NAME",
                "READING",
                "UNIT_ID",	
                "DATA_QUALITY_CODE",	
                "RAW_READING",	
                "UNIX_TIMESTAMP",	
                "CALIBRATION_FLAG",	 
                "MAINTENANCE_FLAG",
            ];

            $siteDataHeadings = [
                "SITE_ID",
            ];

            $metadata= [];
            $siteData = [];

            $pumps = Pump::with('pumpData')->where("site_api_status", 1)->get();


            foreach ($pumps as $key => $pump) {
                $metadata[] = [
                    "SITE_ID" => "site_789",
                    "SITE_UID" => "site_789",
                    "MONITORING_UNIT_ID" => $pump->monitoring_unit_id,
                    "ANALYZER_ID" => "analyzer_436",
                    "PARAMETER_ID" => "parameter_95",
                    "PARAMETER_NAME" => "Flow",
                    "READING" => $pump->pumpData->first()->forward_flow,
                    "UNIT_ID" => "unit_12",
                    "DATA_QUALITY_CODE" => "U",
                    "RAW_READING" => $pump->pumpData->first()->forward_flow,
                    "UNIX_TIMESTAMP" => $timeStamp,
                    "CALIBRATION_FLAG" => 0,
                    "MAINTENANCE_FLAG" => 0,
                ];
                $siteData[] = [
                    "site_789",
                    "site_789",
                    $pump->monitoring_unit_id,
                    "analyzer_436",
                    "parameter_95",
                    "Flow",
                    $pump->pumpData->first()->forward_flow,
                    "unit_12",
                    "U",
                    $pump->pumpData->first()->forward_flow,
                    $timeStamp,
                    0,
                    0,
                ];
            }

            $metaDataCSV =$this->createCSV("metadata.csv", $metadata, $timeStamp, $metadataHeadings);
            if(!$metaDataCSV) throw new Exception("Could not create metadata.csv");
            $siteDataCSV = $this->createCSV("site_789_STACK1_".$timeStamp.".csv", $metadata, $timeStamp);
            if(!$siteDataCSV) throw new Exception("Could not create site_789_STACK1_".$timeStamp.".csv");
            $zip = $this->createZip($timeStamp);
            if(!$zip) throw new Exception("Could not create ".$timeStamp.".zip file");
            $response = $this->apiCall($zip, $timeStamp);
            if(!$response && empty($response)) throw new Exception("Could not call api");
            $response = json_decode($response, true);
            if($response['status'] == "Success") {
                $this->deleteZip($zip);
                //Log::info("File Deleted Successfull");
            }else{
                $this->registerApiError($response);
            }
            // Log::info("API Call Successfull");
            return response()->json([
                "status" => true,
                "message" => "Successfully Submitted",
            ]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ]);
        }
       
    }


    public function createCSV($fileName, $data=null, $timeStamp, $hadings=null){
        try{
            File::makeDirectory(public_path('exports/site_789_STACK1_'.$timeStamp), 0777, true, true);
            $csv = fopen('exports/site_789_STACK1_'.$timeStamp.'/'.$fileName, 'w');
            if($hadings != null) fputcsv($csv, $hadings);
            if($data != null){
                foreach ($data as $row) {
                    fputcsv($csv, $row);
                }
            }
            fclose($csv);
            return true;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createZip($timeStamp){
        try{
            $zip = new ZipArchive();
            $zipPathAndName = public_path('exports/site_789_STACK1_'.$timeStamp.'.zip');
        
            if ($zip->open($zipPathAndName, ZipArchive::CREATE) !== TRUE) {
                echo 'Could not open ZIP file.';
                return;
            } 

            $zip->addFile(public_path('exports/site_789_STACK1_'.$timeStamp.'/metadata.csv'), 'metadata.csv');
            $zip->addFile(public_path('exports/site_789_STACK1_'.$timeStamp.'/site_789_STACK1_'.$timeStamp.'.csv'), 'site_789_STACK1_'.$timeStamp.'.csv');

            $zip->close();
            return $zipPathAndName;     
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteZip($zip){
        try{
            File::deleteDirectory(str_replace(".zip", "", $zip));
            File::delete($zip);
            return true;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function apiCall($zip, $timeStamp){
        try{
             $file = New File($zip);
             $response = Http::attach("file", file_get_contents($zip), 'site_789_STACK1_'.$timeStamp.".zip")
                 ->post('http://rspcboms.environment.rajasthan.gov.in/GLensServer/upload', ["filename" => $timeStamp.".zip"]);
           
            //  Log::info($response);
             
             return $response->body();
 
         }catch(Exception $e){
             Log::error($e->getMessage());
             return false;
         }
         
    }

    public function delaidApiCall($zip, $timeStamp){
        try{
            $file = New File($zip);
            $response = Http::attach("file", file_get_contents($zip), $timeStamp.".zip")
                ->post('http://rspcboms.environment.rajasthan.gov.in/GLensServer/delayedUpload', ["filename" => $timeStamp.".zip"]);

            //  Log::info($response);

            return $response;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        
    }

    

    public function registerApiError($response){
        try{
            ApiErrors::create([
                "status" => false,
                "title" => "API Call Failed",
                "error_message" => $response['statusMessage'],
            ]);
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }


}


