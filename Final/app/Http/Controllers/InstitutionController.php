<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\Configuration;


# Métodos para la API
class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Institution::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institution = Institution::create($request->all());

        return response()->json($institution, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return response()->json(Institution::findOrFail($id));
        }
        catch(ModelNotFoundException $e) {
            return response()->json(["message" => "Record Not Found"], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $institution = Institution::findOrFail($id);
            $institution->update($request->all());
            return response()->json($institution);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(["message" => "Record Not Found"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $institution = Institution::findOrFail($id);
            $institution->delete();
            return response()->json(["message" => "Institution deleted"], 204);
        }
        catch(ModelNotFoundException $e) {
            return response()->json(["message" => "Record Not Found"], 404);
        }
    }

    public function getByHealthRegion($region_sanitaria_id) {
        return response()->json(Institution::where('health_region_id', '=', $region_sanitaria_id)->get());
    }

    public function buscador() {
        $title = Configuration::title();
        return view('vue.index',compact('title'));
    }
}
