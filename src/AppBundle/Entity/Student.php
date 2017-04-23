<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 * @ORM\Table(name="students")
 */
class Student
{
    const NUM_ITEMS = 10;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Assert\Choice(choices = {"male", "female"})
     * @ORM\Column(type="string")
     */
    private $sex;

    /**
     * @ORM\Column(type="string")
     */
    private $placeOfBirth;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @Assert\Count(max="4", maxMessage="A student cannot take part in more than {{ limit }} study groups.")
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\StudyGroup", inversedBy="students")
     * @ORM\JoinTable(name="students_student_groups")
     */
    private $studyGroups;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studyGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Student
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set placeOfBirth
     *
     * @param string $placeOfBirth
     *
     * @return Student
     */
    public function setPlaceOfBirth($placeOfBirth)
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    /**
     * Get placeOfBirth
     *
     * @return string
     */
    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Student
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add studyGroup
     *
     * @param \AppBundle\Entity\StudyGroup $studyGroup
     *
     * @return Student
     */
    public function addStudyGroup(\AppBundle\Entity\StudyGroup $studyGroup)
    {
        $studyGroup->addStudent($this);// Student is the owning side, make sure you persist the association through the Student
        $this->studyGroups[] = $studyGroup;

        return $this;
    }

    /**
     * Remove studyGroup
     *
     * @param \AppBundle\Entity\StudyGroup $studyGroup
     */
    public function removeStudyGroup(\AppBundle\Entity\StudyGroup $studyGroup)
    {
        $studyGroup->removeStudent($this);
        $this->studyGroups->removeElement($studyGroup);
    }

    /**
     * Get studyGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudyGroups()
    {
        return $this->studyGroups;
    }
}
