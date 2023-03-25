<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Libs\ResultResponse;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resultResponse = new ResultResponse();
        try {

            $params = $request->all();

            if (empty($params)) {
                $cursos = Curso::all();
            } else {
                $cursos = DB::table('curso')
                    ->orWhereRaw("CONCAT(nombre_curso, fecha_inicio, pvp_curso) LIKE '%{$params['any']}%'")
                    ->get();
            }

            $resultResponse->setData($cursos);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCurso($request);

        $resultResponse = new ResultResponse();

        try {
            $newCurso = new Curso([
                'nombre_curso' => $request->get('nombreCurso'),
                'fecha_inicio' => $request->get('fechaInicio'),
                'fecha_fin' => $request->get('fechaFin'),
                'pvp_curso' => $request->get('pvpCurso')
            ]);

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
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
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
     * @param  \App\Http\Requests\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateCurso($request);

        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $curso->nombre_curso = $request->get('nombreCurso');
            $curso->fecha_inicio = $request->get('fechaInicio');
            $curso->fecha_fin = $request->get('fechaFin');
            $curso->pvp_curso = $request->get('pvpCurso');

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
     * @param  \App\Http\Requests\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, $id)
    {
        $resultResponse = new ResultResponse();

        try {
            $curso = Curso::findOrFail($id);

            $curso->nombre_curso = $request->get('nombreCurso', $curso->nombre_curso);
            $curso->fecha_inicio = $request->get('fechaInicio', $curso->fecha_inicio);
            $curso->fecha_fin = $request->get('fechaFin', $curso->fecha_fin);
            $curso->pvp_curso = $request->get('pvpCurso', $curso->pvp_curso);

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
     * @return \Illuminate\Http\Response
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
                'nombre_curso' => $request->get('nombreCurso'),
                'fecha_inicio' => $request->get('fechaInicio'),
                'fecha_fin' => $request->get('fechaFin'),
                'pvp_curso' => $request->get('pvpCurso')
            ]);

        $rules['nombre_curso'] = 'required|min:3|max:200';
        $messages['nombre_curso.required'] = 'El nombre del curso es obligatorio';
        $rules['fecha_inicio'] = 'required';
        $messages['fecha_inicio.required'] = 'La fecha de inicio es obligatoria';
        $rules['fecha_fin'] = 'required';
        $messages['fecha_fin.required'] = 'La fecha de fin es obligatoria';
        $rules['pvp_curso'] = 'required|integer';
        $messages['pvp_curso.required'] = 'El precio del curso es obligatorio';

        return Validator::make($request->all(), $rules, $messages);

    }
}
