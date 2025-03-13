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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username', 100);
                $table->string('password');
                $table->enum('role', ['user', 'admin', 'superadmin'])->default('user');
                $table->boolean('request_access')->default(false);
                $table->string('foto')->nullable();
                $table->timestamps();
                $table->timestamp('last_login')->nullable();
                $table->string('pop_id', 12)->nullable();
                $table->foreign('pop_id')->references('pop')->on('kantor_layanan')->onDelete('cascade');
            });
        
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
