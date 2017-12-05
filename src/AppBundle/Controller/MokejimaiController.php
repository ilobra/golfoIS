<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;


/**
 * Mokejimai controller
 * @Route("admin/mokejimai")
 *
 */

class MokejimaiController extends Controller
{
    /**
     * Lists all asmuo entities.
     *
     * @Route("/", name="asmuo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sql = $em->createQuery('
            		SELECT ia.id, ia.suma, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, 
            		a.vardas, a.pavarde, a.elPastas, a.asmensKodas, a.id AS narioId, 
            		n.bankoKortNumeris, it.name AS iranga, i.kokybe 
            		FROM AppBundle:IrangosApmokejimas ia
            		LEFT JOIN AppBundle:Iranga i WITH ia.fkIrangaid=i.id
            		LEFT JOIN AppBundle:Narys n WITH ia.fkNarysid=n.id
            		LEFT JOIN AppBundle:IrangosTipas it WITH i.tipas=it.idIrangosTipas
            		LEFT JOIN AppBundle:Asmuo a WITH n.id=a.id
            		');

        $results = $sql->getResult();

        return $this->render('mokejimai/index.html.twig', array(
            'mokejimai' => $results,
            //'tipas'=>$type,
        ));
    }

}
