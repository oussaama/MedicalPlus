<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\NotificationRepository")
 */
class Notification {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="destinateur", type="string", length=255)
     */
    private $destinateur;

    /**
     * @var string
     *
     * @ORM\Column(name="expediteur", type="string", length=255)
     */
    private $expediteur;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet_not", type="string", length=100)
     */
    private $sujetNot;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_not", type="string", length=255)
     */
    private $contenuNot;
    
     /**
     * @var string
     *
     * @ORM\Column(name="etat_not", type="string", length=20)
     */
    private $etatNot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_not", type="datetime")
     */
    private $dateNot;

    public function __construct() {
        $this->setDateNot(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set destinateur
     *
     * @param string $destinateur
     * @return Notification
     */
    public function setDestinateur($destinateur) {
        $this->destinateur = $destinateur;

        return $this;
    }

    /**
     * Get destinateur
     *
     * @return string 
     */
    public function getDestinateur() {
        return $this->destinateur;
    }

    /**
     * Set expediteur
     *
     * @param string $expediteur
     * @return Notification
     */
    public function setExpediteur($expediteur) {
        $this->expediteur = $expediteur;

        return $this;
    }

    /**
     * Get expediteur
     *
     * @return string 
     */
    public function getExpediteur() {
        return $this->expediteur;
    }

    /**
     * Set sujetNot
     *
     * @param string $sujetNot
     * @return Notification
     */
    public function setSujetNot($sujetNot) {
        $this->sujetNot = $sujetNot;

        return $this;
    }

    /**
     * Get sujetNot
     *
     * @return string 
     */
    public function getSujetNot() {
        return $this->sujetNot;
    }

    /**
     * Set contenuNot
     *
     * @param string $contenuNot
     * @return Notification
     */
    public function setContenuNot($contenuNot) {
        $this->contenuNot = $contenuNot;

        return $this;
    }

    /**
     * Get contenuNot
     *
     * @return string 
     */
    public function getContenuNot() {
        return $this->contenuNot;
    }

    /**
     * Set dateNot
     *
     * @param \DateTime $dateNot
     * @return Notification
     */
    public function setDateNot($dateNot) {
        $this->dateNot = $dateNot;

        return $this;
    }

    /**
     * Get dateNot
     *
     * @return \DateTime 
     */
    public function getDateNot() {
        return $this->dateNot;
    }


    /**
     * Set etatNot
     *
     * @param string $etatNot
     * @return Notification
     */
    public function setEtatNot($etatNot)
    {
        $this->etatNot = $etatNot;

        return $this;
    }

    /**
     * Get etatNot
     *
     * @return string 
     */
    public function getEtatNot()
    {
        return $this->etatNot;
    }
}
