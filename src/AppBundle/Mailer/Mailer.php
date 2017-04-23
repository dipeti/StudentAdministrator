<?php
/**
 * Created by PhpStorm.
 * User: dipet
 * Date: 2017. 04. 23.
 * Time: 20:54
 */

namespace AppBundle\Mailer;


use AppBundle\Entity\Student;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class Mailer
{

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $fromAddress;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $templating
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, RouterInterface $router, $fromAddress)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->fromAddress = $fromAddress;
    }


    /**
     * Send an email to notify the student about personal data changes.
     *
     * @param Student $student
     */
    public function sendNotificationEmail(Student $student)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Changes in personal data.')
            ->setFrom($this->fromAddress)
            ->setTo($student->getEmail())
            ->setBody($this->templating->render('email/email.txt.twig',[
                'student' => $student,
                'groups' => $student->getStudyGroups(),
            ]));
        $this->mailer->send($message);
    }


}