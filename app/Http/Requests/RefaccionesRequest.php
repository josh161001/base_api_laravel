<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefaccionesRequest extends FormRequest
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
            'id_categoria' => ['required', 'integer'],
            'id_marca' => ['required', 'integer'],
            'id_linea' => ['required', 'integer'],
            'id_clave_sat' => ['required', 'integer'],
            'modelo' => ['required', 'string'],
            'cantidad' => ['required', 'integer'],
            'sku' => ['required', 'string'],
            'informacion' => ['required', 'string'],
            'descripcion' => ['required', 'string'],

        ];
    }


    public function message(): array
    {
        return [
            'id_categoria.required' => 'La categoria es requerida',
            'id_categoria.integer' => 'La categoria debe ser un número',
            'id_marca.required' => 'La marca es requerida',
            'id_marca.integer' => 'La marca debe ser un número',
            'id_linea.required' => 'La linea es requerida',
            'id_linea.integer' => 'La linea debe ser un número',
            'id_clave_sat.required' => 'La clave sat es requerida',
            'id_clave_sat.integer' => 'La clave sat debe ser un número',
            'modelo.required' => 'El modelo es requerido',
            'modelo.string' => 'El modelo debe ser una cadena',
            'cantidad.required' => 'La cantidad es requerida',
            'cantidad.integer' => 'La cantidad debe ser un número',
            'sku.required' => 'El sku es requerido',
            'sku.string' => 'El sku debe ser una cadena',
            'informacion.required' => 'La informacion es requerida',
            'informacion.string' => 'La informacion debe ser una cadena',
            'descripcion.required' => 'La descripcion es requerida',
            'descripcion.string' => 'La descripcion debe ser una cadena',
        ];
    }
}
