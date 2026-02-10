<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;
use App\Models\Sla;

echo "Total Tickets: " . Ticket::count() . PHP_EOL;
echo "Tickets with SLA: " . Ticket::whereNotNull('slaID')->count() . PHP_EOL;

$first = Ticket::whereNotNull('slaID')->first();
if ($first) {
    echo "First Ticket SLA ID: " . $first->slaID . PHP_EOL;
    $first->load('sla');
    echo "SLA Relation: " . ($first->sla ? "Found (ID: {$first->sla->slaID})" : "Not Found") . PHP_EOL;
    echo "Response Due: " . ($first->response_due ? $first->response_due->toIso8601String() : "Null") . PHP_EOL;
} else {
    echo "No tickets with SLA found." . PHP_EOL;
}

echo "SLA Count: " . Sla::count() . PHP_EOL;
if (Sla::count() > 0) {
    echo "First SLA ID: " . Sla::first()->slaID . PHP_EOL;
}
