<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
    use Illuminate\Support\Facades\Auth;
 // Importa el modelo adecuado

class AdminController extends Controller
{



    public function index()
    {
        // Verifica si el administrador está autenticado

        $administradores = Administrador::all();
        return view('admin', compact('administradores'));
    }

    public function postAdmin(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'sexo' => 'required|string|max:1',
            'no_empleado' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        Administrador::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'sexo' => $request->sexo,
            'no_empleado' => $request->no_empleado,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['success' => 'Administrador registrado con éxito.']);
    }

   
    public function getAdminData($id)
    {
    // Asegúrate de usar el nombre correcto de la columna
    $administrador = Administrador::where('id_administrador', $id)->first();

    if ($administrador) {
        return response()->json($administrador);
    } else {
        return response()->json(['error' => 'Administrador no encontrado.'], 404);
    }
    }


    public function updateAdmin(Request $request)
    {
    // Validar los datos del formulario
    $request->validate([
        'id_administrador' => 'required|exists:administrador,id_administrador', // Cambiar el nombre de la columna si es necesario
        'nombre' => 'required|string|max:255',
        'apellido_paterno' => 'required|string|max:255',
        'apellido_materno' => 'required|string|max:255',
        'sexo' => 'required|string|max:1',
        'no_empleado' => 'required|string|max:255',
        'password' => 'nullable|string|min:8', // La contraseña es opcional
    ]);

    // Encontrar al administrador y actualizar los datos
    $admin = Administrador::where('id_administrador', $request->id_administrador)->first();

    if ($admin) {
        try {
            $admin->nombre = $request->nombre;
            $admin->apellido_paterno = $request->apellido_paterno;
            $admin->apellido_materno = $request->apellido_materno;
            $admin->sexo = $request->sexo;
            $admin->no_empleado = $request->no_empleado;
    
            if ($request->filled('password')) {
                $admin->password = bcrypt($request->password);
            }
    
            $admin->save();
            return response()->json(['success' => 'Administrador actualizado con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Administrador no encontrado.'], 404);
    }
    

}


public function deleteAdmin(Request $request)
{
    $request->validate([
        'id_administrador' => 'required|exists:administrador,id_administrador',
    ]);

    $admin = Administrador::where('id_administrador', $request->id_administrador)->first();

    if ($admin) {
        $admin->delete();
        return response()->json(['success' => 'Administrador eliminado con éxito.']);
    } else {
        return response()->json(['error' => 'Administrador no encontrado.'], 404);
    }
}
    
}