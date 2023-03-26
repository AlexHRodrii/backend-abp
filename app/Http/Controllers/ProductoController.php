<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Libs\ResultResponse;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
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
                    "MATCH(codigoProducto, titulo, descripcionProducto, pvp, stock, categoria) AGAINST(? IN BOOLEAN MODE)",
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
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProduct($request);

        $resultResponse = new ResultResponse();

        try {
            $newProduct = new Producto([
                'titulo' => $request->get('titulo'),
                'descripcionProducto' => $request->get('descripcionProducto'),
                'pvp' => $request->get('pvp'),
                'stock' => $request->get('stock'),
                'categoria' => $request->get('categoria')
            ]);

            $newProduct->save();

            $resultResponse->setData($newProduct);
            $resultResponse->setStatusCode(ResultResponse::CREATED_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_CREATED_CODE);


        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_BAD_REQUEST);
            $resultResponse->setMessage(ResultResponse::TXT_BAD_REQUEST);
        }

        return response()->json($resultResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $product = Producto::findOrFail($id);

            $resultResponse->setData($product);
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
        $this->validateProduct($request);

        $resultResponse = new ResultResponse();

        try {
            $product = Producto::findOrFail($id);

            $product->titulo = $request->get('titulo');
            $product->descripcionProducto = $request->get('descripcionProducto');
            $product->pvp = $request->get('pvp');
            $product->stock = $request->get('stock');
            $product->categoria = $request->get('categoria');

            $product->save();

            $resultResponse->setData($product);
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
            $product = Producto::findOrFail($id);

            $product->titulo = $request->get('titulo', $product->titulo);
            $product->descripcionProducto = $request->get('descripcionProducto', $product->descripcionProducto);
            $product->pvp = $request->get('pvp', $product->pvp);
            $product->stock = $request->get('stock', $product->stock);
            $product->categoria = $request->get('categoria', $product->categoria);

            $product->save();

            $resultResponse->setData($product);
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
            $product = Producto::findOrFail($id);

            $product->delete();

            $resultResponse->setData($product);
            $resultResponse->setStatusCode(ResultResponse::NO_CONTENT_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_NO_CONTENT_CODE);

        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    private function validateProduct($request)
    {
        $rules = [];
        $messages = [];

        $rules['titulo'] = 'required|min:3|max:200';
        $messages['titulo.required'] = 'El título del producto es obligatorio';
        $rules['descripcionProducto'] = 'required|max:500';
        $messages['descripcionProducto.required'] = 'La descripción del producto es obligatoria';
        $rules['pvp'] = 'required';
        $messages['pvp.required'] = 'El precio del producto es obligatorio';
        $rules['stock'] = 'required|integer';
        $messages['stock.required'] = 'El número del stock del producto es obligatorio';
        $rules['categoria'] = 'required|min:3|max:200';
        $messages['categoria.required'] = 'La categoría del producto es obligatoria';

        return Validator::make($request->all(), $rules, $messages);

    }
}
