<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqSectionSetting;
use App\Models\HomeHeroSetting;
use App\Models\PageHeaderSetting;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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

        $bookingFooterSetting = $this->loadBookingFooterSetting();
        $heroSetting = $this->loadHeroSetting();
        [$homeFaqs, $faqSectionSetting] = $this->loadFaqs();

        return themed_view('rooms.show', compact('room', 'similarRooms', 'bookingFooterSetting', 'heroSetting', 'homeFaqs', 'faqSectionSetting'));
    }

    private function loadFaqs(): array
    {
        $homeFaqs = collect();
        $faqSectionSetting = null;

        if (Schema::hasTable('faqs')) {
            $homeFaqs = Faq::where('is_published', true)
                ->with('translations')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        if (Schema::hasTable('faq_section_settings')) {
            $faqSectionSetting = FaqSectionSetting::find(1);
            $faqSectionSetting?->loadMissing('translations');
        }

        return [$homeFaqs, $faqSectionSetting];
    }

    private function loadBookingFooterSetting(): object
    {
        $default = (object) [
            'header_image' => 'img/rooms/01.jpg',
            'subtitle'     => 'Hotel Experience',
            'title'        => 'Booking Form',
        ];

        if (!Schema::hasTable('page_header_settings')) {
            return $default;
        }

        $setting = PageHeaderSetting::firstOrCreate(
            ['page' => 'booking_footer'],
            [
                'header_image' => 'img/rooms/01.jpg',
                'subtitle'     => 'Hotel Experience',
                'title'        => 'Booking Form',
                'hero_text'    => '',
            ]
        );
        $setting->loadMissing('translations');

        return $setting;
    }

    private function loadHeroSetting(): object
    {
        $default = (object) [
            'show_booking_form' => true,
            'small_title'       => 'Expérience hôtelière',
            'title'             => 'Une expérience unique où séjourner',
            'button_link'       => '/appartements',
            'button_target'     => '_self',
            'background_image'  => 'img/hero_home_1.jpg',
        ];

        if (!Schema::hasTable('home_hero_settings')) {
            return $default;
        }

        $setting = HomeHeroSetting::firstOrCreate(
            ['section' => 'home_hero'],
            [
                'show_booking_form' => true,
                'small_title'       => 'Expérience hôtelière',
                'title'             => 'Une expérience unique où séjourner',
                'button_link'       => '/appartements',
                'button_target'     => '_self',
                'background_type'   => 'video',
                'background_video'  => 'video/sunset.mp4',
                'youtube_video_url' => null,
                'background_image'  => 'img/hero_home_1.jpg',
            ]
        );
        $setting->loadMissing('translations');

        return $setting;
    }
}
