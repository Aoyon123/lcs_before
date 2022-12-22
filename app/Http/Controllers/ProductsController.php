<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ResponseTrait;
    public $publicRepository;
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():JsonResponse
    {
        try{
            return $this->responseSuccess($this->productRepository()->getAll(),'Products Fetched Succesfully.');
        }
        catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():JsonResponse
    {
        try{
            return response()->json([
                'status' => true,
                'message' => 'Product Fetched Succesfully',
                'data' => [],
                'errors' => null

            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
                'errors' => []

            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            return $this->responseSuccess([],'Products Fetched Succesfully.');
        }
        catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id):JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id):JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id):JsonResponse
    {
        //
    }
}
