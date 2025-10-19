<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Inscripcion;
use App\Models\Producto;
use App\Models\Recibo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $empresaId = Auth::user()->empresa->id ?? null;

        // ================================
        // 🟦 Productos por categoría (solo activas)
        // ================================
        $categorias = Categoria::where('id_empresa', $empresaId)
            ->where('estado', 'activo')
            ->get();

        $productosPorCategoria = [];

        foreach ($categorias as $categoria) {
            $count = Producto::where('id_categoria', $categoria->id)
                ->where('id_empresa', $empresaId)
                ->where('estado', 'activo')
                ->count();

            $productosPorCategoria[] = [
                'name' => $categoria->nombre,
                'y' => $count
            ];
        }

        // ================================
        // 🟩 Clientes registrados por mes (últimos 12 meses)
        // ================================
        $meses = [];
        $clientesPorMes = [];

        for ($i = 1; $i <= 12; $i++) {
            $meses[] = Carbon::createFromDate(null, $i, 1)->format('M');

            $clientesPorMes[] = Cliente::whereHas('empresa', function ($q) use ($empresaId) {
                $q->where('id', $empresaId);
            })
                ->whereMonth('created_at', $i)
                ->count();
        }

        // ================================
        // 🟧 Totales y nuevos de hoy
        // ================================
        $totalClientes = Cliente::whereHas('empresa', function ($q) use ($empresaId) {
            $q->where('id', $empresaId);
        })->count();

        $clientesHoy = Cliente::whereHas('empresa', function ($q) use ($empresaId) {
            $q->where('id', $empresaId);
        })
            ->whereDate('created_at', Carbon::today())
            ->count();


        // ================================
        // Retornar a la vista
        // ================================
        return view('dashboard.dashboard', compact(
            'productosPorCategoria',
            'meses',
            'clientesPorMes',
            'totalClientes',
            'clientesHoy',
            
        ));
    }
}
