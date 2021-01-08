<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersFitGenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userfitgenes', function (Blueprint $table) {
            $table->id();
            $table->text('patient_code');
            $table->text('abi_first');
            $table->text('abi_second');
            $table->text('enz_first');
            $table->text('enz_second');
            $table->text('fit_medicine');
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
        Schema::dropIfExists('userfitgenes');
    }
}
