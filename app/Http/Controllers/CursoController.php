<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Libs\ResultResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{

    protected Curso $modelo;

    public function __construct(Curso $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        // Crear el objeto de respuesta
        $resultResponse = new ResultResponse();
        try {

            // Obtener los parámetros de la consulta
            $parametros = $request->query();

            // Inicializar la consulta
            $query = $this->modelo->query();

            // Verificar si se ha proporcionado el parámetro 'any'
            if (isset($parametros['any'])) {
                // Obtener el valor del parámetro 'any'
                $busqueda = $parametros['any'];

                // Aplicar la función MATCH() de MySQL a la consulta
                $query->whereRaw(
                    "MATCH(condigoCurso, nombreCurso, fechaInicio, fechaFin, pvpCurso) AGAINST(? IN BOOLEAN MODE)",
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // Se hace las validaciones
        $this->validateCurso($request);

        $resultResponse = new ResultResponse();

        try {
            // Se crea el objeto curso
            $newCurso = new Curso([
                'nombreCurso' => $request->get('nombreCurso'),
                'fechaInicio' => $request->get('fechaInicio'),
                'fechaFin' => $request->get('fechaFin'),
                'pvpCurso' => $request->get('pvpCurso')
            ]);

            // Se guarda en la base de datos
            $newCurso->save();

            $resultResponse->setData($newCurso);
            $resultResponse->setStatusCode(ResultResponse::CREATED_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_CREATED_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $resultResponse->setData($curso);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validateCurso($request);

        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $curso->nombreCurso = $request->get('nombreCurso');
            $curso->fechaInicio = $request->get('fechaInicio');
            $curso->fechaFin = $request->get('fechaFin');
            $curso->pvpCurso = $request->get('pvpCurso');

            $curso->save();

            $resultResponse->setData($curso);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * put the specified resource in storage.
     *
     * @param Request $request
     * @param  $id
     * @return JsonResponse
     */
    public function put(Request $request, $id)
    {
        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $curso->nombreCurso = $request->get('nombreCurso', $curso->nombreCurso);
            $curso->fechaInicio = $request->get('fechaInicio', $curso->fechaInicio);
            $curso->fechaFin = $request->get('fechaFin', $curso->fechaFin);
            $curso->pvpCurso = $request->get('pvpCurso', $curso->pvpCurso);

            $curso->save();

            $resultResponse->setData($curso);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $curso->delete();

            $resultResponse->setData($curso);
            $resultResponse->setStatusCode(ResultResponse::NO_CONTENT_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_NO_CONTENT_CODE);

        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    private function validateCurso($request)
    {
        $rules = [];
        $messages = [];

        $newCurso = new Curso([
            'nombreCurso' => $request->get('nombreCurso'),
            'fechaInicio' => $request->get('fechaInicio'),
            'fechaFin' => $request->get('fechaFin'),
            'pvpCurso' => $request->get('pvpCurso')
        ]);

        $rules['nombreCurso'] = 'required|min:3|max:200';
        $messages['nombreCurso.required'] = 'El nombre del curso es obligatorio';
        $rules['fechaInicio'] = 'required';
        $messages['fechaInicio.required'] = 'La fecha de inicio es obligatoria';
        $rules['fechaFin'] = 'required';
        $messages['fechaFin.required'] = 'La fecha de fin es obligatoria';
        $rules['pvpCurso'] = 'required|integer';
        $messages['pvpCurso.required'] = 'El precio del curso es obligatorio';

        return Validator::make($request->all(), $rules, $messages);

    }
}
