<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

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

  <table class="page_format" cellspacing="0" cellpadding="0">
    <tr>
      <td class="header_td" colspan="3">
        <?php top(); ?>
      </td>
    </tr>
    <tr>
      <td class="left_td">
        <div class="menu_bg">
        <?php main_menu("story"); ?>
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
        
<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "POVESTEA";
        else 
          echo "THE STORY";  
        echo "</div>";
?> 

		<br />
		<div class="section">
		<div class="section_black">
		<div class="section_grey">

<?php

  if($site_language=="ro")
  {
?>

<div class="image1"><img class="avatar" src="pics/planet.jpg" alt=\"\" /></div>

<br />

<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
O picatura de apa cade intr-un crater langa o epava. Metalul negru incearca sa povesteasca ,oricui asculta, o poveste trista. O umbra se topeste usor cand trece printre crapaturile din nava. Creatura paseste in tacere catre o gaura din perete, tintind mica groapa cu apa care aparuse de curand. In timp ce iese din intuneric, un copil cu ochi albastrii ingenuncheaza langa apa si intinde mana catre aceasta. Band apa, copilul nu simte prezenta altei creaturi atrase de mirosul acesteia. De cand incepuse razboiul si extraterestrii si masinile distrusesera peticele de verdeata care se intindeau departe in orizont, resursele incepura sa fie din ce in ce mai neaccesibile si apa, combustibilul oamenilor, era si mai greu de gasit.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Din cercul mic inegrit de noroi si apa, copilul incearca sa se improspateze inainte de a se ascunde iar. Umbra amenintatoare se apropia din ce in ce mai mult de micul om. Pe cand niste ghiare ies din epava, copilul simte niste frisoane si se intoarce atent pentru a vedea daca este vreun pericol. Nu a apucat nici sa clipeasca cand s-a intors. Forma ciudata de viata era deja deasupra lui, foamea si lacomia citindu-se in ochii sai mari si verzi. Fiinta umana era inspaimantata de creatura enorma care statea in fata sa. A inchis ochii sub presiunea fricii care il imobilizase. Un sunet jos, asemanator cu o sageata care taie aierul, dar mai rapid, l-a trezit pe omul speriat. Extraterestrul respira foarte greu si o pata rosie aparu pe pieptul sau. Chiar in fata micului copil, creatura cazut, zguduind pamantul. In timp ce extraterestul cadea, copil crezu ca vede un inger undeva in departare. Noua creatura incepu sa mearga spre el si, cand intra in conul de umbra dat de o nava, copilul putu sa isi vada salvatorul: un soldat din armata umana care plecase in recunoastere. Acesta se apropie de micut. Cand ajunse langa el, copilul se prabusi la pamant, lesinand.
</font>
</div>
<br>

<br><br>

<div class="image1"><img class="avatar" src="pics/space.jpg" alt=\"\" /></div>

<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nimeni nu credea ca explorarea spatiului are pericolole ei.
Cand prima nava spatiala a fost contruita, fiecare cetatean al Pamantului a fost in extaz.
Toata lumea s-a ridicat cand aceasta a fost lansata.
In primele 2 zile, observatorul spatial de la CMS (Comunitatea Mondiala a Stiintei) a urmarit traseul obiectului spatial si a inregistrat tot ce a intalnit acesta.
In prima zi, nimic special nu s-a intamplat. Se poate spune ca importanta proiectului a fost, poate, prea mare. Omul de rand a inceput sa isi piarda interesul in programul care mancase asa de multi bani din FMS (Fondul Mondial al Stiintei).
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
In a doua zi, nava a primit un semnal slab pe care l-a trimis imediat la centru. Toti oamenii de stiinta de vaza au inceput sa decripteze mesajul dar in drumul sau lung, acesta pierduse o parte din informatiile pe care ar fi trebuie sa le aibe. Chiar daca o mare parte din mesaj fuse tradusa, aceasta nu putea fi pusa cap la cap. A fost ingropata undeva sub o tona de birocratie.
Ore,zile,luni si chiar ani au trecut si nimic de prea mare valoare nu a fost receptionat de nava robotizata. Era doar o precautiune. Nimeni nu vroia o persoana in interiorul prototipului si totul a fost incredintat in mainile calculatorului de la TES ( Terminalul de Explorare a Spatiului) contruit in Drendove, un nou oras cladit pentru acest scop. Multe cladiri de cercetare si de guvernare au fost contruite aici. Se voria un loc pentru toate rasele.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Dupa 50 de ani, majoritatea oamenilor uitasera de PNSR (Prima Nava Spatiala Robotizata). In Dendrove, Set evoluase in fiecare an, noi cladiri adiacente fussesera construite. In memoria proiectului PNSR, nu au distrus centrul de comanda care pierduse de multa vreme contactul cu nava. In zilele acelea, nimeni nu stia unde e si praful era din ce in ce mai vizibil pe masinile care erau o data tratate cu respect. Acum ele erau vechi, doar o amintire fada.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Un bip se aude in noapte. Un cercetator singuratic lucreaza la un proiect cunoscut doar de el. De odata, concentrare sa este intrerupta de bipul care nu lasa noaptea sa se odihneasca. Se ridica si incearca sa localizeze sursa zgomotului.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Ajunge in fata unei usi solide de metal pe care scria cu litere albastre vechi Centrul de Comanda PNSR. Cercetatorul se lupta putin cu usa pe care o deschide cu ceva efort. Nu stia nimic despre aceasta incapere deoarece lucra pt TES doar de 20 de ani.
Consola principala era in mijlocul camerei, acoperita de praf dar un led verde stralucea periodic . Curiozitatea l-a facut sa se apropie si mai mult de consola si spre surprinderea sa, linii de informatie apareau pe ecranul mare orizontal.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nu mai mult de o ora trecu si camera era plina de oameni de stiinta de toate tipurile care incercau sa traduca informatia. PNSR se intorcea acasa si nimeni nu stia de ce. La acel moment, nimanui nu ii pasa.
Prima data au crezut ca era continuarea mesajului primit cu mult timp in urma. Cand nava era la 2 luni distanta de Pamant, grupul de cercetatori selectati de GMS (Guvernul Mondial al Stiintei) a reusit sa traduca informatia.
Cum mesajul avea explicatiile structurii de baza a limbii, a verbelor si pronumelor, grupul a avut ceva ajutor in traducerea mesajului.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Au aflat de o rasa veche numita Tamon care a reusit sa contruiasca sistemul perfect care era in stare sa faca treaba unui guvern mondial. Mesajul avea instructiiunile si puse cap la cap cu informatia din primul mesaj, a prezentat oamenilor planul pentru conducatorul perfect.
Partea mesajului care se pierduse nu mai avea acum nici o importanta deoarece aveau planurile. Toata lumea a contribuit cu ceva la constructia calculatorului. In cativa ani, nucleul principal era terminat.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Timpul a trecut si celelalte nuclee incepeau sa prinda forma. Oamenii ,incapatanati si curiosi, au modificat putin planurile si au adaugat inca un miez, gandind ca ar sporii eficienta proiectului,
Cum urmeaza ca timpul sa arate, interventia a salvat umanitatea de la distrugere totala, dar a baga-to intr-un razboi care avea sa scoata tot ce era mai bun din fiecare dintre oameni.
Ziua activarii era aproape. Secundele era numarate si sperantele erau ridicate. Calculatorul a fost pornit si toate nucleele incepura sa functioneze. Fluxurile de energie au aparut intre coloneale nucleelor si oamenii de stiinta au fost uimiti. Era minunat.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nimeni insa nu a suspectat ce facea de fapt calculatorul la inceput. Zile bune au trecut pana acesta a inceput sa organizeze si sa conduca lumea.
Nu au trecut mai mult de 2 luni, cand ceva aparut pe radarele de departare si apararea planetare fu activata. Crucisatoarele au fost mobilizate si au inconjurat granitele planetare.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
In orizontul albastrui intunecat, un val aparu care avanasa cu o viteza pe care oamenii nu o mai vazusera pana acum. Valul s-a oprit si dupa cateva secunde a implodat, creand un fel de portal. Nici nu au trecut cateva secunde, cand ,prin portal, au inceput sa iasa valuri de nave straine care au inceput sa atace crucisatoarele Terrei.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Batalia a fost violenta si chiar daca oamenii erau depasiti numeric, ei au luptat cu un curaj extraordinar si pentru fiecare nava a lor care cadea de pe cerul intunecat, alte 4 nave ale extraterestrilor erau doborate. Razboiul era aproape de sfarsit si oamenii castigau in ciuda tuturor asteptarilor.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Atunci un lucru total neasteptat s-a petrecut. Patru din nucleele calculatorului au fost inversate si au fortat navele oamenilor sa se opreasca. Ele au fost tinte usoare pe care extraterestrii le-au pulverizat de pe cer.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Dar al cincilea nucleu nu a raspuns comenzilor pe care extraterestrii le exercizau. Acel nucleu s-a dovedit sansa umanitatii de a supraviatui. A distrus complet controlul pe care inamicii il aveau asupra elor 4 nuclee, dar nu a reusit sa restaureze controlul inapoi oamenilor. Intr-o furie necontrolata, masinile nu mai primeau ordine de la nimeni si au inceput sa atace ambele tabere. Milioanele de roboti si de masini de lupta au mutat cele 4 nuclee departe de Dendrove, fiind sub influenta calculatorului scapat de sub control. Al cincilea nucleu a ramas in schimb in Dendrove, unde restul armatei umane si-a construit ultima fortareata.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Un lucru bun a iesit in schimb din aceasta intamplare. In procesul de control al sistemului, extraterestrii au pierdut control partial si nu au mai avut putere sa se intoarca acasa.
Erau blocati intre navele lor, navele umane si oamenii care luptau pentru supravietuire.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Cum doar timpul avea sa spuna, extraterestrii care au atacat Terra nu erau cei care trimisesera mesajul. Ipoteze dupa ipoteze au aparut, dar un singur lucru era cert: partea mesajului pierduta era cheia, dar aceasta nu accesibila nimanui.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
O casca stricata, care apartinuse ,probabil, unui soldat uman, zacea pe campul de lupta, cu o gaura in partea dreapta. Vantul urla printre epave. Umbra unei nave acopera pamanturile triste care erau odata verzi si prospere. Sunetul propulsoarelor au luat locul linistii funebre care, cu cateva momente inainte era tot ce se putea simtii.
Intr-un asemenea loc, oricine isi pierde luciditatea, doar pentru a fi inghitit de energia descatusata de luptele continue.
Sangele curge peste tot, inghitind intr-un foc bolnav tot ce era in viata si chiar si metalul masinilor care umplu craterele cauzate de exploziile nenumarate.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Anul este 2878: 7 ani de cand PNSR s-a intors, 2 ani de cand extraterestrii au incercat sa puna mana pe sistemul oamenilor. Pamantul este o planeta moarta, peste tot misunand masini, extraterestrii si oameni care incearca disperati sa supravietuiasca in mediul neprimitor.
Un razboi lung care nu prevesteste nici un castigator, doar un drum lung pentru fiecare dintre parti.
Care va reusii sa triumfe doar timpul ne va spune, prezentandu-ne doar 2 optiuni: sa fim observatori impartiali sau sa luam parte in aceasta confruntare.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
Oamenii au curajul si scopul lor comun, fiind uniti in fata distrugerii totale.
<br><br>
Masinile, cu actiunile rapide si precise, aduc moarte tuturor din jurul lor.
<br><br>
Extraterestrii se tarasc prin intuneric, inselatori precum umbrele trecutului<br>care se uita cu ochi lacomi spre victimele nebanuitoare.
<br><br>
<b>Tu de partea cui esti?</b>
</font>
</div>
<br><br>

<?php
  }
  else 
  {

?>

<div class="image1"><img class="avatar" src="pics/planet.jpg" alt=\"\" /></div>

<br />

<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A drop of water falls in a little crater near a wreckage. The black metal tries to tell to anyone who listens a sad story. A shadow melts slowly when passing between the cracks in the ship. The creature walks silently towards a hole in the wall, targeting the little pool that appeared not long ago. As it walks out of the darkness, a blue eyed child knees near the water and reaches its hand towards it. Drinking the water, the child does not sense the presence of other creature drawn by the smell of it . Since war started and the aliens and machines rampaged the green patches that stretched long past the horizon, resources began to be scarce and water, the precious fuel of humans, was even hard to find.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
From the small darkened circle of mud and water, the child tries to rejuvenate before hiding again. The threatening shadow comes nearer and nearer the little human. As some claws come out behind the wreckage, the child feels some shivers and carefully it turned to see if there was any danger. He didnt even managed to blink once he turned. The strange form of life was on top of him, greed and hunger glowing from his big green eyes. The human was terrified by the enormous creature that stood before him. He closed his eyes under the pressure of the fear that immobilized him. A low noise, like an arrow cutting the air, but more quicker, woke up the frightened human. The alien was breathing very hard and a strong red stain appeared on his chest. Right before the little child, the giant creature crumbled, shaking the ground. As the alien fell, the child thought he saw an angel somewhere in the distance. The creature started to walk towards him, and as he was covered by a the shadow of a ship, the child could see his savior: a trooper from the human army that was scouting for enemies. The soldier walked towards the child. When he was near him, the little human crumbled, passing out.[/color]
</font>
</div>
<br>

<br><br>

<div class="image1"><img class="avatar" src="pics/space.jpg" alt=\"\" /></div>

<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nobody thought that space exploring had its dangers. When the first space shuttle was built, every citizen of Earth was near total ecstasy. Everybody stood up when it launched. For the first two days, the space observatory of WSC (World Space Community) followed the path of the object and recorded everything it encountered.
In the former day, nothing special happened. One could say, the importance of the project was thought to be, maybe, to great. The common folk started to loose interest in the program that ate so much money form the WSF (World Science Fund).
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
In the later, the shuttle received a fading signal and it sent the fresh information to the center. All the bright scientists started to decrypt the signal but in its long path, it lost a part of the information that it should have hold. Even tough a large part of the message was translated, it didnt make any sense. It was burrowed somewhere under a ton of bureaucracy.
Hours, days, months and years passed and nothing else of some sort of value was received by the robotized shuttle. It was just a precaution. Nobody wanted a live person inside that prototype and everything was entrusted in the hands of the computers from SET (Space Exploring Terminal) built in Drendove, a new city constructed for this purpose. Many buildings of science and world governing were built here. It was wanted as a common place for all rases.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
After 50 years, most of the people forgot about FRSS ( First Robotized Space Shuttle). In Dendrove, SET evolved every year, new adjacent buildings were built. In the memory of FRSS, they didnt destroy the central command station that long lost control of the shuttle. Nowadays, nobody knew were it was and dust was pileing up on the controls and machines that once were treated with respect. Now they were absolute, nothing but a dim memory.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A bip echoes in the night. A lonely scientist works on a project known only by him. Suddenly, his focus is disrupted by the bip that doesn't let the night be still. He gets up and tries to pin point the location of the disturbing noise.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
He comes near a big solid metal door on which, with old blue letters wrote FRSS Control Center. The scientist fights a bit with the metal door which he opens with some effort. He knew nothing about this room as he had been working for SET for about 20 years now.
The main console was in the middle of the room, covered in dust but a green bulb was flashing again and again. The curiosity made him approach the old console and to his surprise, lines of information were coming up on the big horizontal screen.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Not more than an hour passed and the room was filled with scientists of all sorts trying to translate the information. FRSS was coming home but nobody knew why it returned. At the moment, nobody even cared.
They first thought it was the continuing of the first message they received long ago. When the shuttle was about 2 months distance from Earth, the group of scientists, picked by the WSG (World Science Government), managed to translate the information.
As the message had the key of the basic language structure and the verbs and pronouns, the group had some help in decrypting the information.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
They learnt of an old race, named Tamon, which succeeded in constructing the perfect computer system that was capable of doing all the hard work of a world government. The message had the instructions and when combined with the mixed information from the first message, presented the humans a plan of creating the perfect leader.
The part of the message that was lost had no importance now since they had the plans. Everybody contributed with something to the construction of the computer. In a few years, the main core was ready.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Time passed and the cores started to take form. The humans, in their stubbornness and curiosity, modified a little the plans and add another core to the design, thinking it would maximize the efficiency of the design.
As time would reveal it, that intervention turned the humanity from total annihilation to a war that would bring out everything good mankind had within.
The day of the activation was near. Seconds were counted and hopes were up. The computer was turned on and all the cores started to function. Flows of energy appeared between the spines of the cores and the scientists were amazed. It was beautiful.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nobody ever suspected what the computer was doing in the beginning. Days passed before it took control of the main buildings and powers in the world.
After no more than 2 months, something appeared on the long range scanners and the planetary defenses were online. The computer had plans for about everything and showed mankind a new face of life. The destroyers and cruisers stood near the planetary boarders.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
In the dark bluish horizon, a vile wave appeared and was advancing with a speed the humans never seen before. The wave stopped and after a couple of seconds imploded, creating some kind of portal. Mere seconds passed and through the portal entered waves of unseen ships that attacked with no warning the human fleet.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
The battle was fierce and even tough the humans were clearly outnumbered they fought with courage and for every ship of theirs that fell from the dark sky 4 more ships of the aliens were brought down. The war was near the end and humans were prevailing against all expectations.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Then something totaly unexpected happened. Four of the cores of the computer reversed the flows and forced all the human ships that remained in the sky to shutdown. They were then easy targets which the aliens pulverized from the sky.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
But the fifth core didn't answer to the control that the aliens were exercising on him. It proved to be humanity last chance of surviving. It shattered the complete control that the aliens had over the human machines but couldn't turn them back to the humans. In a furious, uncontrolled rage, the machines were taking orders from no one no more and started to attack both humans and aliens. The millions of robots and war machines moved the four cores far from Dendrove being under the influence of the computer system. The fifth core remained in the city were the last defenders of humanity made their stronghold.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A good thing came from this although. In the process of taking control of the 5 cores, the aliens lost their control partially and hadn't power to return home.
They were trapped near Earth, between their machines, the human machines and the humans that tried to save their life.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
As only time would tell, the aliens that attacked Terra werent the rase that sent the message. Hypothesis after hypothesis appeared but one thing was certain: the lost part of the message was the key but it was out of reach.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A damaged helmet, that belonged maybe to a human scout, lies on the battlefield, with a hole in its right side. The wind howls through the wreckage that seems to go on forever. A shadow of a ship covers the sad lands that were once green and prosper. The sound from the burners take the place of the grim silence that a few moments ago was all that one could feel.
In such a place, everyone becomes insane, only to be absorbed by the energy unleashed by the ongoing battles.
Blood flows everywhere, engulfing in a sick fire everything alive and the metal from the enraged machines fills the craters from the explosions.[/color]
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Year is 2878: 7 years since FRSS returned, 2 years since the aliens tried to take control. Earth is now a dead planet, everywhere lurking machines, aliens or humans that are trying so survive in the harsh environment.
A long war that doesn't foresees any winners but only a long way for each of the sides.
Which will prevail only time will tell, letting us 2 options: to be observers or to take part in this great war.
</font>
</div>
<br>

<br><br>
<div class="text1">
<font color="#A0A0A0">
The humans have their courage and common goal, being united in the face of total destruction.
<br><br>
The machines with their precise and quick actions bring death to anything around them.
<br><br>
The aliens lurk in the dark, cunning as the shadows of the past that prowl around the unsuspecting victims.
<br><br>
<b>Which side are you?</b>
</font>
</div>
<br><br>

<?php

  }

?>

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