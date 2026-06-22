<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { dashboard } from '@/routes';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: t('common.dashboard'),
            href: dashboard(),
        },
    ];
</script>

<AppHead title={t('common.dashboard')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                    {t('creator.dashboard_badge')}
                </div>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#24183d] md:text-4xl">
                    {t('creator.dashboard_title')}
                </h1>
                <p class="mt-4 max-w-3xl text-sm leading-7 text-[#5d5470]">
                    {t('creator.dashboard_text')}
                </p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.active_products')}</div>
                        <div class="mt-2 text-3xl font-bold text-[#24183d]">14</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.active_products_note')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.unread_messages')}</div>
                        <div class="mt-2 text-3xl font-bold text-[#24183d]">8</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.unread_messages_note')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.profile_completion')}</div>
                        <div class="mt-2 text-3xl font-bold text-[#24183d]">82%</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.profile_completion_note')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.response_time')}</div>
                        <div class="mt-2 text-3xl font-bold text-[#24183d]">&lt; 1 day</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.response_time_note')}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">{t('creator.priorities')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Finish your shop story</div>
                        <div class="mt-1 text-sm text-[#5d5470]">Add a longer bio, process details, and shipping or pickup notes.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Review new buyer messages</div>
                        <div class="mt-1 text-sm text-[#5d5470]">The MVP depends on direct contact, so quick replies matter.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Refresh featured product images</div>
                        <div class="mt-1 text-sm text-[#5d5470]">Cleaner visuals will lift your product and shop pages immediately.</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">Recent conversations</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-[#24183d]">Custom engraving request</div>
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">New</div>
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">A buyer wants initials added to the Moonlit Keepsake Box.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-[#24183d]">Pickup availability</div>
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">Replied</div>
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">A local buyer asked whether studio pickup is possible this weekend.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-[#24183d]">Gift packaging question</div>
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">Waiting</div>
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">A customer asked about sending a handwritten note with their order.</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">Catalog snapshot</h2>
                <div class="mt-5 overflow-hidden rounded-xl border border-[#d5e8d8]">
                    <table class="min-w-full divide-y divide-[#eef5ef] text-sm">
                        <thead class="bg-[#f0fff1] text-left text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">
                            <tr>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Interest</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eef5ef] text-[#24183d]">
                            <tr>
                                <td class="px-4 py-3 font-medium">Moonlit Keepsake Box</td>
                                <td class="px-4 py-3 text-[#5d5470]">Featured</td>
                                <td class="px-4 py-3 text-[#5d5470]">78 EUR</td>
                                <td class="px-4 py-3 text-[#5d5470]">12 saves</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium">Handbuilt Lavender Cup</td>
                                <td class="px-4 py-3 text-[#5d5470]">Active</td>
                                <td class="px-4 py-3 text-[#5d5470]">Contact for price</td>
                                <td class="px-4 py-3 text-[#5d5470]">7 inquiries</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium">Star Thread Earrings</td>
                                <td class="px-4 py-3 text-[#5d5470]">Draft refresh</td>
                                <td class="px-4 py-3 text-[#5d5470]">34 EUR</td>
                                <td class="px-4 py-3 text-[#5d5470]">5 saves</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
