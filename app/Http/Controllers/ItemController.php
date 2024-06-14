<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Client;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function exportAll()
    {
        $items = Item::with('client')->get();
        $pdf = PDF::loadView('pdf.items', compact('items'));
        return $pdf->download('items.pdf');
    }

    public function exportByClient(Client $client)
    {
        $items = Item::with('client')->where('client_id', $client->id)->get();
        $pdf = PDF::loadView('pdf.items', compact('items'));
        return $pdf->download("items_{$client->alias}.pdf");
    }

    public function index()
    {
        $items = Item::with('client')->get();
        $clients = Client::all();
        $theme = config('themes.active');
        return view("themes.$theme.items.index", compact('items', 'clients'));
    }

    public function edit(Item $item)
    {
        $clients = Client::all();
        $theme = config('themes.active');
        return view("themes.$theme.items.edit", compact('item', 'clients'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function createStep1()
    {
        $recentClients = Client::orderBy('updated_at', 'desc')->take(10)->get();
        return view('themes.default.items.create_step1', compact('recentClients'));
    }

    public function postCreateStep1(Request $request)
    {
        $request->session()->put('client_id', $request->client_id);
        return redirect()->route('items.create.step2');
    }

    public function createStep2()
    {
        return view('themes.default.items.create_step2');
    }

    public function postCreateStep2(Request $request)
    {
        $request->session()->put('description', $request->description);
        return redirect()->route('items.create.step3');
    }

    public function createStep3()
    {
        return view('themes.default.items.create_step3');
    }

    public function postCreateStep3(Request $request)
    {
        $request->session()->put('location', $request->location);
        return redirect()->route('items.create.step4');
    }

    public function createStep4()
    {
        $client_id = session('client_id');
        $client = Client::find($client_id);

        if (!$client) {
            return redirect()->route('items.create.step3')->withErrors('Client not found.');
        }

        return view('themes.default.items.create_step4', compact('client'));
    }

    public function postCreateStep4(Request $request)
    {
        $request->session()->put('latitude', $request->latitude);
        $request->session()->put('longitude', $request->longitude);
        return redirect()->route('items.create.step5');
    }

    public function createStep5()
    {
        return view('themes.default.items.create_step5');
    }

    public function postCreateStep5(Request $request)
    {
        $request->session()->put('latitude', $request->latitude);
        $request->session()->put('longitude', $request->longitude);
        return redirect()->route('items.create.step6');
    }

    public function createStep6()
    {
        return view('themes.default.items.create_step6');
    }

    public function postCreateStep6(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'client_id' => session('client_id'),
            'description' => session('description'),
            'location' => session('location'),
            'latitude' => session('latitude'),
            'longitude' => session('longitude'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function searchClients(Request $request)
    {
        $query = $request->get('query', '');
        $clients = Client::where('alias', 'LIKE', "%{$query}%")->get();
        return response()->json($clients);
    }
}
