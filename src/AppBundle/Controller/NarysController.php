<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\Narys;
use AppBundle\Entity\AsmensTipas;
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
           return $this->redirectToRoute('profileUser', array('id' => $memberid));
        }
        return $this->render('narys/edit.html.twig', array(
            'member' => $member,
            'edit_form' => $editForm->createView(),

        ));
    }


     

}
