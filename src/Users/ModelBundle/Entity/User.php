<?php

namespace Users\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your username can contain only alphanumeric characters and underscores")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=20, minMessage="Username can not be less than {{ limit }} long", maxMessage="Username can not be longer than {{ limit }} characters long")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your password can contain only alphanumeric characters and underscores")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=20, minMessage="Password can not be less than {{ limit }} long", maxMessage="Password can not be longer than {{ limit }} characters long")
     *
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message="Given email is not valid, please provide valid one", checkMX= true, checkHost=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your First name can contain only alphanumeric characters")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=20, minMessage="First name can not be less than {{ limit }} long", maxMessage="First name can not be longer than {{ limit }} characters long")
     *
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your Last name can contain only alphanumeric characters and underscores")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=20, minMessage="Last name can not be less than {{ limit }} long", maxMessage="Last name can not be longer than {{ limit }} characters long")
     *
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     * @Assert\Regex(pattern="/^[0-9()+-]+$/i",htmlPattern = "^[0-9()+-]+$", match=true, message="Your phone can contain only numeric characters and ()-+")
     *
     * @Assert\Length(min=5, max=20, minMessage="Phone can not be less than {{ limit }} long", maxMessage="Phone can not be longer than {{ limit }} characters long")
     *
     *
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=255)
     */
    private $active;



    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="last_login", type="datetime")
     */
    private $lastLogin;


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
     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\Groups", mappedBy="user")
     */
    protected $groups;


    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return User
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lastLogin
     *
     * @param string $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return string 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add roles
     *
     * @param \Users\ModelBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Users\ModelBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Users\ModelBundle\Entity\Role $roles
     */
    public function removeRole(\Users\ModelBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        $roles = array();
        foreach($this->roles as $role){
            $roles[] = $role->getRole();
        }
        return $roles;
    }
    public function getRolesName()
    {
        $roles = array();
        foreach($this->roles as $role){
            $roles[] = $role->getName();
        }
        return $roles;
    }
    public function getSalt(){
        return "UgwsmNvrtGAADHDkSSNlO9e5B6iyi6lIYsgfGrrkq2iv5ZUBBGzajQoxNNN1LCHHrbuugmqlHQyw4R49";
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool    true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool    true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool    true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool    true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        if($this->getActive() == 1){
            return true;
        }else{
            return false;
        }
    }


    /**
     * Add groups
     *
     * @param \Groups\ModelBundle\Entity\Groups $groups
     * @return User
     */
    public function addGroup(\Groups\ModelBundle\Entity\Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Groups\ModelBundle\Entity\Groups $groups
     */
    public function removeGroup(\Groups\ModelBundle\Entity\Groups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
