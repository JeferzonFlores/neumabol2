<?php

namespace App\Http\Controllers;

use App\Models\DetalleRecepcion;
use App\Models\Recepciones;
use App\Models\Articulo;
use App\Models\Proveedor;
use App\Models\tipo_documento;
use App\Models\DetalleMovimientosArticulos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RecepcionesController extends Controller
{
    public function index()
    {
        if (session('recepcion')) {
            session()->forget('recepcion');
        }
        $recepciones = Recepciones::all();
        return view('recepciones.index', compact('recepciones'));
    }
    public function view($id)
    {
        $recepcion = Recepciones::find($id);
        if ($recepcion == null) {
            return redirect()->route('recepciones.index')->with([
                'error' => 'Error',
                'mensaje' => 'Recepcion no encontrada',
                'tipo' => 'alert-danger'
            ]);
        }
        $detalle = DetalleRecepcion::where('recepcion_id', $id)->get();
        //return [$recepcion, $detalle];
        // return $detalle;
        return view('recepciones.view', compact(['recepcion', 'detalle']));
    }
    public function create()
    {
        $proveedores = Proveedor::all();
        $articulos = Articulo::all();
        $tipo_documento = tipo_documento::all();

        return view('recepciones.create', compact(['proveedores', 'articulos', 'tipo_documento']));
    }

    public function addArticulo(Request $request)
    {

        //  return $request;
        $rules = [
            'articulo' => 'required',
            'costo_neto' => 'required',
            'costo_imp' => 'required',
            'costo_total' => 'required',
            'unidades' => 'required',
        ];
        $messages = [
            'articulo.required' => 'El articulo es obligatorio.',
            'costo_neto.required' => 'El costo neto es obligatorio.',
            'costo_imp.required' => 'El impuesto es obligatorio.',
            'costo_total.required' => 'El costo total es obligatorio.',
            'unidades.required' => 'Las unidades son obligatorias.',
        ];

        $this->validate($request, $rules, $messages);

        if (session()->missing('recepcion')) {
            $recepcion = [];
        } else {
            $recepcion = session('recepcion');
        }


        $articulo = Articulo::find($request->articulo);

        if ($articulo == null) {
            return redirect()->route('recepciones.create')->with([
                'error' => 'Error',
                'mensaje' => 'Articulo no encontrado',
                'tipo' => 'alert-danger'
            ]);
        }

        $articulo->cantidad = $request->unidades;
        $articulo->precio_unitario = $request->costo_neto;
        $articulo->impuesto_unitario = $request->costo_imp;

        array_push($recepcion, $articulo);
        session(['recepcion' => $recepcion]);

        return redirect()->route('recepciones.create')->with([
            'error' => 'Success',
            'mensaje' => 'Articulo agregado',
            'tipo' => 'alert-success'
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'proveedor' => 'required',
            'observaciones' => 'required',
            'warehouse_location' => 'required', // Add validation for the new field
        ];
        $messages = [
            'tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'numero_documento.required' => 'El numero de documento es obligatorio.',
            'proveedor.required' => 'El proveedor es obligatorio.',
            'observaciones.required' => 'Las observaciones son obligatorias.',
            'warehouse_location.required' => 'La ubicación del almacén es obligatoria.', // Message for new field
        ];

        $this->validate($request, $rules, $messages);


        $recepcion = new Recepciones();
        $recepcion->proveedor_id = $request->proveedor;
        $recepcion->documento = $request->numero_documento;
        $recepcion->tipo_documentos_id = $request->tipo_documento;
        $recepcion->total_neto = $request->monto_neto;
        $recepcion->total_iva = $request->monto_imp;
        $recepcion->unidades = $request->total_articulos;
        $recepcion->observaciones = $request->observaciones;
        $recepcion->fecha_recepcion = Carbon::now();
        $recepcion->user_id = Auth::user()->id;
        $recepcion->warehouse_location = $request->warehouse_location; // Save the new field
        $recepcion->save();

        //  return session('recepcion');
        foreach (session('recepcion') as $value) {
            $detalle_recepcion = new DetalleRecepcion();
            $detalle_recepcion->recepcion_id = $recepcion->id;
            $detalle_recepcion->producto_id = $value->articulo_id;
            $detalle_recepcion->cantidad = $value->cantidad;
            $detalle_recepcion->precio_unitario = $value->precio_unitario;
            $detalle_recepcion->impuesto_unitario = $value->impuesto_unitario;
            $detalle_recepcion->save();

            $articulo = Articulo::find($value->articulo_id);
            $articulo->stock = $articulo->stock + $value->cantidad;
            $articulo->costo_neto = $value->precio_unitario;
            $articulo->costo_imp = $value->impuesto_unitario;
            $articulo->save();

            $detalleMovimiento = new DetalleMovimientosArticulos();
            $detalleMovimiento->movimiento_id = 1; // 1 = recepciones
            $detalleMovimiento->id_movimiento = $recepcion->id;
            $detalleMovimiento->producto_id = $value->articulo_id;
            $detalleMovimiento->cantidad = $value->cantidad;
            $detalleMovimiento->usuario_id = Auth::user()->id;
            $detalleMovimiento->save();
        }
        session()->forget('recepcion');
        return redirect()->route('recepciones.index')->with([
            'error' => 'Success',
            'mensaje' => 'Recepcion agregada con exito',
            'tipo' => 'alert-success'
        ]);
    }
}