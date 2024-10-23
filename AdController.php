<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jefe;
use App\Models\Docentes;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('no_empleado', 'password');
    
        // Verificar en la tabla administradores
        $administrador = Administrador::where('no_empleado', $credentials['no_empleado'])->first();
        if ($administrador && Hash::check($credentials['password'], $administrador->password)) {
            Auth::login($administrador);
            return redirect()->route('admin.index');
        }
    
        // Verificar en la tabla jefe_division
        $jefe = Jefe::where('no_empleado', $credentials['no_empleado'])->first();
        if ($jefe && Hash::check($credentials['password'], $jefe->password)) {
            Auth::login($jefe);
            return redirect()->route('jefe.materias.show');
        }
    
        // Verificar en la tabla docentes
        $docente = Docentes::where('no_empleado', $credentials['no_empleado'])->first();
        if ($docente && Hash::check($credentials['password'], $docente->password)) {
            Auth::login($docente);
            return redirect()->route('docente.dashboard');
        }
    
        return back()->withErrors(['no_empleado' => 'No se pudo iniciar sesión con esas credenciales.']);
    }
    
    //
}
