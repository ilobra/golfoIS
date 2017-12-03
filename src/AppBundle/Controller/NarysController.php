<?php

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
use Symfony\Component\Security\Core\User\User;


class NarysController extends Controller
{

     /**
     * @Route("/profile", name="profile")
     */
     public function profileAction()
    {
    	$userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('profileUser', [ 'id' => $userid ]);

    }

    /**
     * @Route("/profile/{id}", name="profileUser")
     */
     public function profileShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 


     	return $this->render('narys/profile.html.twig', array(
            	'asmuo' => $user,
            	'narys' => $userAsMember,
        	));


     }

     /**
     * @Route("/profile/{id}/edit", name="profile_edit")
     * @Method({"GET", "POST"})
     */
     public function profileEdit(Request $request){

     	$userid = $this->getUser()->getId();

    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

     	$editForm = $this->createForm('AppBundle\Form\NarysAType', $user);
        $editForm->handleRequest($request);

        $tipas = $em ->getRepository('AppBundle:AsmensTipas')
                         ->find(5); //default: member
        $user->setTipas($tipas);
            
        $em->persist($user);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        	$password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);
        	$this->getDoctrine()->getManager()->flush();
           return $this->redirectToRoute('profileUser', array('id' => $user->getId()));
        }
        return $this->render('narys/edit.html.twig', array(
            'member' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * @Route("/profile/{id}/bankedit", name="profile_bank_edit")
     * @Method({"GET", "POST"})
     */
     public function profileEditBank(Request $request){

     	$em = $this->getDoctrine()->getManager();

     	$userid = $this->getUser()->getId();
     	$member = $em ->getRepository('AppBundle:Narys')
                      ->find($userid); 

     	
     	$editForm = $this->createForm('AppBundle\Form\NarysBType', $member);
        $editForm->handleRequest($request);

        $memberId = $em ->getRepository('AppBundle:Asmuo')
                            ->find($userid); //default: member id
        $member->setId($memberId);
        $em->persist($member);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        	$this->getDoctrine()->getManager()->flush();
           return $this->redirectToRoute('profileUser', array('id' => $userid));
        }
        return $this->render('narys/edit.html.twig', array(
            'member' => $member,
            'edit_form' => $editForm->createView(),

        ));
    }

     /**
     * @Route("/history", name="history")
     */
     public function historyAction()
    {
    	$userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('historyUser', [ 'id' => $userid ]);

    }

    /**
     * @Route("/history/{id}", name="historyUser")
     */
     public function historyShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

            $sql = $em->createQuery('
            		SELECT r.id, r.raundas, r.musimuSk, a.aikstynoInfo
            		FROM AppBundle:Rezultatas r, AppBundle:Aikstynas a
            		WHERE r.fkNarysid = :userid AND r.fkAikstynasid = a.id
                    ORDER BY r.id DESC
            ')->setParameter('userid', $userid)->setMaxResults(5);

		 $results = $sql->getResult();

		 $sql = $em->createQuery('
                    SELECT COUNT(r.id) as kiekis
                    FROM AppBundle:Rezultatas r, AppBundle:Aikstynas a
                    WHERE r.fkNarysid = :userid AND r.fkAikstynasid = a.id
            ')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];

     	return $this->render('narys/history.html.twig', array(
            	'asmuo' => $user,
            	'rezultatai' => $results,
                'kiekis' => $count,
        	)); 


     }

     /**
     * @Route("/history/{id}/add", name="history_add")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function historyAdd(Request $request){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();


    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $result = new Rezultatas();
        $field = new Aikstynas();

        $field = $em->getRepository('AppBundle:Aikstynas')
        			->findAll();
        
        $form = $this->createForm('AppBundle\Form\ResultType', $result);
        

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $member = $em ->getRepository('AppBundle:Asmuo')
                            ->find($userid); //default: member id

        	$id = $member->getId();
        	
        	$playerId = $em ->getRepository('AppBundle:Narys')
                            ->find($id); //default: member id
            
            $result->setfkNarysid($playerId);
            $em->persist($result);
            $em->flush();

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('historyUser', array('id' => $userid));
        }

     	return $this->render('narys/addHistory.html.twig',
            ['history_form' => $form->createView() ]);

     }


     /**
     * @Route("/history/{id}/delete", name="history_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function historyDelete(Rezultatas $id){
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	$rezultatas = $em ->getRepository('AppBundle:Rezultatas')
                         ->find($id); 

        $em->remove($rezultatas);
        $em->flush();

    	return $this->redirectToRoute('historyUser', array('id' => $userid));
     }

     /**
     * @Route("/history/{id}/edit", name="history_edit")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function historyEdit(Request $request, Rezultatas $id){
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();

    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $result = new Rezultatas();
        $rezultatas = $em ->getRepository('AppBundle:Rezultatas')
                          ->find($id); 

        $form = $this->createForm('AppBundle\Form\ResultType', $rezultatas);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('historyUser', array('id' => $userid));
        }

     	return $this->render('narys/editHistory.html.twig',
            ['editHistory_form' => $form->createView() ]);
     }

     /**
     * @Route("profile/{id}/reservations", name="reservationsUser")
     */
     public function reservationsUser(){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 


        $sql = $em->createQuery('
                    SELECT z.data, z.pradziosLaikas, z.pabaigosLaikas, z.id, a.aikstynoInfo
                    FROM AppBundle:ZaidimoRezervacija z, AppBundle:Aikstynas a
                    WHERE z.fkNarysid = :userid AND z.fkAikstynasid = a.id AND z.data>=CURRENT_DATE()
            ')->setParameter('userid', $userid);


         $reservations = $sql->getResult();

         $sql = $em->createQuery('
                    SELECT COUNT(z.id) as kiekis
                    FROM AppBundle:ZaidimoRezervacija z, AppBundle:Aikstynas a
                    WHERE z.fkNarysid = :userid AND z.fkAikstynasid = a.id AND z.data>=CURRENT_DATE()
            ')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];


        return $this->render('narys/myreservations.html.twig', array(
                'asmuo' => $user,
                'narys' => $userAsMember,
                'rezervacijos' => $reservations,
                'kiekis' => $count,
            ));


     }

    /**
     * @Route("/reservations/{id}/delete", name="reservation_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function reservationDelete(ZaidimoRezervacija $id){
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $rezervacija = $em ->getRepository('AppBundle:ZaidimoRezervacija')
                         ->find($id); 

        $em->remove($rezervacija);
        $em->flush();

        return $this->redirectToRoute('reservationsUser', array('id' => $userid));
     }

     /**
     * @Route("profile/{id}/tournments", name="tournmentsUser")
     */
     public function tournmentsUser(){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 


        $sql = $em->createQuery('
                    SELECT z.data, z.pradziosLaikas, z.pabaigosLaikas, z.id, a.aikstynoInfo, z.pavadinimas, t.id as tid
                    FROM AppBundle:ZaidimoRezervacija z, AppBundle:Aikstynas a, AppBundle:Turnyras t
                    WHERE t.fkNarysid = :userid AND z.fkAikstynasid = a.id AND t.fkZaidimoRezervacijaid = z.id AND z.data>=CURRENT_DATE()
            ')->setParameter('userid', $userid);


         $tournments = $sql->getResult();

         $sql = $em->createQuery('
                    SELECT COUNT(z.id) as kiekis
                    FROM AppBundle:ZaidimoRezervacija z, AppBundle:Aikstynas a, AppBundle:Turnyras t
                    WHERE t.fkNarysid = :userid AND z.fkAikstynasid = a.id AND t.fkZaidimoRezervacijaid = z.id AND z.data>=CURRENT_DATE()
            ')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];


        return $this->render('narys/mytournments.html.twig', array(
                'asmuo' => $user,
                'narys' => $userAsMember,
                'turnyrai' => $tournments,
                'kiekis' => $count,
            ));

     }

     /**
     * @Route("/tournments/{id}/delete", name="tournment_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function tournmentDelete(string $id){
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $turnyras = $em ->getRepository('AppBundle:Turnyras')
                         ->find($id);

        $em->remove($turnyras);
        $em->flush();

        return $this->redirectToRoute('tournmentsUser', array('id' => $userid));
     }


     /**
     * @Route("profile/{id}/equipment", name="equipmentUser")
     */
     public function equipmentUser(){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 

         $sql = $em->createQuery('
                    SELECT i.kokybe, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, ia.suma, it.name as tipas
                    FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia
                    WHERE ia.isnuomojimoPabaiga>=CURRENT_DATE() AND i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid AND ia.fkNarysid=:id')->setParameter('id', $userid);


         $equipment = $sql->getResult();

         $sql = $em->createQuery('
                    SELECT COUNT(ia.id) AS kiekis
                    FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia
                    WHERE ia.isnuomojimoPabaiga>=CURRENT_DATE() AND i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid AND ia.fkNarysid=:id')->setParameter('id', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];


        return $this->render('narys/myequipment.html.twig', array(
                'asmuo' => $user,
                'narys' => $userAsMember,
                'iranga' => $equipment,
                'kiekis' => $count,
            ));


     }


     

}
