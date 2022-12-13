<?php

namespace App\Http\Controllers;

use App\Models\salon;
use App\Models\salones;
use App\Models\sensores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FunctionController extends Controller
{
    /*public function registrarsensor(Request $request)
    {
        $validacion= validator::make(
            $request->all(),
            [
                "tipo_sensor"=>"required|Max:255",
               
            ],
            [
                'tipo_sensor' => ['temperatura', 'LAS'],
                'tipo_sensor.required'=>'el campo :attribute es obligatorio',
            
                
            ]
        );
           
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }

        $sensor = new sensores();

        $sensor ->tipo_sensor = $request->tipo_sensor;
    
        
        
        if($sensor->save())
        {

            return response()->json(
                [
                    "status"=>201,
                    "mensaje"=>"sensor registrado",
                    "error"=>null,
                    "data"=>$sensor,
                   'salon'=>$sensor,
                ],201
                );
        }
        else 
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"sensor no registrado",
                    "error"=>null,
                    "data"=>[]
                ],400
                );
        }

    }*/

    public function registrarsalon(Request $request)
    {
        $validacion= validator::make(
            $request->all(),
            [
                "nombre"=>"required|Max:60",
                "edificio"=>"required|Max:60",
                "ubicacion"=>"required|Max:60",
                "usuario"=>'required',
            ],
            [
                'nombre.required' => 'El campo :attribute es obligatorio',
                'nombre.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'edificio.required' => 'El campo :attribute es obligatorio',
                'edificio.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'ubicacion.required' => 'El campo :attribute es obligatorio',
                'ubicacion.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                "usuario.required"  => 'El campo :attribute es obligatorio',
            ]
        );
           
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }

        $salon = new salones(); 
        $user=User::find($request->usuario);
        if(!$user)
        {
            return response()->json(
                [
                    "status"=>401,
                    "mensaje"=>"Datos no ingresados correctamente",
                    "Error"=>"No se encontro el usuario, ingrese bien sus datos",
                    "Data"=>[]
                ], 401
                );

        }

        $salon = new salones(); 
        $sensor=sensores::find(1);
        if(!$sensor)
        {
            return response()->json(
                [
                    "status"=>402,
                    "mensaje"=>"Datos no ingresados correctamente",
                    "Error"=>"No se encontro el sensor, ingrese bien sus datos",
                    "Data"=>[]
                ], 402
                );

        }

        $salon = new salones();
        $salon ->nombre = $request->nombre;
        $salon ->edificio = $request->edificio;
        $salon ->ubicacion = $request->ubicacion;
        $salon ->usuario_id = $request->usuario;
        $salon ->sensor_id = '1';
        
        
        if($salon->save())
        {

            return response()->json(
                [
                    "status"=>200,
                    "mensaje"=>"Todo bien uwu",
                    "error"=>null,
                    "data"=>[]
                ],200
                );


         /*   $response= Http::post("https://io.adafruit.com/api/v2/eder24m3za/groups?x-aio-key=aio_Dpeh458qvhUveFCXyZiHRL0Q3VIi",[
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
                }*/
        }
        else 
        {

            if($salon->fail())

            return response()->json(
                [
                    "status"=>403,
                    "mensaje"=>"salon no registrado",
                    "error"=>null,
                    "data"=>[]
                ],403
                );
        }
    }



    public function modificarusuario(Request $request, $id)
    {
    
        $validacion = validator::make(
            $request->all(),
            [
                "name"=>"required|Max:255",
                "email"=>"required|Max:255",
                "password"=>"required|Max:255",
                "telefono"=>"required",
                "sexo"=>"required|in:femenino,masculino",
                "status"=>"required",
            ],
            
        );
        
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }


       $user = new User(); 
       $user = User::find($id);
       if($user)
       {
        $user ->name            = $request->name;
        $user ->email           = $request->email;
        $user ->password        = $request->password;
        $user ->telefono        = $request->telefono;
        $user ->sexo            = $request->sexo;
        $user ->status          = $request->status;
     
       if($user->save())
       {
        return response()->json(
            [
                "status"=>200,
                "mensaje"=>"los datos se modificaron de manera correcta",
                "error"=>null,
                "data"=>$user
            ],200
            );
       }
    }
    else
    {
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"usuario no encontrado",
                "error"=>[],
            ],400
        );
    }
}

/*public function modificarsensor(Request $request, $id)
{

    $validacion = validator::make(
        $request->all(),
        [
            
            "tipo_sensor"=>"required",
            "salon_id"=>"required",
            "status"=>"required",
        ],
        [
            "tipo_sensor.required"  => 'El campo :attribute es obligatorio',
            "salon_id.required"  => 'El campo :attribute es obligatorio',
            "status.required"  => 'El campo :attribute es obligatorio',
        ]
    );
    
    if($validacion->fails())
    {
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"validacion no exitosa",
                "Error"=>$validacion->errors(),
                "Data"=>[]
            ], 400
            );
    }

    /*$sensor = new sensores(); 
    $Servicio=Servicios::find($request->servicio);

    if(!$Servicio)
    {
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"Datos no ingresados correctamente",
                "Error"=>"No se encontro el servicio",
                "Data"=>[]
            ], 400
            );

    }


   $sensor = new sensores(); 
   $sensor = sensores::find($id);
   if($sensor)
   {
    $sensor ->tipo_sensor        = $request->tipo_sensor;
    $sensor ->salon_id           = $request->salon_id;
    $sensor ->status             = $request->status;
 
   if($sensor->save())
   {
    return response()->json(
        [
            "status"=>200,
            "mensaje"=>"los datos se modificaron de manera correcta",
            "error"=>null,
            "data"=>$sensor
        ],200
        );
   }
}
else
{
    return response()->json(
        [
            "status"=>400,
            "mensaje"=>"sensor no encontrado",
            "error"=>[],
        ],400
    );
}
}
*/

public function modificarsalon(Request $request, $id)
    {
    
        $validacion = validator::make(
            $request->all(),
            [
                "nombre"=>"required|Max:255",
                "edificio"=>"required|Max:255",
                "ubicacion"=>"required|Max:255",
                "usuario_id"=>"required",
                "status"=>"required|in:inactivo,activo",
            ],
            [
                'nombre.required' => 'El campo :attribute es obligatorio',
                'nombre.string' => 'El campo :attribute debe ser de tipo string',
                'nombre.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'edificio.required' => 'El campo :attribute es obligatorio',
                'edificio.string' => 'El campo :attribute debe ser de tipo string',
                'edificio.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'ubicacion.required' => 'El campo :attribute es obligatorio',
                'ubicacion.string' => 'El campo :attribute debe ser de tipo string',
                'ubicacion.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                "usuario_id.required"  => 'El campo :attribute es obligatorio',
                
            ]
        );
        
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }


       $salon = new salones(); 
       $salon = salones::find($id);
       if($salon)
       {
        $salon ->nombre             = $request->nombre;
        $salon ->edificio           = $request->edificio;
        $salon ->ubicacion          = $request->ubicacion;
        $salon ->status             = $request->status;
     
       if($salon->save())
       {
        return response()->json(
            [
                "status"=>200,
                "mensaje"=>"los datos se modificaron de manera correcta",
                "error"=>null,
                "data"=>$salon
            ],200
            );
       }
    }
    else
    {
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"salon no encontrado",
                "error"=>[],
            ],400
        );
    }
}

public function consultarssuario(Request $request)
{ 
    $user = new User();
    $user = DB::table('users')
             ->select('users.*')
             ->get();

             return response()->json(
                [
                    "datos"=>$user
                ]
                );
}

public function consultarsalonid(Request $request, $id)
{
    $user=$request->user();

    $salon = new salones();
    $salon = DB::table('users')
    ->join('salones','users.id','=','salones.usuario_id')
     ->select('salones.id','users.name','salones.usuario_id', 'salones.nombre', 'salones.edificio', 'salones.ubicacion')
     ->where('users.id','=',$id)
     ->get();

             return response()->json(
                [
                    "datos"=>$salon
                ]
                );
}

public function consultarsalon(Request $request)
{ 
    $salon = new salones();
    $salon = DB::table('salones')
             ->select('salones.*')
             ->get();

             return response()->json(
                [
                    "datos"=>$salon
                ]
                );
}

public function consultarsensor(Request $request)
{ 
    $sensor = new sensores();
    $sensor = DB::table('sensores')
             ->select('sensores.*')
             ->get();

             return response()->json(
                [
                    "datos"=>$sensor
                ]
                );
}

public function eliminarusuario(Request $request, $id)
    {
       $usuario = new User(); 
       $usuario = User::find($id);
       if($usuario)
       {
        $usuario ->status = 0;
       
       if($usuario->save())
       {
        return response()->json(
            [
                "status"=>201,
                "mensaje"=>"se elimino el usuario de manera exitosa",
                "error"=>null,
                "data"=>$usuario
            ],201
            );
       }
    }
    else
    {
        return response()->json(
            [
                "mensaje"=>"usuario no encontrado",
                "error"=>[],
            ],200
        );
    }
}

public function eliminarsalon(Request $request, $id)
    {
       $salon = new salones(); 
       $salon = salones::find($id);
       if($salon)
       {
        $salon ->status = "inactivo";
       
       if($salon->save())
       {
        return response()->json(
            [
                "status"=>201,
                "mensaje"=>"se elimino el salon de manera exitosa",
                "error"=>null,
                "data"=>$salon
            ],201
            );
       }
    }
    else
    {
        return response()->json(
            [
                "mensaje"=>"salon no encontrado",
                "error"=>[],
            ],200
        );
    }
}

public function eliminarsensor(Request $request, $id)
    {
       $sensor = new sensores(); 
       $sensor = sensores::find($id);
       if($sensor)
       {
        $sensor ->status = "inactivo";
       
       if($sensor->save())
       {
        return response()->json(
            [
                "status"=>201,
                "mensaje"=>"se elimino el sensor de manera exitosa",
                "error"=>null,
                "data"=>$sensor
            ],201
            );
       }
    }
    else
    {
        return response()->json(
            [
                "mensaje"=>"salon no encontrado",
                "error"=>[],
            ],200
        );
    }
}







}


