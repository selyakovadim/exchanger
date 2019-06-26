<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\PersonalDataRequest;
use App\Models\UserData;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('user.account', []);
    }

    public function personalData(PersonalDataRequest $request)
    {
        UserData::updateOrCreate(
            ['user_id' => Auth::id(), 'key' => UserData::NAME ],
            ['value' => $request->input('name')]
        );

        session()->flash(
            'message-success',
            'Данные успешно сохранены'
        );

        return back();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->user()->changePassword($request->input('password'));

        session()->flash(
            'message-success',
            'Пароль изменён'
        );

        return back();
    }
}
