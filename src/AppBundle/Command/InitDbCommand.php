<?php

namespace AppBundle\Command;

use AppBundle\Entity\Student;
use AppBundle\Entity\StudyGroup;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:db:init')
            ->setDescription('Populates the tables of the database.')
            ->setHelp('This command is required for the application to run properly. It populates the tables of the database with all the necessary records.')
            ->addOption('force',null,InputOption::VALUE_NONE,'Without the --force flag the data are NOT persisted in the database.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'Inserting data...',
            '=================']);

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        if (0 !== count($em->getRepository('AppBundle:Student')->findAll()))
        {
            $output->writeln('The tables are already populated with the necessary data.');
            exit;
        }

        $groups = [];
        /**
         * Inserting study groups
         */
        for ($i = 0; $i < 5 ; $i++)
        {
            $studyGroup = new StudyGroup();
            $studyGroup->setName('StudyGroup #'.$i);
            $studyGroup->setTime(new \DateTime());
            $studyGroup->setLeader('Leader #'.$i);
            $studyGroup->setSubject('Subject #'.$i);
            $em->persist($studyGroup);
            $groups[] = $studyGroup;

        }

        /**
         * Inserting students
         */
        for ($i = 0; $i < 20 ; $i++)
        {
            $student = new Student();
            $student->setName('Student #'.$i);
            $student->setDateOfBirth(new \DateTime('now'));
            $student->setPlaceOfBirth('Budapest');
            $student->setEmail($student->getEmail().'@student.com');
            $student->setSex('male');
            $student->addStudyGroup($groups[rand(0,count($groups)-1)]);
            $em->persist($student);
        }
        /**
         * Make sure you run the command with '--force'
         */
        if($input->getOption('force'))
        {
            $em->flush();
        }
        $output->writeln('Command successfully finished!');
    }

}