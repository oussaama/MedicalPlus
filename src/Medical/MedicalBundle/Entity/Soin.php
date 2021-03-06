<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Soin
 *
 * @ORM\Table(name="soin")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\SoinRepository")
 */
class Soin {
    
    public function __construct() {
        $this->setDateSoin(new \DateTime());
    }

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
     * @ORM\Column(name="nom_soin", type="string", length=100)
     */
    private $nomSoin;

    /**
     * @var string
     *
     * @ORM\Column(name="description_soin", type="text")
     */
    private $descriptionSoin;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_soin", type="float")
     */
    private $prixSoin;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_soin", type="datetime")
     */
    private $dateSoin;

    /**
     * @ORM\ManyToOne(targetEntity="Medical\MedicalBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(name="entreprise_soin",referencedColumnName="id")
     */
    private $entrepriseSoin;

    /**
     * @var string
     * @ORM\Column(name="photo_soin",type="string")
     */
    private $photoSoin;
    
    
    /**
     * @var string
     * @ORM\Column(name="type_soin",type="string",length=30)
     */
    private $typeSoin;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set referenceSoin
     *
     * @param string $referenceSoin
     * @return Soin
     */
    public function setReferenceSoin($referenceSoin) {
        $this->referenceSoin = $referenceSoin;

        return $this;
    }

    /**
     * Get referenceSoin
     *
     * @return string 
     */
    public function getReferenceSoin() {
        return $this->referenceSoin;
    }

    /**
     * Set nomSoin
     *
     * @param string $nomSoin
     * @return Soin
     */
    public function setNomSoin($nomSoin) {
        $this->nomSoin = $nomSoin;

        return $this;
    }

    /**
     * Get nomSoin
     *
     * @return string 
     */
    public function getNomSoin() {
        return $this->nomSoin;
    }

    /**
     * Set descriptionSoin
     *
     * @param string $descriptionSoin
     * @return Soin
     */
    public function setDescreptionSoin($descriptionSoin) {
        $this->descriptionSoin = $descriptionSoin;

        return $this;
    }

    /**
     * Get descriptionSoin
     *
     * @return string 
     */
    public function getDescreptionSoin() {
        return $this->descriptionSoin;
    }

    /**
     * Set prixSoin
     *
     * @param float $prixSoin
     * @return Soin
     */
    public function setPrixSoin($prixSoin) {
        $this->prixSoin = $prixSoin;

        return $this;
    }

    /**
     * Get prixSoin
     *
     * @return float 
     */
    public function getPrixSoin() {
        return $this->prixSoin;
    }

    /**
     * Set dateSoin
     *
     * @param \Datetime $dateSoin
     * @return Soin
     */
    public function setDateSoin($dateSoin) {
        $this->dateSoin = $dateSoin;

        return $this;
    }

    /**
     * Get dateSoin
     *
     * @return \Datetime 
     */
    public function getDateSoin() {
        return $this->dateSoin;
    }

    /**
     * Set entrepriseSoin
     *
     * @param integer $entrepriseSoin
     * @return Soin
     */
    public function setEntrepriseSoin($entrepriseSoin) {
        $this->entrepriseSoin = $entrepriseSoin;

        return $this;
    }

    /**
     * Get entrepriseSoin
     *
     * @return integer 
     */
    public function getEntrepriseSoin() {
        return $this->entrepriseSoin;
    }

    /**
     * Set descriptionSoin
     *
     * @param string $descriptionSoin
     * @return Soin
     */
    public function setDescriptionSoin($descriptionSoin) {
        $this->descriptionSoin = $descriptionSoin;

        return $this;
    }

    /**
     * Get descriptionSoin
     *
     * @return string 
     */
    public function getDescriptionSoin() {
        return $this->descriptionSoin;
    }


    /**
     * Set photoSoin
     *
     * @param string $photoSoin
     * @return Soin
     */
    public function setPhotoSoin($photoSoin)
    {
        $this->photoSoin = $photoSoin;

        return $this;
    }

    /**
     * Get photoSoin
     *
     * @return string 
     */
    public function getPhotoSoin()
    {
        return $this->photoSoin;
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
        return null === $this->photoSoin ? null : $this->getUploadRootDir() . '/' . $this->photoSoin;
    }

    public function getWebPath() {
        return null === $this->photoSoin ? null : $this->getUploadDir() . '/' . $this->photoSoin;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/soin';
    }

    public function uploads() {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );
        $this->photoSoin = $this->getFile()->getClientOriginalName();

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
        if (isset($this->photoSoin)) {
            // store the old name to delete after the update
            $this->temp = $this->photoSoin;
            $this->photoSoin = null;
        } else {
            $this->photoMed = 'initial';
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
            $this->photoSoin = $filename . '.' . $this->getFile()->guessExtension();
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
        $this->getFile()->move($this->getUploadRootDir(), $this->photoSoin);

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
     * Set typeSoin
     *
     * @param string $typeSoin
     * @return Soin
     */
    public function setTypeSoin($typeSoin)
    {
        $this->typeSoin = $typeSoin;

        return $this;
    }

    /**
     * Get typeSoin
     *
     * @return string 
     */
    public function getTypeSoin()
    {
        return $this->typeSoin;
    }
}
