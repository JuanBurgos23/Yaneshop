<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    // Listar empresas según rol
   public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            // Admin puede ver todas las empresas
            $empresas = Empresa::all();
            return view('empresa.empresa', compact('empresas'));
        } else {
            // Cliente solo ve su empresa
            $empresa = auth()->user()->empresa;

            if (!$empresa) {
                // Cliente sin empresa registrada
                return redirect()->route('home')->with('error', 'No tienes una empresa registrada.');
            }

            // Verificar fecha de fin de suscripción
            $fechaFin = $empresa->fecha_fin_suscripcion ? \Carbon\Carbon::parse($empresa->fecha_fin_suscripcion) : null;
            $hoy = \Carbon\Carbon::now();

            if (!$fechaFin || $fechaFin->lt($hoy)) {
                // Suscripción expirada
                return view('empresa.suscripcion_vencida'); // crea esta vista
            }

            // Suscripción vigente, mostrar empresa
            return view('empresa.empresa', ['empresas' => [$empresa]]);
        }
    }

    // Guardar nueva empresa
    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'telefono_whatsapp' => 'required|string|max:20',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'direccion'         => 'nullable|string|max:255',
            'tipo_suscripcion'  => 'required|string',
            'cantidad_meses'    => 'nullable|integer|min:1'
        ]);

        $data = $request->only(['nombre', 'telefono_whatsapp', 'direccion']);
        $data['id_user'] = Auth::id();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Calcular fechas de suscripción
        $data['fecha_inicio_suscripcion'] = now();

        switch ($request->tipo_suscripcion) {
            case 'mes':
                $data['fecha_fin_suscripcion'] = now()->addMonth();
                break;
            case 'trimestre':
                $data['fecha_fin_suscripcion'] = now()->addMonths(3);
                break;
            case 'semestre':
                $data['fecha_fin_suscripcion'] = now()->addMonths(6);
                break;
            case 'anual':
                $data['fecha_fin_suscripcion'] = now()->addYear();
                break;
            case 'opcional':
                $meses = $request->cantidad_meses ?? 1;
                $data['fecha_fin_suscripcion'] = now()->addMonths($meses);
                break;
        }

        $data['tipo_suscripcion'] = $request->tipo_suscripcion;

        $empresa = Empresa::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'empresa' => $empresa]);
        }

        return redirect()->back()->with('success', 'Empresa registrada correctamente');
    }

   // Obtener datos para editar
    public function edit($id)
    {
        if (auth()->user()->hasRole('admin')) {
            // Admin puede editar cualquier empresa
            $empresa = Empresa::findOrFail($id);
        } else {
            // Cliente solo puede editar su empresa
            $empresa = Empresa::where('id_user', auth()->id())->findOrFail($id);
        }

        return response()->json($empresa);
    }


    // Actualizar empresa
   public function update(Request $request, $id)
    {
        try {
            // Cliente solo puede actualizar su empresa
            if(auth()->user()->hasRole('admin')){
                $empresa = Empresa::findOrFail($id);
            } else {
                $empresa = Empresa::where('id_user', auth()->id())->findOrFail($id);
            }

            $request->validate([
                'nombre'            => 'required|string|max:255',
                'telefono_whatsapp' => 'required|string|max:20',
                'logo'              => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'direccion'         => 'nullable|string|max:255',
                'tipo_suscripcion'  => 'required|string',
                'cantidad_meses'    => 'nullable|integer|min:1'
            ]);

            $data = $request->only(['nombre', 'telefono_whatsapp', 'direccion']);

            // Manejo del logo
            if ($request->hasFile('logo')) {
                if ($empresa->logo && Storage::disk('public')->exists($empresa->logo)) {
                    Storage::disk('public')->delete($empresa->logo);
                }
                $data['logo'] = $request->file('logo')->store('logos', 'public');
            }

            // Recalcular fechas de suscripción
            $data['fecha_inicio_suscripcion'] = now();

            switch ($request->tipo_suscripcion) {
                case 'mes':
                    $data['fecha_fin_suscripcion'] = now()->addMonth();
                    break;
                case 'trimestre':
                    $data['fecha_fin_suscripcion'] = now()->addMonths(3);
                    break;
                case 'semestre':
                    $data['fecha_fin_suscripcion'] = now()->addMonths(6);
                    break;
                case 'anual':
                    $data['fecha_fin_suscripcion'] = now()->addYear();
                    break;
                case 'opcional':
                    $meses = $request->cantidad_meses ?? 1;
                    $data['fecha_fin_suscripcion'] = now()->addMonths($meses);
                    break;
                default:
                    // Si no se reconoce el tipo, mantener la fecha de fin actual
                    $data['fecha_fin_suscripcion'] = $empresa->fecha_fin_suscripcion;
                    break;
            }

            $data['tipo_suscripcion'] = $request->tipo_suscripcion;

            $empresa->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Datos de empresa actualizados correctamente',
                'empresa' => $empresa
            ]);
        } catch (\Exception $e) {
            \Log::error('Error actualizando empresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar empresa.'
            ], 500);
        }
    }



    public function showPublic($slug)
    {
        // Buscar la empresa por slug (o falla 404)
        $empresa = Empresa::where('slug', $slug)->firstOrFail();
        $empresaId = $empresa->id;

        // Categorías que tengan productos activos de esta empresa
        $categorias = Categoria::with('subcategorias')
            ->where('id_empresa', $empresaId)
            ->whereHas('productos', function ($query) use ($empresaId) {
                $query->where('id_empresa', $empresaId)
                    ->where('estado', 'activo');
            })
            ->get();

        // Productos normales (sin oferta)
        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Productos nuevos
        $nuevos = Producto::with('categoria', 'imagenes')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->get();

        // Productos en promoción (sin límite)
        $promociones = Producto::with('categoria', 'imagenes')
            ->whereNotNull('precio_oferta')
            ->where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('empresa', 'categorias', 'productos', 'nuevos', 'promociones'));
    }
}
