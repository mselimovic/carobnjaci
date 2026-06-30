<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import Cog from 'lucide-svelte/icons/cog';
    import LayoutGrid from 'lucide-svelte/icons/layout-grid';
    import ShieldCheck from 'lucide-svelte/icons/shield-check';
    import MessageCircle from 'lucide-svelte/icons/message-circle';
    import Package2 from 'lucide-svelte/icons/package-2';
    import Store from 'lucide-svelte/icons/store';
    import Sparkles from 'lucide-svelte/icons/sparkles';
    import type { Snippet } from 'svelte';
    import { page } from '@inertiajs/svelte';
    import AppLogo from '@/components/AppLogo.svelte';
    import { t } from '@/lib/i18n';
    import NavFooter from '@/components/NavFooter.svelte';
    import NavMain from '@/components/NavMain.svelte';
    import NavUser from '@/components/NavUser.svelte';
    import {
        Sidebar,
        SidebarContent,
        SidebarFooter,
        SidebarHeader,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/components/ui/sidebar';
    import { toUrl } from '@/lib/utils';
    import { dashboard } from '@/routes';
    import type { NavItem } from '@/types';

    let {
        children,
    }: {
        children?: Snippet;
    } = $props();

    const user = $derived($page.props.auth.user as { is_admin?: boolean } | undefined);
    const notifications = $derived($page.props.notifications as { unreadMessages?: number } | undefined);

    const mainNavItems = $derived.by<NavItem[]>(() => {
        if (user?.is_admin) {
            return [
                {
                    title: t('common.dashboard'),
                    href: dashboard(),
                    icon: LayoutGrid,
                },
                {
                    title: t('creator.nav_messages'),
                    href: '/creator/messages',
                    icon: MessageCircle,
                    badge: notifications?.unreadMessages ?? 0,
                },
                {
                    title: t('creator.nav_settings'),
                    href: '/creator/settings',
                    icon: Cog,
                },
                {
                    title: t('admin.nav_moderation'),
                    href: '/admin',
                    icon: ShieldCheck,
                },
            ];
        }

        return [
            {
                title: t('common.dashboard'),
                href: dashboard(),
                icon: LayoutGrid,
            },
            {
                title: t('creator.nav_shop'),
                href: '/creator/shop',
                icon: Store,
            },
            {
                title: t('creator.nav_products'),
                href: '/creator/products',
                icon: Package2,
            },
            {
                title: t('creator.nav_messages'),
                href: '/creator/messages',
                icon: MessageCircle,
                badge: notifications?.unreadMessages ?? 0,
            },
            {
                title: t('creator.nav_settings'),
                href: '/creator/settings',
                icon: Cog,
            },
        ];
    });

    const footerNavItems: NavItem[] = [
        {
            title: t('creator.nav_storefront'),
            href: '/',
            icon: Sparkles,
        },
        {
            title: t('creator.nav_security'),
            href: '/settings/security',
            icon: Cog,
        },
    ];
</script>

<Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg" asChild>
                    {#snippet children(props)}
                        <Link
                            {...props}
                            href={toUrl(dashboard())}
                            class={props.class}
                        >
                            <AppLogo />
                        </Link>
                    {/snippet}
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
        <NavMain items={mainNavItems} />
    </SidebarContent>

    <SidebarFooter>
        <NavFooter items={footerNavItems} />
        <NavUser />
    </SidebarFooter>
</Sidebar>
{@render children?.()}
