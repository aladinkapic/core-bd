<html>
<head>
    <title>{{$sluzbenik->ime_prezime ?? 'Nepoznat službenik'}}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <link rel="stylesheet" href="/css/ispis-sluzbenika.css">
</head>

<body>

    @include('hr.sluzbenici.ispis-includes.osnovne-info')
    <footer></footer>

    <!-- Prebivaliste -->
    @include('hr.sluzbenici.ispis-includes.prebivaliste')
    <footer></footer>

    <!-- Stručni ispit -->
    @include('hr.sluzbenici.ispis-includes.strucni-ispit')
    <footer></footer>

    <!-- Položeni ispiti -->
    @include('hr.sluzbenici.ispis-includes.polozeni-ispiti')
    <footer></footer>

    <!-- Kontakt informacije -->
    @include('hr.sluzbenici.ispis-includes.kontakt')
    <footer></footer>

    <!-- Obrazovanje -->
    @include('hr.sluzbenici.ispis-includes.obrazovanje')
    <footer></footer>

    <!-- Vještine -->
    @include('hr.sluzbenici.ispis-includes.vjestine')
    <footer></footer>

    <!-- Zasnivanje RO -->
    @include('hr.sluzbenici.ispis-includes.zasnivanje-ro')
    <footer></footer>

    <!-- Prethodni RS -->
    @include('hr.sluzbenici.ispis-includes.radni-staz-prethodnih')
    <footer></footer>

    <!-- Prestanak RO -->
    @include('hr.sluzbenici.ispis-includes.prestanak-ro')
    <footer></footer>

    <!-- Članovi porodice -->
    @include('hr.sluzbenici.ispis-includes.clanovi-porodice')
    <footer></footer>
</body>
</html>