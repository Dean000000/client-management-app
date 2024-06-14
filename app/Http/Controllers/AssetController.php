<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Client;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class AssetController extends Controller
{
    public function exportAll()
    {
        $assets = Asset::with('client', 'status')->get();
        $pdf = PDF::loadView('pdf.assets', compact('assets'));
        return $pdf->download('assets.pdf');
    }

    public function exportByClient(Client $client)
    {
        $assets = Asset::with('client', 'status')->where('client_id', $client->id)->get();
        $pdf = PDF::loadView('pdf.assets', compact('assets'));
        return $pdf->download("assets_{$client->alias}.pdf");
    }

    public function exportByClientAndStatus(Client $client, Request $request)
    {
        $status = $request->input('status'); // Get the status from the request

        // Validate that status is provided
        if (!$status) {
            return redirect()->back()->withErrors('Status is required.');
        }

        $assets = Asset::with('client')
            ->where('client_id', $client->id)
            ->where('status', $status) // Filter by status
            ->get();

        $pdf = PDF::loadView('pdf.assets', compact('assets'));
        return $pdf->download("assets_{$client->alias}_{$status}.pdf");
    }

    public function index()
    {
        $assets = Asset::with('client')->get();
        $clients = Client::all();
        $statuses = Status::all();
        $theme = config('themes.active');
        return view("themes.$theme.assets.index", compact('assets', 'clients', 'statuses'));
    }

    public function edit(Asset $asset)
    {
        $clients = Client::all();
        $statuses = Status::all();
        $theme = config('themes.active');
        return view("themes.$theme.assets.edit", compact('asset', 'clients', 'statuses'));
    }

public function update(Request $request, Asset $asset)
{
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'description' => 'required|string|max:255',
        'status' => 'required|integer|exists:statuses,id', // Ensure status is validated as an integer
        'location' => 'nullable|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($asset->image_path) {
            Storage::disk('public')->delete($asset->image_path);
        }
        $validated['image_path'] = $request->file('image')->store('assets', 'public');
    }

    $asset->update($validated);

    return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
}



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
