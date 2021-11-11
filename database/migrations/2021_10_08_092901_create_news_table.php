<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('reporter_id')->unsigned()->nullable();
            $table->integer('reference_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('tag')->nullable();
            $table->string('media')->nullable();
            $table->string('media_link')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->integer('view_count')->nullable();
            $table->boolean('display')->default(false);
            $table->boolean('isActive')->default(true);
            $table->boolean('isDeleted')->default(false);
            $table->date('news_date');
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
            $table->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('reference_id')
                ->references('id')
                ->on('reference')
                ->onDelete('set null');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
