<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class LeadFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|string',
            'birthday' => 'required|date',
            'comment' => 'required|string',
        ];
    }
}
