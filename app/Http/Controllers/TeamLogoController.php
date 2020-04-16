<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\UploadTeamLogoRequest;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamLogoController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:reporter');
        $this->middleware('optimizeImages')->only('store');
    }

    public function store(UploadTeamLogoRequest $uploadTeamLogoRequest)
    {

        if (auth()->user()->team->has_logo) {
            Storage::delete(Team::STORAGE_PATH . auth()->user()->team->logo);
        }

        auth()->user()->team->update([
            'logo' => $uploadTeamLogoRequest->logo->hashName(),
        ]);

        $uploadTeamLogoRequest->logo->store(Team::STORAGE_PATH);

        return response()
            ->json([
                'logo' => auth()->user()->team->logo_url,
            ]);
    }

    public function destroy(Request $request)
    {

        if (!auth()->user()->team->has_logo) {
            return response()->json([
                'message' => 'Your Team does not have a logo to remove',
            ], 422);
        }

        Storage::delete(Team::STORAGE_PATH . auth()->user()->team->logo);

        auth()->user()->team->update([
            'logo' => null,
        ]);
        return response()
            ->json([
                'logo' => auth()->user()->team->logo_url,
            ]);
    }

}
