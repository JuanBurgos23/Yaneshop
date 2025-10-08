@php
use Carbon\Carbon;

$alertaSuscripcion = null;
$diasRestantes = null;

// Solo para clientes
if(auth()->user()->hasRole('cliente')) {
    $empresa = auth()->user()->empresa; // Relación one-to-one
    if($empresa && $empresa->fecha_fin_suscripcion) {
        $fechaFin = Carbon::parse($empresa->fecha_fin_suscripcion);
        $hoy = Carbon::now(); // Hora actual también

        // Calcular días completos, redondeando hacia arriba
        $diasRestantes = Carbon::now()->diffInDays($fechaFin, false); 
        // Si quieres redondear hacia arriba en caso de horas parciales:
        $diasRestantes = ceil($diasRestantes);

        if ($diasRestantes <= 7 && $diasRestantes >= 0) {
            $alertaSuscripcion = "Tu suscripción vence en {$diasRestantes} día(s).";
        } elseif ($diasRestantes < 0) {
            $alertaSuscripcion = "Tu suscripción ha expirado. No podrás acceder al sistema hasta renovarla.";
        }
    }
}
@endphp

{{-- Mostrar alerta solo a clientes --}}
@if(auth()->user()->hasRole('cliente') && $diasRestantes !== null && $diasRestantes >= 0 && $diasRestantes <= 7)
<div style="background-color: #fff3cd; color: #856404; padding: 15px; text-align:center;">
    {{ $alertaSuscripcion }}
</div>
@endif

@if(auth()->user()->hasRole('cliente') && $diasRestantes !== null && $diasRestantes < 0)
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Suscripción Expirada',
        text: '{{ $alertaSuscripcion }}',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        
    });
});
</script>
@endif
