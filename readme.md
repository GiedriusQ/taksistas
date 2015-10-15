# Taksistų valdymo sistema

Sistema naudos Laravel 5.1 karkasą, bootstrap ir jQuery.

Veiksmam su koordinatėmis bus naudojamas Google Maps ir Bing Maps API.


## Trys vartotojų lygiai:

1. Administratorius
  * Gali pridėti dispečerines ir vairuotojus.
  * Gali priskirti vairuotoją dispečerinei.
2. Dispečerinė
  * Įveda užsakymą nurodydama paėmimo adresą (deda tašką ant žemėlapio arba įveda adresą).
  * Priskiria užsakymą kažkuriam iš taksistų, pagal jų atstumus iki užsakymo vietos.
3. Taksistas
  * Gali nurodyti savo buvimo vietą HTML5 geolocation pagalba arba uždėti "tašką" ant žemėlapio kur jis dabar yra arba įvesti adresą.
  * Gali peržiūrėti maršrutą iki užsakymo vietos (jei yra užsakymų).
  * Gali pažymėti vykdomam užsakymui galutinį tašką (kur reikia nuvežti žmogų).
  * Gali pažymėti užsakymą kaip įvykdytą.