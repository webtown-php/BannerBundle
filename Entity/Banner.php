<?php

namespace WebtownPhp\BannerBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Banner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Webtown\EmailBundle\Entity\BannerRepository")
 */
class Banner
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=255)
     */
    private $target;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=false)
     */
    private $place;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_flash_enabled", type="boolean", nullable=false)
     */
    private $isFlashEnabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_image_enabled", type="boolean", nullable=false)
     */
    private $isImageEnabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_html_enabled", type="boolean", nullable=false)
     */
    private $isHtmlEnabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_display_count", type="integer", nullable=false)
     */
    private $maxDisplayCount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $endAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="display_count", type="integer", nullable=false)
     */
    private $displayCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="click_count", type="integer", nullable=false)
     */
    private $clickCount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;


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
     * Set name
     *
     * @param string $name
     * @return Banner
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
     * Set target
     *
     * @param string $target
     * @return Banner
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Banner
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set isFlashEnabled
     *
     * @param boolean $isFlashEnabled
     * @return Banner
     */
    public function setIsFlashEnabled($isFlashEnabled)
    {
        $this->isFlashEnabled = $isFlashEnabled;

        return $this;
    }

    /**
     * Get isFlashEnabled
     *
     * @return boolean 
     */
    public function getIsFlashEnabled()
    {
        return $this->isFlashEnabled;
    }

    /**
     * Set isImageEnabled
     *
     * @param boolean $isImageEnabled
     * @return Banner
     */
    public function setIsImageEnabled($isImageEnabled)
    {
        $this->isImageEnabled = $isImageEnabled;

        return $this;
    }

    /**
     * Get isImageEnabled
     *
     * @return boolean 
     */
    public function getIsImageEnabled()
    {
        return $this->isImageEnabled;
    }

    /**
     * Set isHtmlEnabled
     *
     * @param boolean $isHtmlEnabled
     * @return Banner
     */
    public function setIsHtmlEnabled($isHtmlEnabled)
    {
        $this->isHtmlEnabled = $isHtmlEnabled;

        return $this;
    }

    /**
     * Get isHtmlEnabled
     *
     * @return boolean 
     */
    public function getIsHtmlEnabled()
    {
        return $this->isHtmlEnabled;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Banner
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set maxDisplayCount
     *
     * @param integer $maxDisplayCount
     * @return Banner
     */
    public function setMaxDisplayCount($maxDisplayCount)
    {
        $this->maxDisplayCount = $maxDisplayCount;

        return $this;
    }

    /**
     * Get maxDisplayCount
     *
     * @return integer 
     */
    public function getMaxDisplayCount()
    {
        return $this->maxDisplayCount;
    }

    /**
     * Set startAt
     *
     * @param \DateTime $startAt
     * @return Banner
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime 
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     * @return Banner
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set displayCount
     *
     * @param integer $displayCount
     * @return Banner
     */
    public function setDisplayCount($displayCount)
    {
        $this->displayCount = $displayCount;

        return $this;
    }

    /**
     * Get displayCount
     *
     * @return integer 
     */
    public function getDisplayCount()
    {
        return $this->displayCount;
    }

    /**
     * Set clickCount
     *
     * @param integer $clickCount
     * @return Banner
     */
    public function setClickCount($clickCount)
    {
        $this->clickCount = $clickCount;

        return $this;
    }

    /**
     * Get clickCount
     *
     * @return integer 
     */
    public function getClickCount()
    {
        return $this->clickCount;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Banner
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
