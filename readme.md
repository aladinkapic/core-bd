### 0.1.0
- Početna stranica dodana - struktura

Instalacija Sistema

1. git clone http://192.168.14.14:3000/PARCO/core-bd.git
2. cd core-bd
3. composer install
4. npm install
5. npm run dev
6. npm run development -- --watch => real time kompajliranje css i scss stvari


### 0.2.0

Sve neophodne migracije kreirane. Aplikacija postojana za dodavanje novih modula.

### 0.3.0

Kreirani moduli :

    - Državni službenik
    - Modul za odsustvo službenika
    - Radna mjesta


9999. php artisan serve 



# NOTE
    - nazivi inputa (forma) neka korespondiraju nazivima kolona u tabelama
        - ime_sluzbenika -> ime_sluzbenika; da bi jednostavnije i preglednije bilo npr $sluzbenik->ime_sluzbenika = $request->ime_sluzebenika; !


# Bitne komande
    - za pristup odabranom jeziku, birajmo if(Session::has('jezik')) $jezik = Crypt::decryptString(Session::get('jezik'));