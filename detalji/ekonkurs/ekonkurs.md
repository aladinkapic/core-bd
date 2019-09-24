# eKonkurs

### 1. getPrijava

Ovaj servis će služiti za dohvat prijave sa svim njenim podacima na osnovu id-a prijave. 

    1. Naziv - getPrijava
    2. Opis  - Vrši dohvat prijave za dati ID prijave
    3. Ulaz  - ID prijave
    4. Izlaz - Popunjeni objekti tipa prijava (Sluzbenik)
    
    
### 2. Historija prijava

Potrebno je pratiti historiju interakcije core-BD sa ekonkursom. Prilikom kreiranja svakog 
zahtjeva, potrebno je da se spašava u historiju kada je zahtjev kreiran te da se mogu naknadno 
pregledati svi zahtjevi kao i korisnici koji su registrovani na taj način. 

    Tabela 
    
    1. ID                  - unique
    2. id_sluzbenika       - FK
    3. created_at          - timestapm
    4. updated_at          - timestamp
    

