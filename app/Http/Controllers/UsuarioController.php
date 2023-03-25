<?php

namespace App\Http\Controllers;

use App\Libs\ResultResponse;
use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    protected Usuario $modelo;

    public function __construct(Usuario $modelo)
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
                'dni' => 'sometimes|required|string',
                'email' => 'sometimes|required|string',
                'telefono' => 'sometimes|required|string',
                'nombre' => 'sometimes|required|string',
                'apellidos' => 'sometimes|required|string',
                'fechaNacimiento' => 'sometimes|required|string',
                'password' => 'sometimes|required|string',
                'imagenPerfil' => 'sometimes|required|string',
                // Agrega validaciones para otros parámetros aquí
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
                    "MATCH(columna1, columna2, columna3) AGAINST(? IN BOOLEAN MODE)",
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

            // Obtener los resultados de la consulta
            $resultados = $query->get();

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
     * @param $dni
     * @return JsonResponse
     */
    public function show($dni): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {

            $user = $this->modelo->find($dni);

            if (!$user) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            // Preparar los datos de la respuesta
            $resultResponse->setData($user);
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
     * @param StoreUsuarioRequest $request
     * @return JsonResponse
     */
    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {
            $validator = Validator::make($request->all(), [
                'dni' => 'required|string|unique:usuario,dni|size:9',
                'email' => 'required|string|email|unique:usuario,email|max:50',
                'telefono' => 'sometimes|required|string|max:12',
                'nombre' => 'required|string|max:15',
                'apellidos' => 'required|string|max:30',
                'fechaNacimiento' => 'required|string',
                'password' => 'required|string',
                'imagenPerfil' => 'sometimes|required|string',
            ]);

            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $user = new Usuario();
            $user->dni = $request->input('dni');
            $user->email = $request->input('email');
            $user->nombre = $request->input('nombre');
            $user->apellidos = $request->input('apellidos');
            $user->fechaNacimiento = $request->input('fechaNacimiento');
            $user->password = bcrypt($request->input('password'));
            $user->imagenPerfil = $request->input('imagenPerfil');

            if ($request->has('telefono')) {
                $user->telefono = $request->input('telefono');
            }

            if ($request->has('telefono')) {
                $user->imagenPerfil = $request->input('imagenPerfil');
            }

            $user->save();

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
     * @param UpdateUsuarioRequest $request
     * @param $dni
     * @return JsonResponse
     */
    public function update(UpdateUsuarioRequest $request, $dni): JsonResponse
    {
        $resultResponse = new ResultResponse();
        try {

            $validator = Validator::make($request->all(), [
                'email' => ['sometimes', 'required', 'string', 'email', 'max:50', Rule::unique('usuario')->ignore($dni)],
                'telefono' => 'sometimes|required|string|max:12',
                'nombre' => 'sometimes|required|string|max:15',
                'apellidos' => 'sometimes|required|string|max:30',
                'fechaNacimiento' => 'sometimes|required|string',
                'password' => 'sometimes|required|string',
                'imagenPerfil' => 'sometimes|required|string',
            ]);


            if ($validator->fails()) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
                $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $user = $this->modelo->find($dni);

            if (!$user) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $user->dni = $request->input('dni', $user->dni);
            $user->email = $request->input('email', $user->email);
            $user->telefono = $request->input('telefono', $user->telefono);
            $user->nombre = $request->input('nombre', $user->nombre);
            $user->apellidos = $request->input('apellidos', $user->apellidos);
            $user->fechaNacimiento = $request->input('fechaNacimiento', $user->fechaNacimiento);
            $user->imagenPerfil = $request->input('imagenPerfil', $user->imagenPerfil);

            if ($request->has('password')) {
                $user->contrasenya = bcrypt($request->input('password'));
            }


            $user->save();

            // Preparar los datos de la respuesta
            $resultResponse->setData($user);
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
     * @param $dni
     * @return JsonResponse
     */
    public function destroy($dni): JsonResponse
    {
        $resultResponse = new ResultResponse();

        try {
            $user = $this->modelo->find($dni);

            if (!$user) {
                // Preparar los datos de la respuesta
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);

                // Devolver los resultados como una respuesta en formato JSON
                return response()->json($resultResponse);
            }

            $user->delete();

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
