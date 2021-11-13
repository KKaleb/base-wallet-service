<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdRevenueShareGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_revenue_share_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('group');
            $table->string('name');
            $table->decimal('share_percent', 8, 2)->default(0);
            $table->decimal('influencer_percent', 8, 2)->default(0);
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
        Schema::dropIfExists('ad_revenue_share_groups');
    }
}
