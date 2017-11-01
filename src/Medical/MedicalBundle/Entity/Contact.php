<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct() {
        $this->setDateCont(new \DateTime());
    }

    /**
     * @var string
     *
     * @ORM\Column(name="firstname_cont", type="string", length=40)
     */
    private $firstnameCont;

    /**
     * @Assert\Regex(pattern="/\d/",match=false)
     * @ORM\Column(name="lastname_cont", type="string", length=255)
     */
    private $lastnameCont;

    /**
     *
     * @ORM\Column(name="email_cont", type="string", length=60)
     */
    private $emailCont;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_recu", type="string", length=60)
     */
    private $emailRecu;

    /**
     * @Assert\Regex(pattern="/\d/",match=false)
     * @ORM\Column(name="subject_cont", type="string", length=120)
     */
    private $subjectCont;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_cont", type="string", length=255)
     */
    private $contenuCont;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cont", type="datetime")
     */
    private $dateCont;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_cont", type="string")
     */
    private $etatCont;

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
     * Set firstnameCont
     *
     * @param string $firstnameCont
     * @return Contact
     */
    public function setFirstnameCont($firstnameCont)
    {
        $this->firstnameCont = $firstnameCont;

        return $this;
    }

    /**
     * Get firstnameCont
     *
     * @return string 
     */
    public function getFirstnameCont()
    {
        return $this->firstnameCont;
    }

    /**
     * Set lastnameCont
     *
     * @param string $lastnameCont
     * @return Contact
     */
    public function setLastnameCont($lastnameCont)
    {
        $this->lastnameCont = $lastnameCont;

        return $this;
    }

    /**
     * Get lastnameCont
     *
     * @return string 
     */
    public function getLastnameCont()
    {
        return $this->lastnameCont;
    }

    /**
     * Set emailCont
     *
     * @param string $emailCont
     * @return Contact
     */
    public function setEmailCont($emailCont)
    {
        $this->emailCont = $emailCont;

        return $this;
    }

    /**
     * Get emailCont
     *
     * @return string 
     */
    public function getEmailCont()
    {
        return $this->emailCont;
    }

    /**
     * Set subjectCont
     *
     * @param string $subjectCont
     * @return Contact
     */
    public function setSubjectCont($subjectCont)
    {
        $this->subjectCont = $subjectCont;

        return $this;
    }

    /**
     * Get subjectCont
     *
     * @return string 
     */
    public function getSubjectCont()
    {
        return $this->subjectCont;
    }

    /**
     * Set contenuCont
     *
     * @param string $contenuCont
     * @return Contact
     */
    public function setContenuCont($contenuCont)
    {
        $this->contenuCont = $contenuCont;

        return $this;
    }

    /**
     * Get contenuCont
     *
     * @return string 
     */
    public function getContenuCont()
    {
        return $this->contenuCont;
    }

    /**
     * Set dateCont
     *
     * @param \DateTime $dateCont
     * @return Contact
     */
    public function setDateCont($dateCont)
    {
        $this->dateCont = $dateCont;

        return $this;
    }

    /**
     * Get dateCont
     *
     * @return \DateTime 
     */
    public function getDateCont()
    {
        return $this->dateCont;
    }

    /**
     * Set etatCont
     *
     * @param string $etatCont
     * @return Contact
     */
    public function setEtatCont($etatCont)
    {
        $this->etatCont = $etatCont;

        return $this;
    }

    /**
     * Get etatCont
     *
     * @return string 
     */
    public function getEtatCont()
    {
        return $this->etatCont;
    }

    /**
     * Set emailRecu
     *
     * @param string $emailRecu
     * @return Contact
     */
    public function setEmailRecu($emailRecu)
    {
        $this->emailRecu = $emailRecu;

        return $this;
    }

    /**
     * Get emailRecu
     *
     * @return string 
     */
    public function getEmailRecu()
    {
        return $this->emailRecu;
    }
}
