<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liners', function (Blueprint $table) {
            $table->id();
            $table->string('code_report');
            $table->string('code');
            $table->date('date_report');
            $table->enum('status', ['change', 'normal', 'inspect']);
            $table->string('location');
            $table->integer('orden');
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
        Schema::dropIfExists('liners');
    }
}
