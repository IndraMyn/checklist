<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Validator;

class ChecklistController extends Controller
{

    protected $userId;

    public function __construct()
    {
        try {
            $this->userId = JWTAuth::parseToken()->authenticate()->id;
        } catch (\Throwable) {

        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $data = Checklist::all();

            return response([
                "data" => $data
            ]);

        } catch (Exception $e) {

            return response(['error' => $e->getMessage()], 500);

        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response($validator->errors(), 422);
            }

            $create = Checklist::create([
                'name' => $request->name,
                'user_id' => $this->userId
            ]);

            return response([
                'data' => $create,
                'message' => 'Successfully'
            ]);

        } catch (Exception $e) {

            return response(['error' => $e->getMessage()], 500);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checklist  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $product = Checklist::find($id);

            return response([
                'data' => $product
            ]);

        } catch (Exception $e) {

            return response(['error' => $e->getMessage()], 500);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checklist  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checklist  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checklist  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($checklistId)
    {
        $user = Checklist::find($checklistId);

        if (empty($user))
            return response([
                "message" => "ID {$checklistId} is not found!"
            ], 400);

        $user->delete();

        return response([
            "message" => "Successfully"
        ]);

    }
}