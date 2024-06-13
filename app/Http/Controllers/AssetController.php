<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Client;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function createStep1()
    {
        $recentClients = Client::orderBy('updated_at', 'desc')->take(10)->get();
        return view('themes.default.assets.create_step1', compact('recentClients'));
    }

    public function postCreateStep1(Request $request)
    {
        $request->session()->put('client_id', $request->client_id);
        return redirect()->route('assets.create.step2');
    }

    public function createStep2()
    {
        return view('themes.default.assets.create_step2');
    }

    public function postCreateStep2(Request $request)
    {
        $request->session()->put('description', $request->description);
        return redirect()->route('assets.create.step3');
    }

    public function createStep3()
    {
        $statuses = Status::all();
        return view('themes.default.assets.create_step3', compact('statuses'));
    }

    public function postCreateStep3(Request $request)
    {
        $request->session()->put('status', $request->status);
        return redirect()->route('assets.create.step4');
    }

    public function createStep4()
    {
        $clientId = session('client_id');
        $client = Client::find($clientId);
        return view('themes.default.assets.create_step4', compact('client'));
    }

    public function postCreateStep4(Request $request)
    {
        $request->session()->put('location', $request->location);
        return redirect()->route('assets.create.step5');
    }

    public function createStep5()
    {
        return view('themes.default.assets.create_step5');
    }

    public function postCreateStep5(Request $request)
    {
        $request->session()->put('latitude', $request->latitude);
        $request->session()->put('longitude', $request->longitude);
        return redirect()->route('assets.create.step6');
    }

    public function createStep6()
    {
        return view('themes.default.assets.create_step6');
    }

    public function postCreateStep6(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets', 'public');
        }

        Asset::create([
            'client_id' => session('client_id'),
            'description' => session('description'),
            'status' => session('status'),
            'location' => session('location'),
            'latitude' => session('latitude'),
            'longitude' => session('longitude'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    public function searchClients(Request $request)
    {
        $query = $request->get('query', '');
        $clients = Client::where('alias', 'LIKE', "%{$query}%")->get();
        return response()->json($clients);
    }
}
