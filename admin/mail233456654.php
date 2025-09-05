<?php

include 'database.php';

$db=new DataBase_theend;
$db->connect();

$query="select email from users";
$db->query($query);
$i=0;

while($db->next_record())
{

  $email_text="\nEnd of Us - On-line multiplayer game (http://www.ens.ro)\n";


  $email_text.="\nHello and welcome to a very important event in ENS world. This message is adressed to all the former and actual members of our comunity.\n";
  $email_text.="\nWe are proud to present to you the NEW version and hopefully the best so far of what you came to know as \"End of Us\" on-line game. The official lauch will be on 10.02.2007.\n";
  $email_text.="\nThe new version brings:";
  $email_text.="\n\t- A lor of new and interesting upgrades making ENS a more tactical game then ever;";
  $email_text.="\n\t- New units";
  $email_text.="\n\t- Security upgrades (fraud elimination among players);";
  $email_text.="\n\t- New and improved Forum;";
  $email_text.="\n\t- SAME ATHMOSPHERE you all came to love and apreciate during your time with us.";
  $email_text.="\n\nCome and greet your old friends and foes in a new epic battle for planetary dominance.\n\nEchipa End of Us.";


  $email_text.="\n\n\nBuna seara si bine v-am gasit la un eveniment foarte important din lumea ENS-ului.\n";
  $email_text.="\nAcest mesaj se adreseaza atat fostilor cat si actualilor jucatori si pasionati. Cu aceasta ocazie dorim sa va anuntam ca astazi 10.02.2007 vom lansa a treia si speram cea mai reusita versiune a ENS-ului de pana acum.\n";
  $email_text.="\nVeniti alaturi de noi si de prietenii vechi si noi pe care suntem siguri ca nu i-ati uitat intr-o noua inclestare a fortelor umane cu nociva invazie extraterestra.\n";
  $email_text.="\nNoua versiune vine cu multe noi implementari:";
  $email_text.="\n\t- Numeroase upgrade-uri noi;";
  $email_text.="\n\t- Introducerea unor noi tipuri de unitati;";
  $email_text.="\n\t- Marirea securitatii in joc (eliminarea posibilitatilor de frauda);";
  $email_text.="\n\t- Forum complet refacut;";
  $email_text.="\n\t- ACEEASI ATMOSFERA cu care v-ati obisnuit si care v-a facut poate sa reveniti mereu inapoi.";
  $email_text.="\n\nVeniti alaturi de vechii prieteni si dusmani pe care suntem siguri ca nu i-ati uitat intr-o noua inclestare a fortelor umane cu nociva invazie extraterestra.\n\nEchipa End of Us.";


  $email_header="From: endofus@ens.ro\n";

//  if (mail($db->Record["email"]," \"END OF US\" Online Game - New Version",$email_text,$email_header))
  if(1)
  {
    echo "Mail sent to: ".$db->Record["email"]."<br>";
    $i++;
  }
}

echo $i." mails sent.";

echo "<br><br><pre>".$email_text."</pre>";
?>

