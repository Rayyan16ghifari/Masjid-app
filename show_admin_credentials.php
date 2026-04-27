<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔐 Admin Login Credentials\n\n";

// Get all admin users
$adminUsers = \App\Models\User::where('role', 'admin')->get();

if ($adminUsers->isEmpty()) {
    echo "❌ No admin users found in database\n";
    
    // Show all users for reference
    echo "\n👥 All Users in Database:\n";
    $allUsers = \App\Models\User::all();
    foreach ($allUsers as $user) {
        echo "   - ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
    }
} else {
    echo "✅ Found " . $adminUsers->count() . " admin user(s):\n\n";
    
    foreach ($adminUsers as $admin) {
        echo "📋 Admin User Details:\n";
        echo "   👤 Name: {$admin->name}\n";
        echo "   📧 Email: {$admin->email}\n";
        echo "   🔑 Role: {$admin->role}\n";
        echo "   🆔 ID: {$admin->id}\n";
        echo "   📅 Created: {$admin->created_at}\n\n";
        
        echo "🔑 Login Information:\n";
        echo "   📧 Username/Email: {$admin->email}\n";
        echo "   🔒 Password: [Check your records or ask system admin]\n\n";
        
        echo "🌐 Login URL: http://127.0.0.1:8000/login\n";
        echo "🎯 Dashboard URLs:\n";
        echo "   - User Dashboard: http://127.0.0.1:8000/dashboard\n";
        echo "   - Admin Dashboard: http://127.0.0.1:8000/admin/dashboard\n\n";
        
        echo "─────────────────────────────────\n\n";
    }
}

echo "📝 Note:\n";
echo "• If you don't know the password, you may need to:\n";
echo "  1. Check with the system administrator\n";
echo "  2. Use password reset functionality if available\n";
echo "  3. Create a new admin user if you have database access\n\n";

echo "🔧 To create new admin user (if needed):\n";
echo "php artisan tinker\n";
echo "User::create(['name' => 'Admin Name', 'email' => 'admin@example.com', 'password' => Hash::make('password123'), 'role' => 'admin']);\n\n";

echo "✨ Admin credentials display completed!\n";
