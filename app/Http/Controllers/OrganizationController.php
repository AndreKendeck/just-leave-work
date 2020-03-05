<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = auth()->user()->organization;
        return view('organizations.index', [
            'organization' => $organization ,
            'leaves' => $organization->leaves()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //not needed should be
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //not needed
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //not needed
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = auth()->user()->organization;
        if (!$organization->is_owner) {
            abort(403, "You are not allowed to view this page");
        }
        return view('organizations.edit', [
            'organization' => $organization ,
        ]);
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
        $organization = Organization::findOrFail($id);
        if (!$organization->is_owner) {
            abort(403, "You are not allowed to perform this action");
        }
        $organization->update([
            'display_name' => $request->name,
            'description' => $request->description,
        ]);
        if ($request->hasFile('logo')) {
            $organization->update([
                'logo' => $request->logo->hashName()
            ]);
            $request->logo->store(Organization::STORAGE_PATH);
        }
        return redirect()->back()->with('message', 'Organization details have been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
