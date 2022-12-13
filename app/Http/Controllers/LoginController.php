<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use App\Jobs\Mailer;
use App\Jobs\Sms;

class LoginController extends Controller
{
    public function registrar(Request $request)
    {
        $validacion= validator::make(
            $request->all(),
            [
                "name"=>"required|string|max:50",
                "email"=>"required|Max:255|unique:users",
                "password"=>"required|Min:5",
                "telefono"=>"required|Max:10",
                "sexo"=>"required|in:femenino,masculino",
            ],
            [
                'name.required' => 'El campo :attribute es obligatorio',
                'name.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'telefono.required' => 'El campo :attribute es obligatorio',
                'telefono.max' => 'El campo :attribute debe ser de maximo :max caracteres',
                'email.required'  => 'El campo :attribute es obligatorio',
                'email.string' => 'El campo :attribute debe ser de tipo string',
                'password.required'  => 'El campo :attribute es obligatorio',
                'password.min' => 'Password debe tener minimo 5 caracteres.',
                'email.unique'=>'Email repetido',            
            ]
        );
           
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"Validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }

        $user = new User();

        $user ->name = $request->name;
        $user ->email = $request->email;
        $user ->password =Hash::make($request->password);
        $user ->telefono = $request->telefono;
        $user ->sexo = $request->sexo;
        $user ->status = $request->status=1;
        
        
        if($user->save())
        {
           // Sms::dispatch()->delay(now()->addSeconds(10))->onQueue('sms')->onConnection('database');
            return response()->json(
                [
                    "status"=>201,
                    "mensaje"=>"Usuario registrado",
                    "error"=>null,
                    "id"=>$user->id,
                   'name'=>$user->name,
                   'email'=>$user->email,
                   'telefono'=>$user->telefono,
                   'sexo'=>$user->sexo,

                ],201
                );
         
        }
        else 
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"usuario no creado",
                    "error"=>null,
                    "data"=>[]
                ],400
                );
        }

    }


    







    public function createlogin(Request $request)
{
    $validacion= validator::make(
        $request->all(),
        [
            "email"=>"required|Max:255",
            "password"=>"required|Max:255"
        ]
    );
    if($validacion->fails())
    {
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"Validacion no exitosa",
                "Error"=>$validacion->errors(),
                "Data"=>[]
            ], 400
            );
    }
    $User = User::whereEmail($request->email)->first();
    if($User==null) return response()->json(["Error"=>"El usuario no encontrado"],400);
    if($User->status==false) return response()->json(["Error"=>"El usuario no esta verificado"],400);
    if(Hash::check($request->password, $User->password))

    if(!is_null($User) && Hash::check($request->password, $User->password))
    {
        $token=$User->CreateToken("Token")->plainTextToken;
        if($User->save())
        {
         return response()->json(
             [
                 "status"=>201,
                 "id"=>$User->id,
                 "mensaje"=>"Los datos se insertaron de manera correcta",
                 "error"=>null,
                 "data"=>$User,
                 "token"=>$token
             ],201
             );
        }
    }
    return response()->json(
        [
            "status"=>400,
            "mensaje"=>"Los no datos se insertaron de manera correcta",
            "error"=>[],
        ],400
        );

}




public function logout(Request $request)
    {
        $user=$request->user();
        
    return response()->json(
        [
            "status"=>201,
            "mensaje"=>"Se ha cerrado exitosamente",
            "error"=>null,
            "token"=>$request->user()->tokens()->delete(),
        ],201
        );    
    }


    public function verificarUsuario(Request $request){

        Sms::dispatch()->delay(now()->addSeconds(10))->onQueue('sms')->onConnection('database');
        return response()->json(
            [
                "status"=>200,
                "link"=>"",
                "mensaje"=>"Por favor verifique su numero",
                "error"=>null,
                "data"=>[],
            ],200
            );
    }

    public function verificarSms(Request $request){
        $validacion= validator::make(
            $request->all(),
            [
                "codigo"=>"required",
                "request_id"=>"required",
                "email"=>"required"
            ]
        );
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"Validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }
        $response = Http::get("https://api.nexmo.com/verify/check/json?&api_key=03eddd22&api_secret=fusBzsgRQBPc24aPrequest_id=$request->request_id&code=$request->codigo");

        if($response->successful()){
            $User = User::whereEmail($request->email)->first();
            if(!is_null($User)){

                $User->status=1;
                if($User->save()){
                    return response()->json(
                        [
                            "status"=>200,
                            "mensaje"=>"Validacion exitosa",
                            "Error"=>[],
                            "Data"=>[]
                        ], 200
                        );

                }
                
            }
        }

    }



    public function activarCuenta(Request $request)
    {
        $validacion= validator::make(
            $request->all(),
            [
                "email"=>"required|Max:255",
                "password"=>"required|Max:255"
            ],
            [
                'email.unique'=>'Email repetido',
                'password.required'  => 'El campo :attribute es obligatorio',  
            ]
        );
        if($validacion->fails())
        {
            return response()->json(
                [
                    "status"=>400,
                    "mensaje"=>"Validacion no exitosa",
                    "Error"=>$validacion->errors(),
                    "Data"=>[]
                ], 400
                );
        }
    
        $User = new User();
        $User = User::whereEmail($request->email)->first();
        if(!is_null($User) && Hash::check($request->password, $User->password))
        {
            if($User->save())
            {
                $response=Http::post("http://127.0.0.1:9000/api/v4/job/mailCuenta",[
                    "User"=>$User->id,
                    "Url"=>URL::signedRoute('validacion',['user'=>$User])
                ]);

                if($response->successful()){
                    return response()->json(
                        [
                            "status"=>201,
                            "mensaje"=>"Los datos se insertaron de manera correcta",
                            "error"=>null,
                            "data"=>$User,
                        ],201
                        );

                }
                return response()->json(
                    [
                        "status"=>400,
                        "mensaje"=>"Mal",
                        "error"=>null,
                        "data"=>$User,
                    ],400
                    );

            }
    
        }
    
        return response()->json(
            [
                "status"=>400,
                "mensaje"=>"Los datos no son correctos",
                "error"=>null,
                "data"=>$User,
            ],400
            );
    }
}