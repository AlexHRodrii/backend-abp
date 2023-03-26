<?php

namespace App\Http\Controllers;

use App\Libs\ResultResponse;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePedidoRequest $request)
    {
        $this->validatePedido($request);

        $resultResponse = new ResultResponse();

        try {
            $newPedido = new Pedido([
                'pvp_total' => $request->get('pvpTotal'),
                'direccion_envio' => $request->get('direccionEnvio'),
                'fecha' => $request->get('fecha'),
                'dni' => $request->get('dni')
            ]);

            $newPedido->save();

            $resultResponse->setData($newPedido);
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $pedido = Pedido::findOrFail($id);

            $resultResponse->setData($pedido);
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
        $this->validatePedido($request);

        $resultResponse = new ResultResponse();

        try {
            $pedido = Pedido::findOrFail($id);

            $pedido->pvp_total = $request->get('pvpTotal');
            $pedido->direccion_envio = $request->get('direccionEnvio');
            $pedido->fecha = $request->get('fecha');
            $pedido->dni = $request->get('dni');

            $pedido->save();

            $resultResponse->setData($pedido);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Put the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, $id)
    {
        $resultResponse = new ResultResponse();

        try {
            $pedido = Pedido::findOrFail($id);

            $pedido->pvp_total = $request->get('pvpTotal', $pedido->pvp_total);
            $pedido->direccion_envio = $request->get('direccionEnvio', $pedido->direccion_envio);
            $pedido->fecha = $request->get('fecha', $pedido->fecha);
            $pedido->dni = $request->get('dni', $pedido->dni);

            $pedido->save();

            $resultResponse->setData($pedido);
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
            $pedido = Pedido::findOrFail($id);

            $pedido->delete();

            $resultResponse->setData($pedido);
            $resultResponse->setStatusCode(ResultResponse::NO_CONTENT_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_NO_CONTENT_CODE);

        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    private function validatePedido($request)
    {
        $rules = [];
        $messages = [];

        $newPedido = new Pedido([
            'pvp_total' => $request->get('pvpTotal'),
            'direccion_envio' => $request->get('direccionEnvio'),
            'fecha' => $request->get('fecha'),
            'dni' => $request->get('dni')
        ]);

        $rules['pvp_total'] = 'required|integer';
        $messages['pvp_total.required'] = 'El precio del pedido es obligatorio';
        $rules['direccion_envio'] = 'required|min:20|max:200';
        $messages['direccion_envio.required'] = 'La direccion del pedido es obligatoria';
        $rules['fecha'] = 'required';
        $messages['fecha.required'] = 'La fecha es obligatoria';
        $rules['dni'] = 'required|regex:/^[0-9]{8}[A-Z]$/i';
        $messages['dni.required'] = 'El dni del usuario es obligatorio';

        return Validator::make($request->all(), $rules, $messages);

    }
}
