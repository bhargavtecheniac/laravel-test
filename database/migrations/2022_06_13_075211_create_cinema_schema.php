<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
        # Create a migration that creates all tables for the following user stories

        For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
        To not introduce additional complexity, please consider only one cinema.

        Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

        ## User Stories

        **Movie exploration**
        * As a user I want to see which films can be watched and at what times
        * As a user I want to only see the shows which are not booked out

        **Show administration**
        * As a cinema owner I want to run different films at different times
        * As a cinema owner I want to run multiple films at the same time in different locations

        **Pricing**
        * As a cinema owner I want to get paid differently per show
        * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

        **Seating**
        * As a user I want to book a seat
        * As a user I want to book a vip seat/couple seat/super vip/whatever
        * As a user I want to see which seats are still available
        * As a user I want to know where I'm sitting on my ticket
        * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('city', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('state');
            $table->string('zip_code');
            $table->timestamps();
        });

        Schema::create('cinema', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('city');
            $table->timestamps();
        });
        
        Schema::create('cinema_hall', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('total_seats');            
            $table->integer('no_of_vip_seats');
            $table->integer('cinema_id')->unsigned()->nullable();
            $table->foreign('cinema_id')->references('id')->on('cinema')->onDelete('cascade');
            $table->timestamps();
        });
    
        Schema::create('cinema_seat', function($table) {
            $table->increments('id');
            $table->integer('seat_number');            
            $table->integer('type');
            $table->integer('cinema_id')->unsigned()->nullable();
            $table->foreign('cinema_id')->references('id')->on('cinema')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('movie', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('duration');
            $table->timestamps();
        });
        
        Schema::create('show', function($table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->integer('cinema_id')->unsigned()->nullable();
            $table->integer('movie_id')->unsigned()->nullable();
            $table->foreign('cinema_id')->references('id')->on('cinema')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movie')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('booking', function($table) {
            $table->increments('id');
            $table->integer('no_of_seats');
            $table->dateTime('timestamp');
            $table->integer('status');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('show_id')->unsigned()->nullable();
            $table->foreign('show_id')->references('id')->on('show')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('show_seat', function($table) {
            $table->increments('id');
            $table->integer('status');
            $table->double('price');
            $table->integer('show_id')->unsigned()->nullable();
            $table->integer('booking_id')->unsigned()->nullable();
            $table->foreign('show_id')->references('id')->on('show')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('booking')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('payment', function($table) {
            $table->increments('id');
            $table->double('amount');
            $table->dateTime('timestamp');
            $table->text('transactiopn_id');
            $table->enum('payment_method', ['online', 'cash']);
            $table->integer('booking_id')->unsigned()->nullable();
            $table->foreign('booking_id')->references('id')->on('booking')->onDelete('cascade');
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
    }
}
