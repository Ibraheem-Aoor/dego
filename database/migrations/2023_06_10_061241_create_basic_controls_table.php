<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('basic_controls', function (Blueprint $table) {
            $table->id();
            $table->string('theme')->nullable();
            $table->string('site_title')->nullable();
            $table->string('home_style')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('base_currency')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('admin_prefix')->nullable();
            $table->string('is_currency_position')->default('left')->comment('left , right');
            $table->tinyInteger('registration')->default('0')->comment('0 =>disable, 1=>enable');
            $table->tinyInteger('strong_password')->default('0');
            $table->tinyInteger('is_maintenance_mode')->default('0');
            $table->tinyInteger('is_force_ssl')->default('0');
            $table->tinyInteger('has_space_between_currency_and_amount')->default('0');
            $table->integer('fraction_number')->nullable();
            $table->integer('paginate')->nullable();
            $table->string('fb_page_id')->nullable();
            $table->string('fb_app_id')->nullable();
            $table->string('tawk_id')->nullable();
            $table->text('email_description')->nullable();
            $table->string('sender_email_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->tinyInteger('fb_messenger_status')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('tawk_status')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('sms_verification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('sms_notification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('email_verification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('email_notification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('in_app_notification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('push_notification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('is_active_cron_notification')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('error_log')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('analytic_status')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('google_recaptcha_register')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('google_recaptcha_login')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('google_recaptcha_admin_login')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('manual_recaptcha_register')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('manual_recaptcha_login')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('manual_recaptcha_admin_login')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('google_recaptcha')->default('0')->comment('0 => inactive, 1=> Active');
            $table->tinyInteger('manual_recaptcha')->default('0')->comment('0 => inactive, 1=> Active');
            $table->string('cookie_image_driver')->nullable();
            $table->string('cookie_image')->nullable();
            $table->string('cookie_button_link')->nullable();
            $table->string('cookie_button')->nullable();
            $table->string('cookie_heading')->nullable();
            $table->string('date_time_format')->nullable();
            $table->string('coin_market_cap_auto_update_at')->default(null);
            $table->string('coin_market_cap_app_key')->nullable();
            $table->string('currency_layer_auto_update')->nullable();
            $table->string('currency_layer_access_key')->nullable();
            $table->string('admin_dark_mode_logo_driver')->nullable();
            $table->string('admin_dark_mode_logo')->nullable();
            $table->string('admin_logo_driver')->nullable();
            $table->string('admin_logo')->nullable();
            $table->string('favicon_driver')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo_driver')->nullable();
            $table->string('logo')->nullable();
            $table->string('measurement_id')->nullable();
            $table->text('cookie_description')->nullable();
            $table->tinyInteger('cookie_status')->nullable();
            $table->tinyInteger('automatic_payout_permission')->nullable();
            $table->tinyInteger('coin_market_cap_auto_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_controls');
    }
};
