# StudyBuddy

A **StudyBuddy** egy (nem kizárólag) tanulásban segédkező webapplikáció, ami a feladatmenedzsment könnyebbé tevését célozza meg.

## Futtatás első alkalommal
Előfeltételek
- Php
	> Ellenőrizhető a ` php -v ` paranccsal, ha nincs, telepítsd a
[XAMPP-ot](https://sourceforge.net/projects/xampp/files/)
- Composer
	> Ellenőrizhető a `composer -v` paranccsal, ha nincs, telepítsd: [Composer](https://getcomposer.org/download/) 
- Node.js és npm
	>Ellenőrizhető a `node -v` és `npm -v parancsokkal`, ha nincs, vagy elavult a verzió, telepítsd a [Node.js-t](https://nodejs.org/en/download)

Ha ezek megvannak, további konfigurációk, amik szükségesek lehetnek:

- Nyisd meg: C:\xampp\php\php.ini
	> Keresd meg a ;extension=zip sort és töröld ki a pontosvesszőt előle
- Nyisd meg a PowerShellt rendszergazdaként és `Set-ExecutionPolicy RemoteSigned`
	> Kérdésére mondd, hogy "y"

Ezután:

- Kreálj egy .env fájlt a projekt mappájában (`copy .env.example .env`)
	> Kommentáld ki a DB_ sorokat és állítsd a DB_CONNECTIONt mysql-re, adj neki nevet. (DB_DATABASE sor)

- Továbbra is a projekt mappájában végzendő parancsok:
	> `composer install`, 
	`npm install`,
	 `php artisan key:generate`, 
	 `php artisan migrate`
 
Végül:

- Futtasd:
	>`npm run dev`,
	`php artisan serve`




## Funkciók

- Regisztráció, bejelentkezés
	> Laravel authenticationon alapulván, minden funkció megtalálható, csak formátumnak megfelelő e-mail címet fogad el, a jelszót el kell ismételni korrektül és meg kell felelnie adott követelményeknek (pl.: hossz), emellett egy tetszőleges nevet is meg lehet adni. Ezek, a regisztrációnál bekért adatok ezután eltárolódnak az adatbázisban és használatukkal lehetségessé válik a bejelentkezés. Csak bejelentkezve hozzáférhető a webalkalmazás. Ki is lehet jelentkezni.
- Dashboard
	>  Az első a sorban összegzi a felvett adatokat, feladatokat. Amennyiben nincs felvett feladat, kiírja "Nincs közelgő feladat". A feladatok egyébként határidejük szerint vannak rendezve, mai dátumhoz való közelségük alapján.
- Tasks
	> A Tasks nevezetű tab alkalmas a feladatok felvevésére. Itt a feladatok csupán a felvevésük sorrendjében rendeződnek, viszont van egy keresési, vagy szűrési funkció. Ha beléírsz ebbe a mezőbe mind a feladat címében, mind a leírásában keresni fog, emellett leszűkíthető státusz szerint is, mely feladatokat mutassa. Mindezz visszaállítható eredeti állapotába, a reset gombra kattintással.  A feladatok és részleteik mind megtekinthetőek, szerkeszthetőek és törölhetőek. Új feladat is felvehető. Subtaskok, amikkel kisebb részekbe oszthatod a nagyobb feladatokat, vagy a szerkesztés, vagy megtekintés folyamatán vehetőek fel. Feladatcímen kívül egyébként gyorsaság érdekében minden mást opcionális megadni.
- Subjects
	> Fel tudsz venni tantárgyakat, tanárral ezek a tantárgyak szintúgy eltárolódnak az adaatbázisban, mint a feladatok, vagy a bejelentkezési adatok és feladat hozzáadásánál listájuk választhatóvá válik.
- Profil
	> Ki lehet jelentkezni, vagy innen is visszanavigálni a dashboardra.

