<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Client;
use App\Models\Status;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;

class AssetExportController extends Controller
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

    public function exportByClientAndStatus(Client $client, Status $status)
    {
        if (!$status) {
            return redirect()->back()->withErrors('Status not found.');
        }

        $assets = Asset::with('client', 'status')
            ->where('client_id', $client->id)
            ->where('status_id', $status->id) // Ensure correct field name is used
            ->get();
        $pdf = PDF::loadView('pdf.assets', compact('assets'));
        return $pdf->download("assets_{$client->alias}_{$status->name}.pdf");
    }
}
