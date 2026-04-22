* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
$schedule->call(function () {
    app(\App\Services\TaskAutomationService::class)->run();
})->everyFiveMinutes();