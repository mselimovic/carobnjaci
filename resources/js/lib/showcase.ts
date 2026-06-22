export type FeaturedCategory = {
    slug: string;
    name: string;
    icon: string;
    description: string;
    countLabel: string;
};

export type ShopHighlight = {
    label: string;
    value: string;
};

export type FeaturedShop = {
    slug: string;
    name: string;
    city: string;
    description: string;
    specialty: string;
    image: string;
    logo: string;
    coverImage: string;
    bio: string;
    responseTime: string;
    since: string;
    productCount: string;
    highlightBadges: string[];
    highlights: ShopHighlight[];
};

export type FeaturedProduct = {
    slug: string;
    title: string;
    shop: string;
    shopSlug: string;
    category: string;
    priceLabel: string;
    image: string;
    accent: string;
    shortDescription: string;
    description: string;
    materials: string[];
    leadTime: string;
    location: string;
    gallery: string[];
    relatedSlugs: string[];
};

export const featuredCategories: FeaturedCategory[] = [
    {
        slug: 'jewelry',
        name: 'Jewelry',
        icon: 'Gem',
        description: 'Delicate silver, beadwork, and heirloom-inspired pieces.',
        countLabel: '42 makers',
    },
    {
        slug: 'woodwork',
        name: 'Woodwork',
        icon: 'Trees',
        description: 'Carved home pieces, toys, and practical objects with soul.',
        countLabel: '18 workshops',
    },
    {
        slug: 'ceramics',
        name: 'Ceramics',
        icon: 'CupSoda',
        description: 'Wheel-thrown cups, sculptural forms, and one-off tableware.',
        countLabel: '27 studios',
    },
    {
        slug: 'art',
        name: 'Art',
        icon: 'Palette',
        description: 'Illustration, prints, mixed media, and expressive originals.',
        countLabel: '35 artists',
    },
    {
        slug: 'decor',
        name: 'Decor',
        icon: 'Sparkles',
        description: 'Warm interiors, candles, ornaments, and magical small details.',
        countLabel: '24 collections',
    },
    {
        slug: 'clothing',
        name: 'Clothing',
        icon: 'Shirt',
        description: 'Slow-made garments, embroidery, and custom wearable pieces.',
        countLabel: '16 labels',
    },
];

export const featuredShops: FeaturedShop[] = [
    {
        slug: 'atelier-luma',
        name: 'Atelier Luma',
        city: 'Sarajevo',
        description:
            'Quiet woodcraft inspired by old chests, folk ornaments, and moonlit interiors.',
        specialty: 'Woodwork and decor',
        image: '/placeholders/hero-handmade.jpg',
        logo: '/brand/logo.png',
        coverImage: '/placeholders/hero-handmade.jpg',
        bio: 'Atelier Luma creates small-batch wooden keepsakes, decor pieces, and gift objects that feel warm, tactile, and lasting. The studio focuses on details that make a product feel personal rather than mass-produced.',
        responseTime: 'Usually replies within 1 day',
        since: 'Creating since 2021',
        productCount: '14 listed pieces',
        highlightBadges: ['Custom engraving', 'Gift-ready packaging', 'Local workshop'],
        highlights: [
            { label: 'Featured category', value: 'Woodwork' },
            { label: 'Based in', value: 'Sarajevo' },
            { label: 'Known for', value: 'Keepsake boxes and decor' },
        ],
    },
    {
        slug: 'clay-and-quiet',
        name: 'Clay & Quiet',
        city: 'Mostar',
        description:
            'Minimal ceramic pieces shaped for slow mornings, tea rituals, and gifting.',
        specialty: 'Ceramics',
        image: '/placeholders/card-paper.jpg',
        logo: '/brand/logo.png',
        coverImage: '/placeholders/about-studio.avif',
        bio: 'Clay & Quiet makes understated ceramic pieces for everyday rituals. The studio leans into soft textures, handmade variation, and practical forms that still feel gift-worthy.',
        responseTime: 'Usually replies within a few hours',
        since: 'Creating since 2019',
        productCount: '22 listed pieces',
        highlightBadges: ['Wheel-thrown', 'Small batch', 'Tea ritual sets'],
        highlights: [
            { label: 'Featured category', value: 'Ceramics' },
            { label: 'Based in', value: 'Mostar' },
            { label: 'Known for', value: 'Cups, bowls, and gifting sets' },
        ],
    },
    {
        slug: 'mila-studio',
        name: 'Mila Studio',
        city: 'Banja Luka',
        description:
            'Handmade adornments with soft stones, brass, and romantic color palettes.',
        specialty: 'Jewelry',
        image: '/placeholders/card-portrait.jpg',
        logo: '/brand/logo.png',
        coverImage: '/placeholders/card-portrait.jpg',
        bio: 'Mila Studio creates wearable pieces with a gentle, expressive feel. Collections are built around small-batch earrings, lightweight accents, and giftable jewelry made for everyday wear.',
        responseTime: 'Usually replies within 1 day',
        since: 'Creating since 2020',
        productCount: '18 listed pieces',
        highlightBadges: ['Lightweight pieces', 'Gift notes available', 'Small batch'],
        highlights: [
            { label: 'Featured category', value: 'Jewelry' },
            { label: 'Based in', value: 'Banja Luka' },
            { label: 'Known for', value: 'Thread earrings and soft palettes' },
        ],
    },
    {
        slug: 'selo-ink',
        name: 'Selo Ink',
        city: 'Tuzla',
        description:
            'Illustration prints, expressive color work, and original artwork for warm interiors.',
        specialty: 'Art prints',
        image: '/placeholders/card-tree.jpg',
        logo: '/brand/logo.png',
        coverImage: '/placeholders/card-tree.jpg',
        bio: 'Selo Ink brings together prints, originals, and small-run art objects with a strong sense of color and atmosphere. The work is intended to make interiors feel more personal and lived-in.',
        responseTime: 'Usually replies within 2 days',
        since: 'Creating since 2018',
        productCount: '11 listed pieces',
        highlightBadges: ['Originals available', 'Signed prints', 'Studio pickup possible'],
        highlights: [
            { label: 'Featured category', value: 'Art' },
            { label: 'Based in', value: 'Tuzla' },
            { label: 'Known for', value: 'Botanical and expressive prints' },
        ],
    },
];

export const featuredProducts: FeaturedProduct[] = [
    {
        slug: 'moonlit-keepsake-box',
        title: 'Moonlit Keepsake Box',
        shop: 'Atelier Luma',
        shopSlug: 'atelier-luma',
        category: 'Woodwork',
        priceLabel: '78 EUR',
        image: '/placeholders/hero-handmade.jpg',
        accent: 'bg-[#5603AD]',
        shortDescription: 'A warm wooden keepsake box for letters, jewelry, and small treasured objects.',
        description:
            'This handmade keepsake box is built for gifting and personal storage, with a soft finish, practical interior, and a crafted look that feels timeless rather than trendy.',
        materials: ['Solid wood', 'Natural wax finish', 'Soft inner lining'],
        leadTime: 'Made to order in 4-6 days',
        location: 'Sarajevo',
        gallery: [
            '/placeholders/hero-handmade.jpg',
            '/placeholders/card-paper.jpg',
            '/placeholders/about-studio.avif',
        ],
        relatedSlugs: ['handbuilt-lavender-cup', 'botanical-wall-print'],
    },
    {
        slug: 'handbuilt-lavender-cup',
        title: 'Handbuilt Lavender Cup',
        shop: 'Clay & Quiet',
        shopSlug: 'clay-and-quiet',
        category: 'Ceramics',
        priceLabel: 'Contact for price',
        image: '/placeholders/card-paper.jpg',
        accent: 'bg-[#8367C7]',
        shortDescription: 'A softly shaped ceramic cup designed for tea, coffee, and slow mornings.',
        description:
            'Handbuilt in a small batch, this cup emphasizes tactile variation and quiet ritual. Each piece has small differences that make it feel unmistakably handmade.',
        materials: ['Stoneware clay', 'Food-safe glaze', 'Kiln-fired finish'],
        leadTime: 'Ready to ship in 2-3 days',
        location: 'Mostar',
        gallery: [
            '/placeholders/card-paper.jpg',
            '/placeholders/about-studio.avif',
            '/placeholders/card-pompoms.jpg',
        ],
        relatedSlugs: ['moonlit-keepsake-box', 'star-thread-earrings'],
    },
    {
        slug: 'star-thread-earrings',
        title: 'Star Thread Earrings',
        shop: 'Mila Studio',
        shopSlug: 'mila-studio',
        category: 'Jewelry',
        priceLabel: '34 EUR',
        image: '/placeholders/card-pompoms.jpg',
        accent: 'bg-[#C2F8CB]',
        shortDescription: 'Lightweight earrings with playful detail and an easy everyday silhouette.',
        description:
            'These earrings are designed to feel expressive without being heavy. They work equally well as a gift, an event accent, or an everyday jewelry piece.',
        materials: ['Brass findings', 'Thread detail', 'Nickel-free hooks'],
        leadTime: 'Made to order in 3-5 days',
        location: 'Banja Luka',
        gallery: [
            '/placeholders/card-pompoms.jpg',
            '/placeholders/card-portrait.jpg',
            '/placeholders/card-paper.jpg',
        ],
        relatedSlugs: ['handbuilt-lavender-cup', 'botanical-wall-print'],
    },
    {
        slug: 'botanical-wall-print',
        title: 'Botanical Wall Print',
        shop: 'Selo Ink',
        shopSlug: 'selo-ink',
        category: 'Art',
        priceLabel: '46 EUR',
        image: '/placeholders/card-tree.jpg',
        accent: 'bg-[#B3E9C7]',
        shortDescription: 'A vivid print for interiors that need a stronger artistic focal point.',
        description:
            'Printed in a limited small run, this artwork brings saturated color and organic linework into a room without feeling generic or overly polished.',
        materials: ['Fine art paper', 'Archival inks', 'Signed small batch print'],
        leadTime: 'Ships in 1-2 days',
        location: 'Tuzla',
        gallery: [
            '/placeholders/card-tree.jpg',
            '/placeholders/card-portrait.jpg',
            '/placeholders/hero-handmade.jpg',
        ],
        relatedSlugs: ['moonlit-keepsake-box', 'star-thread-earrings'],
    },
];

export const getFeaturedProduct = (slug: string) =>
    featuredProducts.find((product) => product.slug === slug);

export const getFeaturedShop = (slug: string) =>
    featuredShops.find((shop) => shop.slug === slug);

export const getProductsForShop = (shopSlug: string) =>
    featuredProducts.filter((product) => product.shopSlug === shopSlug);
