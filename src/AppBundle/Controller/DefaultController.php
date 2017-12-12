<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="startpage")
     */
    public function indexAction(Request $request)
    {
        // jei vartotojas jau prisijungęs
        if ($this->getUser()!==null){
            $userid = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            // ----- surandamas Asmuo pagal ID -----
            $user = $em ->getRepository('AppBundle:Asmuo')
                         ->find($userid); 

            $userRole=$user->getRoles();
            // šitoj vietoj susidėtų visi vartotojų tipai
            //6 tipui (ROLE_VIP rolei) sukurti homepageVIP twig'ą, 3,2,1 tipams (ROLE_PERSONAL rolei) - homepagePersonal
            if ($userRole[0]=="ROLE_ADMIN"){ return $this->redirectToRoute('homepageAdmin', [ 'id' => $userid ]);}
            else if ($userRole[0]=="ROLE_VIP") {return $this->redirectToRoute('homepageUser', [ 'id' => $userid ]);}
            else if ($userRole[0]=="ROLE_USER") {return $this->redirectToRoute('homepageUser', [ 'id' => $userid ]);}

            else if($userRole[0]=="ROLE_PERSONAL") {return $this->redirectToRoute('homepagePersonal', ['id'=>$userid]);}
           }



        // jei dar ne
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
