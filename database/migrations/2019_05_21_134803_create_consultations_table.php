<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->longText('articulation')->nullable();
            $table->boolean('was_internment?')->nullable();
            $table->longText('diagnostic')->nullable();
            $table->longText('observations')->nullable();

            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('treatments_id')->nullable();
            $table->bigInteger('accompanied_by_id')->nullable();
            $table->bigInteger('reason_id')->unsigned()->nullable();
            $table->bigInteger('derivation_id')->unsigned()->nullable();

            //$table->foreign('treatments_id')->references('id')->on('treatments')->onDelete('cascade');
            //$table->foreign('accompanied_by_id')->references('id')->on('accompanied_by')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('reason_id')->references('id')->on('reasons')->onDelete('cascade');

            #Este queda distinto al resto. Pero asi lo teniamos. Derivacion->Institucion
            $table->foreign('derivation_id')->references('id')->on('institutions')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('consultations');
    }
}

