<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function terms()
    {
        $terms = Setting::where('name', 'terms_conditions')->first();
        $cleanData = preg_replace('/<\/?strong>/', '', $terms->value);
        $title = 'Terms & Conditions';

        return view('settings.index', compact('cleanData', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function privacy()
    {
        $privacy = Setting::where('name', 'privacy_policy')->first();
        $cleanData = preg_replace('/<\/?strong>/', '', $privacy->value);
        $title = 'Privacy & Policy';

        return view('settings.index', compact('cleanData', 'title'));
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
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
