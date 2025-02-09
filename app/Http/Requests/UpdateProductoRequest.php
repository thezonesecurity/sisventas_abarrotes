<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $producto = $this->route('producto');
        return [
            'codigo' => 'required|unique:App\Models\Producto,codigo,'.$producto->id.'|max:50|min:2',
            'nombre' => 'required|unique:App\Models\Producto,nombre,'.$producto->id.'|max:50|min:2',
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'imagen_path' => 'nullable|image|mimes:png,jpg,jpeg,png|max:2048',
            'marca_id' => 'required|integer|exists:App\Models\Marca,id',
            'presentacion_id' => 'required|integer|exists:App\Models\Presentacion,id',
            'categorias' => 'required'
        ];
    }
    public function attributes() //para cambiar el nombre de la variable
    {
        return[
            'marca_id' => 'marca',
            'presentacion_id' => 'presentacion'
        ];
    }
    public function messages()//para vambair el mensaje de la variable
    {
        return[
            'codigo.required' => 'Se requiere un codigo',
        ];
    }
}
