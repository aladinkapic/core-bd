# Notifikacija u modelu

## Model (npr Sluzbenik.php)

Da bi koristili notifikacije, slali mail ili spremali u DB, potrebno je da u svakom od Modela :

    - use \Illuminate\Notifications\Notifiable;
    - use Notifiable;

### Pronađi instancu modela i postavi parametre

    - $sluzbenik = Sluzbenik::find($sluzbenik_id); // Treba imati polje email jer u biti njemu šaljemo obavijest osim ako ne želimo obavijesti putem emaila već samo putem pop up obavijesti
    
    - parametri - oni su opcionalni, ako ih ne pošaljemo, svejedno imaju predefinisane vrijednosti
        $parameters['subject']    = 'Naslov poruke';
        $parameters['from']       = 'Od koga -> od@koga.com';
        $parameters['link']       = 'ako treba linkati nešto na site .. pa se može poslat link !!';
        $parameters['message']    = 'Sadržaj maila ... ';
        $parameters[send_email']  = true;

### Kreiraj notifikaciju

Postoje dva načina kreirana notifikacije : 

    1. $sluzbenik->notify(new NotifyMe($parameters)); || PRVI NAČIN -- ovdje nam treba include-ati Notifable;
    2. Notification::send(Sluzbenik::all(), new SixMonthsWorking($parameters)); || DRUGI NAČIN 

Kada hoćemo da kreiramo notifikacije za više od jednog korisnika, tada koristimo drugi način !!

### Spašavanje u bazu podataka 

Spašavanje u bazu se vrši po defaultu, s tim da bi tabela nije isprojektovana do kraja, i biti će u momentu kada budemo imali oblik obavijesti koji će se kreirati !!

Za sad je kreirana migracija "notifications" koja sadrži nekoliko polja. Jedno od polja je data. U datu spremamo json format oblika :

    'sluzbenik_id' => (string)$notifiable->id, /* returns ID of Sluzbenik */

Pozivajući se na neki od načina za kreiranje notifikacija, kreiramo notifikaciju 
    
### Slanje Emaila

Slanje emaila se vrši istodobno kao kreiranje notifikacije i spašavanje u bazu podataka. S tim, da je jedan parametar bitan kod slanja emaila a on je :
   
    - $parameters[send_email']  = true; // Postavljanjem na true, dajemo na znanje da treba poslati i email
    
Email se šalje na email objekta nad kojim je pozvan (Sluzbenika sa određenim ID -om) !!



### Čitanje notifikacija vezanih za određenog usera
Da bi pročitali sve notifikacije vezane za određenu instancu Modela (čitaj npr. službenika)

    $sluzbenik = Sluzbenik::find($sluzbenik_id); // Treba imati polje email jer u biti njemu šaljemo obavijest osim ako ne želimo obavijesti putem emaila već samo putem pop up obavijesti
    
    foreach ($sluzbenik->notifications as $notification) {
            echo $notification->data['sluzbenik_id']; // npr.
      }



### Dodatne informacije - tabela notifications
U tabeli se nalazi nekoliko kolona. Svaka od kolona je inijcalno definisana, te npr:

1. type           - ( App\Notifications\NotifyMe ) -  govori koju smo "klasu" koristili za kreiranje notifikacije, u našem slučaju NotifyMe
2. notifable_tyle - ( App\Models\Sluzbenik )       -  govori koji smo model koristili za kreiranje notifikacija
3. notifable_id   - ( integer )                    -  govori koji je ID instance modela nad kojim je kreirana notifikacija
4. data           -                                -  svi podaci koji nam trebaju
5. read           -                                -  da li je notifikacija viđena ili ne !! 