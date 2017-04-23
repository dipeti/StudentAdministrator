<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StudyGroup;
use AppBundle\Form\StudyGroupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class StudyGroupController extends Controller
{
    /**
     *@Route("group/add", name="add_group")
     */
    public function addAction(Request $request)
    {
        $group = new StudyGroup();
        $form = $this->createForm(StudyGroupType::class,$group)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            $this->addFlash('success','Study group successfully added.');
            return $this->redirectToRoute('index');
        }

        return $this->render('group/add_group.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     *@Route("group/edit/{id}", name="edit_group")
     */
    public function editAction(Request $request, StudyGroup $group)
    {
        $group = new StudyGroup();
        $form = $this->createForm(StudyGroupType::class,$group)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success','Study group successfully edited.');
            return $this->redirectToRoute('index');
        }

        return $this->render('group/add_group.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
