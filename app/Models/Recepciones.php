<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'documento',
        'tipo_documentos_id',
        'total_neto',
        'total_iva',
        'unidades',
        'observaciones',
        'fecha_recepcion',
        'user_id',
        'warehouse_location',
    ];
    public function
    documentos()
    {

        //$this->belongsTo(TipoDocumentos::class, 'tipo_documentos_id');
        return $this->belongsTo(tipo_documento::class, 'tipo_documentos_id', 'id');
        // return null;
    }

    public function proveedor()
    {
        // return $this->belongsTo(proveedor::class);

        return $this->belongsTo(Proveedor::class);
    }



    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}