<?php

namespace App\Http\Controllers\Admin;

use App\Models\Obtained;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreObtainedRequest;
use App\Http\Requests\Admin\UpdateObtainedRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ObtainedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //abort_if(Gate::denies('obtained_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obtaineds = Obtained::paginate(5);

        return view('admin.obtaineds.index', compact('obtaineds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //abort_if(Gate::denies('obtained_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.obtaineds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObtainedRequest $request)
    {
        //abort_if(Gate::denies('obtained_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Obtained::create($request->validated());

        return redirect()->route('admin.obtained.index')->with('message', "Service Obtained Successfully Created !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obtained  $obtained
     * @return \Illuminate\Http\Response
     */
    public function show(Obtained $obtained)
    {
        return redirect()->route('admin.obtained.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Obtained  $obtained
     * @return \Illuminate\Http\Response
     */
    public function edit(Obtained $obtained)
    {
        //abort_if(Gate::denies('obtained_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.obtaineds.edit', compact('obtained'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Obtained  $obtained
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObtainedRequest $request, Obtained $obtained)
    {
        //abort_if(Gate::denies('obtained_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obtained->update($request->validated());

        return redirect()->route('admin.obtained.index')->with('message', 'Service Obtained Successfully Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obtained  $obtained
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obtained $obtained)
    {
        //abort_if(Gate::denies('obtained_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $obtained->delete();

        return redirect()->route('admin.obtained.index')->with('message', 'Obtained Service Successfully Deleted !');
    }
}
