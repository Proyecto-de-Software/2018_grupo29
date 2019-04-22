<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::enableForeignKeyConstraints();

        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('home')->nullable();;
            $table->boolean('has_document')->nullable();
            $table->bigInteger('phone_number')->nullable();

            # Aca se definen todas las columnas que tienen claves foraneas.
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->bigInteger('health_region_id')->unsigned()->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->bigInteger('documentation_type_id')->unsigned()->nullable();
            $table->bigInteger('social_work_id')->unsigned()->nullable();
            $table->timestamps();

        

             # Y aca se definen efectivamente las claves foraneas.
            
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('health_region_id')->references('id')->on('health_regions')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('documentation_type_id')->references('id')->on('documentation_types')->onDelete('cascade');
            $table->foreign('social_work_id')->references('id')->on('social_works')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
