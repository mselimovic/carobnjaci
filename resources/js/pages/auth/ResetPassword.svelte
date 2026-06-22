<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import PasswordInput from '@/components/PasswordInput.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import { Spinner } from '@/components/ui/spinner';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { update } from '@/routes/password';

    let {
        token,
        email,
    }: {
        token: string;
        email: string;
    } = $props();
</script>

<AppHead title={t('auth.reset_page')} />

<AuthLayout
    title={t('auth.reset_title')}
    description={t('auth.reset_text')}
>
    <Form
        {...update.form()}
        transform={(data) => ({ ...data, token, email })}
        resetOnSuccess={['password', 'password_confirmation']}
    >
        {#snippet children({ errors, processing })}
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">{t('auth.email')}</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="email"
                        value={email}
                        class="mt-1 block w-full"
                        readonly
                    />
                    <InputError message={errors.email} class="mt-2" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">{t('auth.password')}</Label>
                    <PasswordInput
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder={t('auth.password')}
                    />
                    <InputError message={errors.password} />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">{t('auth.confirm_password')}</Label>
                    <PasswordInput
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder={t('auth.confirm_password')}
                    />
                    <InputError message={errors.password_confirmation} />
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    disabled={processing}
                    data-test="reset-password-button"
                >
                    {#if processing}<Spinner />{/if}
                    {t('auth.reset_page')}
                </Button>
            </div>
        {/snippet}
    </Form>
</AuthLayout>
