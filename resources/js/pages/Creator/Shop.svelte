<script lang="ts">
    import { Form, router } from '@inertiajs/svelte';
    import { ImagePlus } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { CreatorShopProfile } from '@/types/marketplace';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_shop'), href: '/creator/shop' },
    ];

    let {
        shop = null,
        profileCompletion = 0,
        nextTasks = [],
    }: {
        shop: CreatorShopProfile | null;
        profileCompletion: number;
        nextTasks: Array<{ title: string; text: string }>;
    } = $props();

    let isEditing = $state(false);

    function deleteShop() {
        if (!confirm(t('creator.delete_shop_confirm'))) {
            return;
        }

        router.delete('/creator/shop');
    }
    function startEdit() {
        isEditing = true;
    }
    function cancelEdit() {
        isEditing = false;
    }

    const fileInputClass =
        'block w-full text-sm text-foreground file:mr-4 file:rounded-full file:border-0 file:bg-primary file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-primary-foreground hover:file:opacity-95';
</script>

<AppHead title={t('creator.nav_shop')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                <div class="max-w-3xl">
                    <div class="theme-pill-soft">{t('creator.shop_badge')}</div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('creator.shop_title')}</h1>
                    <p class="mt-4 text-sm leading-7 text-muted-foreground">{t('creator.shop_form_text')}</p>
                </div>
                <div class="grid w-full gap-4 sm:grid-cols-3 xl:max-w-xl">
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.profile_strength')}</div>
                        <div class="mt-2 text-2xl font-bold text-foreground">{profileCompletion}%</div>
                    </div>
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.public_status')}</div>
                        <div class="mt-2 text-2xl font-bold text-foreground">{shop?.visible ? t('creator.visible') : shop?.statusLabel ?? t('creator.status_pending')}</div>
                    </div>
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.products_count_label')}</div>
                        <div class="mt-2 text-2xl font-bold text-foreground">{shop?.productCount ?? 0}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.08fr_0.92fr]">
            <div class="theme-panel rounded-2xl p-6">
                {#if shop && !isEditing}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div>
                                <h2 class="text-2xl font-semibold text-foreground">{shop.name}</h2>
                                <p class="mt-2 text-sm leading-7 text-muted-foreground">{shop.description ?? shop.bio ?? t('creator.shop_empty_state')}</p>
                            </div>
                            <div class="flex gap-3">
                                <Button type="button" variant="outline" onclick={startEdit}>{t('creator.edit_shop')}</Button>
                                <Button type="button" variant="outline" onclick={deleteShop}>{t('creator.delete_shop')}</Button>
                            </div>
                        </div>

                        {#if shop.coverImage}
                            <img src={shop.coverImage} alt={shop.name} class="h-56 w-full rounded-2xl object-cover" />
                        {/if}

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-xl border border-border p-4">
                                <div class="text-sm font-semibold text-foreground">{t('creator.field_specialty')}</div>
                                <div class="mt-2 text-sm text-muted-foreground">{shop.specialty ?? t('creator.not_provided')}</div>
                            </div>
                            <div class="rounded-xl border border-border p-4">
                                <div class="text-sm font-semibold text-foreground">{t('creator.field_city')}</div>
                                <div class="mt-2 text-sm text-muted-foreground">{shop.city ?? t('creator.not_provided')}</div>
                            </div>
                            <div class="rounded-xl border border-border p-4 md:col-span-2">
                                <div class="text-sm font-semibold text-foreground">{t('creator.field_bio')}</div>
                                <div class="mt-2 text-sm leading-7 text-muted-foreground">{shop.bio ?? t('creator.not_provided')}</div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-xl border border-border p-4">
                                <div class="text-sm font-semibold text-foreground">{t('creator.social_links')}</div>
                                <div class="mt-2 space-y-2 text-sm text-muted-foreground">
                                    <div>Instagram: {shop.instagram ?? t('creator.not_provided')}</div>
                                    <div>Facebook: {shop.facebook ?? t('creator.not_provided')}</div>
                                    <div>TikTok: {shop.tiktok ?? t('creator.not_provided')}</div>
                                    <div>Website: {shop.website ?? t('creator.not_provided')}</div>
                                </div>
                            </div>
                            <div class="rounded-xl border border-border p-4">
                                <div class="text-sm font-semibold text-foreground">{t('creator.images_title')}</div>
                                <div class="mt-3 flex gap-4">
                                    {#if shop.logo}
                                        <img src={shop.logo} alt={shop.name} class="size-20 rounded-2xl object-cover" />
                                    {/if}
                                    {#if shop.coverImage}
                                        <img src={shop.coverImage} alt={shop.name} class="h-20 w-36 rounded-2xl object-cover" />
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                {:else}
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-lg font-semibold text-foreground">{shop ? t('creator.edit_shop_title') : t('creator.shop_form_title')}</h2>
                        {#if shop}
                            <Button type="button" variant="outline" onclick={cancelEdit}>{t('common.cancel')}</Button>
                        {/if}
                    </div>

                    <Form action="/creator/shop" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
                        {#snippet children({ errors, processing, recentlySuccessful })}
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="name">{t('creator.field_shop_name')}</Label>
                                    <Input id="name" name="name" value={shop?.name ?? ''} required />
                                    <InputError message={errors.name} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="specialty">{t('creator.field_specialty')}</Label>
                                    <Input id="specialty" name="specialty" value={shop?.specialty ?? ''} />
                                    <InputError message={errors.specialty} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="city">{t('creator.field_city')}</Label>
                                    <Input id="city" name="city" value={shop?.city ?? ''} />
                                    <InputError message={errors.city} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="phone">{t('creator.field_phone')}</Label>
                                    <Input id="phone" name="phone" value={shop?.phone ?? ''} />
                                    <InputError message={errors.phone} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="instagram">{t('creator.field_instagram')}</Label>
                                    <Input id="instagram" name="instagram" value={shop?.instagram ?? ''} />
                                    <InputError message={errors.instagram} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="facebook">{t('creator.field_facebook')}</Label>
                                    <Input id="facebook" name="facebook" value={shop?.facebook ?? ''} />
                                    <InputError message={errors.facebook} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="tiktok">{t('creator.field_tiktok')}</Label>
                                    <Input id="tiktok" name="tiktok" value={shop?.tiktok ?? ''} />
                                    <InputError message={errors.tiktok} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="website">{t('creator.field_website')}</Label>
                                    <Input id="website" name="website" type="url" value={shop?.website ?? ''} />
                                    <InputError message={errors.website} />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="description">{t('creator.field_short_description')}</Label>
                                <textarea id="description" name="description" rows="3" class="min-h-28 rounded-xl border border-input bg-background px-4 py-3 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-ring">{shop?.description ?? ''}</textarea>
                                <InputError message={errors.description} />
                            </div>

                            <div class="grid gap-2">
                                <Label for="bio">{t('creator.field_bio')}</Label>
                                <textarea id="bio" name="bio" rows="6" class="min-h-40 rounded-xl border border-input bg-background px-4 py-3 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-ring">{shop?.bio ?? ''}</textarea>
                                <InputError message={errors.bio} />
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="logo">{t('creator.field_logo_upload')}</Label>
                                    {#if shop?.logo}
                                        <img src={shop.logo} alt={shop.name} class="size-20 rounded-2xl object-cover" />
                                    {/if}
                                    <div class="rounded-2xl border border-dashed border-border bg-secondary/40 p-4">
                                        <div class="mb-3 flex items-center gap-3 text-sm text-foreground">
                                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                                <ImagePlus class="size-5" />
                                            </div>
                                            <div>
                                                <div class="font-medium">{t('creator.upload_logo_title')}</div>
                                                <div class="text-xs text-muted-foreground">{t('creator.upload_logo_text')}</div>
                                            </div>
                                        </div>
                                        <input id="logo" name="logo" type="file" accept="image/*" class={fileInputClass} />
                                    </div>
                                    <InputError message={errors.logo} />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="cover_image">{t('creator.field_cover_upload')}</Label>
                                    {#if shop?.coverImage}
                                        <img src={shop.coverImage} alt={shop.name} class="h-24 w-full rounded-2xl object-cover" />
                                    {/if}
                                    <div class="rounded-2xl border border-dashed border-border bg-secondary/40 p-4">
                                        <div class="mb-3 flex items-center gap-3 text-sm text-foreground">
                                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                                <ImagePlus class="size-5" />
                                            </div>
                                            <div>
                                                <div class="font-medium">{t('creator.upload_cover_title')}</div>
                                                <div class="text-xs text-muted-foreground">{t('creator.upload_cover_text')}</div>
                                            </div>
                                        </div>
                                        <input id="cover_image" name="cover_image" type="file" accept="image/*" class={fileInputClass} />
                                    </div>
                                    <InputError message={errors.cover_image} />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="submit" disabled={processing}>{shop ? t('creator.save_shop_changes') : t('creator.save_shop')}</Button>
                                {#if recentlySuccessful}
                                    <p class="text-sm text-muted-foreground">{t('common.saved')}</p>
                                {/if}
                            </div>
                        {/snippet}
                    </Form>
                {/if}
            </div>

            <div class="space-y-6">
                <section class="theme-panel rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-foreground">{t('creator.shop_tasks_title')}</h2>
                    <div class="mt-5 space-y-4">
                        {#each nextTasks as task}
                            <div class="rounded-xl border border-border p-4">
                                <div class="text-sm font-semibold text-foreground">{task.title}</div>
                                <div class="mt-1 text-sm text-muted-foreground">{task.text}</div>
                            </div>
                        {/each}
                    </div>
                </section>

                <section class="theme-panel rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-foreground">{t('creator.shop_guidelines_title')}</h2>
                    <div class="mt-5 space-y-4">
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{t('creator.shop_guideline_1_title')}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{t('creator.shop_guideline_1_text')}</div>
                        </div>
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{t('creator.shop_guideline_2_title')}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{t('creator.shop_guideline_2_text')}</div>
                        </div>
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{t('creator.shop_guideline_3_title')}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{t('creator.shop_guideline_3_text')}</div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
</AppLayout>
