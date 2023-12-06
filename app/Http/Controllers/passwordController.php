<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\password;
use App\Models\Passwords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class passwordController extends Controller
{
    public function createPass(password $req) 
    {
        // Определение отправителя
        $user = DB::table("users")->where("id", $req->input("userId"))->first();

        // Шифрование пароля
        $password = Crypt::encryptString($req->input("password"));

        // Добавление данных в БД
        $pass = new Passwords();
        $pass->user_id = $user->id;
        $pass->user_name = $user->name;
        $pass->password = $password;

        if ($user->email === "admin@mail.ru") 
        {
            if ($req->input("accessLevel") === "me")
            {
                $pass->accessLevel = 0;
            } else
            {
                $pass->accessLevel = 2;
            }
        } else
        {
            if ($req->input("accessLevel") === "me")
            {
                $pass->accessLevel = 1;
            } else
            {
                $pass->accessLevel = 2;
            }
        }
        $pass->save();

        return redirect()->route('dashboard');
    }

    public function viewPass (Request $req)
    {
        // Определение пароля по ID
        $pass = Passwords::all()->where("id", $req->input("passId"))->first();

        // Расшифровка пароля
        $passDecrypt = Crypt::decryptString($pass->password);

        return response()->json($passDecrypt);
    }

    public function editPass (Request $req)
    {
        // Определение отправителя
        $user = DB::table("users")->where("id", $req->input("userId"))->first();

        // Определение уровня доступа
        if ($user->email === "admin@mail.ru") 
        {
            if ($req->input("accessLevel") === "me")
            {
                $access = 0;
            } else
            {
                $access = 2;
            }
        } else
        {
            if ($req->input("accessLevel") === "me")
            {
                $access = 1;
            } else
            {
                $access = 2;
            }
        }

        // Шифрование пароля
        $password = Crypt::encryptString($req->input("password"));

        // Обновление данных в БД
        Passwords::where('id', $req->input("editPassId"))->update([
            "password" => $password,
            "accessLevel" => $access
        ]);

        return response()->json("Password Updated");
    }
}
