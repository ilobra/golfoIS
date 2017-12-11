<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TurnyraiController extends Controller
{
    /**
     * @Route("admin/tournaments", name="tournaments")
     */
    public function tournamentShow(Request $request){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        $sql = $em->createQuery('
            		SELECT COUNT(IDENTITY(t.fkZaidimoRezervacijaid)) AS dalyvaujaTurnyruose,  a.elPastas
            		FROM AppBundle:Turnyras t, AppBundle:Asmuo a
            		WHERE t.fkNarysid =a.id
            		GROUP BY a.id');

        $resulttournaments = $sql->getResult();


        $nuo=$request->query->get('from');
        $iki=$request->query->get('to');
        $sql = $em->createQuery('
                   SELECT IDENTITY(t.fkZaidimoRezervacijaid) as id, 
                   zr.data, zr.pradziosLaikas, zr.pabaigosLaikas, zr.pavadinimas,aikst.aikstynoInfo, COUNT(t.fkZaidimoRezervacijaid) AS dalyvauja
            		FROM AppBundle:Turnyras t, AppBundle:Asmuo a, AppBundle:ZaidimoRezervacija zr, AppBundle:Aikstynas aikst
            		WHERE t.fkNarysid =a.id AND t.fkZaidimoRezervacijaid=zr.id AND zr.fkAikstynasid=aikst.id AND zr.data>=:nuo AND zr.data<=:iki
            		GROUP BY zr.id
            		ORDER BY zr.data ASC')->setParameter('nuo',$nuo)->setParameter('iki',$iki);
            $dalvaujanciuTurnyruose=$sql->getResult();

        return $this->render('turnyrai/turnyrai.html.twig', array(
            'asmuo' => $user,

            'turnyrai'=>$dalvaujanciuTurnyruose,

        ));


    }
    /**
     * @Route("admin/tournaments/participants", name="tournamentsParticipants")
     */
    public function ShowParticipants(Request $request){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        // ----- surandamas Asmuo pagal ID -----
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        $sql = $em->createQuery('
            		SELECT r.data, r.pradziosLaikas, r.id, r.pavadinimas, r.pabaigosLaikas, a.aikstynoInfo
            		FROM AppBundle:ZaidimoRezervacija r, AppBundle:Aikstynas a
            		WHERE r.fkAikstynasid = a.id AND r.pradziosLaikas=:etime')->setParameter('etime', '16:00:00');

        $results = $sql->getResult();


        $sql = $em->createQuery('
            		SELECT COUNT(IDENTITY(t.fkZaidimoRezervacijaid)) AS dalyvaujaTurnyruose,  a.elPastas
            		FROM AppBundle:Turnyras t, AppBundle:Asmuo a
            		WHERE t.fkNarysid =a.id
            		GROUP BY a.id');

        $resulttournaments = $sql->getResult();



        $nuo=$request->query->get('from');
        $iki=$request->query->get('to');
        $sql = $em->createQuery('
                   SELECT IDENTITY(t.fkZaidimoRezervacijaid) as id, 
                   zr.data, zr.pradziosLaikas, zr.pabaigosLaikas, zr.pavadinimas,aikst.aikstynoInfo, COUNT(t.fkZaidimoRezervacijaid) AS dalyvauja
            		FROM AppBundle:Turnyras t, AppBundle:Asmuo a, AppBundle:ZaidimoRezervacija zr, AppBundle:Aikstynas aikst
            		WHERE t.fkNarysid =a.id AND t.fkZaidimoRezervacijaid=zr.id AND zr.fkAikstynasid=aikst.id AND zr.data>=:nuo AND zr.data<=:iki
            		GROUP BY zr.id
            		ORDER BY zr.data ASC')->setParameter('nuo',$nuo)->setParameter('iki',$iki);

        $dalvaujanciuTurnyruose=$sql->getResult();

        $sql=$em->createQuery('
        SELECT zr.id,zr.data, zr.pradziosLaikas, zr.pabaigosLaikas, zr.pavadinimas,aikst.aikstynoInfo, a.vardas, a.pavarde, a.elPastas
        FROM AppBundle:Turnyras t, AppBundle:Asmuo a, AppBundle:ZaidimoRezervacija zr, AppBundle:Aikstynas aikst
        WHERE t.fkNarysid =a.id AND t.fkZaidimoRezervacijaid=zr.id AND zr.fkAikstynasid=aikst.id 
        
            		GROUP BY zr.id, a.id');
        $dalyviai=$sql->getResult();


        return $this->render('turnyrai/turnyrodalyviai.html.twig', array(
            'asmuo' => $user,
            'rezultatai' => $results,
            'turnyrai'=>$dalvaujanciuTurnyruose,
            'dalyviai'=>$dalyviai,
        ));


    }
}
