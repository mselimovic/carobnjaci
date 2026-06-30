<script lang="ts">
    import { Link, page, router } from '@inertiajs/svelte';
    import MessageCircleMore from 'lucide-svelte/icons/message-circle-more';
    import LogOut from 'lucide-svelte/icons/log-out';
    import Settings from 'lucide-svelte/icons/settings';
    import {
        DropdownMenuGroup,
        DropdownMenuItem,
        DropdownMenuLabel,
        DropdownMenuSeparator,
    } from '@/components/ui/dropdown-menu';
    import { t } from '@/lib/i18n';
    import UserInfo from '@/components/UserInfo.svelte';
    import { toUrl } from '@/lib/utils';
    import { logout } from '@/routes';
    import { edit } from '@/routes/profile';
    import type { User } from '@/types';

    let {
        user,
    }: {
        user: User;
    } = $props();

    const notifications = $derived($page.props.notifications as { unreadMessages?: number } | undefined);

    function handleLogout(propsOnClick?: (event: MouseEvent) => void) {
        return (event: MouseEvent) => {
            propsOnClick?.(event);
            router.flushAll();
        };
    }
</script>

<DropdownMenuLabel class="p-0 font-normal">
    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
        <UserInfo {user} showEmail={true} />
    </div>
</DropdownMenuLabel>
<DropdownMenuSeparator />
<DropdownMenuGroup>
    <DropdownMenuItem asChild>
        {#snippet children(props)}
            <Link
                class={props.class}
                href={user.is_admin ? '/creator/messages' : '/messages/inbox'}
                onclick={props.onClick}
            >
                <MessageCircleMore class="mr-2 h-4 w-4" />
                {t('creator.nav_messages')}
                {#if notifications?.unreadMessages}
                    <span class="ml-auto inline-flex min-w-5 items-center justify-center rounded-full bg-primary px-1.5 py-0.5 text-[11px] font-semibold text-primary-foreground">
                        {notifications.unreadMessages}
                    </span>
                {/if}
            </Link>
        {/snippet}
    </DropdownMenuItem>
    <DropdownMenuItem asChild>
        {#snippet children(props)}
            <Link
                class={props.class}
                href={toUrl(edit())}
                prefetch
                onclick={props.onClick}
            >
                <Settings class="mr-2 h-4 w-4" />
                {t('user_menu.settings')}
            </Link>
        {/snippet}
    </DropdownMenuItem>
</DropdownMenuGroup>
<DropdownMenuSeparator />
<DropdownMenuItem asChild>
    {#snippet children(props)}
        <Link
            class={props.class}
            href={logout()}
            as="button"
            onclick={handleLogout(props.onClick)}
            data-test="logout-button"
        >
            <LogOut class="mr-2 h-4 w-4" />
            {t('common.log_out')}
        </Link>
    {/snippet}
</DropdownMenuItem>
