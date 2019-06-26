<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\FeedBack;
use App\Notifications\FeedBackNotification;
use Illuminate\Support\Facades\Notification;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback', []);
    }

    public function add(FeedbackRequest $request)
    {
        FeedBack::create($request->all());

        Notification::send(null, new FeedBackNotification());

        session()->flash(
            'message-success',
            'Сообщение успешно отправлено'
        );

        return back();
    }
}