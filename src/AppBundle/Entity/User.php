<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=12, nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="text", nullable=false)
     */
    private $roles;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;



    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
