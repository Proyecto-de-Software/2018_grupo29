<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Http\Requests\StoreConfiguration;


class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:configuration_index', ['only' => ['edit', 'update']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $allConfigurations = Configuration::get();
        $title = Configuration::title();
        $currentConfiguration = ['title' => $allConfigurations[2], 'maintenance' => $allConfigurations[1], 'pagination' => $allConfigurations[0], 'email' => $allConfigurations[3]];
        return view('configurations.edit',compact('title'))->with('configuration',$currentConfiguration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfiguration $request)
    {
        Configuration::systemPages()[0]->update(['value' => $request->pagination]);
        Configuration::maintenance()[0]->update(['value' => $request->maintenance]);
        Configuration::email()[0]->update(['value' => $request->email]);
        Configuration::title()[0]->update(['value' => $request->title]);
        flash('La configuración ha sido actualizada exitosamente')->success();

        return redirect()->route('configurations.edit');
    }
}
