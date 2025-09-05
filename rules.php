<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

$db_theend = new DataBase_theend;
$db_theend->connect();

$site_language=site_language();
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="description" content="Massive multiplayer online game. Adventure game. Browser based. Joc de strategie online." />
  <meta name="keywords" content="massive, multiplayer, free, online, game, mmorpg, strategie, razboi, war" />
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
  <title>End of us - massive multiplayer online game (joc online de strategie)</title>
  <script language="JavaScript" type="text/javascript" src="functions.js"></script>
</head>
<body>
<body>

  <table class="page_format" cellspacing="0" cellpadding="0">
    <tr>
      <td class="header_td" colspan="3">
        <?php top(); ?>
      </td>
    </tr>
    <tr>
      <td class="left_td">
        <div class="menu_bg">
        <?php main_menu("rules"); ?>
        <?php game_menu(); ?>
        </div>
        <div class="left_box_white_spacer"></div>
        <br />
        <?php ad_left(); ?>
      </td>
      <td class="center_td">
        <object type="application/x-shockwave-flash" data="pics/clouds.swf" width="640" height="144">
        <param name="movie" value="pics/clouds.swf" />
        <param name="BGCOLOR" value="#000000" />
        <a title="You must install the Flash Plugin for your Browser in order to view this movie"  href="http://www.macromedia.com/shockwave/download/alternates/"><img src="needplugin.gif" width="431" height="68" alt="placeholder for flash movie" /></a>
        </object>
        <div class="titlebar">MANUAL</div>
        <br />
        <div class="section">
		<div class="section_black">
		<div class="section_grey">   

		<div class="image1"><img class="avatar" src="pics/manual_img.jpg" alt=\"\" /></div> 
		<div class="text1">
<?php

  if($site_language=="ro")
  {
?>

<div style="margin: 10 px;" align="center">
<font color="#00FF00"><b>End of Us - Multiplayer Free Online Game</b></font>
<br>
<b>Manualul Jocului</b>
<br>
v. 1.7.1
</div>

<div style="margin: 10 px;" align="justify">
<b>Important:</b> <i>Toate aspectele jocului sunt imbunatatite in mod constant. Pot aparea mici diferente intre acest manual si joc. Pentru orice probleme sau nelamuriri va rugam consultati forumul nostru unde veti putea gasi ajutor.</i>
<br>
<font color="#909090"><b>Ultima actualizare: 17 februarie 2007</b></font>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="contents">Cuprins</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual" href="#i_the_basics">I. Generalitati</a>
<br>
<a class="manual" href="#ii_units">II. Unitati</a>
<br>
<a class="manual" href="#iii_turns">III. Ture</a>
<br>
<a class="manual" href="#iv_money">IV. Bani</a>
<br>
<a class="manual" href="#v_alliances">V. Aliante</a>
<br>
<a class="manual" href="#vi_battles">VI. Lupte</a>
<br>
<a class="manual" href="#vii_exp_rank">VII. Experienta & Clasamentul</a>
<br>
<a class="manual" href="#viii_intelligence">VIII. Inteligenta</a>
<br>
<a class="manual" href="#ix_upgrades">IX. Upgrade-uri</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="i_the_basics">I. Generalitati</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
End of Us este un joc online de strategie.
<br><br>
El este o combinatie de joc bazat pe ture cu unul in timp real. Un tur dureaza 20 de minute, la sfarsitul caruia este generat aur (in functie de productia de aur a fiecarui jucator) si fiecare jucator primeste 1 AP (Action Point = Punct de Actiune). Cu cateva exceptii, restul jocului se desfasoara in timp real (instantaneu).
<br><br>
Baza pentru productia de aur, pentru atac, aparare, spionaj si contra-spionaj sunt unitatile. Cu cat ai mai multe, cu atat mai bine ;-)
<br><br>
Numarul maxim de unitati ce pot fi cumparate de un jucator este dictat de experienta, nivel si upgrade-ul de pupulatie. Experienta se castiga in lupte. Cu cat ai mai multe puncte de experienta, cu atat vei putea cumpara mai multe unitati. Daca castigi destula experienta vei trece la un nivel superior. Upgrade-ul de pupulatie mareste numarul maxim de unitati ce pot fi cumparate de cineva cu 10% pentru fiecare nivel.
<br><br>
Aproape fiecare actiune din joc costa bani. Aurul poate fi obtinut de la muncitori/sclavi, din atacuri sau prin primirea de transferuri din seiful aliantei (daca faci parte dintr-o alianta).
<br><br>
Unitatile pot fi upgradate pentru a fi mai eficiente. Muncitorii pot profduce mai mult aur, spionii pot fi mai eficienti si unitatile combatante primesc un bonus la puterile de atac sau aparare.
<br><br>
In plus fata de bonusul de putere, unitatil combatante pot fi echipate cu arme. Armele devin mai puternice si mai eficiente din punct de vedere al costului cu fiecare upgrade cumparat.
<br><br>
Nivelul de precizie al armelor poate fi si el imbunatatit. Precizia afecteaza in mod direct puterile de atac sau aparare in lupte.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="ii_units">II. Unitatile</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Aceasta este una dintre conceptele cheie ale jocului. Unitatile pot produce aur, pot ataca inamicii, te pot apara de ei, pot spiona alti jucatori sau te pot apara de alti spioni.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Numarul Maxim de Unitati</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceste este numarul maxim de unitati la care poti ajunge prin cumpararea lor. Cand ai atins acest numar, poti sa iti maresti populatia numai prin capturarea altor unitati in lupte.
<br><br>
Acest numar este alcatuit din trei elemente: <i>nivel</i>, <i>puncte de experienta</i> si <i>upgrade de populatie</i>. Impreuna aceste elemente dau <i>Numarul Maxim de Unitati</i>.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Nivelul</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Fiecare nivel are asociat un numar maxim de unitati. Aceste numere sunt:
<br><br>
Nivel 0 -> 1.000 Unitati
<br>
Nivel 1 -> 2.000 Unitati
<br>
Nivel 2 -> 4.000 Unitati
<br>
Nivel 3 -> 8.000 Unitati
<br>
Nivel 4 -> 16.000 Unitati
<br>
Nivel 5 -> 32.000 Unitati
<br>
... si asa mai departe ...
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Punctele de experienta</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Pentru fiecare punct de experienta <i>Numarul Maxim de Unitati</i> creste cu 1.
<br><br>
Exemple:
<br>
Nivelul 0 cu 0 exp. -> 1.000 Unitati
<br>
Nivelul 0 cu 1 exp. -> 1.001 Unitati
<br>
Nivelul 0 cu 750 exp. -> 1.750 Unitati
<br>
Nivelul 2 cu 0 exp. -> 4.000 Unitati
<br>
Nivelul 2 cu 1 exp. -> 4.001 Unitati
<br>
Nivelul 2 cu 2.300 exp. -> 6.300 Unitati
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Upgrade-urile de populatie</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Fiecare upgrade cumparat mareste numarul maxim de unitati ce pot fi cumparate cu 10%.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Concluzie</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Numarul maxim de unitati este calculat in modul urmator:
<br><br>
([Nivel] + [Puncte de experienta]) * [Upgrade]
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Vei incepe jocul cu 10 unitati.</b></font>
<br>
Poti mari acest numar in doua moduri:
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Cuparare de unitati</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Poti cumpara unitati din sectiunea "Antrenare Unitati".
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Capturare de unitati in lupta</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Cand participi la o lupta si castigi poti captura o parte a unitatilor adversarului.
<br><br>
De fiecare date cand castigi o lupta, capturezi un procent din unitatile adversarului. Acest procent este calculat de o formula bazata pe diferenta de putere dintre tine si inamic. Cu cat va fi mai mare diferenta de putere, cu atat vei putea captura mai multe unitati. Daca procentul este prea mic, nu vei captura nici o unitate.
<br><br>
Prin aceasta metoda poti mari populatia dincolo de <i>Numarul Maxim de Unitati</i>.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Unitatile tale pot fi:</b></font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Unitati neantrenate</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceste unitati produc 1 unitate de aur pe tur. Ele participa in lupte (in atac sau in aparare) si pot folosi arme daca sunt disponibile. in lupta unitatile neantrenate au o putere de baza de 1.
</div>

<div style="margin: 10 px;" align="justify">
Daca este atacat si pierzi lupta, o parte din aceste unitati pot muri. Acelasi lucru se intampla atunci cand ataci pe cineva si pierzi.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Muncitori sau sclavi</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceste unitati vor produce aur. Un muncitor sau sclav produce 10 unitati de aur pe tur.
<br><br>
Poti totusi sa maresti productia de aur printr-un upgrade. Fiecare nivel de upgrade cumparat mareste productia de aur cu 10%.
<br><br>
Daca esti atacat si pierzi lupta, o parte din aceste unitati pot muri.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Contra-spioni</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceste unitati te apara de spionii inamici.
<br><br>
Poti afla mai multe detalii despre aceste unitati in capitolul "Inteligenta".
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. Spioni</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceste unitati pot fi trimise in misiune pentru a afla informatii despre puterile de atac sau aparare a inamicului sau despre unitatile acestuia. Aceste unitati sunt folositoare si pentru a vedea cantitatea de aur detinuta de inamic.
<br><br>
Poti afla mai multe detalii despre aceste unitati in capitolul "Inteligenta".
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>5. Unitati combatante</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acestea sunt unitatile standard folosite in lupte. Ele participa atat in atac cat si in aparare. In functie de tipul luptei, unitatile combatante pot folosi atat arme de aparare cat si arme de atac daca sunt disponibile. Unitatile combatante au o putere de baza de 5.
<br><br>
Daca ataci pe cineva si pirzi lupta, o parte din aceste uniati vor muri sau vor fi capturate. Acelasi lucru se intampla si atunci cand esti atacat si pierzi. Poti afla mai multe informatii despre lupte in capitolul dedicat acestora.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>6. Unitati de atac de elita</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acestea sunt unitati specializate care pot fi folosite doar in atac. Ele pot folosi numai arme de atac si au o putere de baza de 10. <font color="#FFA500">Aceste unitati nu pot fi dezantrenate!</font>
<br><br>
Pentru a antrena unitati de atac de elita trebuie sa antrenezi intai unitati combatante care pot fi apoi antrenate in unitati de atac de elita. Este un maxim din <b>numarul total de unitati combatante</b>* care pot fi antrenate in unitati de elita. Acest numar este dat de nivelul de upgrade al unitatilor de elita. Daca nu ai nici un nivel al acestui tip de upgrade nu poti antrena unitati de elita. Mai multe informatii pot fi gasite in sectiunea dedicata luptelor sau upgrade-urilor.
<br><br>
<font color="#909090">*<b>numarul total de unitati combatante</b> - unitati combatante + unitati de elita de atac + unitati de elita de aparare</font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>7. Unitati de aparare de elita</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acestea sunt unitati specializate care pot fi folosite doar in aparare. Ele pot folosi numai arme de aparare si au o putere de baza de 10. <font color="#FFA500">Aceste unitati nu pot fi dezantrenate!</font>
<br><br>
Pentru a antrena unitati de aparare de elita trebuie sa antrenezi intai unitati combatante care pot fi apoi antrenate in unitati de aparare de elita. Este un maxim din <b>numarul total de unitati combatante</b>* care pot fi antrenate in unitati de elita. Acest numar este dat de nivelul de upgrade al unitatilor de elita. Daca nu ai nici un nivel al acestui tip de upgrade nu poti antrena unitati de elita. Mai multe informatii pot fi gasite in sectiunea dedicata luptelor sau upgrade-urilor.
<br><br>
<font color="#909090">*<b>numarul total de unitati combatante</b> - unitati combatante + unitati de elita de atac + unitati de elita de aparare</font>
</div>

<div style="margin: 10 px;" align="justify">
Daca este necasar sa antrenezi mai multe unitati de un anumit tip si nu poti sa cumperi mai multe, poti dezantrena unitati de un anumit tip si sa le antrenezi ca altceva. De exemplu, daca ai nevoie de mai multe unitati combatante, poti dezntrena muncitori/sclavi. Unitatile dezantrenate devin unitati neantrenate care pot fi apoi antrenate in ce doresti. Retine faptul ca de fiecare data cand reantrenezi o unitate va trebui sa pletesti constul necesar acestei actiuni. Unitatile de elita nu pot fi dezantrenate.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Unitatile pot fi pierdute. Acest lucru se intampla in urmatoarele situatii:</b></font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Pierderea unei lupte</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Cand pierzi o lupta (in atac sau in aparare), o parte din unitatile tale pot muri sau pot fi capturate. Cu cat este mai mare diferenta dintre puterea castigatorului si puterea invinsului, cu atat mai multe unitati poate pierde cel invins.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Trimiterea de spioni in misiune</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Atunci cand sunt trimisi spioni in diverse misiuni exista sanse ca o parte din acestia sa moara. Pentru mai multe detalii puteti consulta capitolul dedicat spionajului.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Contra-spionii sunt omorati</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Contra-spionii pot fi omorati de spionii inamicului. De fiecare data cand cineva incearca sa te spioneze, o parte din contra-spioni pot muri. Pentru mai multe detalii consultati capitolul dedicat spionajului.
</div>

<div style="margin: 10 px;" align="justify">
Unitatile sunt baza dezvoltarii  in End of Us. Cu cat ai mai mule cu atat mai bine. Trebuie sa antrenezi unitatile cu grija astfel incat sa ai suficienti muncitori/scalvi pentru a produce aurul necesar, dar si suficiente unitati combatante sau de spionaj pentru a fi protejat de inamici. Nu uita ca trebuie sa si ataci pentru a castiga experienta si astfel evolua.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="iii_turns">III. Ture</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Productia de aur in End of Us are loc la fiecare tura. Toate trei rasele au turele de 20 de minute. 
<br><br>
La fiecare tura vei primi un AP (Action Point = punct de actiune). AP-urile sunt ultilizate atunci cand ataci inamici si determina durata luptei.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="iv_money">IV. Bani</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Aproape orice actiune in joc costa bani. Aurul este unul din cele mai importante aspecte ale jocului. Gestioneaza bine finantele si vei deveni puternic. Cheltuie fara noima si vei pierde raboiul.
<br><br>
Ai nevoie de bani pentru a cumpara unitati si arme, pentru a face upgrade-uri, pentru a antrena unitati si pentru a repara arme dupa o lupta. Toate costurile sunt la fel la toate rasele.
<br><br>
Cand incepi jocul primesti 20.000 aur depozitat in seif. Depinde de tine sa faci cat mai multe de acesti bani.
<br><br>
Sursa primara de aur in End of Us sunt muncitorii sau sclavii. O unitatte standard de acest tip produce 10 aur pe tur.
<br><br>
Daca vrei ca muncitorii sau sclavii sa fie mai productivi, ii poti upgrada. Odata cumparat upgradeul pentru venit muncitorii sau sclavii vor produce cu 10% mai mult aur la fiecare tur. Acest upgrade este destul de scump si nu ar trebui sa fie prima alegere in perioada de inceput a jocului. 
<br><br>
Poti castiga aur si cand ataci alti jucatori. Atunci cand ataci pe cineva si castigi, vei lua o parte din aurul celui invins. Cu cat puterea de atac este mai mare decat puterea de aparare a celui invins, cu atat mai mult aur vei lua de la el.
<br><br>
Aurul din seif nu poate fi furat.
<br><br>
Mai poti face rost de bani prin vinderea armelor atunci cand ai. Atentie: banii primiti pe arme reprezinta doar 80% din valoarea pe care ai platit-o pe ele la cumparare. Din acest motiv nu e o idee foarte buna sa vinzi decat in cazurile in care ai neaparata nevoie de bani sau atunci cand vrei sa inlocuiesti armele vechi cu unele noi.
<br><br>
Pentru a proteja aurul de atacatori poti sa-l pui in seif. Banii din seif nu pot fi furati. Capacitatea seifului este de 10.000.000 aur (10 milioane). Acesta poate fi upgradat.
<br><br>
Poti retrage bani depzitati in seif fara nici un fel de restrictii. Tine minte totusi ca nu poti depune bani in seif decat odata pe zi.
<br><br>
Daca spionii tai au o putere mult mai mare decat contra-spionii inamici, atunci poti vedea cat aur are celalalt jucator. Atentie! Nu poti afla cat aur este in seif si cat in afara lui. Acest lucru este important deoarece doar aurul aflat in afara seifului poate fi furat.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="v_alliances">V. Aliante</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
In End of us jucatorii se pot grupa in aliante. Acest fapt aduce o multime de avantaje: pe langa avantajul de a face parte dintr-o echipa, vei primi un bonus la puterea de atac si de aparare (bonus calculat in functie de puterea totala de atac sau aparare a aliantei), poti depune bani in seiful aliantei si poti participa in atacuri ale aliantei.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Lucrul in echipa</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Este mult mai usor sa cresti atunci cand lucrezi in echipa. Jucatorii pot schimba informatii, is pot oferi suport sau se pot apara unul pe celalalt de dusmani, etc. Ideea principala este ca oricine se va gandii de doua ori inainte de a ataca un jucator ce face parte dintr-o alianta. Pe de alta parte, daca colegii tai de echipa vor deranja pe cineva, este posibil ca intreaga alianta sa aiba de suferit.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Bonusuri</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Fiecare jucator primeste un anumit bonus la puterea de atac si de aparare in functie de pozitia ocupata in cadrul aliantei.
<br><br>
Comandantul primeste 1% din totalul puterii de atac sau de aparare a aliantei.
<br>
Ofiterii primesc un bonus de 0,8%.
<br>
Membrii normali primesc un bonus de 0,6% din puterea totala de atac sau de aparare.
<br><br>
Puterea totala a aliantei este egala cu suma puterilor membrilor aliantei.
<br><br>
<font color="#FFA500">Bonusul primit nu va fi mai mare de 50% din puterea proprie de atac sau de aparare chiar daca in urma calculelor ar trebui sa fie mai mare!</font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Membrii</b></font>
</div>

<div style="margin: 10 px;" align="justify">
O alianta poate avea maxim 10 mambrii. Acest numar poate fi marit cu cate 10 pana la un maxim de 50 facand un upgrade al aliantei.
<br><br>
O alianta are un singur comandant si un ofiter pentru fiecare 10 membrii. O alianta cu 5 membrii poate avea un singur ofiter, daca numarul membrilor creste la 11 atunci pot fi numiti doi ofiteri.
<br><br>
Comandantul poate promova membrii normali la gradul de ofiter dar ii poate si retrograda.
<br><br>
Ofiterii pot opera asupra seifului aliantei, pot accepta membrii noi in alianta sau da afara mebrii existenti. Numai comandantul poate retrograda ofiteri.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. Seiful aliantei</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Membrii pot depozita bani in seiful aliantei. Acesti bani pot fi transferati de catre comandant sau de catre ofiteri oricarui membru al aliantei. De obicei aurul din seif este folosit pentru upgrade-uri, pentru ajutarea celorlalti membrii sa reziste atacurilor si asa mai departe. Fiecare alianta are politica proprie in ceea ce priveste finantele.
<br><br>
Capacitatea seifului aliantei este de 10.000.000 aur inmultit cu numarul de membrii ai aliantei.
<br><br>
<b><i>Sunt trei surse de venit pentru seiful aliantei:</i></b>
<br><br>
 - Taxa platita de comandant pentru infiintarea aliantei (100.000 aur)
<br>
 - Taxa de intrare in alianta
<br>
<font color="#909090">Comandantul poate specifica cat trebuie sa plateasca un jucator pentru a putea intra in alianta.</font>
<br>
 - Depozitele
<br>
<font color="#909090">Fiecare membru poate depune bani in seiful aliantei odata pe saptamana. Suma de bani ce este depusa de un jucator depinde de ei sau poate fi impusa de comandant. Acest lucru depinde de politica financiara a fiecarei aliante.</font>
<br><br>
<b><i>Transferurile:</i></b>
<br><br>
Aurul din seiful aliantei poate fi transferat catre membrii de comandant sau de ofiteri. Un jucator poate primi aur din seiful aliantei doar odata pe saptamana. Suma maxima ce poate fi transferata intr-o singura tranzactie este de 10% din capacitatea totala a seifului aliantei.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="vi_battles">VI. Lupte</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Luptele reprezinta el mai important aspect al jocului. Prin lupte se poate mari numarul maxim de unitati, se iau bani de la inamici si se castiga respect sau ura.
<br><br>
Sunt doua tipuri de lupte: ofensive si defensive. In joc acest lucru inseamna ca ai doua puteri distincte ale armatei: puterea de atac si puterea de aparare. Aceste puteri se bazeaza pe unitati, arme, upgrade-uri si bonusurile rasei. Comandamentul ofera detalii privind capacitatile de lupta ale unui jucator.
<br><br>
In momentul luptei puterile pot varia in functie de doi factori: densitatea si precizia armelor. Din aceasta cauza, in lupte, puterea reala a armatei poate fi diferita de ceea ce este afisat in comandament.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Action Point (puncte de actiune, AP)</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Pentru fiecare tur ce trece (20 min.) primesti un AP. Aceste sunt folosite atunci cand ataci pe altcineva. La fiecare atac poti folosi de la 1 la 10 AP-uri. Acestea determina durata luptei si in consecinta efectele acesteia.
<br><br>
Numarul de AP-uri folosite afecteaza urmatoarele:
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Aur capturat</b> - Vei lua mai mult aur atunci cand folosesti mai multe AP-uri.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Experienta castigata</b> - Vei castiga mai multa experienta cu cat maresti numarul de AP-uri folosite.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Unitati omorate</b> - Utilizarea mai multor AP-uri va avea ca rezultat moartea mai multor unitati in lupta.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Unitati capturate</b> - La fel ca la unitati omorate.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Stricarea armelor</b> - Cu cat folosesti mai multe AP-uri in lupta cu atat mai tare se vor strica armele. Armele se strica atat la cel care ataca cat si la cel atacat.
<br><br>
ATENTIE: AP-urile nu afecteaza puterile celor doua armate implicate in conflict. Ele afecteaza doar consecintele luptei.
<br><br>
Nota: un atac cu 10 AP-uri inseamna un atac la capacitate maxima.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Puterea de atac sau de aparare</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Aceasta este puterea armatei tale atunci cand ataca sau cand se apara de alte atacuri. Ea este influentata de mai multi factori:
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Unitati</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Urmatoarele tipuri de unitati pot fi trimise in lupta:
<br>
 a) Unitati de elita de atac sau de aparare - aceste unitati au o putere de baza de 10
<br>
 b) Unitati combatante  - aceste unitati au o putere de baza de 5
<br>
 c) Unitati neantrenate - aceste unitati au o putere de baza de 1
<br><br>
Unitatile de elita sunt unitati combatante imbunatatite. Acest lucru inseamna ca mai intai trebuie antrenate unitati combatante ca apoi sa fie upgradate la unitati de elita.
</div>

<div style="margin: 30 px;" align="justify">
<b>Upgrade-ul unitatilor de elita</b>
<br><br>
Acest upgrade determina cate unitati de elita poti avea in functie de numarul total al unitatilor combatante. Trebuie sa ai cel putin nivelul 1 pentru a putea antrena unitati de elita. Fiecare upgrade va mari limita de unitati de elita cu 10%.
<br><br>
[Numarul total de unitati combatante] = [Unitati de atac de elita] + [Unitati de aparare de elita] + [Unitati combatante]
<br><br>
De exemplu, daca ai nivelul 2 la upgrade-ul unitatilor de elita (20%) si 100 de unitati combatante, poti avea maxim 20 de unitati de elita.
</div>

<div style="margin: 10 px;" align="justify">
Unitatile de aparare de elita nu ataca si unitatile de atac de elita nu participa in aparare. Unitatile combatante si cele neantrenate pot lua parte la ambele tipuri de lupte si pot folosi arme.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Arme</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Daca ai upgradat atacul sau apararea, vei avea posibilitatea de a cumpara arme pentru unitati.
<br><br>
In functie de tipul luptei in care sunt implicate, unitatile for folosi arme de atac sau de aparare. O unitate poate folosi o singura arma. Din aceasta cauza nu este i idee prea buna sa ai arme de nivele diferite. Noi sugeram ca unitatile sa fie echipate intotdeauna cu cele mai bune arme disponibile.
<br><br>
Pentru fiecare upgrade cumparat armele disponibile vor fi mai puternice.
<br><br>
Puterea unei arme depinde de unitatea care o foloseste. In principiu, puterea de baza a unitatii este inmultita cu puterea armei. Unitatile mai puternice au prioritate in utilizarea armelor. Acest lucru inseamna ca, daca ai mai multe unitati decat arme, unitatile mai puternice vor folosi arme si astfel puterea rezultata este maximizata.
<br><br>
Unitatile care nu au arme disponibile vor lupta cu puterea lor de baza.
<br><br>
Dupa un atac sau atunci cand pierzi o lupta in aparare, armele se strica si puterea lor scade. In acest moment va trebui sa le repari.
<br><br>
Poti cumpara arme noi, vinde sau repara din meniul "Armament".
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Upgrade-uri</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Sunt cateva upgrade-uri care te pot ajuta in a-ti face armata mai puternica.
<br><br>
 a) Nivelul de atac si nivelul de aparare - pentru fiecare nivel cumparat vei primi o noua arma si puterea armatei va creste cu 10%. Aceste nivele sunt foarte importante pentru puterea armatei tale.
<br><br>
 b) Nivelul de precizie al armelor - La nivelul 0 armele nu sunt foarte precise. Precizia de baza a lor este de 60%. Fiecare nivel va mari aceasta precizie cu 4%.
<br>
Precizia armelor functioneaza in modul urmator: La fiecare lupta este generat un numar aleator cuprins intre nivelul de precizie actual (60% pentru nivelul 0, 64% pentru nivelul 1, etc.) si 100%. Acest factor este aplicat puterii armelor micsorand-o. Acest lucru inseamna ca daca nu ai nici un nivel de precizie, puterea de atac sau aparare poate varia intre 60% si 100% fata de ce este afisat in comandament in functie de noroc.
<br>
Precizia armelor afecteaza atat puterea de atac cat si puterea de aparare.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. Densitatea</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Desitatea este un factor care mareste sau micsoreaza puterea de aparare in functie de numarul total de unitati al celui care se apara in raport cu numarul total de unitati al atacatorului.
<br><br>
In acest caz este vorba de numarul TOTAL de unitati, adica si unitatile combatante, si muncitorii sau sclavii, si unitatile neantrenate. TOATE.
<br><br>
Daca atacatorul are mai putine unitati ca cel care se apara, atunci puterea de aparare va scade. Pe de alta parte, daca atacatorul are mai multe unitati, puterea celui care se apara va creste.
<br><br>
Densitatea nu afecteaza puterea de atac!
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="vii_exp_rank">VII. Experienta si clasamentul</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Atunci cand castigi lupte acumulezi experienta. Experienta se castiga in functie de pozitia in clasament a atacatorului si a celui care se apara.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Calsamentul</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Pentru fiecare jucator este calculata o valoare pe baza careia se calculeaza clasamentul. Aceasta valoare este determinata de puterea de atac, puterea de aparare, puterea de spionaj si puterea de contra-spionaj. Cu cat acestea sunt mai mari cu atat valoarea finala si, in consecinta, pozitia in clasament, vor fi mai mari.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Experienta</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Sunt patru cazuri care determina cat de multa experienta este acumulata in cazul castigarii unei lupte:
<br>
 - Oponentul tau este mai sus in clasament decat tine - castigi 100 exp.
<br>
 - Oponentul tau este apropiat ca pozitie in clasament de tine - castigi 75 exp.
 <br>
 - Oponentul tau ets mai jos in clasament decat tine - cstigi 50 exp.
 <br>
 - Oponentul tau este mult mai jos in clasament decat tine - pierzi 10 exp.
 <br><br>
Pentru fiecare atac dat aceluiasi jucator in interval de 24 de ore experienta castigata se diminueaza cu 30%.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="viii_intelligence">VIII. Inteligenta</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Un jucator bun va afla cat mai multe informatii despre victima inainte de a ataca. Exista doua tipuri de unitati specializate in acest sens in joc: spionii si contra-spionii.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Spionii</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Spionii sunt folositi pentru a afla informatii despre inamic. Ei pot vedea cati bani are inamicul si pot fi trimisi in misiuni pentru a atrange data despre inamic.
<br><br>
<b>1. Afisarea aurului inamicilor:</b> daca puterea ta de spionaj este mult mai mare decat puterea de contra-spionaj a unui anume jucator, vei putea vedea cat aur are acesta. Aceasta informatie poate fi foarte folositoare atunci cand vrei sa stii daca ai sau nu sanse de a captura aur in urma unei lupte. Retine totusi ca spionii vor arata TOT aurul pe care inamicul il detine, inclusiv cel depozitat in seif. Aurul din seif nu poate fi luat.
<br><br>
<b>2. Misiuni de spionaj:</b> Poti trimite spionii in misiuni pentru a afla informatii referitoare la puterile de atac sau aparare ale inamicilor sau pentru a aduna date despre unitatile lor. Dupa fiecare misiune va fi generat un raport care va fi pastrat in istoricul misiunilor de spionaj. Unii spioni pot muri in astfel de misiuni.
<br><br>
Rezultatul unei misiuni de spionaj este afectat de puterea de spionaj si de puterea de contra-spionaj a inamicului dar si de un factor aleator destul de mare astfel incat poti castiga misiuni de spionaj chiar daca puterea ta este mai mica decat a celui vizat. Doau misiuni in care vei trimite acelasi numar de spioni pot avea rezultate diferite din acest motiv. Oricum, cu cat mai multi spioni, cu atat mai multe sanse de a reusi in misiune.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Contra-spionii</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Contra-spionii te vor proteja de spionii inamici. Ei au un rol pasiv dar important.
<br><br>
Daca vrei sa tii secreta cantitatea de aur pe care o ai, trebuie sa ai cat mai multi contra-spioni cu putinta.
<br><br>
Misiunile de spionaj contra ta au sanse mai mari de a esua daca ai mai multi contra-spioni. (Vezi explicatiile date la misiunile de spionaj). O parte din contra-spioni pot muri atunci cand cineva incearca sa te spioneze, chiar daca misiune a de spionaj reuseste sau nu.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="ix_upgrades">IX. Upgrade-uri</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Daca vrei sa evoluezi in joc, trebuie sa cumperi upgrade-uri. Sunt cateva upgrade-uri disponibile si alegerea celui corect la momentul potrivit poate face diferenta dintre un jucator bun si unul slab.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul de atac</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade mareste puterea de atac cu 10% si permite achizitionarea unui nou tip de arma. Armele isi dubleaza puterea de la un nivel la altul.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul de aparare</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade are aceleasi efecte ca cel de atac dar aplicat la puterea de aparare.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul de spionaj / contra-spionaj</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade va mari puterea de spionaj sau contraspionaj cu 10%.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul unitatilor de elita</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade determina numarul de unitatil de elita ce pot fi antrenate raportat la numarul total de unitati de lupta detinute. La nivelul 0 nu poti antrena unitati de elita.
<br><br>
Numarul total de unitati de lupta este egal cu numarul de unitati combatante plus numarul de unitati de elita de atac si de aparare.
<br><br>
Fiecare nivel va mari limita cu 10%.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul venitului</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade va mari productivitatea muncitorilor sau a sclavilor cu 10% la fiecare nivel.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul de precizie al armelor</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade mareste precizia armelor cu 4% la fiecare nivel. La nivelul 0 armele au o precizie de 60%. Acest lucru inseamna ca, atunci cand ataci, forta armatei poate varia intre 60% si 100% fata de puterea afisata in comandament.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Nivelul populatiei</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Acest upgrade mareste numarul maxim de unitati ce pot fi cumparate cu 10% la fiecare nivel. De exemplu, atunci cand incepi jocul poti cumpara unitati pana la un total de 1.000. Daca ai cumpara acest upgrade ai putea cumpara pana la 1.100 de unitati pentri nivelul 1, 1.200 pentru nivelul 2 si asa mai departe. 
<br><br>
Toate upgrade-urile din joc sunt liniare, nu progresive. Acest lucru inseamna ca o marire de 10% se aplica la valoarea de baza si nu la valoarea upgrade-ului precedent.
<br><br>
De exemplu, daca ai nivelul 1 la populatie si ai cumparat toate unitatile pana la 1.100, nivelul 2 iti va permite sa cumperi 100 de unitati in plus, nu 110.
<br><br>
[Valoarea de baza] * [Nivelul 1 + Nivelul 2 + Nivelul 3]
<br>
SI NU [Valoarea de baza] * [Nivelul 1] * [Nivelul 2] * [Nivelul 3]
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[cuprins]</a>
</div>


<?php
  }
  else 
  {

?>

<div style="margin: 10 px;" align="center">
<font color="#00FF00"><b>End of Us - Multiplayer Free Online Game</b></font>
<br>
<b>Game Manual</b>
<br>
v. 1.7.1
</div>

<div style="margin: 10 px;" align="justify">
<b>Important notice:</b> <i>All aspects of the game are improved continuously. There may be small differences between this manual and the actual game. For any problems, please refer to our forum where you can find support.</i>
<br>
<font color="#909090"><b>Last revision: February 17, 2007</b></font>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="contents">Contents</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual" href="#i_the_basics">I. The Basics</a>
<br>
<a class="manual" href="#ii_units">II. Units</a>
<br>
<a class="manual" href="#iii_turns">III. Turns</a>
<br>
<a class="manual" href="#iv_money">IV. Money</a>
<br>
<a class="manual" href="#v_alliances">V. Alliances</a>
<br>
<a class="manual" href="#vi_battles">VI. Battles</a>
<br>
<a class="manual" href="#vii_exp_rank">VII. Experience & Rank</a>
<br>
<a class="manual" href="#viii_intelligence">VIII. Intelligence</a>
<br>
<a class="manual" href="#ix_upgrades">VII. Upgrades</a>
</div>

<br />

<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="i_the_basics">I. The Basics</a>
</div>

<div style="margin: 10 px;" align="justify">
End of Us is an online browser based strategy game.
<br><br>
It is a hybrid between turn-based and real time. One turn lasts 20 minutes, at the end of which gold is generated (based on a player's gold production) and each player gets an attack turn. With few exceptions, everything else happens in real time (instantaneously).
<br><br>
The basis for gold production, attack, defense and intelligence are the units. The more of them you have, the better ;-)
<br><br>
Experience, levels and population upgrades dictate the maximum number of units a player can buy. Experience is gained or lost in battles. The more experience points you have, the more units you can buy. Earn enough experience and you jump to the next level. Population upgrades increase the maximum number of units someone can buy by 10% per level.
<br><br>
Almost every action in the game costs money. Gold can be obtained from workers / slaves, from attacks or by receiving transfers from the Alliance Safe (if you have joined an alliance).
<br><br>
Units can be upgraded so they can perform better. Workers can produce more gold, spies can be more effective and military units gain a bonus to their attack or defense power.
<br><br>
In addition to the bonus to their power, military units can be equipped with weapons. The weapons become more powerful and cost-efficient with every upgrade you buy.
<br><br>
The weapons' precision level can also be upgraded. The precision directly affects your attack or defense power in battles.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="ii_units">II. Units</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
This is one of the key concepts of the game. Your units can earn you gold; they can attack your enemies, defend you from them, spy on others and defend you from spies.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>The Maximum Number of Units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This is the maximum number of units you can reach by buying units. When you have reached this number, you can increase your population only by capturing units in battles.
<br><br>
This number made up of three elements: <i>level</i>, <i>experience points</i> and <i>population upgrades</i>. These figures add up to the <i>Maximum Number of Units</i>.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Each level has its maximum number of units. These numbers are:
<br><br>
Level 0 -> 1.000 Units
<br>
Level 1 -> 2.000 Units
<br>
Level 2 -> 4.000 Units
<br>
Level 3 -> 8.000 Units
<br>
Level 4 -> 16.000 Units
<br>
Level 5 -> 32.000 Units
<br>
... and so on ...
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Experience points</b></font>
</div>

<div style="margin: 10 px;" align="justify">
For each experience point your <i>Maximum Number of Units</i> icreases by one.
<br><br>
Examples:
<br>
Level 0 with 0 exp. -> 1.000 Units
<br>
Level 0 with 1 exp. -> 1.001 Units
<br>
Level 0 with 750 exp. -> 1.750 Units
<br>
Level 2 with 0 exp. -> 4.000 Units
<br>
Level 2 with 1 exp. -> 4.001 Units
<br>
Level 2 with 2.300 exp. -> 6.300 Units
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Population Upgrades</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Each upgrade you buy increases the maximum number of units you can buy by 10%. The increment is linear, meaning that 3 upgrades will give you a bonus of 30% (10% + 10% + 10%) and not 33,1% (10% * 10% * 10%).
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Conclusion</b></font>
</div>

<div style="margin: 10 px;" align="justify">
The maximum number of units is calculated in the following way:
<br><br>
([Level] + [Exp. points]) * [Upgrade]
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>You start the game with 10 units.</b></font>
<br>
You can increase this number in two ways:
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Buying Units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
You can buy units in the "Train Units" screen.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Capturing enemy units in battles</b></font>
</div>

<div style="margin: 10 px;" align="justify">
When you fight a battle and win, you can capture some of the enemy's units.
<br><br>
Every time you win a battle, you capture a percentage of the enemy's units. This percentage is calculated based on the difference between your power and that of the enemy. The greater the power difference, the more units you capture. If the percentage is too small, you won't capture any units.
<br><br>
By this method, you can increase your population beyond the <i>Maximum Number of Units</i>.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Your units can be:</b></font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Untrained units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These units produce 1 gold per turn. They also participate in battles (attacks or defenses) and can carry weapons, if available. In battles, untrained units have a base power of 1.
</div>

<div style="margin: 10 px;" align="justify">
If you are attacked and lose the battle, some of these units will die. The same happens when you attack someone and lose.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Workers or Slaves</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These units produce gold. A standard worker or slave produces 10 gold every turn.
<br><br>
However, you can upgrade your workers / slaves so they can be more productive. Every upgrade you buy increases the gold production of every worker or slave by 10%. All upgrades in End of Us are linear. They can be bought in the Upgrades screen.
<br><br>
If you are attacked and lose the battle, some of these units will die.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Sentries</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These units protect you from enemy spies.
<br><br>
You can find more details on these units in the chapter dedicated to Intelligence.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. Spies</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These units can be sent into missions to gather information about your enemies' Attack, Defense, and Units. They are also useful for viewing the amount of money your enemies have.
<br><br>
You can find more details on these units in the chapter dedicated to Intelligence.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>5. Combat units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These are the standard units used in combat. They participate both in attacks and in defensive battles. Depending on the type of battle, combat units can use both attack and defense weapons, if there are any available. They have a base power of 5.
<br><br>
If you attack someone and lose the battle, some of these units will die or be captured. The same happens when you are attacked and lose. You can find out more about battles in the chapter dedicated to them.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>6. Elite Attack Units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These are specialized combat units that can only be used to attack your enemies. They can only use attack weapons and have a base power of 10. <font color="#FFA500">These units cannot be untrained!</font>
<br><br>
In order to train Elite Attack Units, you must first train regular Combat Units which can in turn be upgraded to Elite. There is a maximum to the <b>total number of combat units</b>* that can be upgraded to Elite. This percentage is dictated by your Elite Units Level upgrade. If you haven't bought any upgrades of this type, you won't be able to train Elite units. Please see the section dedicated to battles or upgrades for more details.
<br><br>
<font color="#909090">*<b>total number of combat units</b> - combat units + elite attack units + elite defense units</font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>7. Elite Defense Units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
These are specialized combat units that can only be used to defend you from enemies. They can only use defense weapons and have a base power of 10. <font color="#FFA500">These units cannot be untrained!</font>
<br><br>
In order to train Elite Defense Units, you must first train regular Combat Units which can in turn be upgraded to Elite. There is a maximum to the <b>total number of combat units</b>* that can be upgraded to Elite. This percentage is dictated by your Elite Units Level upgrade. If you haven't bought any upgrades of this type, you won't be able to train Elite units. Please see the section dedicated to battles or upgrades for more details.
<br><br>
<font color="#909090">*<b>total number of combat units</b> - combat units + elite attack units + elite defense units</font>
</div>

<div style="margin: 10 px;" align="justify">
If you need to assign more units to a particular field and you don't afford / cannot to buy more, you can disband units (un-train) from a field and assign them (re-train) to another. For example, if you need more Combat units, you can disband some Workers / Slaves. The units you disband will become Untrained units which you can train as you see fit. Keep in mind that every time you train or re-train a unit, you will have to pay the training fee. Keep in mind that Elite units can't be untrained.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>You can also lose units. This happens in the following situations:</b></font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Losing a battle</b></font>
</div>

<div style="margin: 10 px;" align="justify">
When you fight a battle (either a defensive or an offensive one) and lose, some of your units can die or be captured. The greater the difference between the winner's power and the loser's power, the more units the defeated may lose.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Spies being sent on a mission</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Whenever you send spies on a mission, there is a chance that some of these spies will die. For more details, please refer to the chapter dedicated to intelligence.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Sentries being killed</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Your sentries can be killed by enemy spies. Whenever someone tries to spy on you, some of your sentries may die. For more details, please refer to the chapter dedicated to intelligence.
</div>

<div style="margin: 10 px;" align="justify">
Units are the basis of development in End of Us. The more you have the better. You need to assign your units carefully, so that you will have enough workers to supply you with the gold you need, but also enough combat and intelligence units to protect you from the enemies. Don't forget you also have to attack others in order to gain experience and hence evolve.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="iii_turns">III. Turns</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Gold production in End of Us is affected by turns. All three races' turns are the same. A turn lasts 20 minutes.
<br><br>
Each turn you will also receive an attack. Attacks are used when you attack enemies and they determine the duration of a battle.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="iv_money">IV. Money</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Almost every action in the game costs money. Gold is one of the most important aspects in the game. Manage your finances well and you will become strong. Spend it foolishly and you will lose the war.
<br><br>
You need money to buy units and weapons, to purchase upgrades, to train units and to repair weapons after a battle. All costs are the same between races.
<br><br>
You start the game with 20.000 gold deposited in your safe. It is up to you to make the most of this money.
<br><br>
The primary source for gold in End of Us are your Workers / Slaves. A standard unit of this type produces 10 gold each turn.
<br><br>
If you want your workers to be more productive, you can upgrade them from the "Upgrades" screen. The "Upgrade workers / slaves", once purchased, will make your units produce an additional 10% gold each turn. These upgrades are expensive and may not be the first choice in the early stages of the game. However, once you are more advanced, this can be a great way to get an edge over your opponents. This upgrade is linear, meaning that each upgrade increases the bonus by 10% of the base value and not the upgraded one.
<br><br>
You can also earn gold by attacking other players. When you attack someone and win, you steal a share of their cash. The greater your attack power is in relation to the defeated player's defense power, the more money you can steal.
<br><br>
The gold in the safe cannot be stolen.
<br><br>
You can also get money from selling your weapons, if you have any. Be careful: the amount of money you get by selling a weapon is just 80% of what you paid for it in the first place. This is why it is not a good idea to sell unless you are in a desperate need of cash or if you need to replace old weapons with better ones.
<br><br>
In order to safeguard them from attackers, you can place your cash in the safe. Money in the safe cannot be stolen. The safe capacity is 10.000.000 (ten millions) gold pieces. This can be upgraded in the safe screen. The upgrade is very expensive and may not be your first choice in the early stages of the game.
<br><br>
You can retract the money you have deposited in the safe all at once or in small shares, without any restrictions - this is entirely up to you. Remember, though, that you can only deposit money in the safe once every day!
<br><br>
If your spies have a much greater power than that of an enemy's sentries, you are able to see the amount of money that player has. Be careful! There is no way to discern how much gold that player has stored in the safe and how much cash he has. This is important because only cash can be stolen.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="v_alliances">V. Alliances</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
In End of Us players can group in alliances. This brings you a lot of advantages: apart from getting all the pro's of being part of a team, you get a bonus to your attack and defense power (based on the total attack / defense power of the alliance), you can deposit money in the alliance safe and you can participate in the Alliance Attacks.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Teamwork</b></font>
</div>

<div style="margin: 10 px;" align="justify">
It is much easier to grow when working in a team. Players can exchange information, support and defend each other from enemies and much more. The main idea is that everyone will think twice before attacking someone who is part of an alliance. On the other hand, if your team mates annoy someone, the whole alliance will suffer.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Bonuses</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Each player gets a certain bonus to their attack and defense power, depending on their rank in the alliance.
<br><br>
The Commander receives 1% of the alliance's total attack or defense power
<br>
The Officers receive a bonus of 0,8%
<br>
Regular members get 0,6% of the total attack or defense power.
<br><br>
The total power of the alliance represents the sum of all members' attack or defense power.
<br><br>
<font color="#FFA500">The bonus you receive will never be greater than 50% of your own attack or defense power even if it should be by the calculations!</font>
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Members</b></font>
</div>

<div style="margin: 10 px;" align="justify">
An alliance can have up to 10 members. This number can be upgraded by an increment of 10 for each upgrade, up to a maximum of 50 members.
<br><br>
An alliance has only one Commander and an Officer for each 10 members (including higher ranked ones). An alliance with 5 members can have 1 officer; when you reach 11 members, you can have 2; more than 21 members means 3 officers and so on.
<br><br>
The commander can promote regular users to Officers and can also retrograde them.
<br><br>
The officers can manage the Alliance Safe, accept new members in the alliance and also disband members. Only the Commander can disband Officers.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. The Alliance Safe</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Members can deposit money in the Alliance Safe. This money can then be transferred by the commander or the officers to any member of the alliance. Usually the gold in the alliance safe is used for upgrades, helping players to resist attacks and so on. Each alliance has its own policy regarding finances.
<br><br>
The capacity of the Alliance Safe is 10.000.000 gold multiplied by the number of members that alliance has.
<br><br>
<b><i>There are 3 sources of income for the alliance safe:</i></b>
<br><br>
 - The tax paid by the commander to create the alliance (100.000 gold)
<br>
 - The Join Tax
<br>
<font color="#909090">The commander can set the amount of gold each player has to pay in order to join the alliance.</font>
<br>
 - Safe deposits
<br>
<font color="#909090">Every member is able to deposit gold in the alliance safe once per week. The amount of gold a player deposits is up to them or can be imposed by the commander. This depends on each alliance's financial policy.</font>
<br><br>
<b><i>Transfers:</i></b>
<br><br>
The gold in the Alliance Safe can be transferred to members by the commander or officers. A player can receive no more than one transfer from the safe each week. The amount of money that can be transferred in one transaction is up to 10% of the safe's current capacity.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="vi_battles">VI. Battles</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
Battles represent the most important aspect of the game. Through battles you increase your maximum number of units; you steal money from your enemies and gain their respect or hatred.
<br><br>
There are two types of battles: offensive and defensive ones. In the game his means that you have two distinct powers for your army: attack power and defense power. These powers are based on units, weapons, upgrades and race bonuses. The Command Center screen provides details about your fighting capabilities.
<br><br>
When the actual fighting occurs, your power may vary, depending on two factors: density and weapons' precision. This is why, in a battle, the actual power of your army may be different from what you see in your Command Center.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Attack Turns</b></font>
</div>

<div style="margin: 10 px;" align="justify">
For each regular turn that passes (20 min.) you get an attack turn. You need them in order to attack others. For each attack you can use anything between 1 and 10 turns. Attack turns determine the duration of a battle and hence the effects of that conflict.
<br><br>
The number of turns you use affects the following:
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Gold stolen</b> - You get more gold if you use more turns.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Experience gained</b> - You earn more experience as you increase the number of turns used.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Units killed</b> - Using more attack turns will result in more units being killed in battle.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Units captured</b> - Same as killing units.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Damage to weapons</b> - The more turns you use in a battle, the more damage weapons take. The damage is applied to both yours and your enemy's weapons.
<br><br>
ATTENTION: Attack turns do not affect in any way the power of the armies involved. Only the consequences of a battle.
<br><br>
Note: 10 attack turns means a full attack.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Attack / Defense Power</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This is the power that your army has when attacking others or when defending from attacks. It is influenced by several factors:
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>1. Units</b></font>
</div>

<div style="margin: 10 px;" align="justify">
The following types of units will be sent into battle:
<br>
 a) Elite Attack / Defense Units - these units have a base power of 10
<br>
 b) Combat Units - these units have a base power of 5
<br>
 c) Untrained Units - these units have a base power of 1
<br><br>
Elite units are upgraded combat units. This means that you must first train combat units in order to upgrade them to elite fighters.
</div>

<div style="margin: 30 px;" align="justify">
<b>The Elite Units Upgrade</b>
<br><br>
This upgrade determines how many elite units you can have in relation to the total number of fighting units. You need at least level 1 to train elites. Each upgrade increases the limit by 10%.
<br><br>
[Total number of fighting units] = [Elite attack] + [Elite defense] + [Combat Units]
<br><br>
For example, if you have Elite Units Level 2 (20%) and 100 fighting units, you can have up to a maximum of 20 elite units.
</div>

<div style="margin: 10 px;" align="justify">
The Elite Defense Units do not attack and the Elite Attack Units do not defend. However, the Combat Units and the Untrained ones perform both tasks and use weapons accordingly.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>2. Weapons</b></font>
</div>

<div style="margin: 10 px;" align="justify">
If you have upgraded your attack / defense capabilities, you will be able to buy weapons for your fighting units.
<br><br>
Based on the type of battle being fought, your units will use either attack or defense weapons. Every unit can use only one weapon. This is why it is not a good idea to have weapons of different levels. We suggest you always equip your units with the best weapons available and sell older ones.
<br><br>
For each upgrade you buy, the weapons available will be more powerful and more cost effective.
<br><br>
The power you get from a weapon depends on the unit that is using it. Basically, the base power or each unit is multiplied by the weapon's power. Stronger units have priority in using weapons. This means that if you have more units than weapons, the best units will be using weapons and thus your power is maximized.
<br><br>
Units that have no weapons available will fight with their base power.
<br><br>
After each attack and after you lose a defensive battle, your weapons take damage and their power decreases. You will need to repair them when this happens. If some attacks you and you win, your weapons will not take damage.
<br><br>
You can buy new weapons, sell or repair them in the Armory screen.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>3. Upgrades</b></font>
</div>

<div style="margin: 10 px;" align="justify">
There are a few upgrades that can help make your armies stronger.
<br><br>
 a) Attack / Defense Level - for each upgrade you buy, you will get a new weapon and your army's power will de increased by 10%. These upgrades are crucial for the strength of your forces.
<br><br>
 b) Weapons' precision level - At level 0, your weapons are not very accurate. The base precision level is 60%. Each upgrade increases this by 4%.
<br>
The precision works like this: For each battle, a random number is generated, ranging between your precision level (60% for level 0, 64% for lvl. 1 etc.) and 100%. This factor is then applied to your power, decreasing it. This means that, when you have no precision upgrades, your actual attack or defense power can be anything from 60% to 100% of what you see in your Command Center, depending on your luck.
<br>
Precision affects your attack power as well as your defense power.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>4. Density</b></font>
</div>

<div style="margin: 10 px;" align="justify">
The density is a factor that can increase or decrease your defense power, depending on the total number of units you have in relation to your attacker.
<br><br>
Here we are talking about the TOTAL number of units, meaning your fighting units, your workers / slaves, your untrained units and so on. ALL of them.
<br><br>
If the attacker has fewer units than the defender, the defense power will decrease. On the other hand, if the attacker has more units, the defender's power will increase.
<br><br>
Density can affect the defense power up to 50% more and 50% less than what you see in the Command Center. It does not affect the attack power!
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="vii_exp_rank">VII. Experience & Rank</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
When you win battles, you gain experience. Experience is won based on the rank position of the attacker and the defender.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Rank</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Each player has a certain rank value, based on which he gets his rank position. The ranked value is determined by the attack power, defense power, spy power and sentry power. The higher these are, the higher you will stand in the rank.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Experience</b></font>
</div>

<div style="margin: 10 px;" align="justify">
There are four situations that determine how much experience you gain or wining a battle:
<br>
 - Your opponent is ranked higher than you ' you win 100 exp.
<br>
 - Your opponent is close to you in rank ' you win 75 exp.
<br>
 - Your opponent is ranked lower than you ' you win 50 exp.
<br>
 - Your opponent is ranked MUCH lower than you ' you lose 10 exp.
<br><br>
For each attack against the same player in a 24 hour period, the experience you gain is decreased by 10%. The eleventh attack on the same user in 24 hours will earn you 0 experience points. After that, for each subsequent attack you will lose more and more experience, even if you win the battle.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="viii_intelligence">VIII. Intelligence</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
A good End of Us player will always find out as much information as he possibly can before attacking. There are two types of intelligence units in the game: Spies and Sentries.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Spies</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Spies are used to gather information about the enemy. They can reveal the amount of gold a player has or they can be sent in missions to gather data about the enemy.
<br><br>
<b>1. Revealing enemies' gold:</b> If your spy power is much greater that that of a particular player, you can see how much money that player has. This information is very useful if you want to know whether you have the chance to steal a lot of gold or not. Keep in mind though that spies reveal ALL the money someone has, including what is deposited in the safe. The gold in the safe cannot be stolen.
<br><br>
<b>2. Spy Missions:</b> You can send your spies in missions to find out information about your enemy's defense or attack capabilities or to gather data about their units. After each mission, a report will be generated and stored in your spy logs. Some of your spies may die during these missions.
<br><br>
The result of a spy mission is affected by your spy power and by the enemy's sentry power but the main factor is a random one which means that you don't necessarily have to have a greater spy power than your enemy's in order for a mission to be successful. Two missions in which you send the same number of spies can have different results because of this random factor. Nevertheless, more spies mean more chances for a successful mission.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Sentries</b></font>
</div>

<div style="margin: 10 px;" align="justify">
Sentries protect you from enemy spies. They have a passive (but important) role.
<br><br>
If you want to keep the amount of gold you have a secret, you must have as many sentries as possible in relation to your enemies' spies.
<br><br>
Spy missions against you have a greater chance of failing if you have more sentries. (See the explanations for the spy missions). Some of your sentries may die whenever someone tries to spy on you, regardless whether the spy mission succeeds or not.
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a class="manual_section" name="ix_upgrades">IX. Upgrades</a>
</div>
<br />
<div style="margin: 10 px;" align="justify">
If you want to evolve in the game, you must buy upgrades. There quite a few upgrades available and choosing the right upgrades at the right time can make the difference between a good and a bad player.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Attack Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade increases you attack power by 10% and enables you to buy a new type of (better) weapons. Generally, weapons double their power for each upgrade you buy.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Defense Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade has all the effects of the Attack Level upgrade but in relation to your defense power.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Spy Level / Sentry Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade increases the power of your spies or sentries by 10% for each level.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Elite Units Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade dictates how many elite units you can train in relation to the total number of fighting units. At level 0 you can't train elite units.
<br><br>
The total number of fighting units equals to the Combat units plus Elite defense and attack units.
<br><br>
Each level increases this limit by 10%.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Workers / Slaves (Income) Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade increases the productivity of your gold workers or slaves by 10% for each level.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Weapons' Precision Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade increases the precision of your weapons. At level 0, your weapons have a precision of 60%. This means that when you attack, your armed forces can have anything from 60% to 100% of the power you see in your Command Center. Each upgrade increases precision by 4%.
</div>

<div style="margin: 10 px;" align="justify">
<font color="#009000"><b>Population Level</b></font>
</div>

<div style="margin: 10 px;" align="justify">
This upgrade increases the maximum number of units you can buy by 10% for each level. For example, when you start the game, you can buy up to a total of 1.000 units. If you were to buy this upgrade, for level 1 you would be able to buy 1.100 units, for level 2 1.200 and so on 
<br><br>
All upgrades in the game are linear and not progressive. This means that a 10% increase applies to the base value and not to the value of the previous upgrade.
<br><br>
For example, if you have Population Level 1 and you have bought all the units (1.100), buying level 2 will enable you to buy an additional 100 units and not 110.
<br><br>
[Base value] * [Level 1 + Level 2 + Level 3]
<br>
AND NOT [Base value] * [Level 1] * [Level 2] * [Level 3]
</div>
<br />
<div style="margin: 10 px;" align="justify">
<a href="#contents">[contents]</a>
</div>

<?php

  }

?>
		</div>

		</div>
		</div>
		</div>
		<br />        
      </td>
      <td class="right_td">
        <?php latest_news_box(); ?>
        <?php counter_box(); ?>
        <div class="right_box_black_spacer"></div>
        <div class="right_box_white_spacer"></div>
        <?php ad_right(); ?>
        <br />
        <?php gazduiresite_box(); ?>
      </td>
    </tr>
  </table>
  <div class="footer">
      <?php bottom(); ?>
  </div>
</body>
</html>