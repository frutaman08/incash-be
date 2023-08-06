<?php

namespace App\Http\Controllers\API;

use App\Helper\Parameter;
use App\Helper\ResponseDefault;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    use ResponseDefault, Parameter;
    private $category;
    
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        try {
            $parameters = $this->setParameterQuery($request);
            $categories = $this->category->index($parameters);
            $meta = $categories->toArray();

            return $this->setSuccessResponse(CategoryResource::collection($categories), 200, [
                'total' => $meta['total'],
                'from' => $meta['from'],
                'to' => $meta['to'],
                'per_page' => $meta['per_page'],
                'current_page' => $meta['current_page'],
                'last_page' => $meta['last_page']
            ]);
        } catch (Exception $e) {
            return $this->setErrorResponse($e->getMessage(), 500);
        }

    }

    public function store(CategoryRequest $request)
    {
        try {
            $input = $request->validated();
            $input['user_id'] = auth()->user()->id;
            $category = $this->category->store($input);
            return $this->setSuccessResponse(new CategoryResource($category), 201);
        } catch (ValidationException $e) {
            return $this->setErrorResponse($e->errors(), 400);
        } catch (Exception $e) {
            return $this->setErrorResponse($e->getMessage(), 500);
        }

    }
}
