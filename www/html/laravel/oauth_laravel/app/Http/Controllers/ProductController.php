<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->getCurrentUser()->products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors()
            ]);
        }
        $product = $this->getCurrentUser()->products()->create($request->all());
        return response()->json([
            'status' => Response::HTTP_OK,
            'product_id' => $product->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function show(int $productId)
    {
        try
        {
            return response()->json($this->getCurrentUser()->products()->findOrFail($productId));
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'error' => $e->getMessage()
            ]);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $productId)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors()
            ]);
        }

        try
        {
            $product = $this->getCurrentUser()->products()->findOrFail($productId);
            $product->update($request->all());
            return response()->json([
                'status' => Response::HTTP_OK,
                'product_id' => $product->id
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $productId)
    {
        try
        {
            $product = $this->getCurrentUser()->products()->findOrFail($productId);
            $product->delete();
            return response()->json([
                'status' => Response::HTTP_OK,
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getCurrentUser()
    {
        return Auth::user();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:products,id,user_id'],
            'description' => ['required', 'string','max:255'],
            'quantity' => ['required', 'integer', "gte:0"],
            'price' => ['required',"gte:0"],
        ]);
    }
}
