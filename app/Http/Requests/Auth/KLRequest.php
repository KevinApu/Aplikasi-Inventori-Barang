<?php

namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;

class KLRequest extends FormRequest
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
            'kodepop' => 'required|string|unique:kantor_layanan,pop',
            'lokasikantor' => 'required|string|unique:kantor_layanan,lokasi',
            'alamatkantor' => 'required|string|unique:kantor_layanan,alamat',
            'kepalakantor' => 'required|string',
        ];
    }



    public function messages()
    {
        return [
            'kodepop.required' => 'Kode POP harus diisi.',
            'kodepop.unique' => 'Kode POP sudah terdaftar.',

            'lokasikantor.required' => 'Lokasi Kantor harus diisi.',
            'lokasikantor.unique' => 'Lokasi kantor sudah terdaftar.',

            'alamatkantor.required' => 'Alamat Kantor harus diisi.',
            'alamatkantor.unique' => 'Alamat kantor sudah terdaftar.',

            'kepalakantor.required' => 'Kepala Kantor harus diisi.',
        ];
    }
}
