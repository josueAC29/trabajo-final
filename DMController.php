<?php

namespace App\Http\Controllers;

use App\Models\DisponibilidadMaterias;
use Illuminate\Http\Request;
use App\Models\Docentes;
use App\Models\Materias;

class DMController extends Controller
{
    // GET: Mostrar todas las disponibilidades de materias
    public function getDisponibilidades()
    {
        $disponibilidades = DisponibilidadMaterias::all();
        $docentes = Docentes::all();
        $materias = Materias::all();
        return view('jefes.materias.disponibilidad', compact('disponibilidades', 'docentes', 'materias'));
    }

    // POST: Crear una nueva disponibilidad de materia
    public function postDisponibilidad(Request $request)
    {
        $request->validate([
            'estatus' => 'required|boolean',
            'docente_id' => 'required|exists:docente,id_docente',
            'materia_id' => 'required|exists:materia,id_materia',
        ]);

        DisponibilidadMaterias::create($request->all());

        return redirect()->back()->with('success', 'Disponibilidad de materia creada exitosamente.');
    }

    // UPDATE: Actualizar una disponibilidad de materia existente
    public function updateDisponibilidad(Request $request, $id)
    {
        $request->validate([
            'estatus' => 'required|boolean',
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
        ]);

        $disponibilidad = DisponibilidadMaterias::findOrFail($id);
        $disponibilidad->update($request->all());

        return redirect()->back()->with('success', 'Disponibilidad de materia actualizada exitosamente.');
    }

    // DELETE: Eliminar una disponibilidad de materia
    public function deleteDisponibilidad($id)
    {
        $disponibilidad = DisponibilidadMaterias::findOrFail($id);
        $disponibilidad->delete();

        return redirect()->back()->with('success', 'Disponibilidad de materia eliminada exitosamente.');
    }
}
