<?php

namespace Medical\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Medicament
 *
 * @ORM\Table(name="medicament")
 * @ORM\Entity(repositoryClass="Medical\MedicalBundle\Repository\MedicamentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Medicament {

    public function __construct() {
        $this->setDateMed(new \DateTime());
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
     * @ORM\Column(name="nom_med", type="string", length=255)
     */
    private $nomMed;

    /**
     * @var string
     *
     * @ORM\Column(name="description_med", type="string", length=255)
     */
    private $descriptionMed;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_med", type="float")
     */
    private $prixMed;

    /**
     * @var string
     * @ORM\Column(name="photo_med", type="string", length=255)
     */
    private $photoMed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_med", type="datetime")
     */
    private $dateMed;

    /**
     * @ORM\ManyToOne(targetEntity="Medical\MedicalBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="entreprise_med",referencedColumnName="id")
     */
    private $entrepriseMed;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_med", type="string", length=255)
     */
    private $categorieMed;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_med", type="integer")
     */
    private $stockMed;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nomMed
     *
     * @param string $nomMed
     * @return Medicament
     */
    public function setNomMed($nomMed) {
        $this->nomMed = $nomMed;

        return $this;
    }

    /**
     * Get nomMed
     *
     * @return string 
     */
    public function getNomMed() {
        return $this->nomMed;
    }

    /**
     * Set descriptionMed
     *
     * @param string $descriptionMed
     * @return Medicament
     */
    public function setDescriptionMed($descriptionMed) {
        $this->descriptionMed = $descriptionMed;

        return $this;
    }

    /**
     * Get descriptionMed
     *
     * @return string 
     */
    public function getDescriptionMed() {
        return $this->descriptionMed;
    }

    /**
     * Set prixMed
     *
     * @param float $prixMed
     * @return Medicament
     */
    public function setPrixMed($prixMed) {
        $this->prixMed = $prixMed;

        return $this;
    }

    /**
     * Get prixMed
     *
     * @return float 
     */
    public function getPrixMed() {
        return $this->prixMed;
    }

    /**
     * Set photoMed
     *
     * @param string $photoMed
     * @return Medicament
     */
    public function setPhotoMed($photoMed) {
        $this->photoMed = $photoMed;

        return $this;
    }

    /**
     * Get photoMed
     *
     * @return string 
     */
    public function getPhotoMed() {
        return $this->photoMed;
    }

    /**
     * Set dateMed
     *
     * @param \DateTime $dateMed
     * @return Medicament
     */
    public function setDateMed($dateMed) {
        $this->dateMed = $dateMed;

        return $this;
    }

    /**
     * Get dateMed
     *
     * @return \DateTime 
     */
    public function getDateMed() {
        return $this->dateMed;
    }

    /**
     * Set entrepriseMed
     *
     * @param integer $entrepriseMed
     * @return Medicament
     */
    public function setEntrepriseMed($entrepriseMed) {
        $this->entrepriseMed = $entrepriseMed;

        return $this;
    }

    /**
     * Get entrepriseMed
     *
     * @return integer 
     */
    public function getEntrepriseMed() {
        return $this->entrepriseMed;
    }

    /**
     * Set categorieMed
     *
     * @param string $categorieMed
     * @return Medicament
     */
    public function setCategorieMed($categorieMed) {
        $this->categorieMed = $categorieMed;

        return $this;
    }

    /**
     * Get categorieMed
     *
     * @return string 
     */
    public function getCategorieMed() {
        return $this->categorieMed;
    }

    /**
     * Set stockMed
     *
     * @param integer $stockMed
     * @return Medicament
     */
    public function setStockMed($stockMed) {
        $this->stockMed = $stockMed;

        return $this;
    }

    /**
     * Get stockMed
     *
     * @return integer 
     */
    public function getStockMed() {
        return $this->stockMed;
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
        return null === $this->photoMed ? null : $this->getUploadRootDir() . '/' . $this->photoMed;
    }

    public function getWebPath() {
        return null === $this->photoMed ? null : $this->getUploadDir() . '/' . $this->photoMed;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/medicament';
    }

    public function uploads() {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );
        $this->photoMed = $this->getFile()->getClientOriginalName();

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
        if (isset($this->photoMed)) {
            // store the old name to delete after the update
            $this->temp = $this->photoMed;
            $this->photoMed = null;
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
            $this->photoMed = $filename . '.' . $this->getFile()->guessExtension();
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
        $this->getFile()->move($this->getUploadRootDir(), $this->photoMed);

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

}
