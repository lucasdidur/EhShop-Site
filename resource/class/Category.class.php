<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 05/07/2016
 * Time: 17:59
 */
class Category
{
    var $id_category;
    var $name;

    var $gui_slot;
    var $gui_name;
    var $gui_icon;
    var $gui_description;

    var $type;

    public function __construct($id_category = null)
    {
        global $db;

        if (is_null($id_category))
            return;

        $stmt = $db->prepare("SELECT * FROM `ea_categories` WHERE id_category = {$id_category}");
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setIdCategory($category['id_category']);
        $this->setName($category['name']);

        $this->setGuiSlot($category['gui_slot']);
        $this->setGuiName($category['gui_name']);
        $this->setGuiIcon($category['gui_icon']);
        $this->setGuiDescription($category['gui_description']);

        $this->setType($category['type']);
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * @param mixed $id_category
     * @return Category
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuiSlot()
    {
        return $this->gui_slot;
    }

    /**
     * @param mixed $gui_slot
     * @return Category
     */
    public function setGuiSlot($gui_slot)
    {
        $this->gui_slot = $gui_slot;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuiName()
    {
        return $this->gui_name;
    }

    /**
     * @param mixed $gui_name
     * @return Category
     */
    public function setGuiName($gui_name)
    {
        $this->gui_name = $gui_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuiIcon()
    {
        return $this->gui_icon;
    }

    /**
     * @param mixed $gui_icon
     * @return Category
     */
    public function setGuiIcon($gui_icon)
    {
        $this->gui_icon = $gui_icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuiDescription()
    {
        return $this->gui_description;
    }

    /**
     * @param mixed $gui_description
     * @return Category
     */
    public function setGuiDescription($gui_description)
    {
        $this->gui_description = $gui_description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Category
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}


