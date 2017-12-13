<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\VIP;
use AppBundle\Entity\AsmensTipas;
use AppBundle\Entity\Rezultatas;
use AppBundle\Entity\Aikstynas;
use AppBundle\Entity\ZaidimoRezervacija;
use AppBundle\Entity\Turnyras;
use Symfony\Component\Security\Core\User\User;
use Doctrine\ORM\Query\ResultSetMapping;


class VIPController extends Controller
{

     /**
     * @Route("/vip/profile", name="profiles")
     */
     public function profileAction()
    {
    	$userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('profileVIP', [ 'id' => $userid ]);

    }
    /**
     * @Route("/vip/best", name="best")
     */
     public function bestAction()
    {
        $userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('bestPlayers', [ 'id' => $userid ]);

    }
    /**
     * @Route("/vip/komanda", name="komanda")
     */
     public function teamAction()
    {
        $userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('komandaVIP', [ 'id' => $userid ]);

    }
    /**
     * @Route("admin/profile", name="profileadm")
     */
    public function profileadmAction()
    {
        $userid = $this->getUser()->getId();

        return $this->redirectToRoute('profileAdmin', [ 'id' => $userid ]);

    }

    /**
     * @Route("/vip/profile/{id}", name="profileVIP")
     */
     public function profileShow(){
     	
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	
    	// ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 


     	return $this->render('vip/profile.html.twig', array(
            	'asmuo' => $user,
            	'vip' => $userAsMember,
        	));


     }
     /**
     * @Route("/vip/best/{id}", name="bestPlayers")
     */
     public function bestShow(Request $request){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $userAsMember = $em ->getRepository('AppBundle:Narys')
                         ->find($userid); 
            
            $sql = $em->createQuery("
                    SELECT a.vardas, a.pavarde, SUM(r.musimuSk)/SUM(r.raundas) AS ratio
                    FROM AppBundle:Rezultatas r, AppBundle:Asmuo a
                    WHERE a.id = r.fkNarysid GROUP BY a.id ORDER BY ratio ASC");

         $results = $sql->getResult();

         $sql = $em->createQuery('
                    SELECT COUNT(r.id) as kiekis
                    FROM AppBundle:Rezultatas r, AppBundle:Aikstynas a
                    WHERE r.fkNarysid = :userid AND r.fkAikstynasid = a.id
            ')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];

         $paginator = $this->get('knp_paginator');
         $result = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
         );


        return $this->render('vip/best.html.twig', array(
                'asmuo' => $user,
                'rezultatai' => $result,
                'kiekis' => $count,
                'page' => $request->query->getInt('page', 1),
		'limit' => $request->query->getInt('limit', 10),
            )); 


     }
     /**
     * @Route("/vip/komanda/{id}", name="komandaVIP")
     */
     public function teamShow(){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

        $sql = $em->createQuery('
                    SELECT k.pavadinimas, COUNT(n.fkKomandaid) as kiekis
                    FROM AppBundle:Komanda k, AppBundle:Narys n
                    WHERE k.id = n.fkKomandaid AND n.id = :userid'
                )->setParameter('userid', $userid);


         $komanda = $sql->getResult();

         $sql = $em->createQuery('
                    SELECT k.pavadinimas, COUNT(n.fkKomandaid) as kiekis
                    FROM AppBundle:Komanda k, AppBundle:Narys n
                    WHERE k.id = n.fkKomandaid AND n.id = :userid'
                )->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];


        return $this->render('vip/komanda.html.twig', array(
                'asmuo' => $user,
                'rezultatai' => $komanda,
                'kiekis' => $count,
            ));

     }

    /**
     * @Route("/vip/sukurti_komanda/{id}", name="create_team")
     */
     public function createTeam(){
        
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        
        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid);
        $name=$_POST['text'];
        $sql = " INSERT INTO komanda (pavadinimas, ikurimo_data) VALUES($name, now())";
        $stmt = $this->getDoctrine()->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute(); 

        $users = $query->getResult();

 /**       $sql = $em->createQuery('
                    INSERT INTO komanda (pavadinimas, ikurimo_data) VALUES($pavadinimas, now())'
                );


        $komanda = $sql->getResult();
*/
        return $this->redirectToRoute('komandaVIP', [ 'id' => $userid ]);
     }
    /**
     * @Route("admin/profile/{id}", name="profileAdmin")
     */
    public function profileadminShow(){

        $userid = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);
         $role=$user->getRoles();
//        $userAsMember = $em ->getRepository('AppBundle:Narys')
//            ->find($userid);


        return $this->render('vip/profileadm.html.twig', array(
            'asmuo' => $user,
//            'vip' => $userAsMember,
        ));


    }

     /**
     * @Route("/vip/profile/{id}/edit", name="profile_editVIP")
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

//        $tipas = $em ->getRepository('AppBundle:AsmensTipas')
//                         ->find(5); //default: member
//        $user->setTipas($tipas);
//
        $em->persist($user);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($user->getPlainPassword()!=null){$password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);}
        	$this->getDoctrine()->getManager()->flush();
           return $this->redirectToRoute('profileUser', array('id' => $user->getId()));
        }
        return $this->render('vip/edit.html.twig', array(
            'member' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }
    /**
     * @Route("admin/profile/{id}/edit", name="profileadm_edit")
     * @Method({"GET", "POST"})
     */
    public function profileadmEdit(Request $request){

        $userid = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        $editForm = $this->createForm('AppBundle\Form\NarysAType', $user);
        $editForm->handleRequest($request);

//        $tipas = $em ->getRepository('AppBundle:AsmensTipas')
//            ->find(4); //default: member
//        $user->setTipas($tipas);

        $em->persist($user);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($user->getPlainPassword()!=null){$password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);}
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profileAdmin', array('id' => $user->getId()));
        }
        return $this->render('vip/editadm.html.twig', array(
            'member' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * @Route("/vip/profile/{id}/bankedit", name="profile_bank_editVIP")
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
        return $this->render('vip/edit.html.twig', array(
            'member' => $member,
            'edit_form' => $editForm->createView(),

        ));
    }

     /**
     * @Route("/vip/history", name="history1")
     */
     public function historyAction()
    {
    	$userid = $this->getUser()->getId();
        
        return $this->redirectToRoute('historyVIP', [ 'id' => $userid ]);

    }

    /**
     * @Route("/vip/history/", name="historyVIP")
     */
     public function historyShow(Request $request){
     	
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
            ')->setParameter('userid', $userid);

		 $results = $sql->getResult();

		 $sql = $em->createQuery('
                    SELECT COUNT(r.id) as kiekis
                    FROM AppBundle:Rezultatas r, AppBundle:Aikstynas a
                    WHERE r.fkNarysid = :userid AND r.fkAikstynasid = a.id
            ')->setParameter('userid', $userid);

         $countArray = $sql->getResult();
         $count = $countArray[0]['kiekis'];

         $paginator = $this->get('knp_paginator');
         $result = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
         );


     	return $this->render('vip/history.html.twig', array(
            	'asmuo' => $user,
            	'rezultatai' => $result,
                'kiekis' => $count,
        	)); 


     }

     /**
     * @Route("/vip/history/{id}/add", name="history_addVIP")
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

     	return $this->render('vip/addHistory.html.twig',
            ['history_form' => $form->createView() ]);

     }


     /**
     * @Route("/vip/history/{id}/delete", name="history_deleteVIP")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function historyDelete(Rezultatas $id){
     	$userid = $this->getUser()->getId();
    	$em = $this->getDoctrine()->getManager();
    	$rezultatas = $em ->getRepository('AppBundle:Rezultatas')
                         ->find($id); 

        $em->remove($rezultatas);
        $em->flush();

    	return $this->redirectToRoute('historyVIP', array('id' => $userid));
     }

     /**
     * @Route("/vip/history/{id}/edit", name="history_editVIP")
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
            return $this->redirectToRoute('historyVIP', array('id' => $userid));
        }

     	return $this->render('vip/editHistory.html.twig',
            ['editHistory_form' => $form->createView() ]);
     }

}
