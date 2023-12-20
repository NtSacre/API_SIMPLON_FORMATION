<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreFormationRequest extends FormRequest
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
            'name' => ['required', 'min:2'],
            'description' => ['required', 'min:5'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required'],

            
           
        ];
    }
    public function failedValidation(validator $validator ){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorList'=>$validator->errors()
        ]));
    }
    public function messages(): array
    {
        return [
            'name.required'=> 'Le champs nom est obligatoire',
            'start_date.required'=> 'Le champs date de debut  est obligatoire',
            'end_date.required'=> 'Le champs date de fin  est obligatoire',
            'status.required'=> 'Le champs status  est obligatoire',

            
            'description.required'=> 'Le champs description est obligatoire et doit contenir au moins 5 caractères',
          
        ];
    }
}
