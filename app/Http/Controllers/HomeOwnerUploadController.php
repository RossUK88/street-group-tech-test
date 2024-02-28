<?php

namespace App\Http\Controllers;

use App\Facades\HomeOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HomeOwnerUploadController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', ['people' => []]);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv']
        ]);

        $path = $request->file('csv')->store('uploads');

        $stream = Storage::readStream($path);

        $header = false;
        $people = [];
        while (($line = fgetcsv($stream)) !== false) {
            if (!$header) {
                $header = true;
                continue;
            }

            $people[] = HomeOwner::toArray($line[0]);
        }

        return Inertia::render('Dashboard', [
            'people' => $people,
        ]);
    }
}
