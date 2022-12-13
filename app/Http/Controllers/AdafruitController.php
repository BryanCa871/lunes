<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdafruitController extends Controller
{
    public function humedad (){
        $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-humedad?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");

        return response()->json([
            "status"=>201,
            "message"=>"Correcto",
            "error"=>null,
            "sensores"=>$response->object()->id,
            "datas"=>$response->object()->last_value,
            ],201);
        }  
        
        public function luz (){
            $response = Http::get("	https://io.adafruit.com/api/v2/eder24m3za/feeds/luz?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
            return response()->json([
                "status"=>201,
                "message"=>"Correcto",
                "error"=>null,
                "sensores"=>$response->object()->id,
               "datas"=>$response->object()->last_value,
                ],201);
            } 

            public function corrientemax(){
                $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-imax?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
        
                return response()->json([
                    "status"=>201,
                    "message"=>"Correcto",
                    "error"=>null,
                    "sensores"=>$response->object()->id,
                   "datas"=>$response->object()->last_value,
                    ],201);
                } 

                public function corrientemin (){
                    $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-imin?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
            
                    return response()->json([
                        "status"=>201,
                        "message"=>"Correcto",
                        "error"=>null,
                        "sensores"=>$response->object()->id,
                       "datas"=>$response->object()->last_value,
                        ],201);
                    } 

                    public function corrientewatts (){
                        $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-watts?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                
                        return response()->json([
                            "status"=>201,
                            "message"=>"Correcto",
                            "error"=>null,
                            "sensores"=>$response->object()->id,
                           "datas"=>$response->object()->last_value,
                            ],201);
                        } 

                        public function temperatura (){
                            $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-temperatura?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                    
                            return response()->json([
                                "status"=>201,
                                "message"=>"Correcto",
                                "error"=>null,
                                "sensores"=>$response->object()->id,
                               "datas"=>$response->object()->last_value,
                                ],201);
                            } 

                            public function magnetico (){
                                $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-magnetico?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                        
                                return response()->json([
                                    "status"=>201,
                                    "message"=>"Correcto",
                                    "error"=>null,
                                    "sensores"=>$response->object()->id,
                                   "datas"=>$response->object()->last_value,
                                    ],201);
                                } 

                                public function pir (){
                                    $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-movimiento?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                            
                                    return response()->json([
                                        "status"=>201,
                                        "message"=>"Correcto",
                                        "error"=>null,
                                        "sensores"=>$response->object()->id,
                                       "datas"=>$response->object()->last_value,
                                        ],201);
                                    } 

                                    public function gas (){
                                        $response = Http::get("https://io.adafruit.com/api/v2/eder24m3za/feeds/default-dot-humo?X-AIO-KEY=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                                
                                        return response()->json([
                                            "status"=>201,
                                            "message"=>"Correcto",
                                            "error"=>null,
                                            "sensores"=>$response->object()->id,
                                           "datas"=>$response->object()->last_value,
                                            ],201);
                                        } 

                 
                            
                                public function crearsalones(Request $request){
                                    $validacion = validator::make(
                                        $request->all(),
                                             [
                                                    "nombre"=>"required|Max:255",
                                            ]);
                                        if($validacion->fails())
                                            {
                                                return response()->json(
                                                    [
                                                        "status"=>400,
                                                        "mensaje"=>"validacion no exitosa",
                                                        "Error"=>$validacion->errors(),
                                                        "Data"=>[]
                                                        ],400);
                                            }
                                
                                            $response= Http::post("https://io.adafruit.com/api/v2/eder24m3za/groups?x-aio-key=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi",[
                                                "name"=>$request->nombre,
                                            ]);
                                
                                            if($response->successful()){
                                                $feeds = array("Humo","Luz","Magnetico","Humedad","Temperatura");
                                
                                                for($i=0; $i<=4; $i++){
                                                    $response2 = Http::post("https://io.adafruit.com/api/v2/eder24m3za/groups/".$request->nombre."/feeds?x-aio-key=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi",[
                                                        "name"=>$feeds[$i],
                                                    ]);
                                                }
                                
                                                if($response2->successful()){
                                                    $response3=Http::get("https://io.adafruit.com/api/v2/eder24m3za/groups/".$request->nombre."?x-aio-key=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi");
                                                    return response()->json([
                                                        "status"=>200,
                                                        "message"=>"feed creada",
                                                        "error"=>null,
                                                        "data"=>$response3->json()
                                                    ],200);
                                                }
                                            }
                                
                                        }
                                    }
