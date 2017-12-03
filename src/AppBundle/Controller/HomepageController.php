<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\Narys;
use AppBundle\Entity\Darbuotojas;
use AppBundle\Entity\AsmensTipas;
use Symfony\Component\Security\Core\User\User;

class HomepageController extends Controller
{

	/**
     * @Route("/homepage", name="homepage")
     */
    public function indexAction()
    {
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        // ----- surandamas Asmuo pagal ID -----
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 
        $type = $user->getTipas();
        
        // ----- nustatomas asmens tipas -----
        $types = $em ->getRepository('AppBundle:AsmensTipas')
                      ->find($type); //default: member
        $userType = $types->getIdAsmensTipas();

        // šitoj vietoj susidėtų visi vartotojų tipai
        if ($userType==5) return $this->redirectToRoute('homepageUser', [ 'id' => $userid ]);
        else return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

     /**
     * @Route("/home/{id}", name="homepageUser")
     */
    public function userHomepage(Asmuo $userid)
    {
    	$userid = $this->getUser()->getId();
    	
    	$em = $this->getDoctrine()->getManager();
    	$user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 
       
		return $this->render('homepage/homepage.html.twig', array(
            	'asmuo' => $user,
        	));
     }
}
