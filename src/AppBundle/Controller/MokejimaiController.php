<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;


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
        $datanuo=$request->request->get('datepicker');
        $dataiki=$request->request->get('datepicker2');

       // $data = new Date();
//        $form = $this->$this->createFormBuilder()
//            ->add('datanuo', $datanuo)
//            ->add('dataiki', $dataiki)
//            ->getForm();
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {

            $userDatenuo = $request->request->get('datepicker');

            $userDateiki = $request->request->get('datepicker2');

          //  $em = $this->getDoctrine()->getManager();
           // $em->persist($userDatenuo);
        //    $em->persist($userDateiki);
         //   $em->flush();

            //return $this->redirectToRoute('asmuo_show', array('id' => $asmuo->getId()));


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
//            		WHERE ia.isnuomojimoPradzia=:nuo AND ia.isnuomojimoPradzia=:iki
//            ')->setParameter('nuo',$userDatenuo)
//        ->setParameter('iki',$userDateiki);

            $results = $sql->getResult();
       // }
        return $this->render('mokejimai/index.html.twig', array(
            'mokejimai' => $results,

            //'tipas'=>$type,
        ));
    }

}
