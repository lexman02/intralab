<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('group_id')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apps');
    }
};
