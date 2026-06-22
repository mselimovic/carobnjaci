<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { t } from '@/lib/i18n';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { logout } from '@/routes';
    import { send } from '@/routes/verification';

    let {
        status = '',
    }: {
        status?: string;
    } = $props();
</script>

<AppHead title={t('auth.verify_page')} />

<AuthLayout
    title={t('auth.verify_title')}
    description={t('auth.verify_text')}
>
    {#if status === 'verification-link-sent'}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            {t('auth.verification_sent')}
        </div>
    {/if}

    <Form {...send.form()} class="space-y-6 text-center">
        {#snippet children({ processing })}
            <Button type="submit" disabled={processing} variant="secondary">
                {#if processing}<Spinner />{/if}
                {t('auth.resend_verification')}
            </Button>

            <TextLink href={logout()} as="button" class="mx-auto block text-sm">
                {t('common.log_out')}
            </TextLink>
        {/snippet}
    </Form>
</AuthLayout>
