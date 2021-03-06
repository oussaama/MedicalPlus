<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\PromoRepository")
 */
class Promo {

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
     * @ORM\Column(name="entreprise_pr", type="integer")
     */
    private $entreprisePr;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pr", type="string", length=255)
     */
    private $nomPr;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_pr", type="string", length=255)
     */
    private $categoriePr;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_pr", type="float")
     */
    private $prixPr;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_pr", type="string", length=255)
     */
    private $photoPr;

    /**
     * @var string
     *
     * @ORM\Column(name="description_pr", type="string", length=255)
     */
    private $descriptionPr;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_pr", type="datetime")
     */
    private $datePr;

    /**
     * @var \Date
     *
     * @ORM\Column(name="datefin_pr", type="date")
     */
    private $datefinPr;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="datedeb_pr", type="date")
     */
    private $datedebPr;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set entreprisePr
     *
     * @param integer $entreprisePr
     * @return Promo
     */
    public function setEntreprisePr($entreprisePr) {
        $this->entreprisePr = $entreprisePr;

        return $this;
    }

    /**
     * Get entreprisePr
     *
     * @return integer 
     */
    public function getEntreprisePr() {
        return $this->entreprisePr;
    }

    /**
     * Set nomPr
     *
     * @param string $nomPr
     * @return Promo
     */
    public function setNomPr($nomPr) {
        $this->nomPr = $nomPr;

        return $this;
    }

    /**
     * Get nomPr
     *
     * @return string 
     */
    public function getNomPr() {
        return $this->nomPr;
    }

    /**
     * Set categoriePr
     *
     * @param string $categoriePr
     * @return Promo
     */
    public function setCategoriePr($categoriePr) {
        $this->categoriePr = $categoriePr;

        return $this;
    }

    /**
     * Get categoriePr
     *
     * @return string 
     */
    public function getCategoriePr() {
        return $this->categoriePr;
    }

    /**
     * Set prixPr
     *
     * @param float $prixPr
     * @return Promo
     */
    public function setPrixPr($prixPr) {
        $this->prixPr = $prixPr;

        return $this;
    }

    /**
     * Get prixPr
     *
     * @return float 
     */
    public function getPrixPr() {
        return $this->prixPr;
    }

    /**
     * Set photoPr
     *
     * @param string $photoPr
     * @return Promo
     */
    public function setPhotoPr($photoPr) {
        $this->photoPr = $photoPr;

        return $this;
    }

    /**
     * Get photoPr
     *
     * @return string 
     */
    public function getPhotoPr() {
        return $this->photoPr;
    }

    /**
     * Set descriptionPr
     *
     * @param string $descriptionPr
     * @return Promo
     */
    public function setDescriptionPr($descriptionPr) {
        $this->descriptionPr = $descriptionPr;

        return $this;
    }

    /**
     * Get descriptionPr
     *
     * @return string 
     */
    public function getDescriptionPr() {
        return $this->descriptionPr;
    }

    /**
     * @var integer
     */
    private $descreptionPr;

    /**
     * Set descreptionPr
     *
     * @param string $descreptionPr
     * @return Promo
     */
    public function setDescreptionPr($descreptionPr) {
        $this->descreptionPr = $descreptionPr;

        return $this;
    }

    /**
     * Get descreptionPr
     *
     * @return string 
     */
    public function getDescreptionPr() {
        return $this->descreptionPr;
    }

    /**
     * Set datePr
     *
     * @param \DateTime $datePr
     * @return Promo
     */
    public function setDatePr($datePr) {
        $this->datePr = $datePr;

        return $this;
    }

    /**
     * Get datePr
     *
     * @return \DateTime 
     */
    public function getDatePr() {
        return $this->datePr;
    }

    /**
     * Set datefinPr
     *
     * @param \Date $datefinPr
     * @return Promo
     */
    public function setDatefinPr($datefinPr) {
        $this->datefinPr = $datefinPr;

        return $this;
    }

    /**
     * Get datefinPr
     *
     * @return \Date 
     */
    public function getDatefinPr() {
        return $this->datefinPr;
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
        return null === $this->photoPr ? null : $this->getUploadRootDir() . '/' . $this->photoPr;
    }

    public function getWebPath() {
        return null === $this->photoPr ? null : $this->getUploadDir() . '/' . $this->photoPr;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/promo';
    }

    public function uploads() {
        if (null === $this->getFile()) {

            return;
        }
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );
        $this->photoPr = $this->getFile()->getClientOriginalName();

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
        if (isset($this->photoPr)) {
            // store the old name to delete after the update
            $this->temp = $this->photoPr;
            $this->nomPh = null;
        } else {
            $this->nomPh = 'initial';
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
            $this->photoPr = $filename . '.' . $this->getFile()->guessExtension();
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
        $this->getFile()->move($this->getUploadRootDir(), $this->photoPr);

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
     * Set datedebPr
     *
     * @param \DateTime $datedebPr
     * @return Promo
     */
    public function setDatedebPr($datedebPr)
    {
        $this->datedebPr = $datedebPr;

        return $this;
    }

    /**
     * Get datedebPr
     *
     * @return \DateTime 
     */
    public function getDatedebPr()
    {
        return $this->datedebPr;
    }
}
