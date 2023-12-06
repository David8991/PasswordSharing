<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\adminCrateUser;
use App\Http\Requests\adminEditUser;
use App\Http\Requests\updateUserPassword;;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    public function usersAll () 
    {
        $data = User::all();
        
        return view("inc.usersAll", ["data" => $data]);
    }

    public function createUser (adminCrateUser $req)
    {
        // Создаем нового пользователя в БД
        $user = new User();
        $user->name = $req->input("name");
        $user->email = $req->input("email");
        $user->password = Hash::make($req->input("password"));
        $user->save();

        return redirect()->route('usersAll');
    }

    public function editUser (adminEditUser $req)
    {   
        // Определение Отправителя и сравнение с Админом
        if ($req->input("userId") == 2)
        {
            // Определение редактируемого пользователя
            $user = User::where("id", $req->input("editUserId"))->first();

            // Принудительное обновление данных 
            $user->forceFill([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
            ])->save();

            return response()->json('Fetch request submitted successfully');
        }
    }

    public function updateUserPassword(updateUserPassword $req)
    {
        $user = User::where("id", $req->input("editUserId"))->first();

        $user->forceFill([
            'password' => Hash::make($req->input("password")),
        ])->save();
    }

    public function deleteUser ($userId)
    {
        $deleteUser = User::where("id", $userId)->first();
        $deleteUser->delete();

        return redirect()->route("usersAll");
    }
}
