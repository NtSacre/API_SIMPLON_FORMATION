<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required', 'min:5', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required','min:8'],
            'role_id' => ['required'],
            'address' => ['required'],
            'telephone' => ['required','regex:/^(70|75|76|77|78)[0-9]{7}$/'],
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
            'email.required'=> 'Le champs email est obligatoire',
            'role_id.required'=> 'Le champs role_id est obligatoire',
            'address.required'=> 'Le champs adresse est obligatoire',
            'telephone.required'=> 'Le champs telephone est obligatoire et doit commencer par 78 ou 77 ou 76 ou 70',
            'password.required'=> 'Le champs mot de passe est obligatoire et doit contenir minimum 8 caracteres',
            
        ];
    }
}
