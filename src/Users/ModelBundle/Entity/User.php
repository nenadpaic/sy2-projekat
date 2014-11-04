<?php

namespace Users\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Users\ModelBundle\Repo\UserRepo")
 * @UniqueEntity(
 *     fields={"username", "email"},
 *     errorPath="port",
 *     message="This username or email already exist"
 * )
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your username can contain only alphanumeric characters and underscores", groups={"registration"})
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min=4, max=20, minMessage="Username can not be less than {{ limit }} long", maxMessage="Username can not be longer than {{ limit }} characters long", groups={"registration"})
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true,  message="Your password can contain only alphanumeric characters and underscores",groups={"registration", "changepass"})
     * @Assert\NotBlank(groups={"registration", "changepass"})
     * @Assert\Length(min=2, max=20, minMessage="Password can not be less than {{ limit }} long", maxMessage="Password can not be longer than {{ limit }} characters long",groups={"registration", "changepass"})
     *
     */
    private $password;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email(message="Given email is not valid, please provide valid one", checkMX= true, checkHost=true,groups={"registration"})
     * @Assert\NotBlank(groups={"registration"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_']+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your First name can contain only alphanumeric characters", groups={"registration", "profile"})
     * @Assert\NotBlank(groups={"registration", "profile"})
     * @Assert\Length(min=2, max=20,groups={"registration", "profile"}, minMessage="First name can not be less than {{ limit }} long", maxMessage="First name can not be longer than {{ limit }} characters long")
     *
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_']+$/i",htmlPattern = "^[a-zA-Z0-9_]+$", match=true, message="Your Last name can contain only alphanumeric characters and underscores",groups={"registration", "profile"})
     * @Assert\NotBlank(groups={"registration", "profile"})
     * @Assert\Length(min=2, max=20,groups={"registration", "profile"}, minMessage="Last name can not be less than {{ limit }} long", maxMessage="Last name can not be longer than {{ limit }} characters long")
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
     * @Assert\Regex(pattern="/^[0-9()+-]+$/i",htmlPattern = "^[0-9()+-]+$", match=true, message="Your phone can contain only numeric characters and ()-+",groups={"registration", "profile"})
     *
     * @Assert\Length(min=5, max=20, groups={"registration", "profile"}, minMessage="Phone can not be less than {{ limit }} long", maxMessage="Phone can not be longer than {{ limit }} characters long")
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
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     *
     *
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_image", type="string", length=255)
     *
     *
     */
    protected  $profileImage;

    /**
     * @var string
     *
     * @ORM\Column(name="timeline_image", type="string", length=255)
     *
     *
     */
    private $timeLineImage;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="last_login", type="datetime")
     */
    private $lastLogin;

    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"username"})
     */
    private $contentChanged;
    /**
     * @Assert\Image(maxSize="1000000")
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="Galery", mappedBy="user", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Documents", mappedBy="user", cascade={"persist", "remove"})
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="TimeLine", mappedBy="user", cascade={"persist", "remove"})
     */
    private $timeline;

	/**
	 * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\Groups", mappedBy="user",cascade={"persist", "remove"})
	 */
	protected $groups;

	/**
	 * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopic", mappedBy="user",cascade={"persist", "remove"})
	 */
	protected $group_topic;

	/**
	 * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopicComment", mappedBy="user",cascade={"persist", "remove"})
	 */
	protected $group_topic_comment;

	/**
	 * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopicCommentReply", mappedBy="user",cascade={"persist", "remove"})
	 */
	protected $group_topic_comment_reply;

	/**
	 * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupUsers", mappedBy="user",cascade={"persist", "remove"})
	 */
	protected $group_users;

	/**
	 * @ORM\OneToMany(targetEntity="Report\ModelBundle\Entity\Reports", mappedBy="user_reporting",cascade={"persist", "remove"})
	 */
	protected $user_reporting;

	/**
	 * @ORM\OneToMany(targetEntity="Report\ModelBundle\Entity\Reports", mappedBy="reported_user",cascade={"persist", "remove"})
	 */
	protected $reported_user;


    public function setFile(UploadedFile $file){
        $this->file = $file;
    }

    public function getFile(){
        return $this->file;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function upload()
    {

        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }


        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDirProfile(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
        return $image;
    }



    public function getAbsolutePathProfile(){
        return null === $this->profileImage
            ? ""
            : $this->getUploadRootDirProfile() . '/'. $this->profileImage;
    }

    protected function getUploadRootDirProfile(){
        return __DIR__.'/../../../../web/'.$this->getUploadDirProfile();
    }
    protected function getUploadDirProfile(){
        return 'uploads/users/profile-images/'. $this->getId();
    }

    public function getAbsolutePathTimeline(){
        return null === $this->timeLineImage
            ? ""
            : $this->getUploadRootDirTimeline() . '/'. $this->timeLineImage;
    }

    protected function getUploadRootDirTimeline(){
        return __DIR__.'/../../../../web/'.$this->getUploadDirTimeline();
    }
    protected function getUploadDirTimeline(){
        return 'uploads/users/profile-images/'. $this->getId();
    }


    public function profileImageDir(){
        return  '/uploads/users/profile-images/'.$this->getId(). '/' . $this->profileImage;
    }
    public function timelineImageDir(){
        return  '/uploads/users/profile-images/'.$this->getId(). '/' . $this->timeLineImage;
    }
    public  function removeProfileImg(){
        if($this->profileImage != ''){
            if(is_file($this->getAbsolutePathProfile())){
                unlink($this->getAbsolutePathProfile());
            }
        }
    }
    public  function removeTimelineImg(){
        if($this->timeLineImage != ''){
            if(is_file($this->getAbsolutePathTimeline())){
                unlink($this->getAbsolutePathTimeline());
            }
        }
    }

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
            $roles[$role->getId()] = $role->getName();
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
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return User
     */
    public function setContentChanged($contentChanged)
    {
        $this->contentChanged = $contentChanged;

        return $this;
    }

    /**
     * Get contentChanged
     *
     * @return \DateTime 
     */
    public function getContentChanged()
    {
        return $this->contentChanged;
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
     * Set token
     *
     * @param string $token
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set profileImage
     *
     * @param string $profileImage
     * @return User
     */
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * Get profileImage
     *
     * @return string 
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * Set timeLineImage
     *
     * @param string $timeLineImage
     * @return User
     */
    public function setTimeLineImage($timeLineImage)
    {
        $this->timeLineImage = $timeLineImage;

        return $this;
    }

    /**
     * Get timeLineImage
     *
     * @return string 
     */
    public function getTimeLineImage()
    {
        return $this->timeLineImage;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
           $this->id,
            $this->username,
            $this->password,
            $this->roles
        ));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->roles
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Add images
     *
     * @param \Users\ModelBundle\Entity\Galery $images
     * @return User
     */
    public function addImage(\Users\ModelBundle\Entity\Galery $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Users\ModelBundle\Entity\Galery $images
     */
    public function removeImage(\Users\ModelBundle\Entity\Galery $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add documents
     *
     * @param \Users\ModelBundle\Entity\Documents $documents
     * @return User
     */
    public function addDocument(\Users\ModelBundle\Entity\Documents $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \Users\ModelBundle\Entity\Documents $documents
     */
    public function removeDocument(\Users\ModelBundle\Entity\Documents $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add timeline
     *
     * @param \Users\ModelBundle\Entity\Timeline $timeline
     * @return User
     */
    public function addTimeline(\Users\ModelBundle\Entity\Timeline $timeline)
    {
        $this->timeline[] = $timeline;

        return $this;
    }

    /**
     * Remove timeline
     *
     * @param \Users\ModelBundle\Entity\Timeline $timeline
     */
    public function removeTimeline(\Users\ModelBundle\Entity\Timeline $timeline)
    {
        $this->timeline->removeElement($timeline);
    }

    /**
     * Get timeline
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeline()
    {
        return $this->timeline;
    }

    /**
     * Add group
     *
     * @param \Groups\ModelBundle\Entity\Groups $group
     * @return User
     */
    public function addGroup(\Groups\ModelBundle\Entity\Groups $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \Groups\ModelBundle\Entity\Groups $group
     */
    public function removeGroup(\Groups\ModelBundle\Entity\Groups $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add group_topic
     *
     * @param \Groups\ModelBundle\Entity\GroupTopic $groupTopic
     * @return User
     */
    public function addGroupTopic(\Groups\ModelBundle\Entity\GroupTopic $groupTopic)
    {
        $this->group_topic[] = $groupTopic;

        return $this;
    }

    /**
     * Remove group_topic
     *
     * @param \Groups\ModelBundle\Entity\GroupTopic $groupTopic
     */
    public function removeGroupTopic(\Groups\ModelBundle\Entity\GroupTopic $groupTopic)
    {
        $this->group_topic->removeElement($groupTopic);
    }

    /**
     * Get group_topic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopic()
    {
        return $this->group_topic;
    }

    /**
     * Add group_topic_comment
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment
     * @return User
     */
    public function addGroupTopicComment(\Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment)
    {
        $this->group_topic_comment[] = $groupTopicComment;

        return $this;
    }

    /**
     * Remove group_topic_comment
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment
     */
    public function removeGroupTopicComment(\Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment)
    {
        $this->group_topic_comment->removeElement($groupTopicComment);
    }

    /**
     * Get group_topic_comment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopicComment()
    {
        return $this->group_topic_comment;
    }

    /**
     * Add group_topic_comment_reply
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply
     * @return User
     */
    public function addGroupTopicCommentReply(\Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply)
    {
        $this->group_topic_comment_reply[] = $groupTopicCommentReply;

        return $this;
    }

    /**
     * Remove group_topic_comment_reply
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply
     */
    public function removeGroupTopicCommentReply(\Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply)
    {
        $this->group_topic_comment_reply->removeElement($groupTopicCommentReply);
    }

    /**
     * Get group_topic_comment_reply
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopicCommentReply()
    {
        return $this->group_topic_comment_reply;
    }

    /**
     * Add group_users
     *
     * @param \Groups\ModelBundle\Entity\GroupUsers $groupUsers
     * @return User
     */
    public function addGroupUser(\Groups\ModelBundle\Entity\GroupUsers $groupUsers)
    {
        $this->group_users[] = $groupUsers;

        return $this;
    }

    /**
     * Remove group_users
     *
     * @param \Groups\ModelBundle\Entity\GroupUsers $groupUsers
     */
    public function removeGroupUser(\Groups\ModelBundle\Entity\GroupUsers $groupUsers)
    {
        $this->group_users->removeElement($groupUsers);
    }

    /**
     * Get group_users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupUsers()
    {
        return $this->group_users;
    }

    /**
     * Add user_reporting
     *
     * @param \Report\ModelBundle\Entity\Reports $userReporting
     * @return User
     */
    public function addUserReporting(\Report\ModelBundle\Entity\Reports $userReporting)
    {
        $this->user_reporting[] = $userReporting;

        return $this;
    }

    /**
     * Remove user_reporting
     *
     * @param \Report\ModelBundle\Entity\Reports $userReporting
     */
    public function removeUserReporting(\Report\ModelBundle\Entity\Reports $userReporting)
    {
        $this->user_reporting->removeElement($userReporting);
    }

    /**
     * Get user_reporting
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserReporting()
    {
        return $this->user_reporting;
    }

    /**
     * Add reported_user
     *
     * @param \Report\ModelBundle\Entity\Reports $reportedUser
     * @return User
     */
    public function addReportedUser(\Report\ModelBundle\Entity\Reports $reportedUser)
    {
        $this->reported_user[] = $reportedUser;

        return $this;
    }

    /**
     * Remove reported_user
     *
     * @param \Report\ModelBundle\Entity\Reports $reportedUser
     */
    public function removeReportedUser(\Report\ModelBundle\Entity\Reports $reportedUser)
    {
        $this->reported_user->removeElement($reportedUser);
    }

    /**
     * Get reported_user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReportedUser()
    {
        return $this->reported_user;
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
