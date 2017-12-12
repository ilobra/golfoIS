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
        // šitoj vietoj susidėtų visi vartotojų tipai
        //6 tipui (ROLE_VIP rolei) sukurti homepageVIP twig'ą, 3,2,1 tipams (ROLE_PERSONAL rolei) - homepagePersonal
        $userRole=$user->getRoles();
        if ($userRole[0]=="ROLE_ADMIN"){ return $this->redirectToRoute('homepageAdmin', [ 'id' => $userid ]);}
        else if ($userRole[0]=="ROLE_VIP") {return $this->redirectToRoute('homepageVIP', [ 'id' => $userid ]);}
        else if ($userRole[0]=="ROLE_USER") {return $this->redirectToRoute('homepageUser', [ 'id' => $userid ]);}

        else if($userRole[0]=="ROLE_PERSONAL") {return $this->redirectToRoute('homepagePersonal', ['id'=>$userid]);}
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
    /**
     * @Route("admin/home/{id}", name="homepageAdmin")
     */
    public function adminHomepage(Asmuo $userid)
    {
        $userid = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        return $this->render('homepage/homepageAdmin.html.twig', array(
            'asmuo' => $user,
        ));
    }

    /**
     * @Route("personnel/home/{id}", name="homepagePersonal")
     */
    public function personnelHomepage(Asmuo $userid)
    {
        $userid = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        return $this->render('homepage/homepagePersonnel.html.twig', array(
            'asmuo' => $user,
        ));
    }

    /**
     * @Route("/vip/home/{id}", name="homepageVIP")
     */
    public function vipHomepage(Asmuo $userid)
    {
        $userid = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 
       
        return $this->render('homepage/homepageVIP.html.twig', array(
                'asmuo' => $user,
            ));
     }
}
