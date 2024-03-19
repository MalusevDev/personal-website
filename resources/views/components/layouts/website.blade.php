<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-default-appearance="dark" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="application-name" content="{{ config('app.name') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#1e293b"/>
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#1e293b"/>
    <title>{{ $title ?? "Home Page - " . config('app.name') }}</title>
    <link href="mailto:dusan@dusanmalusev.dev" rel="me"/>
    <link href="https://dev.to/malusev998" rel="me"/>
    <link href="https://github.com/dmalusev" rel="me"/>
    <link href="https://www.linkedin.com/in/malusevd998" rel="me"/>
    <link href="https://www.reddit.com/user/Back_Professional" rel="me"/>
    <link href="https://stackoverflow.com/users/8411483/dusan-malusev" rel="me"/>
    {{ $structured ?? '' }}
    @if(($useLivewire ?? false))
        @livewireStyles
    @endif
    @vite('resources/css/website.css')

    {{ $css ?? '' }}
    {{ $meta ?? ''}}
</head>

<body class="body">
<x-header/>
<main class="grow">
    {{ $slot }}
</main>
@include('components.footer')
@include('components.search')

<script defer
        src="{{ config('umami.script') }}"
        data-cache="true"
        data-domains="{{ config('app.domain') }}"
        data-website-id="{{ config('umami.id') }}"
        data-auto-track="false"
        nonce="{{ Vite::cspNonce() }}"
></script>

@if(($useLivewire ?? false))
    @livewireScriptConfig
    @vite('resources/js/with-livewire.js')
@else
    @vite('resources/js/app.js')
@endif

</body>
</html>
