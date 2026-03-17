<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amenities = Amenity::whereIn('scope', ['room', 'both'])
            ->orderBy('title')
            ->paginate(15);

        $installations = Amenity::whereIn('scope', ['home', 'both'])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.amenities.index', compact('amenities', 'installations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.amenities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Amenity::create($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.amenities.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);

        return view('admin.amenities.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);
        $data = $this->validatedData($request, $amenity->id);
        $amenity->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);
        $amenity->delete();

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement supprimé.');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'scope' => ['required', 'in:room,both'],
        ]);
    }
}
