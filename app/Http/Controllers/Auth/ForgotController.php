<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    public function index()
    {
        return view('auth.forgot', []);
    }

    public function reset(ForgotRequest $request)
    {
        $user = User::where('email', $request->input('email'))
            ->first();

        $password = str_random(8);
        $user->changePassword($password);

        Mail::to($user)->send(new ResetPassword($password));

        $request->session()->flash(
            'message-success',
            'Новый пароль отправлен на Вашу почту'
        );

        return back();
    }
}
