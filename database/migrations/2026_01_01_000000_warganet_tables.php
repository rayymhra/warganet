<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role')->default('resident')->index();
            $t->string('phone')->nullable();
        });
        Schema::create('schedules', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('category')->index(); $t->text('description')->nullable();
            $t->date('date')->index(); $t->time('start_time'); $t->time('end_time')->nullable();
            $t->string('location'); $t->string('status')->default('published')->index();
            $t->foreignId('created_by')->constrained('users'); $t->timestamps();
        });
        Schema::create('announcements', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique(); $t->string('category')->index();
            $t->text('content'); $t->boolean('is_important')->default(false);
            $t->string('status')->default('published')->index(); $t->timestamp('published_at')->nullable();
            $t->foreignId('created_by')->constrained('users'); $t->timestamps();
        });
        Schema::create('incident_reports', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title'); $t->text('description'); $t->string('category')->nullable()->index();
            $t->string('location'); $t->decimal('latitude', 10, 7)->nullable(); $t->decimal('longitude', 10, 7)->nullable();
            $t->string('image_path')->nullable(); $t->string('source')->default('community');
            $t->decimal('ai_confidence', 4, 3)->nullable(); $t->string('ai_severity')->nullable();
            $t->timestamp('occurred_at')->nullable();
            $t->string('verification_status')->default('pending')->index();
            $t->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('reviewed_at')->nullable(); $t->timestamps();
        });
        Schema::create('incident_status_logs', function (Blueprint $t) {
            $t->id(); $t->foreignId('incident_report_id')->constrained()->cascadeOnDelete();
            $t->foreignId('admin_id')->constrained('users'); $t->string('previous_status')->nullable();
            $t->string('new_status'); $t->text('notes')->nullable(); $t->timestamps();
        });
        Schema::create('external_alerts', function (Blueprint $t) {
            $t->id(); $t->string('source_name'); $t->string('external_id')->nullable()->unique();
            $t->string('title'); $t->text('description'); $t->string('category'); $t->string('location')->nullable();
            $t->text('source_url')->nullable(); $t->timestamp('published_at')->nullable(); $t->timestamp('fetched_at');
            $t->timestamp('expires_at')->nullable(); $t->string('status')->default('active'); $t->timestamps();
        });
        Schema::create('businesses', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('category')->index(); $t->text('description');
            $t->text('address'); $t->string('phone')->nullable(); $t->text('operating_hours')->nullable();
            $t->string('image_path')->nullable(); $t->string('status')->default('published')->index();
            $t->foreignId('created_by')->constrained('users'); $t->timestamps();
        });
        Schema::create('notifications', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete(); $t->string('title');
            $t->text('message'); $t->string('type'); $t->unsignedBigInteger('related_id')->nullable();
            $t->timestamp('read_at')->nullable(); $t->timestamps();
        });
    }
    public function down(): void {
        foreach (['notifications','businesses','external_alerts','incident_status_logs','incident_reports','announcements','schedules'] as $n) Schema::dropIfExists($n);
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['role', 'phone']));
    }
};
