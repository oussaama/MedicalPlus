<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\RendezVousRepository")
 */
class RendezVous {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="id_docteur",referencedColumnName="id")
     */
    private $idDocteur;

    /**
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="id_patient",referencedColumnName="id")
     */
    private $idPatient;

    /**
     * @var int
     *
     * @ORM\Column(name="heure_rv", type="integer")
     */
    private $heureRv;

    /**
     * @var int
     *
     * @ORM\Column(name="minute_rv", type="integer")
     */
    private $minuteRv;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_rv", type="string", length=20)
     */
    private $etatRv;
    
     /**
     * @var \Date
     *
     * @ORM\Column(name="date_rv", type="date")
     */
    private $dateRv;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cin_rv", type="integer")
     */
    private $cinRv;
    
     /**
     * @Assert\Regex(pattern="/\d/",match=false)
     * @ORM\Column(name="firstname_rv", type="string",length=20)
     */
    private $firstnameRv;
    
    /**
     * @Assert\Regex(pattern="/\d/",match=false)
     * @ORM\Column(name="lastname_rv", type="string",length=20)
     */
    private $lastnameRv;
    
    /**
     * @var int
     * @Assert\Regex(pattern="[0-9]",match=false)
     * @ORM\Column(name="tel_rv", type="integer")
     */
    private $telRv;
  
    /**
     * @Assert\Email()
     * @var string
     * @ORM\Column(name="tel_rv", type="string" ,length=50)
     */
    private $emailRv;
    
    /**
     * @var string
     * @ORM\Column(name="reserved", type="string")
     */
    private $reserved;
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set idDocteur
     *
     * @param integer $idDocteur
     * @return RendezVous
     */
    public function setIdDocteur($idDocteur) {
        $this->idDocteur = $idDocteur;

        return $this;
    }

    /**
     * Get idDocteur
     *
     * @return integer 
     */
    public function getIdDocteur() {
        return $this->idDocteur;
    }

    /**
     * Set idPatient
     *
     * @param integer $idPatient
     * @return RendezVous
     */
    public function setIdPatient($idPatient) {
        $this->idPatient = $idPatient;

        return $this;
    }

    /**
     * Get idPatient
     *
     * @return integer 
     */
    public function getIdPatient() {
        return $this->idPatient;
    }

    /**
     * Set heureRv
     *
     * @param integer $heureRv
     * @return RendezVous
     */
    public function setHeureRv($heureRv) {
        $this->heureRv = $heureRv;

        return $this;
    }

    /**
     * Get heureRv
     *
     * @return integer 
     */
    public function getHeureRv() {
        return $this->heureRv;
    }

    /**
     * Set minuteRv
     *
     * @param integer $minuteRv
     * @return RendezVous
     */
    public function setMinuteRv($minuteRv) {
        $this->minuteRv = $minuteRv;

        return $this;
    }

    /**
     * Get minuteRv
     *
     * @return integer 
     */
    public function getMinuteRv() {
        return $this->minuteRv;
    }

    /**
     * Set etatRv
     *
     * @param string $etatRv
     * @return RendezVous
     */
    public function setEtatRv($etatRv) {
        $this->etatRv = $etatRv;

        return $this;
    }

    /**
     * Get etatRv
     *
     * @return string 
     */
    public function getEtatRv() {
        return $this->etatRv;
    }


    /**
     * Set dateRv
     *
     * @param \DateTime $dateRv
     * @return RendezVous
     */
    public function setDateRv($dateRv)
    {
        $this->dateRv = $dateRv;

        return $this;
    }

    /**
     * Get dateRv
     *
     * @return \DateTime 
     */
    public function getDateRv()
    {
        return $this->dateRv;
    }

    /**
     * Set firstnameRv
     *
     * @param string $firstnameRv
     * @return RendezVous
     */
    public function setFirstnameRv($firstnameRv)
    {
        $this->firstnameRv = $firstnameRv;

        return $this;
    }

    /**
     * Get firstnameRv
     *
     * @return string 
     */
    public function getFirstnameRv()
    {
        return $this->firstnameRv;
    }

    /**
     * Set lastnameRv
     *
     * @param string $lastnameRv
     * @return RendezVous
     */
    public function setLastnameRv($lastnameRv)
    {
        $this->lastnameRv = $lastnameRv;

        return $this;
    }

    /**
     * Get lastnameRv
     *
     * @return string 
     */
    public function getLastnameRv()
    {
        return $this->lastnameRv;
    }

    /**
     * Set cinRv
     *
     * @param integer $cinRv
     * @return RendezVous
     */
    public function setCinRv($cinRv)
    {
        $this->cinRv = $cinRv;

        return $this;
    }

    /**
     * Get cinRv
     *
     * @return integer 
     */
    public function getCinRv()
    {
        return $this->cinRv;
    }

    /**
     * Set telRv
     *
     * @param integer $telRv
     * @return RendezVous
     */
    public function setTelRv($telRv)
    {
        $this->telRv = $telRv;

        return $this;
    }

    /**
     * Get telRv
     *
     * @return integer 
     */
    public function getTelRv()
    {
        return $this->telRv;
    }

    /**
     * Set emailRv
     *
     * @param string $emailRv
     * @return RendezVous
     */
    public function setEmailRv($emailRv)
    {
        $this->emailRv = $emailRv;

        return $this;
    }

    /**
     * Get emailRv
     *
     * @return string 
     */
    public function getEmailRv()
    {
        return $this->emailRv;
    }

    /**
     * Set reserved
     *
     * @param string $reserved
     * @return RendezVous
     */
    public function setReserved($reserved)
    {
        $this->reserved = $reserved;

        return $this;
    }

    /**
     * Get reserved
     *
     * @return string 
     */
    public function getReserved()
    {
        return $this->reserved;
    }
    
}
