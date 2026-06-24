<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'name' => 'Jewelry',
                'slug' => 'jewelry',
                'icon' => 'Gem',
                'description' => 'Delicate silver, beadwork, and heirloom-inspired pieces.',
            ],
            [
                'name' => 'Woodwork',
                'slug' => 'woodwork',
                'icon' => 'Trees',
                'description' => 'Carved home pieces, toys, and practical objects with soul.',
            ],
            [
                'name' => 'Ceramics',
                'slug' => 'ceramics',
                'icon' => 'CupSoda',
                'description' => 'Wheel-thrown cups, sculptural forms, and one-off tableware.',
            ],
            [
                'name' => 'Art',
                'slug' => 'art',
                'icon' => 'Palette',
                'description' => 'Illustration, prints, mixed media, and expressive originals.',
            ],
            [
                'name' => 'Decor',
                'slug' => 'decor',
                'icon' => 'Sparkles',
                'description' => 'Warm interiors, candles, ornaments, and magical small details.',
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'icon' => 'Shirt',
                'description' => 'Slow-made garments, embroidery, and custom wearable pieces.',
            ],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            ),
        ]);

        $creator = User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Lejla H.',
                'username' => 'lejla',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'avatar' => '/brand/logo.png',
                'bio' => 'Handmade creator building a careful first storefront on Carobnjaci.',
                'city' => 'Sarajevo',
                'instagram' => '@atelierluma',
                'phone' => '+387 61 000 111',
            ],
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'mehmed.selimovic.ets@gmail.com'],
            [
                'name' => 'Mehmed Selimovic',
                'username' => 'mehmed-selimovic-admin',
                'password' => Hash::make('carbonjaci@2026'),
                'email_verified_at' => now(),
                'is_admin' => true,
                'city' => 'Sarajevo',
            ],
        );

        Shop::query()->where('user_id', $admin->id)->delete();

        $buyerOne = User::query()->updateOrCreate(
            ['email' => 'mina@example.com'],
            [
                'name' => 'Mina K.',
                'username' => 'mina',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'city' => 'Mostar',
            ],
        );

        $buyerTwo = User::query()->updateOrCreate(
            ['email' => 'adnan@example.com'],
            [
                'name' => 'Adnan R.',
                'username' => 'adnan',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'city' => 'Sarajevo',
            ],
        );

        $shops = collect([
            [
                'user' => $creator,
                'name' => 'Atelier Luma',
                'slug' => 'atelier-luma',
                'specialty' => 'Woodwork and decor',
                'description' => 'Quiet woodcraft inspired by old chests, folk ornaments, and moonlit interiors.',
                'bio' => 'Atelier Luma creates small-batch wooden keepsakes, decor pieces, and gift objects that feel warm, tactile, and lasting.',
                'logo' => '/brand/logo.png',
                'cover_image' => '/placeholders/hero-handmade.jpg',
                'city' => 'Sarajevo',
                'instagram' => '@atelierluma',
                'phone' => '+387 61 000 111',
                'response_time' => 'Usually replies within 1 day',
                'status' => 'approved',
            ],
            [
                'user' => User::query()->updateOrCreate(
                    ['email' => 'clay@example.com'],
                    [
                        'name' => 'Maja B.',
                        'username' => 'maja',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'city' => 'Mostar',
                    ],
                ),
                'name' => 'Clay & Quiet',
                'slug' => 'clay-and-quiet',
                'specialty' => 'Ceramics',
                'description' => 'Minimal ceramic pieces shaped for slow mornings, tea rituals, and gifting.',
                'bio' => 'Clay & Quiet makes understated ceramic pieces for everyday rituals with soft textures and handmade variation.',
                'logo' => '/brand/logo.png',
                'cover_image' => '/placeholders/about-studio.avif',
                'city' => 'Mostar',
                'instagram' => '@clayandquiet',
                'phone' => '+387 62 000 222',
                'response_time' => 'Usually replies within a few hours',
                'status' => 'approved',
            ],
            [
                'user' => User::query()->updateOrCreate(
                    ['email' => 'selo@example.com'],
                    [
                        'name' => 'Nera T.',
                        'username' => 'nera',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'city' => 'Tuzla',
                    ],
                ),
                'name' => 'Selo Ink',
                'slug' => 'selo-ink',
                'specialty' => 'Art prints',
                'description' => 'Illustration prints, expressive color work, and original artwork for warm interiors.',
                'bio' => 'Selo Ink brings together prints, originals, and small-run art objects with a strong sense of color and atmosphere.',
                'logo' => '/brand/logo.png',
                'cover_image' => '/placeholders/card-tree.jpg',
                'city' => 'Tuzla',
                'instagram' => '@seloink',
                'phone' => '+387 63 000 333',
                'response_time' => 'Usually replies within 2 days',
                'status' => 'approved',
            ],
        ])->mapWithKeys(function (array $shopData) {
            $user = $shopData['user'];
            unset($shopData['user']);

            return [
                $shopData['slug'] => Shop::query()->updateOrCreate(
                    ['slug' => $shopData['slug']],
                    array_merge($shopData, ['user_id' => $user->id]),
                ),
            ];
        });

        $products = [
            [
                'shop' => $shops['atelier-luma'],
                'category' => $categories['woodwork'],
                'title' => 'Moonlit Keepsake Box',
                'slug' => 'moonlit-keepsake-box',
                'description' => 'A warm wooden keepsake box for letters, jewelry, and small treasured objects.',
                'featured_image' => '/placeholders/hero-handmade.jpg',
                'materials' => ['Solid wood', 'Natural wax finish', 'Soft inner lining'],
                'lead_time' => 'Made to order in 4-6 days',
                'price' => 78,
                'contact_price' => false,
                'is_featured' => true,
                'status' => 'published',
                'views' => 12,
                'images' => [
                    '/placeholders/hero-handmade.jpg',
                    '/placeholders/card-paper.jpg',
                    '/placeholders/about-studio.avif',
                ],
            ],
            [
                'shop' => $shops['clay-and-quiet'],
                'category' => $categories['ceramics'],
                'title' => 'Handbuilt Lavender Cup',
                'slug' => 'handbuilt-lavender-cup',
                'description' => 'A softly shaped ceramic cup designed for tea, coffee, and slow mornings.',
                'featured_image' => '/placeholders/card-paper.jpg',
                'materials' => ['Stoneware clay', 'Food-safe glaze', 'Kiln-fired finish'],
                'lead_time' => 'Ready to ship in 2-3 days',
                'price' => null,
                'contact_price' => true,
                'is_featured' => true,
                'status' => 'published',
                'views' => 7,
                'images' => [
                    '/placeholders/card-paper.jpg',
                    '/placeholders/about-studio.avif',
                    '/placeholders/card-pompoms.jpg',
                ],
            ],
            [
                'shop' => $shops['atelier-luma'],
                'category' => $categories['jewelry'],
                'title' => 'Star Thread Earrings',
                'slug' => 'star-thread-earrings',
                'description' => 'Lightweight earrings with playful detail and an easy everyday silhouette.',
                'featured_image' => '/placeholders/card-pompoms.jpg',
                'materials' => ['Brass findings', 'Thread detail', 'Nickel-free hooks'],
                'lead_time' => 'Made to order in 3-5 days',
                'price' => 34,
                'contact_price' => false,
                'is_featured' => false,
                'status' => 'published',
                'views' => 5,
                'images' => [
                    '/placeholders/card-pompoms.jpg',
                    '/placeholders/card-portrait.jpg',
                    '/placeholders/card-paper.jpg',
                ],
            ],
            [
                'shop' => $shops['selo-ink'],
                'category' => $categories['art'],
                'title' => 'Botanical Wall Print',
                'slug' => 'botanical-wall-print',
                'description' => 'A vivid print for interiors that need a stronger artistic focal point.',
                'featured_image' => '/placeholders/card-tree.jpg',
                'materials' => ['Fine art paper', 'Archival inks', 'Signed small batch print'],
                'lead_time' => 'Ships in 1-2 days',
                'price' => 46,
                'contact_price' => false,
                'is_featured' => false,
                'status' => 'published',
                'views' => 9,
                'images' => [
                    '/placeholders/card-tree.jpg',
                    '/placeholders/card-portrait.jpg',
                    '/placeholders/hero-handmade.jpg',
                ],
            ],
        ];

        foreach ($products as $data) {
            $shop = $data['shop'];
            $category = $data['category'];
            $images = $data['images'];

            unset($data['shop'], $data['category'], $data['images']);

            $product = Product::query()->updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'shop_id' => $shop->id,
                    'category_id' => $category->id,
                ]),
            );

            foreach ($images as $index => $image) {
                ProductImage::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'sort_order' => $index,
                    ],
                    [
                        'image_path' => $image,
                    ],
                );
            }
        }

        $moonlitBox = Product::query()->where('slug', 'moonlit-keepsake-box')->firstOrFail();

        $messages = [
            [
                'sender_id' => $buyerOne->id,
                'receiver_id' => $creator->id,
                'product_id' => $moonlitBox->id,
                'subject' => 'Custom engraving request',
                'message' => 'Can you add initials to the keepsake box before gifting?',
                'read_at' => null,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'sender_id' => $buyerTwo->id,
                'receiver_id' => $creator->id,
                'product_id' => $moonlitBox->id,
                'subject' => 'Pickup on Saturday',
                'message' => 'I am local to Sarajevo and wanted to ask about studio pickup this weekend.',
                'read_at' => now()->subHours(2),
                'created_at' => now()->subDay(),
                'updated_at' => now()->subHours(2),
            ],
            [
                'sender_id' => $buyerOne->id,
                'receiver_id' => $creator->id,
                'product_id' => null,
                'subject' => 'Gift note included?',
                'message' => 'Could you include a short handwritten note if I order a gift set?',
                'read_at' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ];

        foreach ($messages as $message) {
            Message::query()->updateOrCreate(
                [
                    'sender_id' => $message['sender_id'],
                    'receiver_id' => $message['receiver_id'],
                    'subject' => $message['subject'],
                ],
                $message,
            );
        }
    }
}
