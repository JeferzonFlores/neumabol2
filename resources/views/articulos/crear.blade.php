@extends('adminlte::page')

@section('title', 'Crear articulo')

@section('content_header')
@if(session('error'))
<div class="alert {{session('tipo')}} alert-dismissible fade show" role="alert">
    <strong>{{session('error')}}</strong> {{session('mensaje')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@stop

@section('content')
 <br>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Crear articulo</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="col-md-6">
      <form role="form" action="{{route('articulos.store')}}" method="POST">
        @csrf
        
        <div class="form-group row">
          <div class="col-6">
            <label>Tipo</label>
            <input name="cod_interno" required type="text" class="form-control">
          </div>
          <div class="col-6">
            <label>Medida</label>
            <input name="cod_barras" required type="text" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label>Descripcion</label>
          <input name="descripcion" required type="text" class="form-control">
        </div>
        {{-- Campos de Venta y Stock Crítico eliminados --}}
        {{--
        <div class="form-group row">
          <div class="col-4">
            <label>Venta neto</label>
            <input name="venta_neto" id="venta_neto"  class="form-control" required type="number" oninput="ActualizaValorVentaTotal()">
          </div>
          <div class="col-4">
            <label>I.V.A.</label>
            <input name="venta_imp" id="venta_imp" required type="number" class="form-control">
          </div>
          <div class="col-4">
            <label>Total</label>
            <input name="venta_total" id="venta_total" required type="number" oninput="ActualizaValorVentaNeto()"
              class="form-control">
          </div>
        </div>
        --}}
        
        <div class="form-group row">
          <div class="col-6">
            <label>Marca</label>
            <input name="marca" type="text" class="form-control" placeholder="Ingrese la marca">
          </div>
          <div class="col-6">
            <label>Modelo</label>
            <input name="modelo" type="text" class="form-control" placeholder="Ingrese el modelo">
          </div>
        </div>

        <div class="form-group">
          <label>Activo</label>
          <select id="activo" name="activo" class="form-control">
            <option selected="true" value="1">Activo</option>
            <option value="0">Inactivo</option>
          </select>
        </div>

        <br>

        <button type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal">Crear
          Articulo</button>
        <div class="modal fade" id="modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Crear articulo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <p>Seguro que quiere guardar los cambios?&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </form>
    </div>

    <br>
    <!-- Fin contenido -->
  </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
  Crear articulo
</div>
<!-- /.card-footer-->
</div>

@stop

@section('js')
{{-- Las funciones JavaScript ActualizaValorVentaTotal y ActualizaValorVentaNeto han sido eliminadas --}}
<script>
  // No hay funciones JavaScript relacionadas con los campos eliminados
</script>
@stop

@section('footer')
   <div class="float-right d-none d-sm-block">
        <b>Version</b> @version('compact')       
    </div>
@stop
