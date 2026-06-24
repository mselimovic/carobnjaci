<script lang="ts">
    import { Form, router } from '@inertiajs/svelte';
    import { ChevronDown, ImagePlus } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { CreatorCategoryOption, CreatorProductRow, CreatorStatusOption } from '@/types/marketplace';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_products'), href: '/creator/products' },
    ];

    let {
        hasShop = false,
        categories = [],
        statuses = [],
        products = [],
    }: {
        hasShop: boolean;
        categories: CreatorCategoryOption[];
        statuses: CreatorStatusOption[];
        products: CreatorProductRow[];
    } = $props();

    let showCreateForm = $state(false);
    let editingProductId = $state<number | null>(null);

    function toggleCreateForm() {
        showCreateForm = !showCreateForm;
    }

    function startEdit(id: number) {
        editingProductId = id;
    }

    function stopEdit() {
        editingProductId = null;
    }

    function deleteProduct(id: number) {
        if (!confirm(t('creator.delete_product_confirm'))) {
            return;
        }

        router.delete(`/creator/products/${id}`);
    }

    const selectClass =
        'h-12 w-full appearance-none rounded-xl border border-input bg-card px-4 pr-10 text-sm text-foreground shadow-sm outline-none transition focus:border-ring';
    const fileInputClass =
        'block w-full text-sm text-foreground file:mr-4 file:rounded-full file:border-0 file:bg-primary file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-primary-foreground hover:file:opacity-95';
</script>

<AppHead title={t('creator.nav_products')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <div class="theme-pill-soft">
                        {t('creator.products_badge')}
                    </div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('creator.products_title')}</h1>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-muted-foreground">
                        {t('creator.products_text')}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground">{products.length}</div>
                    {#if hasShop}
                        <Button type="button" onclick={toggleCreateForm}>
                            {showCreateForm ? t('common.cancel') : t('creator.add_product')}
                        </Button>
                    {/if}
                </div>
            </div>
        </section>

        <section class="theme-panel rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-foreground">{t('creator.create_product_title')}</h2>
            <p class="mt-2 text-sm text-muted-foreground">{t('creator.create_product_text')}</p>

            {#if hasShop}
                {#if showCreateForm}
                <Form action="/creator/products" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
                    {#snippet children({ errors, processing, recentlySuccessful })}
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="grid gap-2">
                                <Label for="title">{t('creator.field_product_title')}</Label>
                                <Input id="title" name="title" required />
                                <InputError message={errors.title} />
                            </div>
                            <div class="grid gap-2">
                                <Label for="category_id">{t('creator.field_category')}</Label>
                                <div class="relative">
                                    <select id="category_id" name="category_id" class={selectClass}>
                                        <option value="">{t('creator.select_category')}</option>
                                        {#each categories as category}
                                            <option value={category.id}>{category.name}</option>
                                        {/each}
                                    </select>
                                    <ChevronDown class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-muted-foreground" />
                                </div>
                                <InputError message={errors.category_id} />
                            </div>
                            <div class="grid gap-2">
                                <Label for="price">{t('creator.field_price')}</Label>
                                <Input id="price" name="price" type="number" min="0" step="0.01" />
                                <InputError message={errors.price} />
                            </div>
                            <div class="grid gap-2">
                                <Label for="lead_time">{t('creator.field_lead_time')}</Label>
                                <Input id="lead_time" name="lead_time" />
                                <InputError message={errors.lead_time} />
                            </div>
                            <div class="grid gap-2">
                                <Label for="featured_image">{t('creator.field_featured_image')}</Label>
                                <div class="rounded-2xl border border-dashed border-border bg-secondary/40 p-4">
                                    <div class="mb-3 flex items-center gap-3 text-sm text-foreground">
                                        <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <ImagePlus class="size-5" />
                                        </div>
                                        <div>
                                            <div class="font-medium">{t('creator.upload_image_title')}</div>
                                            <div class="text-xs text-muted-foreground">{t('creator.upload_image_text')}</div>
                                        </div>
                                    </div>
                                    <input id="featured_image" name="featured_image" type="file" accept="image/*" class={fileInputClass} />
                                </div>
                                <InputError message={errors.featured_image} />
                            </div>
                            <div class="grid gap-2">
                                <Label for="status">{t('creator.field_status')}</Label>
                                <div class="relative">
                                    <select id="status" name="status" class={selectClass}>
                                        {#each statuses as status}
                                            <option value={status.value} selected={status.value === 'draft'}>{status.label}</option>
                                        {/each}
                                    </select>
                                    <ChevronDown class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-muted-foreground" />
                                </div>
                                <InputError message={errors.status} />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="description">{t('creator.field_description')}</Label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="min-h-32 rounded-xl border border-input bg-background px-4 py-3 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-ring"
                            ></textarea>
                            <InputError message={errors.description} />
                        </div>

                        <div class="grid gap-2">
                            <Label for="materials">{t('creator.field_materials')}</Label>
                            <Input id="materials" name="materials" placeholder={t('creator.field_materials_placeholder')} />
                            <InputError message={errors.materials} />
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-foreground">
                                <input type="hidden" name="contact_price" value="0" />
                                <input type="checkbox" name="contact_price" value="1" class="h-4 w-4 rounded border-border text-primary" />
                                {t('creator.field_contact_price')}
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-foreground">
                                <input type="hidden" name="is_featured" value="0" />
                                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-border text-primary" />
                                {t('creator.field_is_featured')}
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <Button type="submit" disabled={processing}>{t('creator.add_product')}</Button>
                            {#if recentlySuccessful}
                                <p class="text-sm text-muted-foreground">{t('common.saved')}</p>
                            {/if}
                        </div>
                    {/snippet}
                </Form>
                {:else}
                    <div class="mt-6 rounded-xl border border-dashed border-border p-4 text-sm text-muted-foreground">
                        {t('creator.products_add_hint')}
                    </div>
                {/if}
            {:else}
                <div class="mt-6 rounded-xl border border-border p-4 text-sm text-muted-foreground">
                    {t('creator.create_shop_first')}
                </div>
            {/if}
        </section>

        <section class="grid gap-6">
            {#each products as item}
                <article class="theme-panel rounded-2xl p-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-foreground">{item.title}</h2>
                            <p class="mt-1 text-sm text-muted-foreground">{item.price} - {item.status} - {item.updated}</p>
                        </div>
                        <div class="flex gap-3">
                            <Button type="button" variant="outline" onclick={() => startEdit(item.id)}>{t('creator.edit_product')}</Button>
                            <Button type="button" variant="outline" onclick={() => deleteProduct(item.id)}>{t('creator.delete_product')}</Button>
                        </div>
                    </div>

                    {#if item.featuredImage}
                        <img src={item.featuredImage} alt={item.title} class="mt-5 h-48 w-full rounded-2xl object-cover md:w-80" />
                    {/if}

                    {#if editingProductId === item.id}
                    <Form action={`/creator/products/${item.id}`} method="post" enctype="multipart/form-data" class="mt-6 space-y-6 border-t border-border pt-6">
                        {#snippet children({ errors, processing, recentlySuccessful })}
                            <input type="hidden" name="_method" value="PUT" />
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for={`title-${item.id}`}>{t('creator.field_product_title')}</Label>
                                    <Input id={`title-${item.id}`} name="title" value={item.title} required />
                                    <InputError message={errors.title} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for={`category-${item.id}`}>{t('creator.field_category')}</Label>
                                    <div class="relative">
                                        <select id={`category-${item.id}`} name="category_id" class={selectClass}>
                                            <option value="">{t('creator.select_category')}</option>
                                            {#each categories as category}
                                                <option value={category.id} selected={category.id === item.categoryId}>{category.name}</option>
                                            {/each}
                                        </select>
                                        <ChevronDown class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-muted-foreground" />
                                    </div>
                                    <InputError message={errors.category_id} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for={`price-${item.id}`}>{t('creator.field_price')}</Label>
                                    <Input id={`price-${item.id}`} name="price" type="number" min="0" step="0.01" value={item.priceValue} />
                                    <InputError message={errors.price} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for={`lead-${item.id}`}>{t('creator.field_lead_time')}</Label>
                                    <Input id={`lead-${item.id}`} name="lead_time" value={item.leadTime} />
                                    <InputError message={errors.lead_time} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for={`image-${item.id}`}>{t('creator.field_featured_image')}</Label>
                                    <div class="rounded-2xl border border-dashed border-border bg-secondary/40 p-4">
                                        <div class="mb-3 flex items-center gap-3 text-sm text-foreground">
                                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                                <ImagePlus class="size-5" />
                                            </div>
                                            <div>
                                                <div class="font-medium">{t('creator.upload_image_replace_title')}</div>
                                                <div class="text-xs text-muted-foreground">{t('creator.upload_image_replace_text')}</div>
                                            </div>
                                        </div>
                                        <input id={`image-${item.id}`} name="featured_image" type="file" accept="image/*" class={fileInputClass} />
                                    </div>
                                    <InputError message={errors.featured_image} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for={`status-${item.id}`}>{t('creator.field_status')}</Label>
                                    <div class="relative">
                                        <select id={`status-${item.id}`} name="status" class={selectClass}>
                                            {#each statuses as status}
                                                <option value={status.value} selected={status.value === item.statusValue}>{status.label}</option>
                                            {/each}
                                        </select>
                                        <ChevronDown class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-muted-foreground" />
                                    </div>
                                    <InputError message={errors.status} />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for={`description-${item.id}`}>{t('creator.field_description')}</Label>
                                <textarea
                                    id={`description-${item.id}`}
                                    name="description"
                                    rows="4"
                                    class="min-h-28 rounded-xl border border-input bg-background px-4 py-3 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-ring"
                                >{item.description}</textarea>
                                <InputError message={errors.description} />
                            </div>

                            <div class="grid gap-2">
                                <Label for={`materials-${item.id}`}>{t('creator.field_materials')}</Label>
                                <Input id={`materials-${item.id}`} name="materials" value={item.materials} />
                                <InputError message={errors.materials} />
                            </div>

                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center gap-2 text-sm text-foreground">
                                    <input type="hidden" name="contact_price" value="0" />
                                    <input type="checkbox" name="contact_price" value="1" checked={item.contactPrice} class="h-4 w-4 rounded border-border text-primary" />
                                    {t('creator.field_contact_price')}
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm text-foreground">
                                    <input type="hidden" name="is_featured" value="0" />
                                    <input type="checkbox" name="is_featured" value="1" checked={item.isFeatured} class="h-4 w-4 rounded border-border text-primary" />
                                    {t('creator.field_is_featured')}
                                </label>
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="submit" disabled={processing}>{t('creator.update_product')}</Button>
                                <Button type="button" variant="outline" onclick={stopEdit}>{t('common.cancel')}</Button>
                                {#if recentlySuccessful}
                                    <p class="text-sm text-muted-foreground">{t('common.saved')}</p>
                                {/if}
                            </div>
                        {/snippet}
                    </Form>
                    {/if}
                </article>
            {/each}
        </section>
    </div>
</AppLayout>
