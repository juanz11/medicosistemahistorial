<?php

namespace App\Repositories;

use App\Models\Productos;
use App\Models\TotalProductos;

class EstadisticaRepository
{
    public function consultarEstadisticaProductos($visitador_id, $date_from, $date_to ){

        $resultados = array();
        $productos = Productos::all();

        foreach ($productos as $producto ) {
            $total =  0;
            $resumenes_producto = TotalProductos::where('producto_id', $producto->id)
                ->when(id_valido($visitador_id), function($query) use ($visitador_id){
                    return $query->where('visitador_id', $visitador_id);
                })
                ->whereBetween('fecha', [$date_from, $date_to])->get();
            foreach ($resumenes_producto as $resumen_producto) {
                    $total += $resumen_producto->cantidad;
            }
                    $rs = (object)[
                        'nombre' => $producto->nombre,
                        'comision' => $producto->comision,
                        'total' => $total,
                        'calculo' => $producto->comision*$total,
                    ];
                    array_push($resultados, $rs);
            }

        return $resultados;
    } 
}
