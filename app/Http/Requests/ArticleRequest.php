<?php

namespace App\Http\Requests;


use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer.firstname' => 'required',
            'customer.lastname' => 'required',
            'customer.email' => 'required',
            'customer.telephone' => 'required',
            'customer.address.address_1' => 'required',
            'customer.address.city' => 'required',
            'customer.address.postcode' => 'required',


        ];
    }
 /**
     * Get the error messages that apply to the request parameters.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer.firstname' => 'Firstname field is required',
            'customer.lastname' => 'Lastname field is required',
            'customer.email' => 'Email field is required',
            'customer.telephone' => 'Telephone field is required',
            'customer.address.address_1' => 'Address field is required',
            'customer.address.city' => 'City field is required',
            'customer.address.postcode' => 'Postcode field is required',
    
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
