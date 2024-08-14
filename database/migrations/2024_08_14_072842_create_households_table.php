<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_council_id')->constrained()->onDelete('cascade');
            $table->string('household_name');
            $table->foreignId('assigned_worker_id')->nullable()->constrained('users')->onDelete('set null'); // Track the worker who picks the household
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('households');
    }

}
