<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up():void
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Option::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('title');

            $table->timestamps();
        });

        Schema::create('option_value_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(\App\Models\OptionValue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });


    }

    public function down():void
    {
        if (!app()->isProduction())
        {
            Schema::dropIfExists('option_value_product');
            Schema::dropIfExists('option_values');
        }
    }
};
