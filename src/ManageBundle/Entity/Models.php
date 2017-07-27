<?php

namespace ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models
 *
 * @ORM\Table(name="models", options={"comment"="模型表","engine"="MyISAM"})
 * @ORM\Entity
 */
class Models
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=50, nullable=false)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="bundle", type="string", length=50, nullable=false)
     */
    private $bundle;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="string", length=20, nullable=false)
     */
    private $engine = 'MyISAM';

    /**
     * @var string
     *
     * @ORM\Column(name="associated", type="string", length=50, nullable=false)
     */
    private $associated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="structure", type="boolean", length=1, nullable=false)
     */
    private $structure;

    /**
     * @var string
     *
     * @ORM\Column(name="relation", type="string", length=50, nullable=false)
     */
    private $relation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_binary", type="boolean", length=1, nullable=false)
     */
    private $is_binary;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="smallint", length=5, nullable=false)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="mode", type="smallint", length=3, nullable=false)
     */
    private $mode;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint", length=3, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_table", type="integer", length=10, nullable=false)
     */
    private $attribute_table;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan", type="smallint", length=3, nullable=false)
     */
    private $plan;

    /**
     * @var boolean
     *
     * @ORM\Column(name="checked", type="boolean", nullable=false)
     */
    private $checked;

    /**
     * @var string
     *
     * @ORM\Column(name="attributes", type="string", length=10, nullable=false)
     */
    private $attributes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="issystem", type="boolean", nullable=false)
     */
    private $issystem;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=50, nullable=false)
     */
    private $identifier;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_time", type="integer", length=10, nullable=false)
     */
    private $create_time;

    /**
     * @var integer
     *
     * @ORM\Column(name="update_time", type="integer", length=10, nullable=false)
     */
    private $update_time;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_delete", type="boolean", length=1, nullable=false)
     */
    private $is_delete;


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
     *
     * @return Models
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
     * Set title
     *
     * @param string $title
     *
     * @return Models
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Models
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set bundle
     *
     * @param string $bundle
     *
     * @return Models
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;

        return $this;
    }

    /**
     * Get bundle
     *
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return Models
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set associated
     *
     * @param string $associated
     *
     * @return Models
     */
    public function setAssociated($associated)
    {
        $this->associated = $associated;

        return $this;
    }

    /**
     * Get associated
     *
     * @return string
     */
    public function getAssociated()
    {
        return $this->associated;
    }

    /**
     * Set structure
     *
     * @param boolean $structure
     *
     * @return Models
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     * @return boolean
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Set relation
     *
     * @param string $relation
     *
     * @return Models
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set isBinary
     *
     * @param boolean $isBinary
     *
     * @return Models
     */
    public function setIsBinary($isBinary)
    {
        $this->is_binary = $isBinary;

        return $this;
    }

    /**
     * Get isBinary
     *
     * @return boolean
     */
    public function getIsBinary()
    {
        return $this->is_binary;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Models
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Models
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set mode
     *
     * @param integer $mode
     *
     * @return Models
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return integer
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Models
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set attributeTable
     *
     * @param integer $attributeTable
     *
     * @return Models
     */
    public function setAttributeTable($attributeTable)
    {
        $this->attribute_table = $attributeTable;

        return $this;
    }

    /**
     * Get attributeTable
     *
     * @return integer
     */
    public function getAttributeTable()
    {
        return $this->attribute_table;
    }

    /**
     * Set plan
     *
     * @param integer $plan
     *
     * @return Models
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return integer
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return Models
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get checked
     *
     * @return boolean
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set attributes
     *
     * @param string $attributes
     *
     * @return Models
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return string
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set issystem
     *
     * @param boolean $issystem
     *
     * @return Models
     */
    public function setIssystem($issystem)
    {
        $this->issystem = $issystem;

        return $this;
    }

    /**
     * Get issystem
     *
     * @return boolean
     */
    public function getIssystem()
    {
        return $this->issystem;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Models
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return Models
     */
    public function setCreateTime($createTime)
    {
        $this->create_time = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * Set updateTime
     *
     * @param integer $updateTime
     *
     * @return Models
     */
    public function setUpdateTime($updateTime)
    {
        $this->update_time = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Models
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}

