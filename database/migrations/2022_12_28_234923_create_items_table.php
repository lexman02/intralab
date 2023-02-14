<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('url');
            $table->string('icon')->nullable();
            $table->json('allowed_roles')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
