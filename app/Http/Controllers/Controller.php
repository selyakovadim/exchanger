<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Contact;
use App\Models\UserData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user_data = [];

    public function callAction($method, $parameters)
    {
        if (Auth::check()) {

            $collection = UserData::owned()
                ->select(['key', 'value'])
                ->get();

            foreach ($collection as $item) {
                $this->user_data[$item->key] = $item->value;
            }
        }

        View::share('alert', Alert::random());
        View::share('contacts', Contact::all());
        View::share('user_data', $this->user_data);

        return parent::callAction($method, $parameters);
    }
}
