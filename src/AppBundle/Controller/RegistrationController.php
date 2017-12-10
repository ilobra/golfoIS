<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegistrationType;
use AppBundle\Entity\Asmuo;
use AppBundle\Entity\Narys;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new Asmuo();
        $member = new Narys();

        $form = $this->createForm(RegistrationType::class, $user, [
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            // nustatomas nario asmens tipas (id=5)
            $tipas = $em ->getRepository('AppBundle:AsmensTipas')
                         ->find(5); //default: member
            $user->setTipas($tipas);
            $user->setRole("ROLE_USER");
            $em->persist($user);
            $em->flush();

            $id = $user->getId();
            $memberId = $em ->getRepository('AppBundle:Asmuo')
                            ->find($id); //default: member id
            $member->setId($memberId);
            $em->persist($member);
            $em->flush();

            $this->addFlash('success', 'Registracija sėkminga!');

            return $this->redirectToRoute('startpage');
        }

        return $this->render('registration/register.html.twig',
            ['register_form' => $form->createView() ]);
    }
}
