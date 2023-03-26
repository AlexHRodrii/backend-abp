<?php

namespace App\Http\Controllers;

use App\Libs\ResultResponse;
use App\Models\Instalacion;
use App\Http\Requests\StoreInstalacionRequest;
use App\Http\Requests\UpdateInstalacionRequest;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstalacionController extends Controller
{
    protected Instalacion $modelo;

    public function __construct(Instalacion $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Crear el objeto de respuesta
        $resultResponse = new ResultResponse();
        try {

            // Obtener los parámetros de la consulta
            $parametros = $request->query();

            // Validar los parámetros de la consulta
            $validator = Validator::make($parametros, [
                'any' => 'sometimes|required|string',
                'nombreInstalacion' => 'sometimes|required|string|max:50',
                'descripcionInstalacion' => 'sometimes|required|string',
                'pvpHora' => 'sometimes|required|string',
                'deporteAsociado' => 'sometimes|required|string',
            ]);

            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            // Inicializar la consulta
            $query = $this->modelo->query();

            // Verificar si se ha proporcionado el parámetro 'any'
            if (isset($parametros['any'])) {
                // Obtener el valor del parámetro 'any'
                $busqueda = $parametros['any'];

                // Aplicar la función MATCH() de MySQL a la consulta
                $query->whereRaw(
                    "MATCH(codigoInstalacion, nombreInstalacion, descripcionInstalacion, pvpHora, deporteAsociado) AGAINST(? IN BOOLEAN MODE)",
                    [$busqueda]
                );

                // Eliminar el parámetro 'any' de los parámetros de la consulta
                unset($parametros['any']);
            }

            // Iterar sobre los demás parámetros de la consulta
            foreach ($parametros as $columna => $valor) {
                // Anidar cláusulas WHERE a la consulta que busquen en la columna los valores recibidos por parámetro
                $query->where(function ($query) use ($columna, $valor) {
                    $query->where($columna, 'like', "%$valor%");
                });
            }

            // Aplicar la paginación
            $perPage = $params['itemsPerPage'] ?? 5;
            $page = $params['page'] ?? 1;

            // Obtener los resultados de la consulta
            $resultados = $query->paginate($perPage, ['*'], 'page', $page);

            // Preparar los datos de la respuesta
            $resultResponse->setData($resultados);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        } catch (\Exception $e) {

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::INTERNAL_SERVER_ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_INTERNAL_SERVER_ERROR_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {

            $product = $this->modelo->find($id);

            if (!$product) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            // Preparar los datos de la respuesta
            $resultResponse->setData($product);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);

        } catch (\Exception $e) {

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::INTERNAL_SERVER_ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_INTERNAL_SERVER_ERROR_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInstalacionRequest $request
     * @return JsonResponse
     */
    public function store(StoreInstalacionRequest $request): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {
            $validator = Validator::make($request->all(), [
                'nombreInstalacion' => 'required|string|max:50',
                'descripcionInstalacion' => 'required|string',
                'pvpHora' => 'required|string',
                'deporteAsociado' => 'required|string',
            ]);

            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $instalacion = new Producto();
            $instalacion->nombreInstalacion = $request->input('nombreInstalacion');
            $instalacion->descripcionInstalacion = $request->input('descripcionInstalacion');
            $instalacion->pvpHora = $request->input('pvpHora');
            $instalacion->deporteAsociado = $request->input('deporteAsociado');

            $instalacion->save();

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::CREATED_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_CREATED_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        } catch (\Exception $e) {

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::INTERNAL_SERVER_ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_INTERNAL_SERVER_ERROR_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInstalacionRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateInstalacionRequest $request, $id): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {

            $validator = Validator::make($request->all(), [
                'nombreInstalacion' => 'sometimes|required|string|max:50',
                'descripcionInstalacion' => 'sometimes|required|string',
                'pvpHora' => 'sometimes|required|string',
                'deporteAsociado' => 'sometimes|required|string',
            ]);


            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $instalacion = $this->modelo->find($id);

            if (!$instalacion) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $instalacion->nombreInstalacion = $request->input('nombreInstalacion', $instalacion->nombreInstalacion);
            $instalacion->descripcionInstalacion = $request->input('descripcionInstalacion', $instalacion->descripcionInstalacion);
            $instalacion->pvpHora = $request->input('pvpHora', $instalacion->pvpHora);
            $instalacion->deporteAsociado = $request->input('deporteAsociado', $instalacion->deporteAsociado);

            $instalacion->save();

            // Preparar los datos de la respuesta
            $resultResponse->setData($instalacion);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);

        } catch (\Exception $e) {

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::INTERNAL_SERVER_ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_INTERNAL_SERVER_ERROR_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $resultResponse = new ResultResponse();

        try {
            $instalacion = $this->modelo->find($id);

            if (!$instalacion) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $instalacion->delete();

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::NO_CONTENT_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_NO_CONTENT_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);

        } catch (\Exception $e) {

            // Preparar los datos de la respuesta
            $resultResponse->setStatusCode(ResultResponse::INTERNAL_SERVER_ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_INTERNAL_SERVER_ERROR_CODE);

            // Devolver los resultados como una respuesta en formato JSON
            return response()->json($resultResponse);
        }
    }
}
