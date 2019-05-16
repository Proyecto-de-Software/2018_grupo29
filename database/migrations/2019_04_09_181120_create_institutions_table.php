<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('director');
            $table->string('phone_number');
            $table->string('x_coordinate');
            $table->string('y_coordinate');
            
            $table->bigInteger('health_region_id')->nullable();
            $table->bigInteger('institution_type_id')->unsigned();
            
            $table->foreign('institution_type_id')->references('id')->on('institutions_types')->onDelete('cascade');
            
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
        Schema::dropIfExists('institutions');
    }
}
