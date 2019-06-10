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
            $table->date('birthdate');
            $table->string('place_of_birth')->nullable();
            $table->string('home');
            $table->boolean('has_document');
            $table->bigInteger('dni_number');
            $table->bigInteger('phone_number')->nullable();
            $table->bigInteger('medical_history_number')->nullable();
            $table->bigInteger('folder_number')->nullable();

            # Aca se definen todas las columnas que tienen claves foraneas.
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('health_region_id')->nullable();
            $table->bigInteger('gender_id')->unsigned();
            $table->bigInteger('documentation_type_id')->nullable();
            $table->bigInteger('social_work_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

        

             # Y aca se definen efectivamente las claves foraneas.
            
            
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
           
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
