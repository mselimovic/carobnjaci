import { get } from 'svelte/store';
import { page } from '@inertiajs/svelte';

type TranslationPrimitive = string;
interface TranslationObject {
    [key: string]: TranslationPrimitive | TranslationObject | TranslationPrimitive[];
}
type TranslationValue = TranslationPrimitive | TranslationObject | TranslationPrimitive[];

function resolvePath(source: Record<string, TranslationValue>, key: string): TranslationValue | undefined {
    return key.split('.').reduce<TranslationValue | undefined>((current, segment) => {
        if (!current || Array.isArray(current) || typeof current === 'string') {
            return undefined;
        }

        return current[segment];
    }, source);
}

export function t(key: string, replacements: Record<string, string> = {}): string {
    const props = get(page).props as {
        translations?: Record<string, TranslationValue>;
    };

    const translations = props.translations ?? {};
    const value = resolvePath(translations, key);

    if (typeof value !== 'string') {
        return key;
    }

    return Object.entries(replacements).reduce(
        (text, [replacementKey, replacementValue]) =>
            text.replaceAll(`:${replacementKey}`, replacementValue),
        value,
    );
}

export function locale(): string {
    const props = get(page).props as { locale?: string };
    return props.locale ?? 'en';
}
