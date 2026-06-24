<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('admin.nav_moderation'), href: '/admin' },
    ];

    let {
        shops = [],
        products = [],
    }: {
        shops: Array<{
            id: number;
            name: string;
            owner: string;
            ownerEmail: string;
            city: string | null;
            status: string;
            statusLabel: string;
            productsCount: number;
            createdAt: string | null;
        }>;
        products: Array<{
            id: number;
            title: string;
            shop: string;
            owner: string;
            category: string;
            status: string;
            statusLabel: string;
            createdAt: string | null;
        }>;
    } = $props();

    const selectClass =
        'h-12 w-full appearance-none rounded-xl border border-input bg-card px-4 text-sm text-foreground shadow-sm outline-none transition focus:border-ring';
</script>

<AppHead title={t('admin.page_title')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="theme-pill-soft">{t('admin.badge')}</div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('admin.page_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-muted-foreground">{t('admin.page_text')}</p>
        </section>

        <section class="theme-panel rounded-2xl p-6">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-foreground">{t('admin.shops_title')}</h2>
                <div class="text-sm text-muted-foreground">{shops.length} {t('admin.items_label')}</div>
            </div>

            <div class="mt-5 space-y-4">
                {#each shops as shop}
                    <article class="rounded-2xl border border-border p-5">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
                            <div class="space-y-2">
                                <div class="text-lg font-semibold text-foreground">{shop.name}</div>
                                <div class="text-sm text-muted-foreground">{shop.owner} • {shop.ownerEmail}</div>
                                <div class="text-sm text-muted-foreground">{shop.city ?? t('admin.no_city')} • {shop.productsCount} {t('admin.products_label')} • {shop.createdAt}</div>
                                <div class="theme-pill-soft inline-flex">{shop.statusLabel}</div>
                            </div>

                            <Form action={`/admin/shops/${shop.id}`} method="post" class="grid gap-3 sm:grid-cols-[220px_auto] sm:items-end">
                                {#snippet children({ processing })}
                                    <div class="grid gap-2">
                                        <Label for={`shop-status-${shop.id}`}>{t('admin.change_status')}</Label>
                                        <select id={`shop-status-${shop.id}`} name="status" class={selectClass}>
                                            <option value="pending" selected={shop.status === 'pending'}>{t('admin.status_pending')}</option>
                                            <option value="approved" selected={shop.status === 'approved'}>{t('admin.status_approved')}</option>
                                            <option value="suspended" selected={shop.status === 'suspended'}>{t('admin.status_suspended')}</option>
                                        </select>
                                    </div>
                                    <Button type="submit" disabled={processing}>{t('admin.save_action')}</Button>
                                {/snippet}
                            </Form>
                        </div>
                    </article>
                {/each}
            </div>
        </section>

        <section class="theme-panel rounded-2xl p-6">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-foreground">{t('admin.products_title')}</h2>
                <div class="text-sm text-muted-foreground">{products.length} {t('admin.items_label')}</div>
            </div>

            <div class="mt-5 space-y-4">
                {#each products as product}
                    <article class="rounded-2xl border border-border p-5">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
                            <div class="space-y-2">
                                <div class="text-lg font-semibold text-foreground">{product.title}</div>
                                <div class="text-sm text-muted-foreground">{product.shop} • {product.owner}</div>
                                <div class="text-sm text-muted-foreground">{product.category || t('admin.no_category')} • {product.createdAt}</div>
                                <div class="theme-pill-soft inline-flex">{product.statusLabel}</div>
                            </div>

                            <Form action={`/admin/products/${product.id}`} method="post" class="grid gap-3 sm:grid-cols-[220px_auto] sm:items-end">
                                {#snippet children({ processing })}
                                    <div class="grid gap-2">
                                        <Label for={`product-status-${product.id}`}>{t('admin.change_status')}</Label>
                                        <select id={`product-status-${product.id}`} name="status" class={selectClass}>
                                            <option value="draft" selected={product.status === 'draft'}>{t('admin.status_draft')}</option>
                                            <option value="pending" selected={product.status === 'pending'}>{t('admin.status_pending')}</option>
                                            <option value="published" selected={product.status === 'published'}>{t('admin.status_published')}</option>
                                            <option value="rejected" selected={product.status === 'rejected'}>{t('admin.status_rejected')}</option>
                                        </select>
                                    </div>
                                    <Button type="submit" disabled={processing}>{t('admin.save_action')}</Button>
                                {/snippet}
                            </Form>
                        </div>
                    </article>
                {/each}
            </div>
        </section>
    </div>
</AppLayout>
