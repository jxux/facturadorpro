<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantBinnaclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binnacles', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('user_id');
            $table->uuid('external_id');
            $table->date('date');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->decimal('hour', 8, 2)->nullable();
            $table->unsignedInteger('customer_id');
            $table->json('customer');
            $table->unsignedInteger('category_id');
            $table->date('period');
            $table->unsignedInteger('service_id');
            $table->string('description', 2000)->nullable();
            $table->integer('status')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('category_id')->references('id')->on('Category_Binnacles');
            $table->foreign('service_id')->references('id')->on('Service_Binnacles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binnacles');
    }
}
