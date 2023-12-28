<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{WithHeadings, WithMapping, ShouldAutoSize};
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Inv\Inventory;

class InventoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Inventory::with('unspscProduct')
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->whereNotNull('number')
            ->get();
    }

    public function headings(): array
    {
        return [
            "numero-inventario",
            "descripcion (especificaciones tecnicas)",
            "código producto estandar ONU (productUNSPSC)",
            "marca",
            "modelo",
            "serial",
            "vida_util",
            "codigo OC",
            "estado del producto",
            "lugar",
            "quien entrega",
            "responsable",
            "usuario",
            "observaciones",
            "valor",
            "cuenta contable",
            "factura",
            "fecha entrega",
            "old number",
        ];
    }

    public function map($inventory): array
    {
        $description = '';

        if ($inventory->unspscProduct) {
            $description .= 'Std: ' . rtrim($inventory->unspscProduct->name) . "\n";
        }

        if ($inventory->product) {
            $description .= 'Bodega: ' . rtrim($inventory->product->name);
        } else {
            $description .= 'Desc: ' . rtrim($inventory->description);
        }

        return [
            $inventory->number,
            $description,
            optional($inventory->unspscProduct)->code,
            $inventory->brand,
            $inventory->model,
            $inventory->serial_number,
            $inventory->useful_life,
            $inventory->po_code,
            $inventory->status,
            $inventory->place_id,
            $inventory->request_user_id,
            $inventory->user_responsible_id,
            $inventory->user_using_id,
            $inventory->observations,
            $inventory->po_price,
            $inventory->accounting_code_id,
            $inventory->dte_number,
            $inventory->deliver_date,
            $inventory->old_number,
        ];
    }
    
}
