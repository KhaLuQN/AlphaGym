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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id('template_id');
            $table->string('name')->comment('Tên mẫu để admin nhận biết');
            $table->string('subject');
            $table->longText('body')->comment('Nội dung mẫu, chứa các biến như [TEN_HOI_VIEN]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
