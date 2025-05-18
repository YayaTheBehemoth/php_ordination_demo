# Ordination API

Dette projekt er en rekonstruktion af [ordination](https://github.com/YayaTheBehemoth/ordination) – et system til håndtering af medicinordinationer for patienter.  
Projektet er omskrevet til et Laravel API med Swagger-dokumentation og automatiske tests.

## Domænemodel og relationer

Systemet modellerer følgende centrale klasser og relationer:

- **Patient**  
  En patient kan have flere ordinationer.

- **Laegemiddel**  
  Et lægemiddel kan indgå i mange ordinationer.

- **Ordination**  
  Abstrakt baseklasse for ordinationer.  
  Underklasser:
    - **PN** (efter behov):  
      Indeholder start/slut-dato, antal enheder pr. dosis, og kan anvendes i en given periode.
    - **DagligFast**:  
      Indeholder faste doser på fire tidspunkter (morgen, middag, aften, nat) i en given periode.
    - **DagligSkaev**:  
      Indeholder et vilkårligt antal doser på specifikke tidspunkter hver dag i en given periode.

- **Dosis**  
  Repræsenterer en enkelt dosis (tidspunkt og antal enheder).  
  Bruges både i DagligFast (fire faste doser) og DagligSkaev (liste af doser).

### Relationer (forenklet UML)

```
Patient 1---* Ordination *---1 Laegemiddel
Ordination <|-- PN
Ordination <|-- DagligFast
Ordination <|-- DagligSkaev
DagligFast *---1 Dosis (morgen)
DagligFast *---1 Dosis (middag)
DagligFast *---1 Dosis (aften)
DagligFast *---1 Dosis (nat)
DagligSkaev 1---* Dosis
PN 1---* Dato (anvendelsesdatoer)
```

## Funktionalitet

- Opret, hent og anvend ordinationer (PN, DagligFast, DagligSkaev)
- Hent patienter og lægemidler
- Beregn anbefalet dosis pr. døgn
- Statistik på ordinationer
- Swagger-dokumenteret API
- Automatisk database-seeding og tests

---

## Projektstruktur

- **app/Models/**  
  Eloquent-modeller for Patient, Laegemiddel, Ordination, PN, DagligFast, DagligSkaev, Dosis m.fl.

- **app/Repositories/**  
  Repository-klasser til databaseoperationer for de forskellige modeller.

- **app/Services/**  
  Forretningslogik, fx oprettelse og anvendelse af ordinationer.

- **app/Http/Controllers/**  
  API-controllere, som modtager requests og returnerer responses.

- **app/Http/Requests/**  
  Form Request-klasser til validering af input.

- **app/Http/Resources/**  
  API Resource-klasser, der formaterer output til JSON.

- **database/migrations/**  
  Migrationer til at oprette databasens tabeller.

- **database/seeders/**  
  Seeders til at fylde databasen med testdata.

- **routes/api.php**  
  Indeholder alle API-ruter.

---

## Kom godt i gang

### 1. Klon projektet

```sh
git clone https://github.com/YayaTheBehemoth/php_ordination_demo.git
cd php_ordination_demo
```

### 2. Installer afhængigheder

```sh
composer install
```

### 3. Opret miljøfil og generér nøgle

```sh
cp .env.example .env
php artisan key:generate
```

### 4. Opret SQLite database

- Opret en tom fil i `database`-mappen:

På Linux/macOS eller Git Bash/WSL på Windows:
```sh
touch database/database.sqlite
```
På Windows (CMD):
```sh
type nul > database\database.sqlite
```

### 5. Kør migrationer og seed databasen

```sh
php artisan migrate --seed
```

### 6. Generér Swagger-dokumentation

```sh
php artisan l5-swagger:generate
```

### 7. Start serveren

```sh
php artisan serve
```

### 8. Åbn API-dokumentation

Gå til [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) for at se og teste API'et via Swagger UI.

---

## Test

Kør automatiske tests med:

```sh
php artisan test
```
