<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Student;
use AppBundle\Mailer\Mailer;
use Symfony\Component\EventDispatcher\GenericEvent;

class DataModifiedSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;
    public function __construct(\AppBundle\Mailer\Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public static function getSubscribedEvents()
    {
        return ['data.modified' => 'onDataModified'];
    }

    public function onDataModified(GenericEvent $event)
    {
        if ($event->getSubject() instanceof Student)
        {
            $student = $event->getSubject();
            $this->mailer->sendNotificationEmail($student);
        }
    }
}