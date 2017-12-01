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
            $type = $user->getTipas();
        
            // ----- nustatomas asmens tipas -----
            $types = $em ->getRepository('AppBundle:AsmensTipas')
                      ->find($type); //default: member
            $userType = $types->getIdAsmensTipas();

            // šitoj vietoj susidėtų visi vartotojų tipai
            if ($userType==5) return $this->redirectToRoute('homepageUser', [ 'id' => $userid ]);
         }

        // jei dar ne
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
