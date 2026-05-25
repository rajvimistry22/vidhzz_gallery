<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BoutiqueSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vidhi.test'],
            [
                'name' => 'Vidhi Admin',
                'phone' => '9999999999',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'FESTIVE20'],
            [
                'type' => 'percent',
                'value' => 20,
                'min_order_amount' => 1499,
                'max_discount' => 1000,
                'usage_limit' => 500,
                'used_count' => 0,
                'per_user_limit' => 2,
                'is_active' => true,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addYear(),
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Festive Signature Drop'],
            [
                'subtitle' => 'Minimal luxury for Navratri, gifting, and ceremony styling.',
                'image' => 'images/banners/navratri_banner.png',
                'mobile_image' => 'images/banners/navratri_banner.png',
                'cta_text' => 'Shop Now',
                'cta_url' => '/products',
                'badge_text' => 'New season',
                'position' => 'hero',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Handcrafted Bangles Edit'],
            [
                'subtitle' => 'Elegant stacks, festive color stories, and artisan finish.',
                'image' => 'images/banners/bangles_banner.png',
                'mobile_image' => 'images/banners/bangles_banner.png',
                'cta_text' => 'Explore Bangles',
                'cta_url' => '/collections/bangles-collections',
                'badge_text' => 'Trending',
                'position' => 'hero',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        // ─────────────────────────────────────────────
        // CATEGORY 1: NAVRATRI COLLECTIONS
        // ─────────────────────────────────────────────
        $navratri = Category::create([
            'name'         => 'Navratri Collections',
            'slug'         => 'navratri-collections',
            'description'  => 'Handcrafted festive accessories made with love for your Garba nights — from jhumkas to hair bows, belts, hasli and more.',
            'image'        => 'images/categories/navratri.png',
            'banner_image' => 'images/banners/navratri_banner.png',
            'sort_order'   => 1,
            'is_active'    => true,
        ]);

        $navratriProducts = [
            [
                'name'              => 'Gota & Bead Navratri Choker Set',
                'sku'               => 'VID-NAV-001',
                'subcategory'       => 'handmade-set',
                'short_description' => 'Handmade multi-layered choker set with gold gota, colorful beads and small mirror work.',
                'description'       => 'A stunning handmade choker set crafted by artisans using traditional gota patti ribbon, tiny shimmering mirrors, and a variety of colorful seed beads. The set includes a main choker and matching maang tikka. Completely handmade — no two pieces are identical!',
                'price'             => 850.00,
                'sale_price'        => 699.00,
                'stock'             => 30,
                'sizes'             => ['One Size'],
                'colors'            => ['Multicolor', 'Red & Gold', 'Pink & Gold'],
                'material'          => 'Gota Patti, Seed Beads & Mirrors',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Hand-Painted Clay Garba Jhumkas',
                'sku'               => 'VID-NAV-002',
                'subcategory'       => 'earrings',
                'short_description' => 'Lightweight hand-painted terracotta clay jhumkas with vibrant Garba motifs.',
                'description'       => 'These adorable jhumkas are lovingly hand-sculpted from air-dry clay and painted with intricate Gujarati folk art motifs — peacocks, geometric patterns, and tiny mirrors. Feather-light and comfortable to wear all evening at Garba.',
                'price'             => 450.00,
                'sale_price'        => 399.00,
                'stock'             => 50,
                'sizes'             => ['One Size'],
                'colors'            => ['Red & Blue', 'Yellow & Green', 'Orange & Teal'],
                'material'          => 'Air-Dry Clay, Acrylic Paint & Mirror Work',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Mirror-Embroidery Gujarati Kamarbandh Belt',
                'sku'               => 'VID-NAV-003',
                'subcategory'       => 'belt',
                'short_description' => 'Traditional Gujarati handmade waist belt with dense mirror embroidery and thread work.',
                'description'       => 'Bring your lehenga silhouette to life with this authentic handmade kamarbandh. Dense mirror work, vibrant thread embroidery, and cowrie shell accents are stitched by hand onto a sturdy cotton base. Adjustable tie-back ensures a perfect fit for dancing.',
                'price'             => 1100.00,
                'sale_price'        => 899.00,
                'stock'             => 25,
                'sizes'             => ['Adjustable'],
                'colors'            => ['Red & Gold', 'Green & Gold', 'Blue & Gold'],
                'material'          => 'Cotton Base, Glass Mirrors, Cowrie Shells & Silk Threads',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Thread & Shell Hasli Neckpiece',
                'sku'               => 'VID-NAV-004',
                'subcategory'       => 'hasli',
                'short_description' => 'Handcrafted rigid choker (hasli) wrapped in vibrant silk thread with dangling shells and beads.',
                'description'       => 'This handmade hasli neckpiece is crafted on a semi-rigid wire base and meticulously hand-wrapped with premium silk threads in festive colors. Dangling shells, tiny ghungroo bells, and seed beads add movement and melody as you dance.',
                'price'             => 650.00,
                'sale_price'        => null,
                'stock'             => 40,
                'sizes'             => ['Adjustable'],
                'colors'            => ['Orange & Red', 'Pink & Gold', 'Teal & White'],
                'material'          => 'Silk Thread, Wire Frame, Shells & Ghungroo',
                'is_featured'       => true,
                'is_trending'       => false,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Pastel Bandhani Silk Bow Hair Clip',
                'sku'               => 'VID-NAV-005',
                'subcategory'       => 'hair-bow',
                'short_description' => 'An oversized handmade bow clip crafted from soft pastel bandhani silk fabric.',
                'description'       => 'Add a pop of festive color to your hairstyle with this gorgeous handmade bandhani silk bow. The oversized silhouette looks stunning in a half-up hairstyle or pinned at the side of a braid. Made from genuine bandhani fabric with a sturdy alligator clip.',
                'price'             => 350.00,
                'sale_price'        => 299.00,
                'stock'             => 60,
                'sizes'             => ['One Size'],
                'colors'            => ['Pastel Pink', 'Pastel Blue', 'Marigold Yellow'],
                'material'          => 'Bandhani Silk Fabric & Metal Alligator Clip',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Mirror-Bead Braided Parandi Hair String',
                'sku'               => 'VID-NAV-006',
                'subcategory'       => 'hair-string',
                'short_description' => 'A traditional braided parandi (hair extension string) with colourful beads and mini mirrors.',
                'description'       => 'Adorn your braid with this vibrant handmade parandi — a traditional Punjabi and Gujarati hair accessory. Braided with silk threads, interspersed with tiny round mirrors, colorful seed beads, and finished with golden tassels at the end. Simply weave it into your plait.',
                'price'             => 320.00,
                'sale_price'        => 280.00,
                'stock'             => 55,
                'sizes'             => ['90cm', '120cm'],
                'colors'            => ['Red & Gold', 'Multicolor', 'Pink & Silver'],
                'material'          => 'Silk Thread, Seed Beads & Mini Mirrors',
                'is_featured'       => false,
                'is_trending'       => false,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Floral Mirror-Work Hair Clips Trio',
                'sku'               => 'VID-NAV-007',
                'subcategory'       => 'hair-clips',
                'short_description' => 'Set of 3 handmade mini hair clips with fabric flower and mirror work centers.',
                'description'       => 'A sweet set of three snap hair clips, each hand-decorated with a handmade fabric flower and a tiny round mirror at the center, surrounded by golden gota ribbon petals. Mix and match them along a side part, half-up style, or bun.',
                'price'             => 280.00,
                'sale_price'        => 249.00,
                'stock'             => 80,
                'sizes'             => ['Set of 3'],
                'colors'            => ['Pink & Gold', 'Orange & Gold', 'Multicolor'],
                'material'          => 'Fabric Flowers, Gota Patti & Mini Mirrors on Metal Snap Clips',
                'is_featured'       => false,
                'is_trending'       => false,
                'is_new_arrival'    => false,
            ],
        ];

        $this->createProducts($navratri->id, $navratriProducts, 'images/products/navratri/');

        // ─────────────────────────────────────────────
        // CATEGORY 2: BANGLES COLLECTIONS
        // ─────────────────────────────────────────────
        $bangles = Category::create([
            'name'         => 'Bangles Collections',
            'slug'         => 'bangles-collections',
            'description'  => 'Beautiful handcrafted bangles — silk-thread wrapped, beaded, gota patti, and more. Each set lovingly made by hand.',
            'image'        => 'images/categories/bangles.png',
            'banner_image' => 'images/banners/bangles_banner.png',
            'sort_order'   => 2,
            'is_active'    => true,
        ]);

        $banglesProducts = [
            [
                'name'              => 'Pastel Silk-Thread Stacked Bangles Set',
                'sku'               => 'VID-BAN-001',
                'subcategory'       => 'silk-thread',
                'short_description' => 'A gorgeous 12-piece set of slim silk-thread wrapped bangles in soft pastel shades.',
                'description'       => 'This beautiful set of 12 individually silk-thread wrapped bangles comes in a curated palette of soft pastel shades — blush pink, baby blue, mint green, and ivory. Each bangle is wrapped and knotted by hand, and finished with a tiny tassel detail.',
                'price'             => 950.00,
                'sale_price'        => 799.00,
                'stock'             => 40,
                'sizes'             => ['2.4', '2.6', '2.8'],
                'colors'            => ['Pastel Mix', 'Pink & Gold', 'Mint & Ivory'],
                'material'          => 'Silk Thread on Acrylic Bangle Base',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Shell & Bead Gold-Plated Kada Pair',
                'sku'               => 'VID-BAN-002',
                'subcategory'       => 'kada',
                'short_description' => 'A handcrafted pair of kadas decorated with cowrie shells, seed beads, and a gold-plated finish.',
                'description'       => 'These statement kadas are hand-decorated with rows of tiny cowrie shells, seed beads, and gold spacer beads on a sturdy metal base with a premium gold-plated coating. The perfect arm candy for Navratri and festivals.',
                'price'             => 1200.00,
                'sale_price'        => 999.00,
                'stock'             => 25,
                'sizes'             => ['2.4', '2.6', '2.8'],
                'colors'            => ['White & Gold', 'Pink & Gold', 'Blue & Gold'],
                'material'          => 'Gold-Plated Metal, Cowrie Shells & Seed Beads',
                'is_featured'       => true,
                'is_trending'       => false,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Handmade Gota Patti Glass Bangle Assortment',
                'sku'               => 'VID-BAN-003',
                'subcategory'       => 'gota-patti',
                'short_description' => 'Classic glass bangles wrapped and embellished with golden gota patti ribbon and tiny pearls.',
                'description'       => 'Traditional glass bangles get a handmade upgrade with this beautiful gota patti embellishment technique. Each bangle is wrapped with golden gota ribbon and dotted with tiny faux pearls. Comes in a set of 8 bangles, 4 per hand.',
                'price'             => 650.00,
                'sale_price'        => null,
                'stock'             => 50,
                'sizes'             => ['2.4', '2.6', '2.8'],
                'colors'            => ['Gold & White', 'Gold & Pink', 'Gold & Red'],
                'material'          => 'Glass Bangles, Gota Patti Ribbon & Faux Pearls',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Custom Name Initial Resin Bangle',
                'sku'               => 'VID-BAN-004',
                'subcategory'       => 'custom',
                'short_description' => 'A unique clear resin bangle with your name initial and dried flowers embedded inside.',
                'description'       => 'Order a completely personalised resin bangle with your chosen initial letter set in clear transparent resin along with tiny dried baby\'s breath flowers and gold leaf flakes. A wearable piece of art that\'s completely one-of-a-kind.',
                'price'             => 780.00,
                'sale_price'        => null,
                'stock'             => 20,
                'sizes'             => ['2.4', '2.6', '2.8'],
                'colors'            => ['Clear & Gold', 'Rose Tinted', 'Lavender Tinted'],
                'material'          => 'Epoxy Resin, Gold Leaf & Dried Flowers',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
        ];

        $this->createProducts($bangles->id, $banglesProducts, 'images/products/bangles/');

        // ─────────────────────────────────────────────
        // CATEGORY 3: RESIN COLLECTIONS
        // ─────────────────────────────────────────────
        $resin = Category::create([
            'name'         => 'Resin Collections',
            'slug'         => 'resin-collections',
            'description'  => 'Handcrafted resin art — phone covers, keychains, and Pooja thalis made with pressed flowers, gold flakes, and pearls.',
            'image'        => 'images/categories/resin.png',
            'banner_image' => 'images/banners/resin_banner.png',
            'sort_order'   => 3,
            'is_active'    => true,
        ]);

        $resinProducts = [
            [
                'name'              => 'Pressed Flower Resin Phone Cover',
                'sku'               => 'VID-RES-001',
                'subcategory'       => 'phone-cover',
                'short_description' => 'A beautiful clear resin phone cover with real pressed flowers embedded inside.',
                'description'       => 'Carry a tiny garden with you! This handmade clear resin phone cover features real pressed and dried flowers — daisies, baby\'s breath, and tiny lavender sprigs — embedded in crystal-clear epoxy resin. Each cover is unique. Available for most popular phone models. Please specify your model at checkout.',
                'price'             => 599.00,
                'sale_price'        => 499.00,
                'stock'             => 35,
                'sizes'             => ['iPhone 13', 'iPhone 14', 'iPhone 15', 'Samsung S23', 'Samsung S24', 'Custom (specify)'],
                'colors'            => ['Clear with Pink Flowers', 'Clear with White Flowers', 'Clear with Mixed Wildflowers'],
                'material'          => 'Epoxy Resin, Real Pressed Flowers & Polycarbonate Case Base',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Gold Flake Initial Resin Keychain',
                'sku'               => 'VID-RES-002',
                'subcategory'       => 'keychain',
                'short_description' => 'Personalised resin keychain with your alphabet initial and swirling gold flakes.',
                'description'       => 'A charming personalised keychain in your chosen alphabet letter, hand-cast in crystal-clear epoxy resin with swirling gold leaf flakes inside. The golden flakes catch the light beautifully. Comes with a gold-plated keyring. A thoughtful gift or daily accessory.',
                'price'             => 299.00,
                'sale_price'        => 249.00,
                'stock'             => 60,
                'sizes'             => ['Standard Size (~4cm)'],
                'colors'            => ['Clear & Gold', 'Rose Gold Tinted', 'Sage Green Tinted'],
                'material'          => 'Epoxy Resin, Gold Leaf Flakes & Gold-Plated Keyring',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Rose Petal & Pearl Resin Pooja Thali',
                'sku'               => 'VID-RES-003',
                'subcategory'       => 'pooja-thali',
                'short_description' => 'An elegant handcrafted resin Pooja thali with embedded rose petals and faux pearls.',
                'description'       => 'Elevate your pooja space with this stunning handcrafted resin thali. Made with premium food-safe epoxy resin, with dried rose petals, gold leaf, and white faux pearls embedded in layers. The surface is polished to a high gloss. Comes with a matching small diya holder and incense stick rest.',
                'price'             => 1199.00,
                'sale_price'        => 999.00,
                'stock'             => 15,
                'sizes'             => ['25cm diameter'],
                'colors'            => ['Blush Pink & Gold', 'White & Gold', 'Deep Red & Gold'],
                'material'          => 'Epoxy Resin, Dried Rose Petals, Gold Leaf & Faux Pearls',
                'is_featured'       => true,
                'is_trending'       => false,
                'is_new_arrival'    => true,
            ],
        ];

        $this->createProducts($resin->id, $resinProducts, 'images/products/resin/');

        // ─────────────────────────────────────────────
        // CATEGORY 4: HALDI ACCESSORIES
        // ─────────────────────────────────────────────
        $haldi = Category::create([
            'name'         => 'Haldi Accessories',
            'slug'         => 'haldi-accessories',
            'description'  => 'Bright, beautiful yellow handmade jewellery and accessories for your Haldi ceremony.',
            'image'        => 'images/categories/haldi.png',
            'banner_image' => 'images/banners/haldi_banner.png',
            'sort_order'   => 4,
            'is_active'    => true,
        ]);

        $haldiProducts = [
            [
                'name'              => 'Marigold Gota Patti Haldi Jewellery Set',
                'sku'               => 'VID-HAL-001',
                'subcategory'       => 'jewellery-set',
                'short_description' => 'A complete handmade Haldi jewellery set with marigold flowers and golden gota patti.',
                'description'       => 'Look radiant on your Haldi day with this gorgeous handmade jewellery set. Includes a marigold gota necklace, matching stud earrings, a maang tikka, and two flower hair pins. Made with artificial marigold flowers, golden gota patti ribbon, and pearl beads. Lightweight and comfortable for daytime ceremonies.',
                'price'             => 1499.00,
                'sale_price'        => 1199.00,
                'stock'             => 20,
                'sizes'             => ['Full Set'],
                'colors'            => ['Yellow & Gold', 'Yellow & White'],
                'material'          => 'Artificial Marigold Flowers, Gota Patti & Pearl Beads',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Handmade Pearl & Yellow Rose Haldi Choker',
                'sku'               => 'VID-HAL-002',
                'subcategory'       => 'choker',
                'short_description' => 'A dainty handmade choker with faux pearls and tiny yellow fabric roses for the Haldi bride.',
                'description'       => 'This sweet and elegant choker is made by hand with tiny yellow fabric roses, pearl bead clusters, and golden chain details. The perfect delicate accessory for the bride or the bridal squad on Haldi day.',
                'price'             => 650.00,
                'sale_price'        => 549.00,
                'stock'             => 35,
                'sizes'             => ['Adjustable'],
                'colors'            => ['Yellow & Pearl White'],
                'material'          => 'Fabric Roses, Faux Pearls & Gold-Plated Chain',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => 'Yellow Silk-Thread Haldi Bangles Set',
                'sku'               => 'VID-HAL-003',
                'subcategory'       => 'bangles',
                'short_description' => 'A set of 12 sunshine yellow silk-thread bangles with tiny golden bead accents.',
                'description'       => 'Brighten up your wrists on Haldi day with this beautiful set of 12 hand-wrapped silk-thread bangles in cheerful sunshine yellow. Each bangle has tiny golden beads threaded at regular intervals for an extra touch of sparkle.',
                'price'             => 599.00,
                'sale_price'        => 499.00,
                'stock'             => 45,
                'sizes'             => ['2.4', '2.6', '2.8'],
                'colors'            => ['Sunshine Yellow & Gold'],
                'material'          => 'Yellow Silk Thread & Gold Seed Beads on Acrylic Base',
                'is_featured'       => false,
                'is_trending'       => false,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Haldi Floral Tiara & Hair Pins Set',
                'sku'               => 'VID-HAL-004',
                'subcategory'       => 'hair-accessories',
                'short_description' => 'A handmade bridal tiara with marigold flowers and matching pearl hair pins for Haldi.',
                'description'       => 'A complete bridal hair accessories set for the Haldi ceremony. The tiara crown is hand-assembled with artificial marigold heads, golden leaves, and pearl sprigs on a flexible wire base. Comes with 4 matching floral hair pins to complete the look.',
                'price'             => 799.00,
                'sale_price'        => 699.00,
                'stock'             => 18,
                'sizes'             => ['Adjustable Crown'],
                'colors'            => ['Yellow & Gold', 'Yellow & White'],
                'material'          => 'Artificial Marigold, Pearl Sprigs & Gold Wire Frame',
                'is_featured'       => true,
                'is_trending'       => false,
                'is_new_arrival'    => false,
            ],
        ];

        $this->createProducts($haldi->id, $haldiProducts, 'images/products/haldi/');

        // ─────────────────────────────────────────────
        // CATEGORY 5: BABY SHOWER ACCESSORIES
        // ─────────────────────────────────────────────
        $babyShower = Category::create([
            'name'         => 'Baby Shower Accessories',
            'slug'         => 'baby-shower-accessories',
            'description'  => 'Sweet, handcrafted baby shower accessories for the mom-to-be — tiaras, sashes, brooches and more.',
            'image'        => 'images/categories/babyshower.png',
            'banner_image' => 'images/banners/babyshower_banner.png',
            'sort_order'   => 5,
            'is_active'    => true,
        ]);

        $babyShowerProducts = [
            [
                'name'              => 'Mom-to-Be Floral Crown & Sash Set',
                'sku'               => 'VID-BSH-001',
                'subcategory'       => 'tiara-sash',
                'short_description' => 'A beautiful handmade floral tiara crown and personalised "Mom-to-Be" sash ribbon.',
                'description'       => 'Make the mom-to-be feel like royalty! This handmade set includes a delicate floral crown with soft pink and white fabric flowers, baby\'s breath, and tiny pearl sprigs — plus a wide pastel satin "Mom-to-Be" sash with a golden foil print. The perfect photo prop and keepsake.',
                'price'             => 899.00,
                'sale_price'        => 749.00,
                'stock'             => 25,
                'sizes'             => ['Adjustable Crown', 'Standard Sash'],
                'colors'            => ['Blush Pink & White', 'Mint & White', 'Lilac & White'],
                'material'          => 'Fabric Flowers, Pearl Sprigs, Satin Ribbon & Foil Print',
                'is_featured'       => true,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Handmade Clay Baby Shower Brooch Pair',
                'sku'               => 'VID-BSH-002',
                'subcategory'       => 'brooch',
                'short_description' => 'A sweet pair of handmade clay brooches — a pram and a baby bootie — perfect for baby shower décor.',
                'description'       => 'These utterly charming brooches are hand-sculpted from premium air-dry polymer clay. One features a miniature baby pram and the other a tiny baby bootie, each painted in delicate pastel shades and glazed for a lasting finish. Pin them on jackets, bags, or use as gift tags.',
                'price'             => 450.00,
                'sale_price'        => 399.00,
                'stock'             => 40,
                'sizes'             => ['Pair (~3cm each)'],
                'colors'            => ['Blush Pink', 'Baby Blue', 'Mint Green'],
                'material'          => 'Polymer Clay, Acrylic Paint & Gold-Plated Pin Base',
                'is_featured'       => false,
                'is_trending'       => true,
                'is_new_arrival'    => true,
            ],
            [
                'name'              => 'Baby Shower Guest Favour Keychains (Set of 10)',
                'sku'               => 'VID-BSH-003',
                'subcategory'       => 'favours',
                'short_description' => 'Set of 10 handmade resin/clay baby-themed keychains — adorable party favours for your guests.',
                'description'       => 'Treat your baby shower guests to these adorable handmade keychains. Each set of 10 includes a mix of baby bottle, pacifier, and star-shaped clear resin keychains with tiny pearls inside. The perfect party favour that guests will actually love and keep.',
                'price'             => 999.00,
                'sale_price'        => 849.00,
                'stock'             => 30,
                'sizes'             => ['Set of 10'],
                'colors'            => ['Pink Mix', 'Blue Mix', 'Neutral Pastel Mix'],
                'material'          => 'Epoxy Resin, Faux Pearls & Gold-Plated Keyrings',
                'is_featured'       => false,
                'is_trending'       => false,
                'is_new_arrival'    => false,
            ],
            [
                'name'              => '"Baby on the Way" Decorative Floral Frame',
                'sku'               => 'VID-BSH-004',
                'subcategory'       => 'decor',
                'short_description' => 'A handmade dried flower and ribbon frame for the baby shower photo booth backdrop.',
                'description'       => 'Create a beautiful photo booth moment with this handmade decorative frame. The wooden frame base is adorned with handmade fabric flowers, dried baby\'s breath, golden ribbon bows, and a calligraphy banner saying "Baby on the Way." A stunning photo prop and keepsake décor piece.',
                'price'             => 1299.00,
                'sale_price'        => 1099.00,
                'stock'             => 10,
                'sizes'             => ['A4 Size Frame'],
                'colors'            => ['Blush Pink & Gold', 'Sage & White', 'Lilac & Gold'],
                'material'          => 'Wooden Frame, Fabric Flowers, Dried Baby\'s Breath & Ribbon',
                'is_featured'       => true,
                'is_trending'       => false,
                'is_new_arrival'    => true,
            ],
        ];

        $this->createProducts($babyShower->id, $babyShowerProducts, 'images/products/babyshower/');
    }

    private function createProducts(int $categoryId, array $products, string $imageFolder): void
    {
        foreach ($products as $pData) {
            $slug = Str::slug($pData['name']);
            // ensure unique slug
            $count = Product::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            $p = Product::create([
                'category_id'     => $categoryId,
                'name'            => $pData['name'],
                'slug'            => $slug,
                'sku'             => $pData['sku'],
                'subcategory'     => $pData['subcategory'],
                'short_description' => $pData['short_description'],
                'description'     => $pData['description'],
                'price'           => $pData['price'],
                'sale_price'      => $pData['sale_price'],
                'stock'           => $pData['stock'],
                'unit'            => 'piece',
                'sizes'           => $pData['sizes'],
                'colors'          => $pData['colors'],
                'material'        => $pData['material'],
                'is_featured'     => $pData['is_featured'],
                'is_trending'     => $pData['is_trending'],
                'is_new_arrival'  => $pData['is_new_arrival'],
                'is_active'       => true,
                'sort_order'      => 0,
                'rating'          => round(3.8 + (lcg_value() * 1.2), 1),
            ]);

            ProductImage::create([
                'product_id' => $p->id,
                'image_path' => $imageFolder . Str::slug($pData['name']) . '.jpg',
                'alt_text'   => $pData['name'],
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }
}
