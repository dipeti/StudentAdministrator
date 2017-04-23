<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render(':index:index.html.twig');
    }


    /**
     * @Route("student/add", name="add_student")
     */
    public function addAction(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class,$student)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
          $em = $this->getDoctrine()->getManager();
          $em->persist($student);
          $em->flush();
          return $this->redirectToRoute('index');
        }

        return $this->render(':student:add_student.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
