<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Mokejimai controller
 * @Route("admin/mokejimai")
 *
 */

class MokejimaiController extends Controller
{
    /**
     * Lists all mokejimai entities.
     *
     * @Route("/", name="mokejimai_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('mokejimai/index.html.twig', array(

        ));

    }
    /**
     * Lists all mokejimai entities.
     *
     * @Route("/iranga", name="uziranga")
     * @Method({"GET", "POST"})
     */
    public function irangosMokejimaiAction(Request $request)
    {

        $datanuo=$request->query->get('from');
        $dataiki=$request->query->get('to');
        $searchemail=$request->request->get('emailSearch');
        $em = $this->getDoctrine()->getManager();

        $parameters = array(
            'nuo' => $datanuo
        ,'iki' => $dataiki
        );
                $sql = $em->createQuery('
            		SELECT ia.id, ia.suma, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, 
            		a.vardas, a.pavarde, a.elPastas, a.asmensKodas, a.id AS narioId, 
            		n.bankoKortNumeris, it.name AS iranga, i.kokybe 
            		FROM AppBundle:IrangosApmokejimas ia, AppBundle:Iranga i, AppBundle:Narys n, AppBundle:IrangosTipas it, AppBundle:Asmuo a
            		WHERE ia.fkIrangaid=i.id AND ia.fkNarysid=n.id AND i.tipas=it.idIrangosTipas
            		AND n.id=a.id AND ia.isnuomojimoPradzia >= :nuo AND ia.isnuomojimoPradzia <= :iki
            		ORDER BY ia.isnuomojimoPradzia ASC
            ')->setParameters($parameters);


        $results = $sql->getResult();

        $sqlemail=$em->createQuery('SELECT ia.id, ia.suma, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, 
            		a.vardas, a.pavarde, a.elPastas, a.asmensKodas, a.id AS narioId, 
            		n.bankoKortNumeris, it.name AS iranga, i.kokybe 
            		FROM AppBundle:IrangosApmokejimas ia, AppBundle:Iranga i, AppBundle:Narys n, AppBundle:IrangosTipas it, AppBundle:Asmuo a
            		WHERE ia.fkIrangaid=i.id AND ia.fkNarysid=n.id AND i.tipas=it.idIrangosTipas
            		AND n.id=a.id AND a.elPastas=:searchEmail
            		ORDER BY ia.isnuomojimoPradzia ASC
            ')->setParameter('searchEmail',$searchemail);
        $resultsemail=$sqlemail->getResult();

        return $this->render('mokejimai/uziranga.html.twig', array(
            'mokejimai' => $results,
            'asmensmokejimai'=>$resultsemail
        ));
    }

    /**
     * Lists all mokejimai entities.
     *
     * @Route("/naryste", name="uznaryste")
     * @Method({"GET", "POST"})
     */
    public function narystesMokejimaiAction(Request $request)
    {
        $datanuo=$request->query->get('from');
        $dataiki=$request->query->get('to');


        $searchemail=$request->request->get('emailSearch');
        $em = $this->getDoctrine()->getManager();

        $sql = $em->createQuery('
            		SELECT na.id, a.id AS narioId, n.bankoKortNumeris, a.vardas, a.pavarde,a.elPastas, a.asmensKodas,
            		na.suma, na.narystesPradzia,na.narystesPabaiga
            		FROM AppBundle:Narys n, AppBundle:Asmuo a, AppBundle:NarystesApmokejimas na
            		WHERE n.id=a.id AND n.id=na.fkNarysid
            		AND na.narystesPradzia>=:nuo AND na.narystesPradzia<=:iki
            		ORDER BY na.narystesPradzia ASC
            ')->setParameter('nuo',$datanuo)
       ->setParameter('iki',$dataiki);

        $results = $sql->getResult();

        $sqlemail = $em->createQuery('
            		SELECT na.id, a.id AS narioId, n.bankoKortNumeris, a.vardas, a.pavarde,a.elPastas, a.asmensKodas,
            		na.suma, na.narystesPradzia,na.narystesPabaiga
            		FROM AppBundle:Narys n, AppBundle:Asmuo a, AppBundle:NarystesApmokejimas na
            		WHERE n.id=a.id AND n.id=na.fkNarysid
            		AND a.elPastas=:searchEmail 
            		ORDER BY na.narystesPradzia ASC
            ')->setParameter('searchEmail',$searchemail);

        $resultsemail = $sqlemail->getResult();


        return $this->render('mokejimai/uznaryste.html.twig', array(
            'narystes' => $results,
            'asmensnarystes'=>$resultsemail,

        ));
    }
}
