<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\DateReportCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get Paginated Products List
     *
     * @return AnonymousResourceCollection
     */
    public function products(): AnonymousResourceCollection
    {
        return ProductCollection::collection($this->productService->paginatedProducts());
    }

    /**
     * Create or Update Product
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     */
    public function saveProduct(StoreProductRequest $request): ProductResource
    {
        $product = $this->productService->saveProduct($request->all());
        return new ProductResource($product);
    }

    /**
     * Remove product
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function removeProduct(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'Product has been deleted successfully!']);
    }

    /**
     * Purchase products
     *
     * @param StoreReportRequest $request
     * @return JsonResponse
     */
    public function purchase(StoreReportRequest $request): JsonResponse
    {
        $this->productService->purchaseProducts($request->get('order'));
        return response()->json(['message' => 'Your order has been placed successfully']);
    }

    /**
     * Report about products on specific date
     *
     * @param Request $request
     */
    public function dateReport(Request $request)
    {
        if (!$request->exists('date')) return response()->json(['message' => 'Specify the date first!'], 422);

        $data = $this->productService->dateReport($request->get('date'));

        return DateReportCollection::collection($data)->additional(['message' => 'Daily Report on ' . $request->get('date')]);
    }
}
