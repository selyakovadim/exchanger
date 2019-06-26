<?php

namespace App\Http\Requests;

use App\Models\Reserve;

class WalletsRequest extends FormRequest
{
    protected function after($instance)
    {
        $reserve = Reserve::select('id', 'regex')
            ->findOrFail($this->input('valut_id'));

        if (!preg_match($reserve->regex, $this->input('schet')[$reserve->id])) {
            $instance->errors()->add('schet.invalid_format', 'Неверный формат счёта');
        }
    }

    public function rules()
    {
        return [];
    }
}
