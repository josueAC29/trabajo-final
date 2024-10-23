<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aulas; 


class AulasController extends Controller {
    public function aulas() {
        $aulas = Aulas::all();
        return view('admin.aulas.aulas', compact('aulas'));
    }

    public function postAula(Request $request) {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edificio' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'cupo' => 'required|integer',
            'estatus' => 'required|string|max:50',
        ]);

        // Creación de un nuevo registro en la base de datos
        Aulas::create([
            'nombre' => $request->nombre,
            'edificio' => $request->edificio,
            'tipo' => $request->tipo,
            'cupo' => $request->cupo,
            'estatus' => $request->estatus,
        ]);

        return response()->json(['success' => 'Aula registrada con éxito.']);
    }


    public function getAulaData($id)
    {
    // Asegúrate de usar el nombre correcto de la columna
    $aula = Administrador::where('id_aula', $id)->first();

    if ($aula) {
        return response()->json($aula);
    } else {
        return response()->json(['error' => 'Aula no encontrada no encontrado.'], 404);
    }
    }
   


    public function updateAula(Request $request)
    {
    // Validar los datos del formulario
    $request->validate([
        'id_aula' => 'required|exists:aulas,id_aula', // Asegúrate de que el nombre de la columna sea correcto
        'nombre' => 'required|string|max:255',
        'edificio' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'cupo' => 'required|integer',
        'estatus' => 'required|string|max:50',
    ]);

    // Encontrar el aula por ID
    $aula = Aulas::where('id_aula', $request->id_aula)->first();

    if ($aula) {
        try {
            // Actualizar los datos del aula
            $aula->nombre = $request->nombre;
            $aula->edificio = $request->edificio;
            $aula->tipo = $request->tipo;
            $aula->cupo = $request->cupo;
            $aula->estatus = $request->estatus;

            
            $aula->save();
            return response()->json(['success' => 'Aula actualizada con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }



        } else {
        return response()->json(['error' => 'Aula no encontrada.'], 404);
        }
        }




         public function deleteAula(Request $request) {
        $request->validate([
            'id_aula' => 'required|exists:aulas,id_aula',
        ]);
    
        $aula = Aulas::where('id_aula', $request->id_aula)->first();
    
        if ($aula) {
            $aula->delete();
            return response()->json(['success' => 'Aula eliminada con éxito.']);
        } else {
            return response()->json(['error' => 'Aula no encontrada.'], 404);
        }
         }
    


}
