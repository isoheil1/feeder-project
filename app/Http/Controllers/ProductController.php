<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
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
     * @return \App\Http\Resources\ProductCollection
     */
    public function index(): ProductCollection
    {
        return new ProductCollection($this->repository->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\ProductResource
     */
    public function store(StoreProductRequest $request): JsonResponse|ProductResource
    {
        $product = $this->repository->create($request->validated());

        return $product ?
            new ProductResource($product) :
            ResponseHelper::fail(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: trans('errors.500'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \App\Http\Resources\ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\ProductResource
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse|ProductResource
    {
        return $this->repository->update($product, $request->validated()) ?
            new ProductResource($product) :
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
