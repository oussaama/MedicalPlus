<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\ArticleRepository")
 */
class Article {

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
     * @ORM\Column(name="auteur", type="integer")
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_art", type="text")
     */
    private $contenuArt;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_art", type="array")
     */
    private $photoArt;

    /**
     * @var \Datetime
     * 
     * @ORM\Column(name="date_art",type="datetime")
     */
    private $dateArt;

    /**
     * @var integer
     * 
     * @ORM\Column(name="auteur_id",type="integer")
     */
    private $auteurId;

    /**
     * @var string
     * 
     * @ORM\Column(name="etat_art",type="string",length=20)
     */
    private $etatArt;
    
    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="Medical\MedicalBundle\Entity\Categorie", cascade={"persist"})
     * @ORM\JoinColumn(name="categorieArt",referencedColumnName="id")
     */
    private $categorieArt;
    
     /**
     * @var integer
     * 
     * @ORM\Column(name="commentaire_art",type="integer")
     */
    private $commentaireArt;

    public function __construct() {
        $this->setDateArt(new \DateTime());
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
     * Set auteur
     *
     * @param integer $auteur
     * @return Article
     */
    public function setAuteur($auteur) {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return integer 
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set contenuArt
     *
     * @param string $contenuArt
     * @return Article
     */
    public function setContenuArt($contenuArt) {
        $this->contenuArt = $contenuArt;

        return $this;
    }

    /**
     * Get contenuArt
     *
     * @return string 
     */
    public function getContenuArt() {
        return $this->contenuArt;
    }

    /**
     * Set dateArt
     *
     * @param \DateTime $dateArt
     * @return Article
     */
    public function setDateArt($dateArt) {
        $this->dateArt = $dateArt;

        return $this;
    }

    /**
     * Get dateArt
     *
     * @return \DateTime 
     */
    public function getDateArt() {
        return $this->dateArt;
    }

    /**
     * Set photoArt
     *
     * @param string $photoArt
     * @return Article
     */
    public function setPhotoArt($photoArt) {
        $this->photoArt = $photoArt;

        return $this;
    }

    /**
     * Get photoArt
     *
     * @return string 
     */
    public function getPhotoArt() {
        return $this->photoArt;
    }

    /**
     * Set auteurId
     *
     * @param integer $auteurId
     * @return Article
     */
    public function setAuteurId($auteurId) {
        $this->auteurId = $auteurId;

        return $this;
    }

    /**
     * Get auteurId
     *
     * @return integer 
     */
    public function getAuteurId() {
        return $this->auteurId;
    }

    /**
     * Set etatArt
     *
     * @param string $etatArt
     * @return Article
     */
    public function setEtatArt($etatArt) {
        $this->etatArt = $etatArt;

        return $this;
    }

    /**
     * Get etatArt
     *
     * @return string 
     */
    public function getEtatArt() {
        return $this->etatArt;
    }
    
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    public function getAbsolutePath() {
        return null === $this->photoArt ? null : $this->getUploadRootDir() . '/' . $this->photoArt;
    }

    public function getWebPath() {
        return null === $this->photoArt ? null : $this->getUploadDir() . '/' . $this->photoArt;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/article';
    }

    public function uploads() {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );
        $this->photoArt = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setsFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->photoArt)) {
            // store the old name to delete after the update
            $this->temp = $this->photoArt;
            $this->photoArt = null;
        } else {
            $this->photoArt = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->photoArt = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->photoArt);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }



    /**
     * Set categorieArt
     *
     * @param integer $categorieArt
     * @return Article
     */
    public function setCategorieArt($categorieArt)
    {
        $this->categorieArt = $categorieArt;

        return $this;
    }

    /**
     * Get categorieArt
     *
     * @return integer 
     */
    public function getCategorieArt()
    {
        return $this->categorieArt;
    }

    /**
     * Set commentaireArt
     *
     * @param integer $commentaireArt
     * @return Article
     */
    public function setCommentaireArt($commentaireArt)
    {
        $this->commentaireArt = $commentaireArt;

        return $this;
    }

    /**
     * Get commentaireArt
     *
     * @return integer 
     */
    public function getCommentaireArt()
    {
        return $this->commentaireArt;
    }
}
