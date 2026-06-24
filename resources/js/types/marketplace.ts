export type CategoryCard = {
    slug: string;
    name: string;
    icon: string;
    description: string;
    countLabel: string;
};

export type ProductCardData = {
    slug: string;
    title: string;
    shop: string;
    shopSlug: string;
    category: string;
    priceLabel: string;
    image: string;
    accent: string;
    interestLabel?: string;
};

export type ShopCardData = {
    slug: string;
    name: string;
    city: string;
    description: string;
    specialty: string;
    image: string;
    logo: string;
    publishedCount?: number;
};

export type ShopSummary = {
    slug: string;
    name: string;
    city: string;
    description: string;
    logo: string;
};

export type ProductDetail = {
    slug: string;
    title: string;
    category: string;
    priceLabel: string;
    shortDescription: string;
    description: string;
    leadTime: string;
    location: string;
    materials: string[];
    gallery: string[];
};

export type ShopDetail = {
    slug: string;
    name: string;
    city: string;
    description: string;
    specialty: string;
    bio: string;
    logo: string;
    coverImage: string;
    responseTime: string;
    productCount: string;
    highlights: Array<{ label: string; value: string }>;
    highlightBadges: string[];
    since: string;
};

export type CreatorPriority = {
    title: string;
    text: string;
};

export type CreatorCatalogRow = {
    title: string;
    status: string;
    price: string;
    interest: string;
};

export type CreatorProductRow = {
    id: number;
    title: string;
    categoryId: number | null;
    description: string;
    featuredImage: string | null;
    materials: string;
    leadTime: string;
    priceValue: string;
    contactPrice: boolean;
    isFeatured: boolean;
    statusValue: 'draft' | 'pending' | 'published' | 'rejected';
    status: string;
    price: string;
    updated: string;
};

export type CreatorShopProfile = {
    id: number;
    name: string;
    slug: string;
    city: string | null;
    status: string;
    statusLabel: string;
    description: string | null;
    bio: string | null;
    specialty: string | null;
    responseTime: string;
    instagram: string | null;
    facebook: string | null;
    tiktok: string | null;
    website: string | null;
    phone: string | null;
    productCount: number;
    visible: boolean;
    coverImage: string | null;
    logo: string | null;
};

export type CreatorMessageRow = {
    subject: string;
    buyer: string;
    state: string;
    excerpt: string;
    createdAt?: string | null;
};

export type CreatorCategoryOption = {
    id: number;
    name: string;
};

export type CreatorStatusOption = {
    value: 'draft' | 'pending' | 'published';
    label: string;
};
