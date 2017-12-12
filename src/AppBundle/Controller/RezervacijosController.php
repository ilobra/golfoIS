<?php

namespace AppBundle\Controller;

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\Narys;
use AppBundle\Entity\AsmensTipas;
use AppBundle\Entity\Rezultatas;
use AppBundle\Entity\Aikstynas;
use AppBundle\Entity\ZaidimoRezervacija;
use AppBundle\Entity\Turnyras;
use AppBundle\Entity\Iranga;
use AppBundle\Entity\IrangosApmokejimas;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class RezervacijosController extends Controller
{

    /**
     * @Route("/reservation", name="reservation")
     */
     public function reservationShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

            $sql = $em->createQuery('
            		SELECT r.data, r.pradziosLaikas, r.id, r.pabaigosLaikas, a.aikstynoInfo
            		FROM AppBundle:ZaidimoRezervacija r, AppBundle:Aikstynas a
            		WHERE r.data = CURRENT_DATE() AND r.fkAikstynasid = a.id ORDER BY r.data, r.pradziosLaikas');

		 $results = $sql->getResult();

		 $sql = $em->createQuery('
                    SELECT COUNT(r.id) AS kiekis
            		FROM AppBundle:ZaidimoRezervacija r, AppBundle:Aikstynas a
            		WHERE r.data = CURRENT_DATE() AND r.fkAikstynasid = a.id');

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];

     	return $this->render('rezervacija/allReservations.html.twig', array(
            	'asmuo' => $user,
            	'rezultatai' => $results,
                'kiekis' => $count,
        	)); 


     }

     /**
     * @Route("/reservation/{id}", name="reservation_date")
     */
     public function reservationDate( Request $request){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $userDate = $request->request->get('datepicker');

        $timeMor = '08:00:00';
		$timeMor1 = '11:00:00';
		$timeDay = '12:00:00';
		$timeDay1 = '15:00:00';
        
        $sql = $em->createQuery(
            		'SELECT a.aikstynoInfo, a.id, z.pradziosLaikas
					FROM AppBundle:Aikstynas a,  AppBundle:ZaidimoRezervacija z
					WHERE z.pradziosLaikas = :etime AND z.data = :edate AND a.id = z.fkAikstynasid')->setParameters(array('etime' => $timeMor, 'edate' => $userDate));

        $fields = $em ->getRepository('AppBundle:Aikstynas')
                         ->findAll();

		$results = $sql->getResult();

		$sql = $em->createQuery(
            		'SELECT COUNT(a.id) as kiekis
					FROM AppBundle:Aikstynas a,  AppBundle:ZaidimoRezervacija z
					WHERE z.pradziosLaikas = :etime AND z.data = :edate AND a.id = z.fkAikstynasid')->setParameters(array('etime' => $timeMor, 'edate' => $userDate));

		$countArray = $sql->getResult();
        $count = $countArray[0]['kiekis'];

        $sql = $em->createQuery(
            		'SELECT a.aikstynoInfo, a.id, z.pradziosLaikas
					FROM AppBundle:Aikstynas a,  AppBundle:ZaidimoRezervacija z
					WHERE z.pradziosLaikas = :etime AND z.data = :edate AND a.id = z.fkAikstynasid')->setParameters(array('etime' => $timeDay, 'edate' => $userDate));
        $results1 = $sql->getResult();

        $sql = $em->createQuery(
            		'SELECT COUNT(a.id) as kiekis
					FROM AppBundle:Aikstynas a,  AppBundle:ZaidimoRezervacija z
					WHERE z.pradziosLaikas = :etime AND z.data = :edate AND a.id = z.fkAikstynasid')->setParameters(array('etime' => $timeDay, 'edate' => $userDate));

		$countArray = $sql->getResult();
        $count1 = $countArray[0]['kiekis'];

     	return $this->render('rezervacija/newReservation.html.twig', array(
            	'asmuo' => $user,
            	'rezultatai' => $results,
            	'rezultatai1' => $results1,
                'laikasRyt' => $timeMor,
                'laikasRyt1' => $timeMor1,
                'laikasDien' => $timeDay,
                'laikasDien1' => $timeDay1,
                'aikstynai' => $fields,
                'data' => $userDate,
                'kiekisRyt' => $count,
                'kiekisDien' => $count1,
        	)); 


     }

     /**
     * @Route("/reservation/add/{aikstynoid}/{laikasPr}/{laikasPab}/{data}", name="reservation_add")
     */
     public function reservationAdd(string $data, string $laikasPr, string $laikasPab, int $aikstynoid){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

       $aikstynas = $em ->getRepository('AppBundle:Aikstynas')
                         ->find($aikstynoid); 

      $data1 = \DateTime::createFromFormat('Y-m-d', $data);
      $laikasPr1 = \DateTime::createFromFormat('H:i:s', $laikasPr);
      $laikasPab1 = \DateTime::createFromFormat('H:i:s', $laikasPab);

        $reservation = new ZaidimoRezervacija();
        $reservation->setData($data1);
       	$reservation->setPradziosLaikas($laikasPr1);
        $reservation->setPabaigosLaikas($laikasPab1);
        $reservation->setPavadinimas('Rezervacija');
        $reservation->setfkNarysid($userAsMember);
        $reservation->setfkAikstynasid($aikstynas);

        $em->persist($reservation);

        $em->flush();
       return $this->redirectToRoute('reservationsUser', array('id' => $user->getId()));
          
     }

      /**
     * @Route("/tournments", name="tournments")
     */
     public function tournmentShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $sql = $em->createQuery('
            		SELECT r.data, r.pradziosLaikas, r.id, r.pavadinimas, r.pabaigosLaikas, a.aikstynoInfo
            		FROM AppBundle:ZaidimoRezervacija r, AppBundle:Aikstynas a
            		WHERE r.data >= CURRENT_DATE() AND r.fkAikstynasid = a.id AND r.pradziosLaikas=:etime ORDER BY r.data')->setParameter('etime', '16:00:00');

		 $results = $sql->getResult();

		 $sql = $em->createQuery('
                    SELECT COUNT(r.id) AS kiekis
            		FROM AppBundle:ZaidimoRezervacija r, AppBundle:Aikstynas a
            		WHERE r.data >= CURRENT_DATE() AND r.fkAikstynasid = a.id AND r.pradziosLaikas=:etime')->setParameter('etime', '16:00:00');

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];


         $sql = $em->createQuery('
            		SELECT IDENTITY(t.fkZaidimoRezervacijaid) AS id 
            		FROM AppBundle:Turnyras t
            		WHERE t.fkNarysid =:userid')->setParameter('userid', $userid);

         $results1 = $sql->getResult();

         $sql = $em->createQuery('
                   SELECT COUNT(IDENTITY(t.fkZaidimoRezervacijaid)) as kiekis
            		FROM AppBundle:Turnyras t
            		WHERE t.fkNarysid =:userid')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count1 = $countArray[0]['kiekis'];

     	return $this->render('rezervacija/allTournments.html.twig', array(
            	'asmuo' => $user,
            	'rezultatai' => $results,
                'kiekis' => $count,
                'kiekis1' => $count1,
                'turnyrai' => $results1,
        	)); 


     }

     /**
     * @Route("/tournments/{rezervacijosid}", name="tournment_add")
     */
     public function tournmentAdd(int $rezervacijosid){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

       	$rezervacija = $em ->getRepository('AppBundle:ZaidimoRezervacija')
                         ->find($rezervacijosid);

        $text1 = (string)$userid;
        $text2 = (string)$rezervacijosid;

        $text = $text1.$text2;
        $tournid=md5(uniqid($text)); 
        
        $tournment = new Turnyras();
        $tournment->setId($tournid);
        $tournment->setfkNarysid($userAsMember);
        $tournment->setFkZaidimoRezervacijaid($rezervacija);

        $em->persist($tournment);

        $em->flush();
        return $this->redirectToRoute('tournmentsUser', array('id' => $user->getId()));
          
     }

     /**
     * @Route("/equipment", name="equipment")
     */
     public function equipmentShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $equipmentType = $em -> getRepository('AppBundle:IrangosTipas')
        					 ->findAll();

     	return $this->render('rezervacija/equipmentType.html.twig', array(
            	'asmuo' => $user,
            	'irangosTipai' => $equipmentType,
        	)); 


     }

     /**
     * @Route("/equipment/{id}", name="equipmentType")
     */
     public function equipmentType(int $id){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $equipmentType = $em -> getRepository('AppBundle:IrangosTipas')
        					 ->find($id);

        $sql = $em->createQuery('
            		SELECT i.kokybe, i.isigijimoData, i.id, it.name as tipas
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it
            		WHERE i.tipas = :id AND i.tipas=it.idIrangosTipas')->setParameter('id', $id);


		$results = $sql->getResult();

		$sql1 = $em->createQuery('
                    SELECT COUNT(i.id) as kiekis
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it
            		WHERE i.tipas = :id AND i.tipas=it.idIrangosTipas')->setParameter('id', $id);

		$countArray = $sql1->getResult();
        $count = $countArray[0]['kiekis'];

        $sql3 = $em->createQuery('
            		SELECT ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, i.isigijimoData, i.id, it.name as tipas
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia
            		WHERE ia.isnuomojimoPabaiga>=CURRENT_DATE() AND i.tipas = :id AND i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid')->setParameter('id', $id);

        $results3 = $sql3->getResult();

        $sql4 = $em->createQuery('
            		SELECT COUNT(ia.id) AS kiekis
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia
            		WHERE ia.isnuomojimoPabaiga>=CURRENT_DATE() AND i.tipas = :id AND i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid')->setParameter('id', $id);

        $countArray = $sql4->getResult();
        $count3 = $countArray[0]['kiekis'];

		$kaina = 0;
		$antraste = ' ';

		//die($count3);

		if ($id==1) {
			$kaina = 2.00;
			$antraste = 'Nuomos kaina nurodyta vienai dienai. Nuomojama viena lazda';		
		}
		if ($id==2) {
			$kaina = 3.50;
			$antraste = 'Nuomos kaina nurodyta vienai dienai. Gaunamas 40 kamuoliukų žetonas.';
		}
		if ($id==3) {
			$kaina = 35;
			$antraste = 'Nuomos kaina nurodyta vienai dienai. Nuomojamas vienas golfo automobilis.';
		}


        $countArray = $sql1->getResult();
        $count = $countArray[0]['kiekis'];

     	return $this->render('rezervacija/equipment.html.twig', array(
            	'asmuo' => $user,
            	'iranga' => $results,
            	'kiekis' => $count,
            	'kaina' => $kaina,
            	'antraste' => $antraste,
            	'kiekis' => $count,
            	'kiekis1' => $count3,
            	'isnuomota' => $results3,
            	'narys' => $userAsMember,
        	));  


     }

     /**
     * @Route("/equipment/{id}/{irangosid}/{kaina}", name="equipment_date")
     */
     public function equipmentDate(int $irangosid, string $kaina){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $sql = $em->createQuery('
            		SELECT i.kokybe, i.isigijimoData, i.id, it.name as tipas
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it
            		WHERE i.id = :id AND i.tipas=it.idIrangosTipas')->setParameter('id', $irangosid);

		$equipment = $sql->getResult(); 

     	return $this->render('rezervacija/equipmentDate.html.twig', array(
            	'asmuo' => $user,
            	'iranga' => $equipment,
            	'kaina' => $kaina,
        	)); 


     }

     /**
     * @Route("/equipment/{id}/{irangosid}/{kaina}/confirm", name="equipment_confirm")
     */
     public function equipmentConfirm(Request $request, int $irangosid, string $kaina){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

        $sql = $em->createQuery('
            		SELECT i.kokybe, i.isigijimoData, i.id, it.name as tipas
            		FROM AppBundle:Iranga i, AppBundle:IrangosTipas it
            		WHERE i.id = :id AND i.tipas=it.idIrangosTipas')->setParameter('id', $irangosid);

		$equipment = $sql->getResult(); 

		$days = $request->request->get('days');

		$date = date("Y-m-d");
		$dateToday = date("Y-m-d");

        // Paskaičiuojamas terminas
        if ($days==1) $date = date('Y-m-d', strtotime('+1 days'));
        if ($days==2) $date = date('Y-m-d', strtotime('+2 days'));
        if ($days==3) $date = date('Y-m-d', strtotime('+3 days'));
        if ($days==7) $date = date('Y-m-d', strtotime('+7 days'));
        if ($days==14) $date = date('Y-m-d', strtotime('+14 days'));

        $price = $days * $kaina;




     	return $this->render('rezervacija/equipmentConfirm.html.twig', array(
            	'asmuo' => $user,
            	'iranga' => $equipment,
            	'data' => $date,
            	'siandData' => $dateToday,
            	'finalKaina' => $price,
        	)); 


     }

      /**
     * @Route("/equipment/{irangosid}/{kaina}/confirm/{isnPabaiga}", name="equipment_done")
     */
     public function equipmentDone(int $irangosid, string $kaina, string $isnPabaiga){
     	// die("***");
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 


        $equipment = $em ->getRepository('AppBundle:Iranga')
                         ->find($irangosid);

        $isnPradzia = date("Y-m-d");

        $isnPradzia1 = \DateTime::createFromFormat('Y-m-d', $isnPradzia);
        $isnPabaiga1 = \DateTime::createFromFormat('Y-m-d', $isnPabaiga);

        //die($isnPradzia1);

        $kaina1 = (float)$kaina;

        $eqpDone = new IrangosApmokejimas();
        $eqpDone->setSuma($kaina1);
        $eqpDone->setIsnuomojimoPradzia($isnPradzia1);
        $eqpDone->setIsnuomojimoPabaiga($isnPabaiga1);
        $eqpDone->setFkNarysid($userAsMember);
        $eqpDone->setFkIrangaid($equipment);

        $em->persist($eqpDone);
        $em->flush();

        return $this->redirectToRoute('equipmentUser', array('id' => $user->getId()));
     }
}


