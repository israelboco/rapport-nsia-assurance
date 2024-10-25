<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'code_unique' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'role_id' => ['integer', 'exists:roles,id'],
        ];
    }

     /**
     * Mapper la réponse API à la requête.
     */
    public function mapFromApiResponse(array $data)
    {
        $this->merge([
            'nom' =>  $data['nom'],
            'prenom' =>  $data['prenom'],
            'code_unique' => $data['code_unique'],
            'email' =>  $data['email'],
            'role_id' =>  $data['role_id'],
        ]);
    }
}
