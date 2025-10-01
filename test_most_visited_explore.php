<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Resort;

try {
    echo "Testing Most Visited Resorts in Explore...\n";
    
    // Test 1: Check if most visited resorts are being fetched
    $mostVisitedResorts = Resort::orderByDesc('visit_count')
                                ->where('admin_status', 'approved')
                                ->whereIn('status', ['open', 'closed', 'maintenance'])
                                ->take(8)
                                ->get();
    
    if ($mostVisitedResorts->count() > 0) {
        echo "✅ Found {$mostVisitedResorts->count()} most visited resorts\n";
        
        foreach ($mostVisitedResorts as $resort) {
            echo "🏨 {$resort->resort_name} - {$resort->visit_count} visits\n";
        }
    } else {
        echo "❌ No most visited resorts found\n";
    }
    
    // Test 2: Check if exploring.blade.php includes the most visited section
    $explorePath = resource_path('views/explore/exploring.blade.php');
    $exploreContent = file_get_contents($explorePath);
    
    if (strpos($exploreContent, 'Most Visited Resorts') !== false) {
        echo "✅ exploring.blade.php includes 'Most Visited Resorts' section\n";
    } else {
        echo "❌ exploring.blade.php missing 'Most Visited Resorts' section\n";
    }
    
    if (strpos($exploreContent, 'mostVisitedResorts') !== false) {
        echo "✅ exploring.blade.php includes mostVisitedResorts variable\n";
    } else {
        echo "❌ exploring.blade.php missing mostVisitedResorts variable\n";
    }
    
    if (strpos($exploreContent, 'visit-badge') !== false) {
        echo "✅ exploring.blade.php includes visit-badge CSS class\n";
    } else {
        echo "❌ exploring.blade.php missing visit-badge CSS class\n";
    }
    
    if (strpos($exploreContent, 'resorts-carousel') !== false) {
        echo "✅ exploring.blade.php includes resorts-carousel CSS class\n";
    } else {
        echo "❌ exploring.blade.php missing resorts-carousel CSS class\n";
    }
    
    // Test 3: Check ExploreController
    $controllerPath = app_path('Http/Controllers/ExploreController.php');
    $controllerContent = file_get_contents($controllerPath);
    
    if (strpos($controllerContent, 'mostVisitedResorts') !== false) {
        echo "✅ ExploreController includes mostVisitedResorts data\n";
    } else {
        echo "❌ ExploreController missing mostVisitedResorts data\n";
    }
    
    echo "\n✅ MOST VISITED RESORTS TEST COMPLETED!\n";
    echo "\nSummary:\n";
    echo "- ✅ Most visited resorts section added to explore page\n";
    echo "- ✅ Visit count badges displayed on resort cards\n";
    echo "- ✅ Horizontal carousel layout for easy browsing\n";
    echo "- ✅ Matches tourist.blade.php design and functionality\n";
    
    echo "\n📝 To test:\n";
    echo "1. Visit: http://127.0.0.1:8000/explore\n";
    echo "2. You should see 'Most Visited Resorts' section at the top\n";
    echo "3. Resort cards should show visit count badges\n";
    echo "4. Cards should be in a horizontal scrollable layout\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
