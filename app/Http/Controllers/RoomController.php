<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        $room->load('amenities.translations', 'translations');
        abort_unless($room->status === 'published', 404);

        $amenityIds = $room->amenities->pluck('id');

        $similarQuery = Room::with('amenities.translations', 'translations')
            ->where('status', 'published')
            ->whereKeyNot($room->id);

        if ($amenityIds->isNotEmpty()) {
            $similarQuery->withCount([
                'amenities as shared_amenities_count' => fn ($query) => $query->whereIn('amenities.id', $amenityIds),
            ])->orderByDesc('shared_amenities_count');
        }

        $similarRooms = $similarQuery
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        return view('rooms.show', compact('room', 'similarRooms'));
    }
}
