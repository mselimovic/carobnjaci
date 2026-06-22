<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import PasswordInput from '@/components/PasswordInput.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Checkbox } from '@/components/ui/checkbox';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import { Spinner } from '@/components/ui/spinner';
    import AuthBase from '@/layouts/AuthLayout.svelte';
    import { register } from '@/routes';
    import { store } from '@/routes/login';
    import { request } from '@/routes/password';

    let {
        status = '',
        canResetPassword,
        canRegister,
    }: {
        status?: string;
        canResetPassword: boolean;
        canRegister: boolean;
    } = $props();
</script>

<AppHead title={t('auth.login_page')} />

<AuthBase
    title={t('auth.login_title')}
    description={t('auth.login_text')}
>
    {#if status}
        <div class="mb-4 text-center text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <Form
        {...store.form()}
        resetOnSuccess={['password']}
        class="flex flex-col gap-6"
    >
        {#snippet children({ errors, processing })}
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">{t('auth.email_address')}</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError message={errors.email} />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">{t('auth.password')}</Label>
                        {#if canResetPassword}
                            <TextLink href={request()} class="text-sm">
                                {t('auth.forgot_password_link')}
                            </TextLink>
                        {/if}
                    </div>
                    <PasswordInput
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder={t('auth.password')}
                    />
                    <InputError message={errors.password} />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" />
                        <span>{t('auth.remember_me')}</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    disabled={processing}
                    data-test="login-button"
                >
                    {#if processing}<Spinner />{/if}
                    {t('common.log_in')}
                </Button>
            </div>

            {#if canRegister}
                <div class="text-center text-sm text-muted-foreground">
                    {t('auth.dont_have_account')}
                    <TextLink href={register()}>{t('auth.sign_up')}</TextLink>
                </div>
            {/if}
        {/snippet}
    </Form>
</AuthBase>
