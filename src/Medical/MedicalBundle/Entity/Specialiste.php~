<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialiste
 *
 * @ORM\Table(name="specialiste")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\SpecialisteRepository")
 */
class Specialiste
{
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
     * @ORM\Column(name="nom_spec", type="string", length=40)
     */
    private $nomSpec;


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
     * Set nomSpec
     *
     * @param string $nomSpec
     * @return Specialiste
     */
    public function setNomSpec($nomSpec)
    {
        $this->nomSpec = $nomSpec;

        return $this;
    }

    /**
     * Get nomSpec
     *
     * @return string 
     */
    public function getNomSpec()
    {
        return $this->nomSpec;
    }
}
