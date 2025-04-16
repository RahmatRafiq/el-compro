<?php
namespace App\Http\Controllers;

use App\Helpers\MediaLibrary;
use App\Models\AboutApp;
use Illuminate\Http\Request;

class AboutAppController extends Controller
{
    /**
     * Display the profiles.
     */
    public function index()
    {
        $aboutApp           = AboutApp::first();
        $strukturOrganisasi = $aboutApp->getMedia('struktur-organisasi')->first();
        return view('admin.about-app.index', compact('aboutApp', 'strukturOrganisasi'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'struktur-organisasi.*' => 'required|file|max:2048|mimes:jpeg,jpg,png',
            'id'                    => 'required|integer',
        ]);

        AboutApp::find($request->id);

        return response()->json(['message' => 'Image uploaded'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'contact_email'   => 'nullable|string|email|max:255',
            'contact_phone'   => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
        ]);
        $aboutApp = AboutApp::find($id);

        if ($request->has('struktur-organisasi')) {
            MediaLibrary::put(
                $aboutApp,
                'struktur-organisasi',
                $request,
                'struktur-organisasi'
            );
        }

        if ($aboutApp) {
            $aboutApp->update($request->all());
            $message = 'About App updated successfully.';
        } else {
            AboutApp::create($request->all());
            $message = 'About App created successfully.';
        }

        return redirect()->route('about-app.index')
            ->with('success', $message);
    }

    public function deleteFile(Request $request)
    {
        $aboutApp = AboutApp::find($request->id);
        $aboutApp->clearMediaCollection('struktur-organisasi');
        return response()->json(['message' => 'Image deleted'], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'contact_email'   => 'nullable|string|email|max:255',
            'contact_phone'   => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
        ]);

        AboutApp::create($request->all());

        return redirect()->route('about-app.index')
            ->with('success', 'About App created successfully.');
    }
}
