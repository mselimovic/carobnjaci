<script lang="ts">
    import { Form, page } from '@inertiajs/svelte';
    import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
    import AppHead from '@/components/AppHead.svelte';
    import DeleteUser from '@/components/DeleteUser.svelte';
    import Heading from '@/components/Heading.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import { edit } from '@/routes/profile';
    import { send } from '@/routes/verification';
    import type { BreadcrumbItem } from '@/types';

    let {
        mustVerifyEmail,
        status = '',
    }: {
        mustVerifyEmail: boolean;
        status?: string;
    } = $props();

    const breadcrumbItems: BreadcrumbItem[] = [
        {
            title: t('settings.profile_page'),
            href: edit(),
        },
    ];

    const user = $derived($page.props.auth.user);
</script>

<AppHead title={t('settings.profile_page')} />

<AppLayout breadcrumbs={breadcrumbItems}>
    <h1 class="sr-only">{t('settings.profile_page')}</h1>

    <SettingsLayout>
        <div class="flex flex-col space-y-6">
            <Heading
                variant="small"
                title={t('settings.profile_info')}
                description={t('settings.profile_info_text')}
            />

            <Form
                {...ProfileController.update.form()}
                class="space-y-6"
                options={{ preserveScroll: true }}
            >
                {#snippet children({ errors, processing, recentlySuccessful })}
                    <div class="grid gap-2">
                        <Label for="name">{t('auth.name')}</Label>
                        <Input
                            id="name"
                            name="name"
                            class="mt-1 block w-full"
                            value={user.name}
                            required
                            autocomplete="name"
                            placeholder={t('auth.full_name')}
                        />
                        <InputError class="mt-2" message={errors.name} />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">{t('auth.email_address')}</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            class="mt-1 block w-full"
                            value={user.email}
                            required
                            autocomplete="username"
                            placeholder={t('auth.email_address')}
                        />
                        <InputError class="mt-2" message={errors.email} />
                    </div>

                    {#if mustVerifyEmail && !user.email_verified_at}
                        <div>
                            <p class="-mt-4 text-sm text-muted-foreground">
                                {t('settings.unverified_email')}
                                <TextLink href={send()} as="button">
                                    {t('settings.resend_verification')}
                                </TextLink>
                            </p>

                            {#if status === 'verification-link-sent'}
                                <div
                                    class="mt-2 text-sm font-medium text-green-600"
                                >
                                    {t('settings.verification_sent')}
                                </div>
                            {/if}
                        </div>
                    {/if}

                    <div class="flex items-center gap-4">
                        <Button
                            type="submit"
                            disabled={processing}
                            data-test="update-profile-button">{t('common.save')}</Button
                        >

                        {#if recentlySuccessful}
                            <p class="text-sm text-neutral-600">{t('common.saved')}</p>
                        {/if}
                    </div>
                {/snippet}
            </Form>
        </div>

        <DeleteUser />
    </SettingsLayout>
</AppLayout>
