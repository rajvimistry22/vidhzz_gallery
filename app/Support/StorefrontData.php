<?php

namespace App\Support;

class StorefrontData
{
    public static function testimonials(): array
    {
        return [
            ['name' => 'Riya Patel', 'quote' => 'The finishing feels premium and the packaging is beautiful.', 'city' => 'Ahmedabad'],
            ['name' => 'Kashvi Shah', 'quote' => 'My Navratri look came together in one order. Elegant, lightweight, and festive.', 'city' => 'Vadodara'],
            ['name' => 'Meera Doshi', 'quote' => 'The resin keychains and pooja thali felt handcrafted and truly special.', 'city' => 'Surat'],
        ];
    }

    public static function gallery(): array
    {
        return [
            ['title' => 'Festival Dressing', 'image' => asset('images/placeholders/gallery-1.svg')],
            ['title' => 'Handmade Bangles', 'image' => asset('images/placeholders/gallery-2.svg')],
            ['title' => 'Resin Art Gifts', 'image' => asset('images/placeholders/gallery-3.svg')],
            ['title' => 'Haldi Styling', 'image' => asset('images/placeholders/gallery-4.svg')],
        ];
    }
}
