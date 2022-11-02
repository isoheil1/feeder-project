<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ResponseHelper::success(Response::HTTP_OK, $this->repository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->repository->create($request->validated());

        return $product ?
            ResponseHelper::success(Response::HTTP_OK, $product->toArray()) :
            ResponseHelper::fail(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: trans('errors.500'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return ResponseHelper::success(Response::HTTP_OK, $this->repository->show($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return $this->repository->update($product, $request->validated()) ?
            ResponseHelper::success(Response::HTTP_OK, $product->toArray()) :
            ResponseHelper::fail(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: trans('errors.500'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        return $this->repository->delete($product) ?
            response()->json([], Response::HTTP_NO_CONTENT) :
            ResponseHelper::fail(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: trans('errors.500'));
    }
}
