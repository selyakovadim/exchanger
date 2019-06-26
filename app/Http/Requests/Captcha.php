<?php

namespace App\Http\Requests;

trait Captcha
{
    public function validator($factory)
    {
        $rules = $this->rules();
        $messages = $this->messages();

        if (!empty(config('captcha.secret')) && !empty(config('captcha.sitekey'))) {
            $rules['g-recaptcha-response'] = 'required|captcha';
            $messages['g-recaptcha-response.*'] = 'Подтвердите, что Вы не робот';
        }

        $validator = $factory->make(
            $this->validationData(), $rules,
            $messages, $this->attributes()
        );

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        return $validator;
    }
}