<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\PendingJsonToInsert;

class WebserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fonasa(Request $request)
    {
        /* Si se le envió el run y el dv por GET */
        if($request->has('run') AND $request->has('dv')) {
            $rut = $request->input('run');
            $dv  = $request->input('dv');

            $wsdl = asset('ws/fonasa/CertificadorPrevisionalSoap.wsdl');
            $client = new \SoapClient($wsdl,array('trace'=>TRUE));
            $parameters = array(
                "query" => array(
                    "queryTO" => array(
                        "tipoEmisor"  => 3,
                        "tipoUsuario" => 2
                    ),
                    "entidad"           => env('FONASA_ENTIDAD'),
                    "claveEntidad"      => env('FONASA_CLAVE'),
                    "rutBeneficiario"   => $rut,
                    "dgvBeneficiario"   => $dv,
                    "canal"             => 3
                )
            );
            $result = $client->getCertificadoPrevisional($parameters);

            if ($result === false) {
                /* No se conecta con el WS */
                $error = array("error" => "No se pudo conectar a FONASA");
            }
            else {
                /* Si se conectó al WS */
                if($result->getCertificadoPrevisionalResult->replyTO->estado == 0) {
                    /* Si no hay error en los datos enviados */

                    $certificado            = $result->getCertificadoPrevisionalResult;
                    $beneficiario           = $certificado->beneficiarioTO;
                    $afiliado               = $certificado->afiliadoTO;

                    $user['run']            = $beneficiario->rutbenef;
                    $user['dv']             = $beneficiario->dgvbenef;
                    $user['name']           = $beneficiario->nombres;
                    $user['fathers_family'] = $beneficiario->apell1;
                    $user['mothers_family'] = $beneficiario->apell2;
                    $user['birthday']       = $beneficiario->fechaNacimiento;
                    $user['gender']         = $beneficiario->generoDes;
                    $user['desRegion']         = $beneficiario->desRegion;
                    $user['desComuna']         = $beneficiario->desComuna;
                    $user['direccion']      = $beneficiario->direccion;
                    $user['telefono']      = $beneficiario->telefono;

                    if($afiliado->desEstado == 'ACTIVO') {
                        $user['tramo'] = $afiliado->tramo;
                    }
                    else {
                        $user['tramo'] = null;
                    }
                    //$user['estado']       = $afiliado->desEstado;
                }
                else {
                    /* Error */
                    $error = array("error" => $result->getCertificadoPrevisionalResult->replyTO->errorM);
                }
            }

            // echo '<pre>';
            //print_r($result);
            //dd($result);

            return isset($user) ? json_encode($user) : json_encode($error);
        }
    }

    public function pendingJsonToInsert(Request $request)
    {
        // Validar el request
        $request->validate([
            'model_route' => 'required|string', // Ruta al modelo
            'model_data' => 'required|array',   // Datos del modelo
        ]);

        // Obtener la ruta del modelo y los datos del JSON
        $modelRoute = $request->input('model_route');
        $modelData = $request->input('model_data');

        // Verificar si ya existe una fila sin procesar para el modelo especificado
        $existingPendingRecord = PendingJsonToInsert::where('model_route', $modelRoute)
            ->where('procesed', 0)
            ->first();

        // Si existe una fila sin procesar, informar y no insertar una nueva fila
        if ($existingPendingRecord) {
            return response()->json(['message' => 'Ya existe una fila sin procesar para este modelo'], 409);
        }

        // Si existe una fila procesada, crear un nuevo registro con el mismo modelo y datos
        try {
            DB::transaction(function () use ($modelRoute, $modelData) {
                PendingJsonToInsert::create([
                    'model_route' => $modelRoute,
                    'json' => json_encode($modelData),
                    'procesed' => 0
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear un nuevo registro: ' . $e->getMessage()], 500);
        }

        // Devolver una respuesta exitosa
        return response()->json(['message' => 'Registro creado en PendingJsonToInsert']);
    }
}
