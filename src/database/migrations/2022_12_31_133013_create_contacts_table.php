<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable('false');
            $table->string('name')->nullable('false');
            $table->string('email')->unique()->nullable('false');
            $table->enum('source',['facebook','whatsapp','google','website'])->nullable('false');
            $table->enum('stage',['lead','opportunity','customer'])->default('lead')->nullable('false');
            $table->enum('status',['open','in_progress','dropped'])->default('open')->nullable('false');
            $table->enum('pipeline',['meeting_booked','contacted','negotiation','proposal_sent','won','lost'])->nullable('false');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
