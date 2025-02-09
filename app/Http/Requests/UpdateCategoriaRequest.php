<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
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
        $categoria = $this->route('categoria');
        $caracteristicaID = $categoria->caracteristica->id;
        return [
             'nombre' => 'required|max:150|min:2|unique:App\Models\Caracteristica,nombre,'.$caracteristicaID,
             'descripcion' => 'nullable|max:255'
        ];
    }
}
