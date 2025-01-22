<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangMasukRequest extends FormRequest
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
            'kodebarang' => 'required',
            'kategori'      => 'required|not_in:new',
            'namabarang'    => 'required|not_in:new',
            'seri'         => 'required',
            'jumlah'         => 'required|numeric',
            'lokasi'         => 'required',
            'foto'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ];
    }
}
