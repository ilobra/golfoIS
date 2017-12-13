<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aikstynas;
use AppBundle\Entity\AikstynoTvarkymas;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\IrangosTipas;
use AppBundle\Entity\StovejimoAikstele;
use AppBundle\Entity\Iranga;
use AppBundle\Entity\IrangosApmokejimas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PersonalasController extends Controller
{
    /**
     * @Route("personnel/profile", name="profile_personnel")
     */
    public function profileAction()
    {
        $userid = $this->getUser()->getId();
        return $this->redirectToRoute('profile_personnel_show', [ 'id' => $userid ]);

    }

    /**
     * @Route("personnel/profile/{id}", name="profile_personnel_show")
     */
    public function profilePersonnelShow(Asmuo $id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Asmuo')
            ->find($id);

        $darbuotojas = $em->getRepository('AppBundle:Darbuotojas')->find($id);

        return $this->render('personalas/profile.html.twig', array(
            'asmuo' => $user,
            'personalas' => $darbuotojas,
        ));
    }

    /**
     * @Route("personnel/profile/{id}/edit", name="profile_personnel_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Asmuo $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profilePersonnelEdit(Request $request, Asmuo $id){

        $em = $this->getDoctrine()->getManager();

        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($id);

        $editForm = $this->createForm('AppBundle\Form\PersonalasType', $user);
        $editForm->handleRequest($request);

        $em->persist($user);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($user->getPlainPassword()!=null){
                $password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profile_personnel_show', array('id' => $user->getId()));
        }
        return $this->render('personalas/edit.html.twig', array(
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }

    // STOVĖJIMO AIKŠTELĖS DARBUOTOJŲ FUNKCIJOS

    /**
     * @Route("personnel/stovejimo_aikstele_index", name="stovejimo_aikstele_index")
     */
    public function stovejimoAiksteleIndex(){

        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $sql = $em->createQuery('
                    SELECT SA.vietosNr, SA.priskyrimoData, SA.id, A.vardas, A.elPastas
                    FROM AppBundle:StovejimoAikstele SA
                    LEFT JOIN AppBundle:Asmuo A WITH SA.fkAsmuoid=A.id
                    GROUP BY SA.id
            		ORDER BY SA.vietosNr DESC');
        $SVietos = $sql->getResult();

        return $this->render('personalas/stovejimo_aikstele.html.twig', array(
            'vietos' => $SVietos,
            'asmuo' => $user,
        ));
    }

    /**
     * @Route("/personnel/stovejimo_aikstele/{id}/add", name="stovejimo_aikstele_add")
     * @Method({"GET", "POST"})
     */
    public function stovejimoAiksteleAdd(Request $request, StovejimoAikstele $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $aikstele = $em->getRepository('AppBundle:StovejimoAikstele')
            ->find($id);

        $editForm = $this->createForm('AppBundle\Form\StovejimoAiksteleType', $aikstele);
        $editForm->handleRequest($request);
        try {
            $em->persist($aikstele);
            $em->flush();
        }
        catch(\Doctrine\DBAL\DBALException $e)
        {
            $this->addFlash('danger', 'Pasirinktas vartotojas jau turi pirskirtą stovėjimo vietą');
            return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
        }
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vartotojui sėkmingai priskirta vieta');
            return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
        }
        return $this->render('personalas/stovejimo_aikstele_add.html.twig', array(
            'aikstele' => $aikstele,
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/personnel/stovejimo_aikstele/{id}/delete", name="stovejimo_aikstele_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function stovejimoAiksteleDelete(StovejimoAikstele $id){
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $sql = $em->createQuery('
            		UPDATE AppBundle:StovejimoAikstele SA
            		SET SA.priskyrimoData=null, SA.fkAsmuoid=null
            		WHERE SA.id = :id
            ')->setParameter('id', $id);

        $sql->execute();

        return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
    }

    // GOLFO AIKŠTYNO DARBUOTOJŲ FUNKCIJOS

    /**
     * @Route("personnel/aikstyno_tvarkymas", name="aikstyno_tvarkymas_index")
     */
    public function aikstynoTvarkymasIndex(){

        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $data = new \DateTime();

        $sql = $em->createQuery('
                    SELECT ait.data, ait.pradziosLaikas, ait.pabaigosLaikas, ai.aikstynoInfo, ait.id
                    FROM AppBundle:AikstynoTvarkymas ait, AppBundle:Aikstynas ai
                    WHERE ai.id = ait.fkAikstynasid AND ait.fkDarbuotojasid = :id
            		ORDER BY ait.data DESC, ai.aikstynoInfo ASC, ait.pradziosLaikas DESC ')->setParameter('id', $userid);
        $rezervuotiLaikai = $sql->getResult();



        return $this->render('personalas/aikstyno_tvarkymas_index.html.twig', array(
            'asmuo' => $user,
            'data' => $data,
            'laikai' =>$rezervuotiLaikai,
        ));
    }

    /**
     * @Route("personnel/aikstyno_tvarkymas/show", name="aikstyno_tvarkymas_index_date")
     */
    public function aikstynoTvarkymasIndexDate(Request $request){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $userDate = $request->request->get('date');

        $timeMor1 = '11:00:00';
        $timeMor2 = '12:00:00';
        $timeDay1 = '15:00:00';
        $timeDay2 = '16:00:00';

        $sql = $em->createQuery('
                    SELECT aik.id, aik.aikstynoInfo
                    FROM AppBundle:Aikstynas aik
            		ORDER BY aik.aikstynoInfo DESC');
        $aikstynai = $sql->getResult();

        $sql = $em->createQuery('
            		SELECT IDENTITY(t.fkAikstynasid) AS id 
            		FROM AppBundle:AikstynoTvarkymas t
            		WHERE t.data = :dat')->setParameters(['dat' => $userDate ]);

        $results1 = $sql->getResult();

        return $this->render('personalas/aikstyno_tvarkymas_show.html.twig', array(
            'asmuo' => $user,
            'aikstynai' => $aikstynai,
            'laikasRyt' => $timeMor1,
            'laikasRyt1' => $timeMor2,
            'laikasDien' => $timeDay1,
            'laikasDien1' => $timeDay2,
            'data' => $userDate,
            'dalyvauja' => $results1,
        ));
    }

    /**
     * @Route("personnel/aikstyno_tvarkymas/{id}/add/{data}/{laikasPr}/{laikasPab}", name="aikstyno_tvarkymas_add")
     */
    public function aikstynoTvarkymasAdd(Request $request, Aikstynas $id, string $data, string $laikasPr, string $laikasPab){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);
        $darbuotojas = $em->getRepository('AppBundle:Darbuotojas')->find($userid);

        $result = new AikstynoTvarkymas();
        $data1 = \DateTime::createFromFormat('Y-m-d', $data);
        $laikasPr1 = \DateTime::createFromFormat('H:i:s', $laikasPr);
        $laikasPab1 = \DateTime::createFromFormat('H:i:s', $laikasPab);


            $result->setData($data1);
            $result->setPabaigosLaikas($laikasPab1);
            $result->setPradziosLaikas($laikasPr1);
            $form = $this->createForm('AppBundle\Form\AikstynoTvarkymasType', $result);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $result->setFkDarbuotojasid($darbuotojas);
                $result->setFkAikstynasid($id);
                $em->persist($result);
                $em->flush();

                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('aikstyno_tvarkymas_index', array('id' => $userid));
            }

        return $this->render('personalas/aikstyno_tvarkymas_add.html.twig',
            [   'asmuo' => $user,
                'form' => $form->createView(),
                ]);

    }
    /**
     * @Route("personnel/aikstyno_tvarkymas/{id}/edit", name="aikstyno_tvarkymas_edit")
     * @Method({"GET", "POST"})
     */
    public function aikstynoTvarkymasEdit(Request $request, AikstynoTvarkymas $id){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);
        $tvarkymas = $em ->getRepository('AppBundle:AikstynoTvarkymas')->find($id);


        $editForm = $this->createForm('AppBundle\Form\AikstynoTvarkymasType', $tvarkymas);
        $editForm->handleRequest($request);

        $em->persist($tvarkymas);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('aikstyno_tvarkymas_index', array('id' => $userid));
        }
        return $this->render('personalas/aikstyno_tvarkymai_edit.html.twig', array(
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }
    // IRANGOS NUOMOS DARBUOTOJŲ FUNKCIJOS

    /**
     * @Route("personnel/iranga_apmokejimai", name="iranga_apmokejimai_index")
     */
    public function irangaApmokejimaiIndex(Request $request){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        $equipmentType = $em -> getRepository('AppBundle:IrangosTipas')->findAll();

        $tipas=$request->query->get('tipas');

        if ($tipas == '') {
            $sql = $em->createQuery('
                    SELECT i.kokybe, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, ia.suma, it.name as tipas, asm.elPastas
                    FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia, AppBundle:Asmuo asm
                    WHERE i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid AND asm.id=ia.fkNarysid
                    ORDER BY i.tipas DESC
                    ');
        }
        else {
            $sql = $em->createQuery('
                    SELECT i.kokybe, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, ia.suma, it.name as tipas, asm.elPastas
                    FROM AppBundle:Iranga i, AppBundle:IrangosTipas it, AppBundle:IrangosApmokejimas ia, AppBundle:Asmuo asm
                    WHERE i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid AND asm.id=ia.fkNarysid AND it.name = :tipas
                    ORDER BY i.tipas DESC
                    ')->setParameter('tipas', $tipas);
        }
        $equipment = $sql->getResult();

        return $this->render('personalas/iranga_apmokejimai_index.html.twig', array(
            'asmuo' => $user,
            'iranga' => $equipment,
            'visaIranga' => $equipmentType,
        ));
    }
    /**
     * @Route("personnel/iranga", name="iranga_index")
     */
    public function irangaIndex(){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $sql = $em->createQuery('
                    SELECT i.kokybe, i.isigijimoData, it.name as tipas, i.id
                    FROM AppBundle:Iranga i, AppBundle:IrangosTipas it
                    WHERE i.tipas=it.idIrangosTipas
                    Order BY it.name ASC, i.kokybe ASC
                    ');
        $equipment = $sql->getResult();

        return $this->render('personalas/iranga_index.html.twig', array(
            'asmuo' => $user,
            'iranga' => $equipment,
        ));
    }

    /**
     * @Route("personnel/iranga/{id}/show", name="iranga_show")
     * @param Iranga $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function irangaShow(Iranga $id){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Asmuo')->find($userid);

        $iranga = $em->getRepository('AppBundle:Iranga')->find($id);

        $sql = $em->createQuery('
                    SELECT ia.suma, ia.isnuomojimoPradzia, ia.isnuomojimoPabaiga, it.name as tipas, i.kokybe
                    FROM AppBundle:Iranga i, AppBundle:IrangosApmokejimas ia, AppBundle:IrangosTipas it
                    WHERE i.tipas=it.idIrangosTipas AND i.id=ia.fkIrangaid AND i.id = :id
                    ORDER BY i.tipas DESC
                    ')->setParameter('id', $id);

        $irangos_apmokejimai = $sql->getResult();

        return $this->render('personalas/iranga_show.html.twig', array(
            'asmuo' => $user,
            'iranga' => $iranga,
            'apmokejimai' => $irangos_apmokejimai,
        ));
    }

    /**
     * @Route("personnel/iranga/{id}/edit", name="iranga_edit")
     * @Method({"GET", "POST"})
     */
    public function irangaEdit(Request $request, Iranga $id){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);
        $iranga = $em->getRepository('AppBundle:Iranga')->find($id);


        $editForm = $this->createForm('AppBundle\Form\IrangaType', $iranga);
        $editForm->handleRequest($request);

        $em->persist($iranga);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('iranga_index', array('id' => $userid));
        }
        return $this->render('personalas/iranga_edit.html.twig', array(
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * @Route("personnel/iranga/add", name="iranga_add")
     */
    public function irangaAdd(Request $request){

        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $result = new Iranga();

        $form = $this->createForm('AppBundle\Form\IrangaType', $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($result);
            $em->flush();

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('iranga_index', array('id' => $userid));
        }

        return $this->render('personalas/iranga_add.html.twig',
            [   'asmuo' => $user,
                'form' => $form->createView(),
            ]);

    }
    /**
     * @Route("personnel/iranga/{id}/delete", name="iranga_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function irangaDelete(Iranga $id){
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $iranga = $em ->getRepository('AppBundle:Iranga')->find($id);

        $sql = $em->createQuery('
                    DELETE 
                    FROM AppBundle:IrangosApmokejimas ia
                    WHERE ia.fkIrangaid = :id
                    ')->setParameter('id', $id);
        $sql->execute();

        $em->remove($iranga);
        $em->flush();

        return $this->redirectToRoute('iranga_index');
    }
}
