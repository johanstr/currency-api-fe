# Currency API Version 1.0
Deze API is bedoeld voor Front-end Developers. Het betreft een basic API, die geschreven is in vanilla PHP.
  
## Installatie
### STAP 1
Maak een aparte map voor de API aan, bij voorkeur in de rootmap van je lokale webserver (**htdocs** of **www** bijvoorbeeld). Ga dan vervolgense de code binnenhalen via de onderstaande terminal opdracht (zorg er wel voor dat je in de map zelf staat):  
  
```bash
git clone https://github.com/johanstr/currency-api-fe.git .
```  
  
### STAP 2
Nadat je deze code hebt binnengehaald dien je nog wel een aantal stappen uit te voeren alvorens je de API kunt gebruiken in je Front-end App.  
  
Tik in de map waar je de code hebt binnengehaald de volgende terminal opdracht in:  
  
```bash
composer install
```
  
### STAP 3
Maak de database aan en importeer het bestand: ***currency-db.sql***  
  
### STAP 4
Pas de credentials aan in het bestand **app\Database\Database.php** en vervang daar de database naam, de username en de password voor toegang tot de database.  
  
## Aanroepen van de API
Je roept in JavaScript de API aan met de URL op jouw computer, bijvoorbeeld:  
```
http://localhost/currency-api/?cmd={client|currencies|wallet|buy|sell}[&client_id=1]
```  
Hierin is het toevoegen van de *client_id* afhankelijk van de command.  
Voor *cmd* geldt dat één van 5 genoemde opties mogelijk is.  
  

## Functionaliteit van de API  
### [GET] http://localhost/currency-api/?cmd=clients  
Levert alle clients in de database op.  
  
### [GET] http://localhost/currency-api/?cmd=currencies
Levert alle valuta in de database op.  
  
### [GET] http://localhost/currency-api/?cmd=wallet&client_id=1  
Levert de wallet op van de client met ID 1.  
  
### [POST] http://localhost/currency-api/?cmd=buy
Benodigde **FORM DATA** is *currency_id*, *client_id*, *amount*.
Aan de wallet wordt een nieuwe aankoop van valuta toegevoegd.  
  
### [POST] http://localhost/currency-api/?cmd=sell  
Benodigde **FORM DATA** is *wallet_id* en *currency_id*.
Een valuta in de wallet wordt verkocht en derhalve uit de wallet verwijdert.  
  
**FORM DATA** is in JavaScript een Object welke je dan kunt vullen met velden en waarden, bijvoorbeeld:  
  
```js
let myform = new FormData();

myform.append('client_id', 1);
```  
Door het op deze manier te doen kun je met een fetch heel gemakkelijk dit object meegeven aan de call. Het werkt dan alsof een formulier is ingevuld en op de submit knop is gedrukt. Dit zorgt er tevens voor dat de data ook op eenzelfde manier als bij een formulier in PHP binnenkomt. Je hoeft ook geen header met Content-Type aan je fetch mee te geven, daar zorgt FormData zelf voor dan.