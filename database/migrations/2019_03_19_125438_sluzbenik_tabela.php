<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SluzbenikTabela extends Migration{
    public function up(){
        Schema::create('sluzbenici', function (Blueprint $table) { // koristit ćemo termin sluzbenici jer ima ih više : državni službenik, 'vaki 'naki službenik
            $table->bigIncrements('id');
            $table->string('ime', 90)->nullable();
            $table->string('prezime', 90)->nullable();
            $table->string('korisnicko_ime', 100)->nullable();
            $table->string('email', 100)->nullable();

            $table->string('sifra', 100)->default('Pocetni2020!');
            $table->string('pin')->default('1234');

            $table->bigInteger('jmbg')->nullable();
            $table->string('fotografija')->nullable();
            $table->string('ime_roditelja')->nullable();
            $table->string('djevojacko_prezime')->nullable();             // U zavisnosti od pola, djevojačko prezime je obavezno ako je žena u pitanju
            $table->integer('pol')->default('1');                   /** 0 -> žene , 1-> muškarci **/
            $table->integer('kategorija')->nullable();                    /** 1. Državni službenik; 2. Namještenik; 3. Pripravnik; 4. Volonter **/
            $table->string('drzavljanstvo_1', 50)->nullable();     //
            $table->string('drzavljanstvo_2', 50)->nullable();     //
            $table->integer('nacionalnost')->nullable();                  // FK 1. Bošnjak; 2. Srbin; 3. Hrvat; 4.Ostali
            $table->date('datum_rodjenja')->nullable();                    // 1. Januar 2019 -> mjesec treba biti tekstualnog karaktera
            // $table->integer('godine_zivota')->nullable();                      // trenutna godina - godina rođenja -> napraviti metodu u modelu
            $table->string('mjesto_rodjenja', 100)->nullable();
            $table->integer('bracni_status')->nullable();                 // sifrarnik : 1. Slobodan / Slobodna; 2. Oženjen / Udata; 3. Razveden / Razvedena; 4. Udovac / Udovica
            $table->string('licna_karta')->nullable();           // mora biti jedinstveno
            $table->string('mjesto_izdavanja_lk', 50)->nullable(); // mjesto izdavanja LK treba ponuditi u obliku neke pretrage ?
            $table->integer('privremeni_premjestaj')->nullable();         // Privremeni premjestaj !???????????
            $table->string('PIO', 50)->nullable();                 //

            $table->integer('radno_mjesto')->nullable();                  // radno mjesto pod kojim spada sluzbenik - ALEM

            /** ovdje ćemo držati informaciju o tome da li službenik trenutno radi ili je dobio otkaz */
            $table->integer('trenutno_radi')->default(1); // 1. ako radi; 0. ako je dobio otkaz -- to nam je potrebno zbog varijante da je dobio otkaz te treba unijeti razloge zbog kojeg se našao u toj situaciji

            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('sluzbenici');
    }
}
