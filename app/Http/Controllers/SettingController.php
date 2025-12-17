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
public function providerPrivacy()
{
    $privacy = Setting::where('name', 'privacy_policy')->first();
    $cleanData = $privacy ? preg_replace('/<\/?strong>/', '', $privacy->value) : '';
    $title = 'Privacy & Policy';

    return view('providers.providerPrivacy', compact('cleanData', 'title'));
}

    public function providerTerms()
    {
        $terms = Setting::where('name', 'terms_conditions')->first();
        $cleanData = preg_replace('/<\/?strong>/', '', $terms->value);
        $title = 'Terms & Conditions';

        return view('providers.providerTerms', compact('cleanData', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function privacy()
{
    $privacy = Setting::where('name', 'privacy_policy')->first();
    $cleanData = $privacy ? preg_replace('/<\/?strong>/', '', $privacy->value) : '';
    $title = 'Privacy & Policy';

    return view('settings.index', compact('cleanData', 'title'));
}
 
}
