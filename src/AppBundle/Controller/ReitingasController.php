<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReitingasController extends Controller
{
    /**
     * @Route("/ranking", name="ranking")
     */
    public function rankingAction()
    {

    $em = $this->getDoctrine()->getManager();


            $sql = $em->createQuery('
            		SELECT a.id, a.vardas, a.pavarde, k.pavadinimas AS komanda, SUM(r.musimuSk) AS result
            		FROM AppBundle:Rezultatas r, AppBundle:Asmuo a       		
            		LEFT JOIN AppBundle:Narys n WITH a.id=n.id
            		LEFT JOIN AppBundle:Komanda k WITH n.fkKomandaid=k.id
            		WHERE r.fkNarysid=a.id
            		GROUP BY a.id
            		ORDER BY result DESC 
            		');

            $results = $sql->getResult();
        return $this->render('reitingas/ranking.html.twig', array(
            'reitingas'=> $results
        ));
    }

}
