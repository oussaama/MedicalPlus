<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\PanierRepository")
 */
class Panier {

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
     * @ORM\JoinColumn(name="patient_p",nullable="false", type="integer",referencedColumnName="id")
     */
    private $patientP;

    /**
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\Medicament", cascade={"persist"})
     * @ORM\JoinColumn(name="produit_p",nullable="false", type="integer",referencedColumnName="id")
     */
    private $produitP;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_p", type="integer")
     */
    private $stockP;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_p", type="datetime")
     */
    private $dateP;
    
    /**
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="entreprise_p",nullable="false", type="integer",referencedColumnName="id")
     */
    private $entrepriseP;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set patientP
     *
     * @param integer $patientP
     * @return Panier
     */
    public function setPatientP($patientP) {
        $this->patientP = $patientP;

        return $this;
    }

    /**
     * Get patientP
     *
     * @return integer 
     */
    public function getPatientP() {
        return $this->patientP;
    }

    /**
     * Set produitP
     *
     * @param integer $produitP
     * @return Panier
     */
    public function setProduitP($produitP) {
        $this->produitP = $produitP;

        return $this;
    }

    /**
     * Get produitP
     *
     * @return integer 
     */
    public function getProduitP() {
        return $this->produitP;
    }

    /**
     * Set stockP
     *
     * @param integer $stockP
     * @return Panier
     */
    public function setStockP($stockP) {
        $this->stockP = $stockP;

        return $this;
    }

    /**
     * Get stockP
     *
     * @return integer 
     */
    public function getStockP() {
        return $this->stockP;
    }

    /**
     * Set dateP
     *
     * @param \DateTime $dateP
     * @return Panier
     */
    public function setDateP($dateP) {
        $this->dateP = $dateP;

        return $this;
    }

    /**
     * Get dateP
     *
     * @return \DateTime 
     */
    public function getDateP() {
        return $this->dateP;
    }


    /**
     * Set entrepriseP
     *
     * @param integer $entrepriseP
     * @return Panier
     */
    public function setEntrepriseP($entrepriseP)
    {
        $this->entrepriseP = $entrepriseP;

        return $this;
    }

    /**
     * Get entrepriseP
     *
     * @return integer 
     */
    public function getEntrepriseP()
    {
        return $this->entrepriseP;
    }
}
