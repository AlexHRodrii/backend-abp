<?php

namespace App\Http\Controllers;

use App\Libs\ResultResponse;
use App\Models\ImagenProducto;
use App\Http\Requests\StoreImagenProductoRequest;
use App\Http\Requests\UpdateImagenProductoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ImagenProductoController extends Controller
{
    protected ImagenProducto $modelo;

    public function __construct(ImagenProducto $modelo)
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
                'any' => 'required|string',
                'referenciaProducto' => 'required|integer',
                'url' => 'required|string',
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
                    "MATCH(referenciaProducto, url) AGAINST(? IN BOOLEAN MODE)",
                    [$busqueda]
                );

                // Eliminar el parámetro 'any' de los parámetros de la consulta
                unset($parametros['any']);
            }

            // Iterar sobre los demás parámetros de la consulta
            foreach ($parametros as $columna => $valor) {
                if ($columna !== 'itemsPerPage' && $columna !== 'page') {
                    // Anidar cláusulas WHERE a la consulta que busquen en la columna los valores recibidos por parámetro
                    $query->where(function ($query) use ($columna, $valor) {
                        $query->where($columna, 'like', "%$valor%");
                    });
                }
            }

            // Aplicar la paginación
            $perPage = $parametros['itemsPerPage'] ?? 5;
            $page = $parametros['page'] ?? 1;

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
     * @param StoreImagenProductoRequest $request
     * @return JsonResponse
     */
    public function store(StoreImagenProductoRequest $request): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {
            $validator = Validator::make($request->all(), [
                'referenciaProducto' => 'required|integer',
                'url' => 'required|string',
            ]);

            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $iProducto = new ImagenProducto();
            $iProducto->referenciaProducto = $request->input('referenciaProducto');
            $iProducto->url = $request->input('url');

            $iProducto->save();

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
     * @param UpdateImagenProductoRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateImagenProductoRequest $request, $id): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {

            $validator = Validator::make($request->all(), [
                'referenciaProducto' => 'required|integer',
                'url' => 'required|string',
            ]);


            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $iProducto = $this->modelo->find($id);

            if (!$iProducto) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $iProducto->referenciaProducto = $request->input('referenciaProducto', $iProducto->referenciaProducto);
            $iProducto->url = $request->input('url', $iProducto->url);

            $iProducto->save();

            // Preparar los datos de la respuesta
            $resultResponse->setData($iProducto);
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
            $iProducto = $this->modelo->find($id);

            if (!$iProducto) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $iProducto->delete();

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
