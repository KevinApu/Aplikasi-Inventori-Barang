<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRusakRequest extends FormRequest
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
            'jumlah_rusak' => 'required|integer|min:1',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'kondisi' => 'required|string|max:255',
            'penyebab' => 'required|string|max:255',
            'barcode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'foto.required' => 'Foto wajib diunggah!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
        ];
    }
}
