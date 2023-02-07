<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('leaves', function (Blueprint $table) {
			$table->id();
			$table->date("start");
			$table->date("end");
			$table->unsignedBigInteger("user_id")->comment("The employee that requested this leave.");
			$table->foreign("user_id")->references("id")->on("users");
			$table->boolean("accepted")->comment("Whether the leave request was accepted or not.");
//			$table->unsignedBigInteger("accepted_by")->comment("The user that accepted this leave request.");
//			$table->foreign("accepted_by")->references("id")->on("users");
			$table->enum("type", [
				"medical",
				"paid"
			]);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('leaves');
	}
};
