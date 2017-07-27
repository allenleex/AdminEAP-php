<?php

namespace ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelFormAttr
 *
 * @ORM\Table(name="model_form_attr")
 * @ORM\Entity
 */
class ModelFormAttr
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
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="attr", type="string", length=200, nullable=false)
     */
    private $attr;

    /**
     * @var string
     *
     * @ORM\Column(name="choices", type="string", length=200, nullable=false)
     */
    private $choices;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var string
     *
     * @ORM\Column(name="entitypath", type="string", length=100, nullable=false)
     */
    private $entitypath;

    /**
     * @var string
     *
     * @ORM\Column(name="property", type="string", length=100, nullable=false)
     */
    private $property;

    /**
     * @var string
     *
     * @ORM\Column(name="query_builder", type="string", length=200, nullable=false)
     */
    private $queryBuilder;

    /**
     * @var integer
     *
     * @ORM\Column(name="model_form_id", type="integer", nullable=false)
     */
    private $modelFormId;

    /**
     * @var string
     *
     * @ORM\Column(name="validate_rule", type="string", length=100, nullable=false)
     */
    private $validateRule;

    /**
     * @var string
     *
     * @ORM\Column(name="error_info", type="string", length=50, nullable=false)
     */
    private $errorInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="auto_type", type="string", length=50, nullable=false)
     */
    private $autoType;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=50, nullable=false)
     */
    private $value;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isonly", type="boolean", nullable=false)
     */
    private $isonly;

    /**
     * @var string
     *
     * @ORM\Column(name="bundle", type="string", length=50, nullable=false)
     */
    private $bundle;

    /**
     * @var string
     *
     * @ORM\Column(name="dealhtml", type="string", length=100, nullable=false)
     */
    private $dealhtml;

    /**
     * @var string
     *
     * @ORM\Column(name="dealhtmltags", type="string", length=100, nullable=false)
     */
    private $dealhtmltags;

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
     * @return ModelFormAttr
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
     * Set type
     *
     * @param string $type
     *
     * @return ModelFormAttr
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return ModelFormAttr
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set attr
     *
     * @param string $attr
     *
     * @return ModelFormAttr
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;

        return $this;
    }

    /**
     * Get attr
     *
     * @return string
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set choices
     *
     * @param string $choices
     *
     * @return ModelFormAttr
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * Get choices
     *
     * @return string
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Set required
     *
     * @param boolean $required
     *
     * @return ModelFormAttr
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set entitypath
     *
     * @param string $entitypath
     *
     * @return ModelFormAttr
     */
    public function setEntitypath($entitypath)
    {
        $this->entitypath = $entitypath;

        return $this;
    }

    /**
     * Get entitypath
     *
     * @return string
     */
    public function getEntitypath()
    {
        return $this->entitypath;
    }

    /**
     * Set property
     *
     * @param string $property
     *
     * @return ModelFormAttr
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set queryBuilder
     *
     * @param string $queryBuilder
     *
     * @return ModelFormAttr
     */
    public function setQueryBuilder($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * Get queryBuilder
     *
     * @return string
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * Set modelFormId
     *
     * @param integer $modelFormId
     *
     * @return ModelFormAttr
     */
    public function setModelFormId($modelFormId)
    {
        $this->modelFormId = $modelFormId;

        return $this;
    }

    /**
     * Get modelFormId
     *
     * @return integer
     */
    public function getModelFormId()
    {
        return $this->modelFormId;
    }

    /**
     * Set validateRule
     *
     * @param string $validateRule
     *
     * @return ModelFormAttr
     */
    public function setValidateRule($validateRule)
    {
        $this->validateRule = $validateRule;

        return $this;
    }

    /**
     * Get validateRule
     *
     * @return string
     */
    public function getValidateRule()
    {
        return $this->validateRule;
    }

    /**
     * Set errorInfo
     *
     * @param string $errorInfo
     *
     * @return ModelFormAttr
     */
    public function setErrorInfo($errorInfo)
    {
        $this->errorInfo = $errorInfo;

        return $this;
    }

    /**
     * Get errorInfo
     *
     * @return string
     */
    public function getErrorInfo()
    {
        return $this->errorInfo;
    }

    /**
     * Set autoType
     *
     * @param string $autoType
     *
     * @return ModelFormAttr
     */
    public function setAutoType($autoType)
    {
        $this->autoType = $autoType;

        return $this;
    }

    /**
     * Get autoType
     *
     * @return string
     */
    public function getAutoType()
    {
        return $this->autoType;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ModelFormAttr
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set isonly
     *
     * @param boolean $isonly
     *
     * @return ModelFormAttr
     */
    public function setIsonly($isonly)
    {
        $this->isonly = $isonly;

        return $this;
    }

    /**
     * Get isonly
     *
     * @return boolean
     */
    public function getIsonly()
    {
        return $this->isonly;
    }

    /**
     * Set bundle
     *
     * @param string $bundle
     *
     * @return ModelFormAttr
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
     * Set dealhtml
     *
     * @param string $dealhtml
     *
     * @return ModelFormAttr
     */
    public function setDealhtml($dealhtml)
    {
        $this->dealhtml = $dealhtml;

        return $this;
    }

    /**
     * Get dealhtml
     *
     * @return string
     */
    public function getDealhtml()
    {
        return $this->dealhtml;
    }

    /**
     * Set dealhtmltags
     *
     * @param string $dealhtmltags
     *
     * @return ModelFormAttr
     */
    public function setDealhtmltags($dealhtmltags)
    {
        $this->dealhtmltags = $dealhtmltags;

        return $this;
    }

    /**
     * Get dealhtmltags
     *
     * @return string
     */
    public function getDealhtmltags()
    {
        return $this->dealhtmltags;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
     * @return ModelFormAttr
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
