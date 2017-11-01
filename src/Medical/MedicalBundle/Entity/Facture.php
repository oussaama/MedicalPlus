<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\FactureRepository")
 */
class Facture {

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
     * @ORM\JoinColumn(name="entreprise_fact",nullable="false", type="integer",referencedColumnName="id")
     */
    private $entrepriseFact;
   

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fact", type="date")
     */
    private $dateFact;

    /**
     * @var string
     *
     * @ORM\Column(name="class_fact", type="string")
     */
    private $classFact;

    /**
     * @Assert\Regex(pattern="\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b",match=false)
     * @ORM\Column(name="email_fact", type="string",length="40")
     */
    private $emailFact;
    
    /**
     * @Assert\Regex(pattern="[0-9]{8}",match=false)
     * @ORM\Column(name="tel_fact", type="integer",length="40")
     */
    private $telFact;
    
    /**
     * @var float
     *
     * @ORM\Column(name="prix_fact", type="float")
     */
    private $prixFact;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="nom_fact", type="string",length="40")
     */
    private $nomFact;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="prenom_fact", type="string",length="40")
     */
    private $prenomFact;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="commande_fact", type="array")
     */
    private $commandeFact;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="adress_fact", type="string",length="255")
     */
    private $adressFact;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="state_fact", type="string",length="40")
     */
    private $stateFact;
    
      /**
     * @var string 
     * 
     * @ORM\Column(name="city_fact", type="string",length="40")
     */
    private $cityFact;
    
      /**
     * @var string 
     * 
     * @ORM\Column(name="code_fact", type="integer")
     */
    private $codeFact;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="type_fact",type="integer")
     */
    private $typeFact;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set entrepriseFact
     *
     * @param integer $entrepriseFact
     * @return Facture
     */
    public function setEntrepriseFact($entrepriseFact) {
        $this->entrepriseFact = $entrepriseFact;

        return $this;
    }

    /**
     * Get entrepriseFact
     *
     * @return integer 
     */
    public function getEntrepriseFact() {
        return $this->entrepriseFact;
    }

    /**
     * Set dateFact
     *
     * @param \DateTime $dateFact
     * @return Facture
     */
    public function setDateFact($dateFact) {
        $this->dateFact = $dateFact;

        return $this;
    }

    /**
     * Get dateFact
     *
     * @return \DateTime 
     */
    public function getDateFact() {
        return $this->dateFact;
    }

    /**
     * Set prixFact
     *
     * @param float $prixFact
     * @return Facture
     */
    public function setPrixFact($prixFact) {
        $this->prixFact = $prixFact;

        return $this;
    }

    /**
     * Get prixFact
     *
     * @return float 
     */
    public function getPrixFact() {
        return $this->prixFact;
    }

    /**
     * Set classFact
     *
     * @param string $classFact
     * @return Facture
     */
    public function setClassFact($classFact)
    {
        $this->classFact = $classFact;

        return $this;
    }

    /**
     * Get classFact
     *
     * @return string 
     */
    public function getClassFact()
    {
        return $this->classFact;
    }

    /**
     * Set emailFact
     *
     * @param string $emailFact
     * @return Facture
     */
    public function setEmailFact($emailFact)
    {
        $this->emailFact = $emailFact;

        return $this;
    }

    /**
     * Get emailFact
     *
     * @return string 
     */
    public function getEmailFact()
    {
        return $this->emailFact;
    }

    /**
     * Set telFact
     *
     * @param string $telFact
     * @return Facture
     */
    public function setTelFact($telFact)
    {
        $this->telFact = $telFact;

        return $this;
    }

    /**
     * Get telFact
     *
     * @return string 
     */
    public function getTelFact()
    {
        return $this->telFact;
    }

    /**
     * Set nomFact
     *
     * @param string $nomFact
     * @return Facture
     */
    public function setNomFact($nomFact)
    {
        $this->nomFact = $nomFact;

        return $this;
    }

    /**
     * Get nomFact
     *
     * @return string 
     */
    public function getNomFact()
    {
        return $this->nomFact;
    }

    /**
     * Set prenomFact
     *
     * @param string $prenomFact
     * @return Facture
     */
    public function setPrenomFact($prenomFact)
    {
        $this->prenomFact = $prenomFact;

        return $this;
    }

    /**
     * Get prenomFact
     *
     * @return string 
     */
    public function getPrenomFact()
    {
        return $this->prenomFact;
    }

    /**
     * Set commandeFact
     *
     * @param array $commandeFact
     * @return Facture
     */
    public function setCommandeFact($commandeFact)
    {
        $this->commandeFact = $commandeFact;

        return $this;
    }

    /**
     * Get commandeFact
     *
     * @return array 
     */
    public function getCommandeFact()
    {
        return $this->commandeFact;
    }

    /**
     * Set adressFact
     *
     * @param string $adressFact
     * @return Facture
     */
    public function setAdressFact($adressFact)
    {
        $this->adressFact = $adressFact;

        return $this;
    }

    /**
     * Get adressFact
     *
     * @return string 
     */
    public function getAdressFact()
    {
        return $this->adressFact;
    }

    /**
     * Set stateFact
     *
     * @param string $stateFact
     * @return Facture
     */
    public function setStateFact($stateFact)
    {
        $this->stateFact = $stateFact;

        return $this;
    }

    /**
     * Get stateFact
     *
     * @return string 
     */
    public function getStateFact()
    {
        return $this->stateFact;
    }

    /**
     * Set cityFact
     *
     * @param string $cityFact
     * @return Facture
     */
    public function setCityFact($cityFact)
    {
        $this->cityFact = $cityFact;

        return $this;
    }

    /**
     * Get cityFact
     *
     * @return string 
     */
    public function getCityFact()
    {
        return $this->cityFact;
    }

    /**
     * Set codeFact
     *
     * @param integer $codeFact
     * @return Facture
     */
    public function setCodeFact($codeFact)
    {
        $this->codeFact = $codeFact;

        return $this;
    }

    /**
     * Get codeFact
     *
     * @return integer 
     */
    public function getCodeFact()
    {
        return $this->codeFact;
    }

    /**
     * Set typeFact
     *
     * @param integer $typeFact
     * @return Facture
     */
    public function setTypeFact($typeFact)
    {
        $this->typeFact = $typeFact;

        return $this;
    }

    /**
     * Get typeFact
     *
     * @return integer 
     */
    public function getTypeFact()
    {
        return $this->typeFact;
    }
}
