<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_cat", type="string", length=50)
     */
    private $nomCat;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="type_cat",type="string",length="20")
     */
    private $typeCat;


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
     * Set nomCat
     *
     * @param string $nomCat
     * @return Categorie
     */
    public function setNomCat($nomCat)
    {
        $this->nomCat = $nomCat;

        return $this;
    }

    /**
     * Get nomCat
     *
     * @return string 
     */
    public function getNomCat()
    {
        return $this->nomCat;
    }

    /**
     * Set typeCat
     *
     * @param string $typeCat
     * @return Categorie
     */
    public function setTypeCat($typeCat)
    {
        $this->typeCat = $typeCat;

        return $this;
    }

    /**
     * Get typeCat
     *
     * @return string 
     */
    public function getTypeCat()
    {
        return $this->typeCat;
    }
}
