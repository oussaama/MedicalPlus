<?php

// src/AppBundle/Entity/User.php

namespace Medical\MedicalBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct(); 
    }

    /**
     * @var string
     * @ORM\Column(name="cin", type="string", length=8)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=30)
     */
    private $state;

    /**
     * @var int
     * @ORM\Column(name="$code", type="int", length=4)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="class", type="string", length=15)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(name="first_name", type="string", length=30)
     */
    private $firstName;

    /**
     * @ORM\Column(name="city", type="last_name", length=40)
     */
    private $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var String
     *
     * @ORM\Column(name="month", type="string")
     */
    private $month;

    /**
     * @ORM\Column(name="profession", type="string")
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1)
     */
    private $sex;

    /**
     * @ORM\Column(name="tel", type="integer", length=20)
     */
    private $tel;

    /**
     * @var string
     * @ORM\Column(name="speciality", type="string", length=50)
     */
    private $speciality;

    /**
     * @var integer
     *
     * @ORM\Column(name="role", type="integer")
     * @ORM\OneToOne(targetEntity="Medical\MedicalBundle\Entity\Role",cascade="persist")
     * @ORM\JoinColumn(name="id")
     */
    private $role;
    
    /**
     * @var string
     *
     * @ORM\Column(name="entreprise_name", type="string")
     */
    private $entrepriseName;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nombre",type="integer")
     */
    private $nombre;
    
    /**
     * @ORM\Column(name="assurance", type="string")
     */
    private $assurance;
    
    /**
     * @var \Date
     * @ORM\Column(name="createdt",type="date")
     */
    private $createDt;
    
    /**
     * @var integer
     * @ORM\Column(name="nbpromo",type="integer")
     */
    private $nbpromo;
    
     /**
     * @var integer
     * @ORM\Column(name="nbprod",type="integer")
     */
    private $nbprod;

    /**
     * Set cin
     *
     * @param string $cin
     * @return User
     */
    public function setCin($cin) {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string 
     */
    public function getCin() {
        return $this->cin;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return User
     */
    public function setAdress($adress) {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress() {
        return $this->adress;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return User
     */
    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set code
     *
     * @param int $code
     * @return User
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return int 
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return User
     */
    public function setPicture($picture) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return User
     */
    public function setClass($class) {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Set day
     *
     * @param integer $day
     * @return User
     */
    public function setDay($day) {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return User
     */
    public function setYear($year) {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param string $month
     * @return User
     */
    public function setMonth($month) {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * Set profession
     *
     * @param string $profession
     * @return User
     */
    public function setProfession($profession) {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession() {
        return $this->profession;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return User
     */
    public function setSex($sex) {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex() {
        return $this->sex;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     * @return User
     */
    public function setTel($tel) {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel() {
        return $this->tel;
    }

    /**
     * Set speciality
     *
     * @param string $speciality
     * @return User
     */
    public function setSpeciality($speciality) {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return string
     */
    public function getSpeciality() {
        return $this->speciality;
    }

    /**
     * Set role
     *
     * @param integer $role
     * @return User
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set entrepriseName
     *
     * @param integer $entrepriseName
     * @return User
     */
    public function setEntrepriseName($entrepriseName)
    {
        $this->entrepriseName = $entrepriseName;

        return $this;
    }

    /**
     * Get entrepriseName
     *
     * @return integer 
     */
    public function getEntrepriseName()
    {
        return $this->entrepriseName;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set assurance
     *
     * @param string $assurance
     * @return User
     */
    public function setAssurance($assurance)
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * Get assurance
     *
     * @return string 
     */
    public function getAssurance()
    {
        return $this->assurance;
    }

    /**
     * Set create
     *
     * @param \Date $createDt
     * @return User
     */
    public function setCreateDt($createDt)
    {
        $this->createDt = $createDt;

        return $this;
    }

    /**
     * Get create
     *
     * @return \Date
     */
    public function getCreateDt()
    {
        return $this->createDt;
    }

    /**
     * Set nbpromo
     *
     * @param integer $nbpromo
     * @return User
     */
    public function setNbpromo($nbpromo)
    {
        $this->nbpromo = $nbpromo;

        return $this;
    }

    /**
     * Get nbpromo
     *
     * @return integer 
     */
    public function getNbpromo()
    {
        return $this->nbpromo;
    }

    /**
     * Set nbprod
     *
     * @param integer $nbprod
     * @return User
     */
    public function setNbprod($nbprod)
    {
        $this->nbprod = $nbprod;

        return $this;
    }

    /**
     * Get nbprod
     *
     * @return integer 
     */
    public function getNbprod()
    {
        return $this->nbprod;
    }
}
