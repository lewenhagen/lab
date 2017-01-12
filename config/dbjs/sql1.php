<?php

/**
 * Generate random values to use in lab.
 */
include __DIR__ . "/../random.php";

$owner = rand_array(["Adam", "Berit", "Ceasar"]);
$ownerChar = rand_array(["a", "e"]);



// Settings
$base = tempDir();
$dbname = "db.sqlite";
$db = "$base/$dbname";
$sqlite = "sqlite3 -header -column $db";

$sqlFile = "games.sql";
$tableA = "Games";

$sqlCreate = <<<EOD
DROP TABLE IF EXISTS "Jetty";
CREATE TABLE "Jetty" ("jettyPosition" INTEGER PRIMARY KEY  NOT NULL  UNIQUE , "boatType" VARCHAR(20) NOT NULL , "boatEngine" VARCHAR(20) NOT NULL , "boatLength" INTEGER, "boatWidth" INTEGER, "ownerName" VARCHAR(20));
EOD;

$sqlInsert = <<<EOD
INSERT INTO "Jetty" VALUES
(1,'Buster XXL','Yamaha 115hk',635,240,'Adam'),
(2,'Buster M','Yamaha 40hk',460,186,'Berit'),
(3,'Linder 440','Tohatsu 4hk',431,164,'Ceasar');
EOD;



return [



/**
 * Titel and introduction to the lab.
 */
"answerFormat" => "text",

"title" => "Lab 1 SQL introduktion",

"intro" => <<<EOD
Lek runt med inledande SQL-satser i SQLite. Det är bra om du har manualen för SQLite uppe, där kan du se [syntaxen för SQL-satserna](https://www.sqlite.org/lang.html) och du kan se vilka [extra funktioner som stöds](https://www.sqlite.org/lang_corefunc.html).

Du får en databas att jobba med och du skall använda SQL för att hämta ut och presentera information från databasen. Databasen är den som du jobbat med i övningen "[Kom igång med databasen SQLite](https://dbwebb.se/kunskap/kom-igang-med-databasen-sqlite)".

I andra delen av labben bygger vi ut databasen och använder joins för att joina innehållet från olika tabeller.

**Tips.**

I labben skapas en databas `$dbname` och du kan använda följande kommando för att jobba mot den databasen.

> `sqlite3 -header -column $dbname`

Det kan vara bra för att testa, men kom ihåg att databasen byggs om varje gång du exekverar labben.

EOD
,

"header" => null,

"passPercentage" => 68.75/100,
"passDistinctPercentage" => 100/100,
/*
*/

/*
"grades" => [
    "pass" => 60/100,
    "pass-distinct" => 100/100,
]
*/

"sections" => [



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "CREATE TABLE Jetty",

"intro" => <<<EOD
Vi har nu en tom databas och skall återskapa databasen med innehåll från övningen med `boats.sqlite` och tabellen Jetty.

Till att börja med skapar vi tabellen Jetty.

Glöm inte att avsluta varje SQL-sats med ett semikolon.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Titta i filen `Mos_Jetty.sql` och kopiera SQL-satserna för `DROP TABLE` och `CREATE TABLE`. Byt tabellens namn till `Jetty`. Exekvera dem i varsin SQL sats.

Svara sedan med resultatet från:

> `SELECT * FROM Jetty;`

Det är den sista SQL-satsen som innehåller själva svaret på varje uppgift, det är så labbverktyget fungerar. I detta fallet blir resultatet helt tomt, men vi har ännu inte lagt in några värden i tabellen så det är helt i sin ordning.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite, $sqlCreate) {
    execute("$sqlite \"$sqlCreate\"");
    return execute("$sqlite \"select * from Jetty\"");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Börja med att inspektera strukturen av tabellen. Olika databasmotorer har olika sätt att inspektera hur tabeller är skapade. I SQLite skriver du så här.

> `.schema Jetty`

I labben gör du en rad som ser ut så här:

> `SQL ".schema Jetty" false`

Notera att du _inte avslutar_ med semikolon nu. Det gör du endast när du skriver ren SQL.

Värdet i slutet kan du ändra till `true` för att få utskrift av resultatet, som en _hint_ om hur det skall se ut. Det är bra för debugging. Pröva hur det ser ut. Ändra sedan tillbaka till `false` för att få mindre utskrifter.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    return execute("$sqlite \".schema Jetty\"");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "INSERT INTO",

"intro" => <<<EOD
Nu använder vi `INSERT INTO` för att lägga till rader i tabellen.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Titta i filen `Mos_Jetty.sql` och kopiera de SQL-satser som börjar med `INSERT INTO`. Exekvera dem en och en. 

Glöm inte byta namn på tabellen till `Jetty`.

Svara sedan med resultatet från:

> `SELECT * FROM Jetty;`

EOD
,

"points" => 1,

"answer" => function () use ($sqlite, $sqlInsert) {
    execute("$sqlite \"$sqlInsert\"");
    return execute("$sqlite \"select * from Jetty\"");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "SELECT FROM",

"intro" => <<<EOD
Låt oss söka ut och visa information från tabellen med hjälp av `SELECT FROM`.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa namnet för `boatType` på de båtar som ligger inlagda. Rubriken för kolumnen skall vara "Type".

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    boatType AS "Type"
FROM  Jetty
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa namnet på samtliga ägare och vilken båttyp som de har. Rubriken för ägaren skall vara "Owner" och för båtens typ "Type".

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    ownerName AS Name,
    boatType AS Type
FROM Jetty
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa all information om de båtar som ägs av $owner.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite, $owner) {
    $sql = <<<EOD
SELECT
    *
FROM Jetty
WHERE
    ownerName = "$owner"
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa båttyp ("Type"), båtens motor ("Engine") och ägarens namn ("Owner") för alla ägarens namn som innehåller ett `$ownerChar`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite, $ownerChar) {
    $sql = <<<EOD
SELECT
    boatType AS Type,
    boatEngine AS Engine,
    ownerName AS Owner
FROM Jetty
WHERE
    ownerName LIKE "%$ownerChar%"
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa de båtar som är längre än 4.5 meter. Visa båtens typ ("Type") och båtens längd ("Length").

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    boatType AS Type,
    boatLength AS Length
FROM Jetty
WHERE
    boatLength > 450
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa de båtar som är längre än 4.5 meter och kortare än 6 meter. Visa båtens typ ("Type") och båtens längd ("Length").

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    boatType AS Type,
    boatLength AS Length
FROM Jetty
WHERE
    boatLength > 450 AND
    boatLength < 600
;
EOD;
    return execute("$sqlite '$sql'");
},

],




/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Skriv ett `WHERE`-villkor som uppfyller regeln att visa de båtar som är längre än 4.5 meter och kortare än 7 meter och har en båtmotor från Yamaha, eller båtar som har en motor från Tohatsu. Visa båtens typ ("Type") och båtens motor ("Engine").

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    boatType AS Type,
    boatLength AS Length
FROM Jetty
WHERE
    (boatLength > 450 AND
    boatLength < 600 AND
    boatEngine LIKE "Yamaha%") OR
    boatEngine LIKE "Tohatsu%"
;
EOD;
    return execute("$sqlite '$sql'");
},

],




/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Lägg till och uppdatera",

"intro" => <<<EOD
Använd `INSERT INTO` för att lägga till fler rader och `UPDATE` för att uppdatera informationen i databasen.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Det har tillkommit ytterligare båtar som skall läggas in i tabellen. Lägg till följande.

| Typ | Motor | Längd | Bredd | Ägare |
|-----|-------|-------|-------|-------|
| Seadoo Spark | Rotax 90hk | 305 | 118 | Debbie |
| Plastic skiff | Oar | 220 | 99 | Debbie |

Svara sedan med `SELECT *` och sortera på båtens ägare i sjunkande ordning.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
INSERT INTO Jetty (boatType, boatEngine, boatLength, boatWidth, ownerName) VALUES ("Seadoo Spark", "Rotax 90hk", 305, 118, "Debbie"), ("Plastic skiff", "Oar", 220, 99, "Debbie")
;
EOD;
    execute("$sqlite '$sql'");

    $sql = <<<EOD
SELECT
    *
FROM Jetty
ORDER BY ownerName DESC;
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Aggregerande funktioner",

"intro" => <<<EOD
Använd `SELECT FROM` tillsammans med aggregerande funktioner för att svara på följande frågor.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Räkna ut antalet matcher som har spelats. Döp rubriken till "Antal matcher". Tips `COUNT()`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    Count(id) AS "Antal matcher"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Summera antalet poäng som hemmalagen tagit ("Poäng hemma"), samt antalet poäng som bortalagen tagit ("Poäng borta"). Tips `SUM()`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    SUM(scoreA) AS "Poäng hemma",
    SUM(scoreB) AS "Poäng borta"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Beräknade värden",

"intro" => <<<EOD
I en databas vill man inte dubbellagra information. Man lagrar endast det som behövs. Saker som går att räkna fram, med hjälp av befintlig data, behöver inte dubbellagras. Tänk till exempel på födelsedatum kontra ålder.

Om man dubbellagrar data riskerar man att missa en del av datat vid till exempel en `UPDATE`. Man vill inte göra en `UPDATE` på två platser, om det är "samma" värde (födelsedatum, ålder).

I en databas som är *normaliserad* brukar det inte finnas duplicerad data.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
En match spelas om 4 serier och i varje serie spelar lagen om 5 poäng. Varje lag är indelat i fyra tvåmannalag som spelar om 4 poäng per serie. Den 5:e poängen kommer från lagens totala slagning per serie.

I varje match spelar man alltså om 20 poäng. Om resultatet visar på färre poäng på en match så beror det på att någon delmatch blivit oavgjord, eller att man avslutat matchen i förtid på grund av att det ena laget redan har vunnit och sista serien behövs inte spelas.

Skriv en SELECT sats som summerar totalen ("Total") av de poäng (samtliga `scoreA` plus samtliga `scoreB`) som tagits.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    SUM(scoreA) + SUM(scoreB) AS "Total"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Ta nu reda på om några matcher inte blev färdigspelade, eller om några delmatcher blev oavgjorda. Vid oavgjord match får inget lag poäng.

Gör detta genom att räkna ut det totala antalet möjliga poäng (20 x antalet matcher) och minska med de poäng som tagits i matcherna (samtliga `scoreA` + samtliga `scoreB`).

Du får fram en siffra ("Total"), som säger hur många delmatcher som inte spelades eller blev oavgjorda.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    COUNT(scoreA) * 20 - SUM(scoreA) - SUM(scoreB) AS "Total"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Skriv en SELECT sats som endast visar de matcher där `scoreA + scoreB` inte blir 20.

Ta med kolumnerna "Omgång", "Hemmalag", "Bortalag", "Poäng hemma", "Poäng borta" samt "Total" som är totalt antal poäng för matchen.

Rapporten du får fram bör du kunna jämföra med siffran i föregående uppgift och se kopplingen.

Som databasmänniska vill man ibland plocka fram samma information på olika sätt för att jämföra att det känns logiskt och korrekt.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    name AS "Omgång",
    teamA AS "Hemmalag",
    teamB AS "Bortalag",
    scoreA AS "Poäng hemma",
    scoreB AS "Poäng borta",
    scoreA + scoreB AS "Total"
FROM Games
WHERE
    scoreA + scoreB != 20
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Inbyggda funktioner",

"intro" => <<<EOD
Databaser har inbyggda funktioner som hjälper oss att förbereda rapporterna. Det finns inbyggda funktioner för stränghantering, datum och andra bra att ha funktioner.

Låt oss använda några av de inbyggda funktionera.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Visa de matcher som spelades i matchserien "Semifinal A". För varje match visa "Hemmalag", "Bortalag" samt en sammanslagen kolumn som visar "scoreA - scoreB" i formen "12 - 8". Lös det genom att skapa en sträng via strängkonkatenering.

I SQLite är `||` operatorn för strängkonkatenering. Döp kolumnen till "Total".

Lägg till ytterligare en kolumn som du döper till "Diff" som visar differensen mellan `scoreA` och `scoreB`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    teamA as "Hemmalag",
    teamB AS "Bortalag",
    scoreA || " - " || scoreB AS "Total",
    scoreA - scoreB AS "Diff"
FROM Games
WHERE
    name = "Semifinal A"
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Rapporter",

"intro" => <<<EOD
Med aningen mer avancerad SQL kan man skapa rapporter direkt från informationen i databasen. Kanske trodde man att det behövdes extra programmeringsstöd, men se när vi nu skapar en resultattabell för matcherna.

I varje match tävlar man om 20 poäng, den som har flest vinner matchen och får 2 matchpoäng. Vid lika delar man 1 matchpoäng per lag.

Du kan skapa IF-satser med [SQLites CASE konstruktion](http://www.sqlite.org/lang_expr.html#case).

Vår mål är att skapa en tabell som ser ut ungefär så här.

| Lag | S | V | O | F | TOTAL | D | P |
|-----|---|---|---|---|-------|---|---|
| Team Clan BK | 3 | 2 | 0 | 1 | 29 - 29 | 0 | 4 |
| Team Pergamon BC | 3 | 1 | 0 | 2 | 29 - 29 | 0 | 2 |

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Skapa en rapport som visar varje match med tidpunkt ("Tid"), teamA ("Hemmalag"), teamB ("Bortalag") samt en sträng om vem som vann. "Lag A", "Lag B" eller "Lika".

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    start AS "Tid",
    teamA AS "Hemmalag",
    teamB AS "Bortalag",
    CASE WHEN scoreA > scoreB THEN "Lag A"
        WHEN scoreA = scoreB THEN "Lika"
        ELSE "Lag B"
        END
        AS "Vinnare"
    
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Det fanns inga matcher som var lika, men låt oss ändra det. Skriv en `UPDATE` sats som ändrar matchen som spelades "2016-04-08 20:20" så att ställningen blev 10-10. Gör samma sak för matchen som spelades "2016-04-09 09:00". Använd endast en `UPDATE` sats för att göra båda ändringarna (tips `IN`).

Skapa en matchlista som består av `name` ("Omgång"), `teamA` ("Lag") och "Poäng" där poäng är 2 om `teamA` vann matchen, 1 om matchen var lika och 0 vid förlorad match.

Vi vill alltså bara se matcher som `teamA` spelat. Till att börja med.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
UPDATE Games SET
    scoreA = 10,
    scoreB = 10
WHERE
    start IN (
        "2016-04-08 20:20",
        "2016-04-09 09:00"
    )
;
SELECT 
    name AS "Omgång",
    teamA AS "Lag",
    CASE WHEN scoreA > scoreB THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],




/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Skapa en exakt likadan matchlista för bortalaget `teamB`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT 
    name AS "Omgång",
    teamB AS "Lag",
    CASE WHEN scoreB > scoreA THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Slå samman resultaten från de båda matchlistorna (1, 2) med `UNION ALL` (3) så att det blir en gemensam lista.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    name AS "Omgång",
    teamA AS "Lag",
    CASE WHEN scoreA > scoreB THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games

UNION ALL

SELECT 
    name AS "Omgång",
    teamB AS "Lag",
    CASE WHEN scoreB > scoreA THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;
EOD;
    return execute("$sqlite '$sql'");
},

],





/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * New section of exercises.
 */
[
"title" => "Vyer",

"intro" => <<<EOD
Vyer är som tabeller. Man kan skapa vyer från andra rapporter, som `UNION ALL` satsen vi precis såg. Det gör det enklare att jobba med SQL-frågor som blir allt större, vi kan helt enkelt dela in dem i vyer. Tips `CREATE VIEW`.

EOD
,

"shuffle" => false,

"questions" => [



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Skapa en vy `GameList` från SQL-satsen med `UNION ALL`.

Svara med `SELECT * FROM GameList`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
CREATE VIEW GameList AS
SELECT
    name AS "Omgång",
    teamA AS "Lag",
    CASE WHEN scoreA > scoreB THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games

UNION ALL

SELECT 
    name AS "Omgång",
    teamB AS "Lag",
    CASE WHEN scoreB > scoreA THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;
SELECT * FROM GameList;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Då gör vi rapporten för matchtabellen. Börja med att lägga till så rapporten innehållar "Lag", "Spelade" som antal matcher spelade, "Poäng" som totalt antal poäng samlade via vunna eller oavgjorda matcher. Sortera per "Poäng" i sjunkande ordning.

Plocka endast ut de lag som spelar "Final"-matchen.

Använd din vy `GameList`. Tips `GROUP BY`.

EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    Lag,
    COUNT(Lag) AS "Spelade",
    SUM(Poäng) AS "Poäng"
FROM 
    GameList
WHERE
    Omgång = "Final"
GROUP BY Lag
ORDER BY Poäng DESC
;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Bygg vidare på rapporten för matchtabellen. Lägg till "Total" och "Diff", så som det visas i exemplet här under.

| Lag | Spelade | V | O | F | Total | Diff | Poäng |
|-----|:---:|:---:|:---:|:---:|:-------:|:---:|:---:|
| Team Clan BK | 3 | 2 | 0 | 1 | 29 - 29 | 0 | 4 |
| Team Pergamon BC | 3 | 1 | 0 | 2 | 29 - 29 | 0 | 2 |

Du skall nu ha en tabell som innehåller "Lag", "Spelade", "Total", "Diff", "Poäng".

Tips. Skapa en ny vy GameListNew som innehåller den informationen du behöver.
 
EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
CREATE VIEW GameListNew AS
SELECT
    name AS "Omgång",
    teamA AS "Lag",
    scoreA AS "SerierVunna",
    scoreB AS "SerierFörlorade",
    CASE WHEN scoreA > scoreB THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games

UNION ALL

SELECT 
    name AS "Omgång",
    teamB AS "Lag",
    scoreB AS "SerierVunna",
    scoreA AS "SerierFörlorade",
    CASE WHEN scoreB > scoreA THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;

SELECT
    Lag,
    COUNT(Lag) AS "Spelade",
    SUM(serierVunna) || " - " || SUM(serierFörlorade) AS "Total",
    SUM(serierVunna) - SUM(serierFörlorade) AS "Diff",
    SUM(Poäng) AS "Poäng"
FROM 
    GameListNew
WHERE
    Omgång = "Final"
GROUP BY Lag
ORDER BY Poäng DESC
;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Pröva nu samma rapport på matchserien "Semifinal A". Om matchpoängen är lika så använder man "Diff" för att välja ut den som vinner.
 
EOD
,

"points" => 1,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    Lag,
    COUNT(Lag) AS "Spelade",
    SUM(serierVunna) || " - " || SUM(serierFörlorade) AS "Total",
    SUM(serierVunna) - SUM(serierFörlorade) AS "Diff",
    SUM(Poäng) AS "Poäng"
FROM 
    GameListNew
WHERE
    Omgång = "Semifinal A"
GROUP BY Lag
ORDER BY Poäng DESC, DIFF DESC
;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Bygg färdigt rapporten för matchtabellen. Lägg till "Vunna", "Oavgjorda" och "Förlorade", så som det visas i exemplet här under.

| Lag | Spelade | Vunna | Oavgjorda | Förlorade | Total | Diff | Poäng |
|-----|:---:|:---:|:---:|:---:|:-------:|:---:|:---:|
| Team Clan BK | 3 | 2 | 0 | 1 | 29 - 29 | 0 | 4 |
| Team Pergamon BC | 3 | 1 | 0 | 2 | 29 - 29 | 0 | 2 |

Du skall nu ha en tabell som motsvarar tabellen ovan.

Tips. Skapa en ny vy GameListComplete som innehåller den informationen du behöver.
 
EOD
,

"points" => 5,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
CREATE VIEW GameListComplete AS
SELECT
    name AS "Omgång",
    teamA AS "Lag",
    CASE WHEN scoreA > scoreB THEN 1
        ELSE 0
        END
        AS "Vunna",
    CASE WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Oavgjorda",
    CASE WHEN scoreA < scoreB THEN 1
        ELSE 0
        END
        AS "Förlorade",
    scoreA AS "SerierVunna",
    scoreB AS "SerierFörlorade",
    CASE WHEN scoreA > scoreB THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games

UNION ALL

SELECT 
    name AS "Omgång",
    teamB AS "Lag",
    CASE WHEN scoreA < scoreB THEN 1
        ELSE 0
        END
        AS "Vunna",
    CASE WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Oavgjorda",
    CASE WHEN scoreA > scoreB THEN 1
        ELSE 0
        END
        AS "Förlorade",
    scoreB AS "SerierVunna",
    scoreA AS "SerierFörlorade",
    CASE WHEN scoreB > scoreA THEN 2
        WHEN scoreA = scoreB THEN 1
        ELSE 0
        END
        AS "Poäng"
FROM Games
;

SELECT
    Lag,
    COUNT(Lag) AS "Spelade",
    SUM(Vunna) AS "Vunna",
    SUM(Oavgjorda) AS "Oavgjorda",
    SUM(Förlorade) AS "Förlorade",
    SUM(serierVunna) || " - " || SUM(serierFörlorade) AS "Total",
    SUM(serierVunna) - SUM(serierFörlorade) AS "Diff",
    SUM(Poäng) AS "Poäng"
FROM 
    GameListComplete
WHERE
    Omgång = "Final"
GROUP BY Lag
ORDER BY Poäng DESC
;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * A question.
 */
[

"text" => <<<EOD
Kontrollera att din sista matchrapport även fungerar på matchserien "Semifinal B".
 
EOD
,

"points" => 5,

"answer" => function () use ($sqlite) {
    $sql = <<<EOD
SELECT
    Lag,
    COUNT(Lag) AS "Spelade",
    SUM(Vunna) AS "Vunna",
    SUM(Oavgjorda) AS "Oavgjorda",
    SUM(Förlorade) AS "Förlorade",
    SUM(serierVunna) || " - " || SUM(serierFörlorade) AS "Total",
    SUM(serierVunna) - SUM(serierFörlorade) AS "Diff",
    SUM(Poäng) AS "Poäng"
FROM 
    GameListComplete
WHERE
    Omgång = "Semifinal B"
GROUP BY Lag
ORDER BY Poäng DESC, Diff DESC
;

EOD;
    return execute("$sqlite '$sql'");
},

],



/** ---------------------------------------------------------------------------
 * Closing up this section.
 */
], // EOF questions
], // EOF section



/** ===========================================================================
 * Closing up all sections.
 */
] // EOF sections



/**
 * Closing up this lab.
 */
]; // EOF the entire lab
