<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        // Update or insert AUD currency settings
        $settingsToUpdate = [
            'currency_code' => 'AUD',
            'currency_symbol' => '$',
            'currency' => 'AUD',
        ];

        foreach ($settingsToUpdate as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'group' => 'general', 'updated_at' => now()]
            );
        }

        // Adjust shipping thresholds to AUD values if at default INR values
        DB::table('settings')
            ->where('key', 'free_shipping_threshold')
            ->whereIn('value', ['2999', '2999.00', '2999.0'])
            ->update(['value' => '299', 'updated_at' => now()]);

        DB::table('settings')
            ->where('key', 'flat_shipping_rate')
            ->whereIn('value', ['150', '150.00', '150.0'])
            ->update(['value' => '15', 'updated_at' => now()]);

        DB::table('settings')
            ->where('key', 'cod_max_limit')
            ->whereIn('value', ['25000', '25000.00'])
            ->update(['value' => '2500', 'updated_at' => now()]);

        // Update announcement banner text if it contains rupee symbol
        DB::table('banners')
            ->where('type', 'announcement')
            ->where('title', 'like', '%₹%')
            ->update([
                'title' => 'COMPLIMENTARY SHIPPING ON ORDERS OVER $299 | WORLDWIDE COUTURE DELIVERY',
                'updated_at' => now()
            ]);

        // Clear cache if Setting model is available
        if (class_exists(Setting::class)) {
            Setting::clearCache();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        DB::table('settings')->where('key', 'currency_code')->update(['value' => 'INR']);
        DB::table('settings')->where('key', 'currency_symbol')->update(['value' => '₹']);
        DB::table('settings')->where('key', 'currency')->update(['value' => 'INR']);

        if (class_exists(Setting::class)) {
            Setting::clearCache();
        }
    }
};
