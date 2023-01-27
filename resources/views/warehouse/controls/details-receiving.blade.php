<div>
    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="type">Tipo de {{ $control->type_format }}</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ optional($control->typeReception)->name }}"
                id="type"
                readonly
            >
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="date">Fecha de {{ $control->type_format }}</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->date_format }}"
                id="date"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        @switch($control->type_reception_id)
            @case(\App\Models\Warehouse\TypeReception::receiving())
                <fieldset class="form-group col-md-2">
                    <label for="origin-id">Origen</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        value="{{ optional($control->origin)->name }}"
                        id="origin-id"
                        readonly
                    >
                </fieldset>
                @break
            @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                <fieldset class="form-group col-md-2">
                    <label for="store-origin-id">Bodega Origen</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        value="{{ optional($control->originStore)->name }}"
                        id="store-origin-id"
                        readonly
                    >
                </fieldset>
                @break
            @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
                <fieldset class="form-group col-md-2">
                    <label for="purchase-order-code">Código OC</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        value="{{ $control->po_code }}"
                        id="purchase-order-code"
                        readonly
                    >
                </fieldset>
                @break
        @endswitch

        @if($control->isPurchaseOrder())
            <fieldset class="form-group col-md-2">
                <label for="po-date">Fecha OC</label>
                <input
                    type="text"
                    id="po-date"
                    class="form-control form-control-sm"
                    value="{{ $control->po_date }}"
                    readonly
                >
            </fieldset>
            <fieldset class="form-group col-md-8">
                <label for="supplier-name">Proveedor</label>
                <input
                    type="text"
                    id="supplier-name"
                    class="form-control form-control-sm"
                    value="{{ optional($control->supplier)->name }}"
                    readonly
                >
            </fieldset>
        @endif

        @if($control->isReceptionNormal())
        <fieldset class="form-group col-md-3">
            <label for="program-id">Programa</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->program_name }}"
                id="program-id"
                readonly
            >
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="note">Nota</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->note }}"
                id="note"
                readonly
            >
        </fieldset>
        @endif
    </div>

    @if($control->isPurchaseOrder())
        <div class="form-row">
            <fieldset class="form-group col-md-2">
                <label for="guide-date">Fecha Guía</label>
                <input
                    type="date"
                    id="guide-date"
                    class="form-control form-control-sm"
                    value="{{ $control->guide_date }}"
                    readonly
                >
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="guide-number">Nro. Guía</label>
                <input
                    type="text"
                    id="guide-number"
                    class="form-control form-control-sm"
                    value="{{ $control->guide_number }}"
                    readonly
                >
            </fieldset>

            <fieldset class="form-group col-md-3">
                <label for="program-id">Programa</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    value="{{ $control->program_name }}"
                    id="program-id"
                    readonly
                >
            </fieldset>

            <fieldset class="form-group col-md-5">
                <label for="note">Nota</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    value="{{ $control->note }}"
                    id="note"
                    readonly
                >
            </fieldset>
        </div>
    @endif

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="signer-id">Visador Ingreso Bodega</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->receptionVisator->full_name ?? 'No posee Visador Ingreso Bodega' }}"
                id="signer-id"
                readonly
            >
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="signer-id">Visador Recepción Técnica</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->technicalSigner->full_name ?? 'No posee Visador Recepción Técnica' }}"
                id="signer-id"
                readonly
            >
        </fieldset>

    </div>
</div>
