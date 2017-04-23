<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Events;
use AppBundle\Form\StudentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $request->query->get('page', 1);
        $groupsRepo = $em->getRepository('AppBundle:StudyGroup');
        $groups = $groupsRepo->findAll();
        $studentsRepo = $em->getRepository('AppBundle:Student');
        if ($request->query->has('name'))
        {
            $nameFilter = $request->query->get('name');
            $students = $studentsRepo->findByName($nameFilter,$page);
            return $this->render('index/index.html.twig',[
                'students' => $students,
                'groups' => $groups,
            ]);
        }
        elseif ($request->query->has('groups'))
        {
            $groupFilter = $request->query->get('groups');
            $studyGroupsRepo = $this->getDoctrine()->getRepository('AppBundle:StudyGroup');
            $students = $studyGroupsRepo->findByGroups($groupFilter,$page);
            return $this->render('index/index.html.twig',[
                'students' => $students,
                'groups' => $groups,
                'query' => ['groups' => $groupFilter]
            ]);
        }
       $students = $studentsRepo->findAll($page);
       return $this->render('index/index.html.twig',[
           'students' => $students,
           'groups' => $groups,
       ]);
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
          $this->addFlash('success','Student successfully added.');
          return $this->redirectToRoute('index');
        }

        return $this->render(':student:add_student.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("student/edit/{id}", name="edit_student")
     */
    public function editAction(Request $request, Student $student)
    {
        $form = $this->createForm(StudentType::class, $student)
            ->add('submit', SubmitType::class)
            ->add('remove', SubmitType::class, ['attr' => ['class' => 'btn-danger']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if ($form->get('remove')->isClicked())
            {
                $em->remove($student);
                $this->addFlash('success','Student successfully deleted.');
            }
            else
            {
                $this->addFlash('success','Student successfully edited.');
                $this->get('event_dispatcher')->dispatch(Events::DATA_MODIFIED,new GenericEvent($student));
            }
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render(':student:add_student.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
