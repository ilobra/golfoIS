<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Asmuo;
use AppBundle\Entity\Narys;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Asmuo controller.
 *
 * @Route("admin/asmuo", name="asmenys")
 */
class AsmuoController extends Controller
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
            		SELECT a.id, a.vardas, a.pavarde, a.elPastas, a.asmensKodas, ast.name AS tipas
            		FROM AppBundle:Asmuo a, AppBundle:AsmensTipas ast
            		WHERE a.tipas = ast.idAsmensTipas');

        $results = $sql->getResult();

        return $this->render('asmuo/index.html.twig', array(
            'asmuos' => $results,
            //'tipas'=>$type,
        ));
    }

    /**
     * Creates a new asmuo entity.
     *
     * @Route("/new", name="asmuo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $asmuo = new Asmuo();
        $member=new Narys();
        $form = $this->createForm('AppBundle\Form\AsmuoType', $asmuo);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this
                ->get('security.password_encoder')
                ->encodePassword($asmuo,$asmuo->getPlainPassword());


            $type = $asmuo->getTipas();

            // ----- nustatomas asmens tipas -----
            $types = $em ->getRepository('AppBundle:AsmensTipas')
                ->find($type); //default: member
            $userType = $types->getIdAsmensTipas();
            if($userType==6){
                $asmuo->setRole("ROLE_VIP");}
            else if($userType==5){
                $asmuo->setRole("ROLE_USER");}
            else if($userType==4){
                $asmuo->setRole("ROLE_ADMIN");}
            else if($userType==3||$userType==2||$userType==1){
                $asmuo->setRole("ROLE_PERSONAL");}
            $asmuo->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($asmuo);
            $em->flush();
            if($userType==6||$userType==5)
            { $id = $asmuo->getId();
            $memberId = $em ->getRepository('AppBundle:Asmuo')
                ->find($id); //default: member id
            $member->setId($memberId);
            $em->persist($member);
            $em->flush();}

            return $this->redirectToRoute('asmuo_show', array('id' => $asmuo->getId()));
        }

        return $this->render('asmuo/new.html.twig', array(
            'asmuo' => $asmuo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a asmuo entity.
     *
     * @Route("/{id}", name="asmuo_show")
     * @Method("GET")
     */
    public function showAction(Asmuo $asmuo)
    {
        $deleteForm = $this->createDeleteForm($asmuo);
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        // ----- surandamas Asmuo pagal ID -----
//        $user = $em ->getRepository('AppBundle:Asmuo')
//            ->find($userid);
        $type = $asmuo->getTipas();
        $types = $em ->getRepository('AppBundle:AsmensTipas')
            ->find($type); //default: member
        return $this->render('asmuo/show.html.twig', array(
            'asmuo' => $asmuo,
            'tipas'=>$type,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing asmuo entity.
     *
     * @Route("/{id}/edit", name="asmuo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asmuo $asmuo)
    {
        $deleteForm = $this->createDeleteForm($asmuo);
        $editForm = $this->createForm('AppBundle\Form\AsmuoType', $asmuo);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
           if($asmuo->getPlainPassword()!=null)
           { $password = $this
                ->get('security.password_encoder')
                ->encodePassword($asmuo, $asmuo->getPlainPassword());
           $asmuo->setPassword($password);}
            $type = $asmuo->getTipas();

            // ----- nustatomas asmens tipas -----
            $types = $em ->getRepository('AppBundle:AsmensTipas')
                ->find($type); //default: member
            $userType = $types->getIdAsmensTipas();
            if($userType==6){
                $asmuo->setRole("ROLE_VIP");}
            if($userType==5){
                $asmuo->setRole("ROLE_USER");}
            if($userType==4){
                $asmuo->setRole("ROLE_ADMIN");}
            if($userType==3||$userType==2||$userType==1){
                $asmuo->setRole("ROLE_PERSONAL");}

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('asmuo_edit', array('id' => $asmuo->getId()));
        }

        return $this->render('asmuo/edit.html.twig', array(
            'asmuo' => $asmuo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a asmuo entity.
     *
     * @Route("/{id}", name="asmuo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asmuo $asmuo)
    {
        $form = $this->createDeleteForm($asmuo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asmuo);
            $em->flush();
        }

        return $this->redirectToRoute('asmuo_index');
    }

    /**
     * Creates a form to delete a asmuo entity.
     *
     * @param Asmuo $asmuo The asmuo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asmuo $asmuo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asmuo_delete', array('id' => $asmuo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
