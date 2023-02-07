
- zárt felület, mondjuk csak @eclick.hu e-mail címmel lehessen regisztrálni
- egyszerű jogosultsági rendszer: menedzser vagy dolgozó
- dolgozó CRUD - alapadatokkal: név, email cím, beosztás, hány szabadnapja van
- a dolgozó tud kérvényezni szabadságot amit a menedzser jóváhagyja, erről jön e-mail
- a menedzser tudjon felvinni jóváhagyás nélkül is egyébként két féle tipus létezik betegség vagy normál szabi
- calendar nézet szuper lenne, nincs preferencia kíváncsiak vagyunk mit hozol ötletnek
- ha gondolod és marad rá idő akkor HO jelző egy hétre előre mondjuk - egyáltlaán nem kötelező
- UI rád van bízva, annyit tegyél bele ami nem okoz gondot

Gondolatok amik eszembe jutottak:
- még elérhető szabadnapok számítása a request leadásánál
- ha medical a leave, akkor ne lehessen elfogadni, mert az inkább bejelentés, mint választási lehetőség a munkáltatónak
- lehessen elutasítani a szabadságot, hogy ne foglalja a helyet az elfogadó nézetben, esetleg ekkor is értesítsen e-mailben
  - ehhez felvennék mégegy mezőt a leaves táblára, ami tárolja a rejected nevű mezőn ezt az értéket
  - ha rejected az érték, akkor nem jelenik meg, illetve elutasításkor a dolgozó kap egy e-mailt
  - elutasító gombot (formmal) helyeznék el a manage leaves oldalra
  - hozzáadnék egy új route-t és controller függvényt
- manager által felvitt szabadság:
  - választhatna, hogy szeretné e elfogadott állapotban felvinni
- ha már el lett fogadva, akkor lehessen visszavonni az elfogadást, erről is küldjön értesítést