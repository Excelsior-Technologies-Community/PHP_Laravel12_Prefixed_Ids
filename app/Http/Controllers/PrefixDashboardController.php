<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrefixConfig;

class PrefixDashboardController extends Controller
{
    public function index()
    {
        $configs = PrefixConfig::latest()->get();
        return view('prefix-dashboard.index', compact('configs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string|max:255',
            'prefix'      => 'required|string|max:50|unique:prefix_configs,prefix',
            'label'       => 'required|string|max:100',
        ]);

        PrefixConfig::create([
            'model_class' => $request->model_class,
            'prefix'      => rtrim($request->prefix, '_') . '_',
            'label'       => $request->label,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Prefix Added Successfully! 🎉');
    }

    public function update(Request $request, PrefixConfig $prefixConfig)
    {
        $request->validate([
            'prefix' => 'required|string|max:50|unique:prefix_configs,prefix,' . $prefixConfig->id,
            'label'  => 'required|string|max:100',
        ]);

        $prefixConfig->update([
            'prefix'    => rtrim($request->prefix, '_') . '_',
            'label'     => $request->label,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Prefix Updated Successfully! ✅');
    }

    public function destroy(PrefixConfig $prefixConfig)
    {
        $prefixConfig->delete();
        return back()->with('success', 'Prefix Deleted! 🗑️');
    }
}
