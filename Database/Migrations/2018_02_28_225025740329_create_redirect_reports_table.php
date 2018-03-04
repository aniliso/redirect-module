<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('redirect__reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('url')->nullable();
            $table->string('ip', 15)->nullable();
            $table->smallInteger('status_code')->nullable();

            $table->integer('redirect_id')->unsigned()->nullable();
            $table->foreign('redirect_id')->references('id')->on('redirect__redirects')->onDelete('SET NULL');

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('redirect__reports');
        Schema::enableForeignKeyConstraints();
    }
}
