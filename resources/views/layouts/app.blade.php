<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/">

<head>
    @include('client.layouts.partials.head')
    <title>{{ config('app.name', 'GreenEmpire') }}</title>
</head>

<body class="light-style layout-menu-fixed" dir="ltr">
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('client.layouts.partials.sidebar')

            <div class="layout-page">
                @include('client.layouts.partials.navbar')

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                    @include('client.layouts.partials.footer')
                </div>
            </div>
        </div>
    </div>
    @include('client.layouts.partials.scripts')
    @stack('scripts')
</body>

</html>