import type { Page, PageProps, Errors, ErrorBag } from "@inertiajs/inertia";

declare module "@inertiajs/core" {
    // modifique de acordo com o midleware HandleInertiaRequest
    interface PageProps extends Page<PageProps> {
        errors: Errors & ErrorBag;
        versions?: {
            laravel: string;
            php: string;
        };
    }
}
