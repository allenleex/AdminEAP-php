<?php

namespace ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelForm
 *
 * @ORM\Table(name="model_form")
 * @ORM\Entity
 */
class ModelForm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
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
     * @var integer
     *
     * @ORM\Column(name="model_id", type="integer", nullable=false)
     */
    private $modelId;

    /**
     * @var integer
     *
     * @ORM\Column(name="bindform", type="integer", nullable=false)
     */
    private $bindform;

    /**
     * @var string
     *
     * @ORM\Column(name="bindfield", type="string", length=50, nullable=false)
     */
    private $bindfield;

    /**
     * @var string
     *
     * @ORM\Column(name="parent_form", type="string", length=100, nullable=false)
     */
    private $parentForm;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="string", length=50, nullable=false)
     */
    private $remark;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="smallint", nullable=false)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="fmgroup", type="smallint", nullable=false)
     */
    private $fmgroup;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="initcondition", type="string", length=200, nullable=false)
     */
    private $initcondition;

    /**
     * @var string
     *
     * @ORM\Column(name="initmodel", type="string", length=50, nullable=false)
     */
    private $initmodel;

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
     * @ORM\Column(name="create_time", type="integer", nullable=false)
     */
    private $createTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="update_time", type="integer", nullable=false)
     */
    private $updateTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_delete", type="boolean", nullable=false)
     */
    private $isDelete;



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
     * @return ModelForm
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
     * @return ModelForm
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
     * Set modelId
     *
     * @param integer $modelId
     *
     * @return ModelForm
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return integer
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set bindform
     *
     * @param integer $bindform
     *
     * @return ModelForm
     */
    public function setBindform($bindform)
    {
        $this->bindform = $bindform;

        return $this;
    }

    /**
     * Get bindform
     *
     * @return integer
     */
    public function getBindform()
    {
        return $this->bindform;
    }

    /**
     * Set bindfield
     *
     * @param string $bindfield
     *
     * @return ModelForm
     */
    public function setBindfield($bindfield)
    {
        $this->bindfield = $bindfield;

        return $this;
    }

    /**
     * Get bindfield
     *
     * @return string
     */
    public function getBindfield()
    {
        return $this->bindfield;
    }

    /**
     * Set parentForm
     *
     * @param string $parentForm
     *
     * @return ModelForm
     */
    public function setParentForm($parentForm)
    {
        $this->parentForm = $parentForm;

        return $this;
    }

    /**
     * Get parentForm
     *
     * @return string
     */
    public function getParentForm()
    {
        return $this->parentForm;
    }

    /**
     * Set remark
     *
     * @param string $remark
     *
     * @return ModelForm
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set type
     *
     * @param boolean $type
     *
     * @return ModelForm
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return ModelForm
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
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
     * @return ModelForm
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
     * Set fmgroup
     *
     * @param integer $fmgroup
     *
     * @return ModelForm
     */
    public function setFmgroup($fmgroup)
    {
        $this->fmgroup = $fmgroup;

        return $this;
    }

    /**
     * Get fmgroup
     *
     * @return integer
     */
    public function getFmgroup()
    {
        return $this->fmgroup;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ModelForm
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set initcondition
     *
     * @param string $initcondition
     *
     * @return ModelForm
     */
    public function setInitcondition($initcondition)
    {
        $this->initcondition = $initcondition;

        return $this;
    }

    /**
     * Get initcondition
     *
     * @return string
     */
    public function getInitcondition()
    {
        return $this->initcondition;
    }

    /**
     * Set initmodel
     *
     * @param string $initmodel
     *
     * @return ModelForm
     */
    public function setInitmodel($initmodel)
    {
        $this->initmodel = $initmodel;

        return $this;
    }

    /**
     * Get initmodel
     *
     * @return string
     */
    public function getInitmodel()
    {
        return $this->initmodel;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return ModelForm
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
     * @return ModelForm
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
     * @return ModelForm
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
     * @return ModelForm
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
     * @return ModelForm
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set updateTime
     *
     * @param integer $updateTime
     *
     * @return ModelForm
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return ModelForm
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }
}
