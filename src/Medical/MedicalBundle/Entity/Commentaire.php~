<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="utilisateur_com",nullable="false", type="integer",referencedColumnName="id")
     */
    private $utilisateurCom;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\Article", cascade={"persist"})
     * @ORM\JoinColumn(name="article_com",nullable="false", type="integer",referencedColumnName="id")
     */
    private $articleCom;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_com", type="datetime")
     */
    private $dateCom;

     /**
     * @var string
     *
     * @ORM\Column(name="type_com", type="string" length=40)
     */
    private $typeCom;

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
     * Set utilisateurCom
     *
     * @param integer $utilisateurCom
     * @return Commentaire
     */
    public function setUtilisateurCom($utilisateurCom)
    {
        $this->utilisateurCom = $utilisateurCom;

        return $this;
    }

    /**
     * Get utilisateurCom
     *
     * @return integer 
     */
    public function getUtilisateurCom()
    {
        return $this->utilisateurCom;
    }

    /**
     * Set articleCom
     *
     * @param integer $articleCom
     * @return Commentaire
     */
    public function setArticleCom($articleCom)
    {
        $this->articleCom = $articleCom;

        return $this;
    }

    /**
     * Get articleCom
     *
     * @return integer 
     */
    public function getArticleCom()
    {
        return $this->articleCom;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set dateCom
     *
     * @param \DateTime $dateCom
     * @return Commentaire
     */
    public function setDateCom($dateCom)
    {
        $this->dateCom = $dateCom;

        return $this;
    }

    /**
     * Get dateCom
     *
     * @return \DateTime 
     */
    public function getDateCom()
    {
        return $this->dateCom;
    }

    /**
     * Set typeCom
     *
     * @param string $typeCom
     * @return Commentaire
     */
    public function setTypeCom($typeCom)
    {
        $this->typeCom = $typeCom;

        return $this;
    }

    /**
     * Get typeCom
     *
     * @return string 
     */
    public function getTypeCom()
    {
        return $this->typeCom;
    }
}
