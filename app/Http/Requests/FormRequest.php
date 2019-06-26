<?php

namespace App\Http\Requests;


class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function validate()
    {
        $this->prepareForValidation();

        $instance = $this->getValidatorInstance();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (! $instance->passes()) {
            $this->failedValidation($instance);
        }

        $this->after($instance);

        if (!$instance->messages()->isEmpty()) {
            $this->failedValidation($instance);
        }
    }

    protected function after($instance)
    {
    }
}