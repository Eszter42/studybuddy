# StudyBuddy

A **StudyBuddy** egy (nem kizárólag) tanulásban segédkező webapplikáció, ami a személyes feladatmenedzsment könnyebbé tételét célozza meg.

## Futtatás első alkalommal
### Előfeltételek
- **Php**
	> Ellenőrizhető a `php -v ` paranccsal, ha nincs, telepítsd a
[XAMPP-ot](https://sourceforge.net/projects/xampp/files/)
- **Composer**
	> Ellenőrizhető a `composer -v` paranccsal, ha nincs, telepítsd: [Composer](https://getcomposer.org/download/) 
- **Node.js és npm**
	>Ellenőrizhető a `node -v` és `npm -v parancsokkal`, ha nincs, vagy elavult a verzió, telepítsd a [Node.js-t](https://nodejs.org/en/download)

Ha ezek megvannak, további konfigurációk, amik **szükségesek lehetnek**:

- Nyisd meg: C:\xampp\php\php.ini
	> Keresd meg a ;extension=zip sort és töröld ki a pontosvesszőt előle
- Nyisd meg a PowerShellt rendszergazdaként és `Set-ExecutionPolicy RemoteSigned`
	> Kérdésére írd, hogy "y"

**Ezután:**

- Készíts egy .env fájlt a projekt mappájában: `copy .env.example .env`
	> Kommentáld ki a DB_ sorokat és állítsd a DB_CONNECTIONt mysql-re, adj neki nevet (study_buddy). (DB_DATABASE sor), esetleg az APP_NAME-et is írd át Laravelről StudyBuddyra

	>hozz létre egy új mysql adatbázist studdybuddy néven

- Továbbra is a projekt mappájában végzendő parancsok:
	> - `composer install`, 
	>- `npm install`,
	 >- `php artisan key:generate`, 
	 >- `php artisan migrate`
	 >- `php artisan db:seed`
 
**Végül:**

- **Futtasd:**
	>- `npm run dev`,
	>- `php artisan serve`

## Futtatás
Indítsd el XAMPP-on a MySQL-t, futtasd a projekt mappájában ezeket a parancsokat:
- `npm run dev`,
- `php artisan serve`

## Tesztadatok
Tesztadatok elérhetőek a `test@example.com` emaillel és test1234 jelszóval való bejelentkezéssel. A DatabaseSeeder.php-ból.

## Funkciók

- **Regisztráció, bejelentkezés**
	> Laravel authenticationon alapul, minden szükséges funkció megtalálható, csak formátumnak megfelelő e-mail címet fogad el, a jelszót meg kell ismételni, hogy az egyezzen az elsőször bevittel és meg kell felelnie adott követelményeknek (például hossz), emellett egy tetszőleges nevet is meg kell adni. Ezek a regisztrációnál bekért adatok ezután eltárolódnak az adatbázisban és használatukkal lehetségessé válik a bejelentkezés. Csak bejelentkezve hozzáférhető a webalkalmazás. Ki is lehet jelentkezni. A belépési pont alapértelmezetten a login, emellett viszont a /register is elérhető, ha fiókot akarsz készíteni.
- **Dashboard**
	>  A címsorban látható az aktuális idő percre pontosan. Az alatta lévő blokk carousel formában mutatja az adatokat. Első a közelgő feladatok, ami a három legkorábbi (még nem kész státuszú) időponttal bíró feladatot mutatja. Második a magas prioritású feladatok, ami véletlenszerű három feladatot mutat amiknek a prioritása magas és még nincs készen. Harmadik a véletlenszerű feladat, ami gombnyomásra kisorsol egy random feladatot, ha a használónak esetleg nehezére esne a választás. Negyedik a kész feladatok. Ezután a carousel visszaugrik az első lapra. Az alatta látható pontokkal a felhasználó kedvére navigálhat a lapok közt.
- **Tasks**
	> A Tasks nevezetű oldal alkalmas a feladatok felvevésére a tetején lévő + New gombra való kattintással. A kért adatok bevitele és a create gombra kattintás után a feladat belekerül az adatbázisba. Az Ongoing Tasks listán a feladatok határidő szerint vannak rendezve. A feladatok kereshetőek amennyiben a Serach nevű mezőbe beleírsz és rányomsz a Filter gombra. A keresés mind a feladat címét, mind a leírását figyelembe veszi. Szűkíthető prioritás szerint is és visszaállítható eredeti állapotába a Reset gombra kattintással. Egy feladat címére kattintva megtekinthetőek a részletek, valamint kihúzhatóak a subtaskok vagy hozzáadhatóak új subtaskok. Ha az Edit gombra kattintasz  szerkeszthetőek a feladat adatai, ha a Delete-re tölöhető a feladat. Minden feladat alatt van egy csík ami a subtaskok készenléti arányát mutatja. Ha a feladat elején lévő négyzet kipipálásra kerül, a feladat státusza megváltozik készre és átkerül a Completed Tasks listába.
- **Subjects**
	> Fel tudsz venni tantárgyakat, tanárral együtt ezek a tantárgyak eltárolódnak az adatbázisban, mint a feladatok, vagy a bejelentkezési adatok és feladat hozzáadásánál listájuk választhatóvá válik.

## Tesztek, eredmények, és azok dokumentációja

A tesztek a Tests mappán belül a Feature mappában találhatóak, a tesztek eredményei, pedig a `php artisan test` paranccsal megtekinthetőek. Lefuttatására az eredmény 23 sikeres és 5 átugrott teszt lesz. Ami át lett ugorva, az még nem teljeskörűen implementált funkció, tehát nem tesztelhető.

- Az Auth mappa tesztjei:
**AuthenticationTest.php** fájl

	>- test_login_screen_can_be_rendered
meghívja a `/login` oldalt és
    ellenőrzi, hogy 200 OK választ ad-e.
    
    >- test_users_can_authenticate_using_the_login_screen létrehoz egy teszt felhasználót, POST kéréssel bejelentkezik. Ellenőrzi a felhasználó be lett-e jelentkeztetve, átirányít-e a dashboardra.
    
    >- test_users_can_not_authenticate_with_invalid_password létrehoz felhasználót, rossz jelszóval próbál loginolni, ellenőrzi, hogy nem lesz bejelentkezve
    
    >- test_users_can_logout bejelentkezteti a usert , meghívja a `/logout` route-ot. Ellenőrzi kijelentkeztet-e, 
        visszairányít-e a kezdőoldalra (`/`)
     
	 **EmailVerificationTest.php** fájl

	>- test_email_verification_screen_can_be_rendered létrehoz egy nem hitelesített teszt felhasználót,  
meghívja a `/verify-email` oldalt bejelentkezett állapotban  
és ellenőrzi, hogy az oldal 200 OK választ ad-e.

	>- test_email_can_be_verified létrehoz egy nem hitelesített felhasználót, generál egy ideiglenes hitelesítési linket, megnyitja azt bejelentkezve ellenőrzi, hogy a Verified esemény lefutott-e, hogy a felhasználó e-mail címe hitelesített állapotba került-e, hogy a rendszer dashboardra irányít-e verified=1 paraméterrel.
	
	>- test_email_is_not_verified_with_invalid_hash létrehoz egy nem hitelesített felhasználót,  hibás hash-sel generál hitelesítési linket, megnyitja azt, ellenőrzi, hogy a felhasználó e-mail címe nem kerül hitelesítésre.

	**PasswordConfirmationTest.php** fájl

	> -   test_confirm_password_screen_can_be_rendered** létrehoz egy teszt felhasználót,  bejelentkezett állapotban meghívja a `/confirm-password` oldalt  és ellenőrzi, hogy az oldal 200 OK választ ad-e.
	
	> -   test_password_can_be_confirmed létrehoz egy teszt felhasználót, POST kéréssel elküldi a helyes jelszót a jelszó megerősítő route-ra, ellenőrzi, hogy a rendszer átirányít-e és nem keletkezik session hiba.

	> -   test_password_is_not_confirmed_with_invalid_password létrehoz egy teszt felhasználót,  POST kéréssel hibás jelszót küld,  ellenőrzi, hogy a rendszer session hibát jelez és a megerősítés nem történik meg.

	**PasswordResetTest.php** fájl

	> -   test_reset_password_link_screen_can_be_rendered meghívja a `/forgot-password` oldalt és ellenőrzi, hogy 200 OK választ ad-e.  

	> -   test_reset_password_link_can_be_requested létrehoz egy teszt felhasználót, POST kéréssel jelszó-visszaállítási linket kér az e-mail címére, ellenőrzi, hogy a rendszer ResetPassword értesítést küld-e a felhasználónak.

	> -   test_reset_password_screen_can_be_rendered létrehoz egy teszt felhasználót, jelszó-visszaállítási link kérés után megnyitja a tokennel generált  `/reset-password/{token}` oldalt, ellenőrzi, hogy az oldal 200 OK választ ad-e.

	> -   test_password_can_be_reset_with_valid_token létrehoz egy teszt felhasználót,  jelszó-visszaállítási link kérés után POST kéréssel új jelszót állít be érvényes tokennel,  ellenőrzi, hogy nem keletkezik session hiba és a rendszer a login oldalra irányít.
	
	**PasswordUpdateTest.php** fájl

	> -   test_password_can_be_updated létrehoz egy teszt felhasználót, bejelentkezve PUT kéréssel új jelszót állít be a `/password` route-on. Ellenőrzi, hogy nem keletkezik session hiba, visszairányít-e a profil oldalra, valamint hogy a jelszó ténylegesen frissült-e az adatbázisban.

	> -   test_correct_password_must_be_provided_to_update_password létrehoz egy teszt felhasználót, bejelentkezve hibás jelenlegi jelszóval próbál jelszót módosítani. Ellenőrzi, hogy a rendszer hibát jelez és visszairányít a profil oldalra.

	**RegistrationTest.php** fájl

	> -   test_registration_screen_can_be_rendered meghívja a `/register` oldalt és ellenőrzi, hogy 200 OK választ ad-e.

	> -   test_new_users_can_register POST kéréssel új felhasználót regisztrál megadott adatokkal. Ellenőrzi, hogy a felhasználó be lett-e jelentkeztetve és átirányít-e a dashboardra.
	
- Feature mappában található tesztek:
	**ApiSubjectCrudTest.php** fájl

	> -   test_authenticated_user_can_create_subject létrehoz egy teszt felhasználót, bejelentkezve POST kéréssel új tantárgyat hoz létre a subjects.store route-on. Ellenőrzi, hogy a kérés után átirányítás történik-e, valamint hogy a tantárgy adatai bekerültek-e az adatbázisba.
	
	**ApiTaskAuthorizationTest.php** fájl

	> -   test_guest_cannot_access_tasks bejelentkezés nélkül meghívja a `/tasks` oldalt. Ellenőrzi, hogy a rendszer átirányít-e a bejelentkezési oldalra
	
	**ApiTaskFilterTest.php** fájl

	> -   test_user_can_filter_tasks_by_status létrehoz egy teszt felhasználót, majd két különböző prioritású feladatot hoz létre hozzá. Bejelentkezve meghívja a `/tasks?priority=high` oldalt és ellenőrzi, hogy csak a megfelelő státuszú feladat jelenik meg, a másik nem.

	**ExampleTest.php** fájl

	> -   test_the_application_returns_a_successful_response meghívja a `/` kezdőoldalt és ellenőrzi, hogy a rendszer átirányít-e a bejelentkezési oldalra (`/login`).

	**ProfileTest.php** fájl
	(a tesztosztály inicializálásakor minden teszt kihagyásra kerül, mivel a profil funkció implementációja még nem készült el)

	> -   test_profile_page_is_displayed létrehoz egy teszt felhasználót, bejelentkezve meghívja a `/profile` oldalt és ellenőrzi, hogy az oldal sikeres választ ad-e.

	> -   test_profile_information_can_be_updated létrehoz egy teszt felhasználót, bejelentkezve módosítja a profil adatait. Ellenőrzi, hogy nem keletkezik session hiba, visszairányít-e a profil oldalra, valamint hogy az adatok frissültek-e az adatbázisban.
	
	> - test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged létrehoz egy teszt felhasználót, bejelentkezve úgy módosítja a profil adatokat, hogy az e-mail cím változatlan marad. Ellenőrzi, hogy az e-mail hitelesítési állapot nem változik.

	> -   test_user_can_delete_their_account létrehoz egy teszt felhasználót, bejelentkezve törli a fiókját helyes jelszó megadásával. Ellenőrzi, hogy nem keletkezik session hiba, visszairányít-e a kezdőoldalra, valamint hogy a felhasználó törlésre került-e.


	> -   test_correct_password_must_be_provided_to_delete_account létrehoz egy teszt felhasználót, bejelentkezve hibás jelszóval próbálja törölni a fiókot. Ellenőrzi, hogy a rendszer hibát jelez és a felhasználó nem kerül törlésre.
