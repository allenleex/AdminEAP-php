<?php

namespace ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menus
 *
 * @ORM\Table(name="menus", options={"comment"="菜单表","engine"="MyISAM"})
 * @ORM\Entity
 */
class Menus
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
     * @ORM\Column(name="label", type="string", length=50, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=100, nullable=false)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="routeArgs", type="string", length=100, nullable=false)
     */
    private $routeArgs;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=50, nullable=false)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="badge", type="string", length=50, nullable=false)
     */
    private $badge;

    /**
     * @var string
     *
     * @ORM\Column(name="badgeColor", type="string", length=50, nullable=false)
     */
    private $badgeColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="pid", type="integer", length=10, nullable=false)
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="children", type="string", length=10, nullable=false)
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=50, nullable=false)
     */
    private $controller;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=50, nullable=false)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="bundle", type="string", length=50, nullable=false)
     */
    private $bundle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hide", type="boolean", length=1, nullable=false)
     */
    private $is_hide;

    /**
     * @var boolean
     *
     * @ORM\Column(name="binary_tree", type="boolean", nullable=false)
     */
    private $binary_tree;

    /**
     * @var integer
     *
     * @ORM\Column(name="left_node", type="integer", nullable=false)
     */
    private $left_node;

    /**
     * @var integer
     *
     * @ORM\Column(name="right_node", type="integer", nullable=false)
     */
    private $right_node;

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
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", length=5, nullable=false)
     */
    private $sort;

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
     * @return Menus
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
     * Set label
     *
     * @param string $label
     *
     * @return Menus
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
     * Set route
     *
     * @param string $route
     *
     * @return Menus
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set routeArgs
     *
     * @param string $routeArgs
     *
     * @return Menus
     */
    public function setRouteArgs($routeArgs)
    {
        $this->routeArgs = $routeArgs;

        return $this;
    }

    /**
     * Get routeArgs
     *
     * @return string
     */
    public function getRouteArgs()
    {
        return $this->routeArgs;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Menus
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set badge
     *
     * @param string $badge
     *
     * @return Menus
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * Get badge
     *
     * @return string
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * Set badgeColor
     *
     * @param string $badgeColor
     *
     * @return Menus
     */
    public function setBadgeColor($badgeColor)
    {
        $this->badgeColor = $badgeColor;

        return $this;
    }

    /**
     * Get badgeColor
     *
     * @return string
     */
    public function getBadgeColor()
    {
        return $this->badgeColor;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     *
     * @return Menus
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set children
     *
     * @param string $children
     *
     * @return Menus
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set controller
     *
     * @param string $controller
     *
     * @return Menus
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Menus
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set bundle
     *
     * @param string $bundle
     *
     * @return Menus
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
     * Set isHide
     *
     * @param boolean $isHide
     *
     * @return Menus
     */
    public function setIsHide($isHide)
    {
        $this->is_hide = $isHide;

        return $this;
    }

    /**
     * Get isHide
     *
     * @return boolean
     */
    public function getIsHide()
    {
        return $this->is_hide;
    }

    /**
     * Set binaryTree
     *
     * @param boolean $binaryTree
     *
     * @return Menus
     */
    public function setBinaryTree($binaryTree)
    {
        $this->binary_tree = $binaryTree;

        return $this;
    }

    /**
     * Get binaryTree
     *
     * @return boolean
     */
    public function getBinaryTree()
    {
        return $this->binary_tree;
    }

    /**
     * Set leftNode
     *
     * @param integer $leftNode
     *
     * @return Menus
     */
    public function setLeftNode($leftNode)
    {
        $this->left_node = $leftNode;

        return $this;
    }

    /**
     * Get leftNode
     *
     * @return integer
     */
    public function getLeftNode()
    {
        return $this->left_node;
    }

    /**
     * Set rightNode
     *
     * @param integer $rightNode
     *
     * @return Menus
     */
    public function setRightNode($rightNode)
    {
        $this->right_node = $rightNode;

        return $this;
    }

    /**
     * Get rightNode
     *
     * @return integer
     */
    public function getRightNode()
    {
        return $this->right_node;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return Menus
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
     * @return Menus
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Menus
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
     * @return Menus
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
     * Set issystem
     *
     * @param boolean $issystem
     *
     * @return Menus
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
     * @return Menus
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
     * @return Menus
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
     * @return Menus
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
     * @return Menus
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

