<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('feature_requests', function(Blueprint $table) {
			$table->snowflakeId();
			$table->string('title');
			$table->string('details');
			$table->integer('priority');
			$table->string('status');
			$table->timestamps();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('feature_requests');
	}
};
