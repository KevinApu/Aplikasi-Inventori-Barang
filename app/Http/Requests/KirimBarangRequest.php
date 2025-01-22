<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KirimBarangRequest extends FormRequest
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
            'barang.*.nama_barang' => 'required|string',
            'barang.*.seri'        => 'required|string',
            'barang.*.jumlah'      => 'required|numeric',
            'barang.*.satuan'      => 'required|string',
            'barang.*.lokasi'      => 'required|string',
        ];
    }
}
