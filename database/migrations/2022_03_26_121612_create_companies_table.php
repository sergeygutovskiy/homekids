<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name');
            $table->string('full_name');
            
            $table->string('phone');
            $table->string('email');
            $table->string('site');

            $table->string('owner');
            $table->string('responsible');
            $table->string('responsible_phone');

            $table->unsignedBigInteger('organization_type_id');
            $table->foreign('organization_type_id')->references('id')->on('dictionaries');

            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('dictionaries');

            $table->json('education_license')->nullable();
            $table->json('medical_license')->nullable();

            $table->boolean('is_has_innovative_platform');

            $table->enum('status', [ 'accepted', 'pending', 'rejected' ])->default('accepted');
            $table->text('rejected_status_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
