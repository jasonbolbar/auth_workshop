<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Location::all());
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
        $location = Location::create($request->all());
        return response()->json([
            'status' => Response::HTTP_OK,
            'location_id' => $location->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function show(int $locationId)
    {
        try
        {
            return response()->json(Location::findOrFail($locationId));
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
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $locationId)
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
            $location = Location::findOrFail($locationId);
            $location->update($request->all());
            return response()->json([
                'status' => Response::HTTP_OK,
                'location_id' => $location->id
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
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $locationId)
    {
        try
        {
            $location = Location::findOrFail($locationId);
            $location->delete();
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:locations,id,user_id'],
            'description' => ['required', 'string','max:255'],
            'country' => ['required', 'string','max:255'],
            'state' => ['required', 'string','max:255'],
            'city' => ['required', 'string','max:255']
        ]);
    }
}

