php <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PredavaciTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predavaci', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('ime', 100)->nullable();
            $table->string('prezime', 100)->nullable();
            $table->string('telefon', 100)->nullable();
            $table->string('mail', 100)->nullable();
            $table->text('napomena')->nullable();
            $table->text('oblasti_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predavaci');
    }
}
