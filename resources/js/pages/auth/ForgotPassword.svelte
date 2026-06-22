<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { login } from '@/routes';
    import { email } from '@/routes/password';

    let {
        status = '',
    }: {
        status?: string;
    } = $props();
</script>

<AppHead title={t('auth.forgot_page')} />

<AuthLayout
    title={t('auth.forgot_title')}
    description={t('auth.forgot_text')}
>
    {#if status}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <div class="space-y-6">
        <Form {...email.form()}>
            {#snippet children({ errors, processing })}
                <div class="grid gap-2">
                    <Label for="email">{t('auth.email_address')}</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        placeholder="email@example.com"
                    />
                    <InputError message={errors.email} />
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                        type="submit"
                        class="w-full"
                        disabled={processing}
                        data-test="email-password-reset-link-button"
                    >
                        {#if processing}<Spinner />{/if}
                        {t('auth.email_reset_link')}
                    </Button>
                </div>
            {/snippet}
        </Form>

        <div class="space-x-1 text-center text-sm text-muted-foreground">
            <span>{t('auth.return_to')}</span>
            <TextLink href={login()}>{t('common.log_in')}</TextLink>
        </div>
    </div>
</AuthLayout>
