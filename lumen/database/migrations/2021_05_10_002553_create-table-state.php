<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'state',
            function (Blueprint $table) {
                $table->uuid('process_uuid')->primary()->default(DB::raw('uuid()'));
                $table->longText('payload');
                $table->longText('phases');
                $table->dateTime('marked_as_done_at')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('state');
    }
}
