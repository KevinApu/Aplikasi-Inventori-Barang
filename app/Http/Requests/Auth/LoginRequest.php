<?php

namespace App\Http\Requests\Auth;

use App\Models\KLModel;
use App\Models\KLUsers;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required',
            'password' => 'required',
        ];
    }


    public function assignRole()
    {
        $password = $this->input('password');
        $username = $this->input('username');

        $user = KLUsers::where('username', $username)
            ->where('password', $password)
            ->first();

        if ($user) {
            return [
                'role' => $user->role, // Mengambil role dari KLUsers
                'pop' => $user->pop,   // Mengambil pop dari KLUsers
            ];
        }

        $superadmin = KLModel::where('password_superadmin', $password)->first();
        if ($superadmin) {
            if ($superadmin) {
                return [
                    'role' => 'superadmin', 
                    'pop' => null,           
                ];
            }
        }

        return null;
    }
}
