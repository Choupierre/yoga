<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'groups' => ['present', 'array','nullable'],
            'groups.*.name' => ['required','distinct', 'string'],
            'groups.*.ids' => ['present', 'array','nullable'],
            'groups.*.ids.*' => ['required','distinct', 'integer'],
        ]);
      
        $company->groups = $validated['groups'];
        $company->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
