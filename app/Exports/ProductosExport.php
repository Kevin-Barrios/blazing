<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductosExport implements FromCollection
{
    public function collection()
    {
        return Producto::with('categoria')
            ->select('nombre', 'precio', 'talla', 'activo', 'id_categoria')
            ->get()
            ->map(function ($producto) {
                return [
                    'Nombre'     => $producto->nombre,
                    'Precio'     => $producto->precio,
                    'Talla'      => $producto->talla,
                    'Categoría'  => $producto->categoria->nombre ?? 'Sin categoría',
                    'Activo'     => $producto->activo ? 'Sí' : 'No',
                ];
            });
    }
}
