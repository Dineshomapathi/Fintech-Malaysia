<?php 
 
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateEnquiriesTable  extends Migration
{
/**
* Run the migrations.
*
* @return void
*/ 
public function up()
{
	
	Schema::create('enquiries', function (Blueprint $table) { 
	$table->increments('id'); 
	$table->string('name'); 
	$table->string('email'); 
	$table->string('phone_number');
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
        Schema::dropIfExists('enquiries');
     }
}