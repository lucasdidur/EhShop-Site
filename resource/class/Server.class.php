<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 05/07/2016
 * Time: 18:35
 */
class Server
{
    var $id_server;
    var $id_category;

    var $name;
    var $icon;
    var $bungee_name;

    public function __construct($id_server = null)
    {
        global $db;

        if(is_null($id_server))
            return;

        $stmt = $db->prepare("SELECT * FROM `ea_servers` WHERE id_server = {$id_server};");
        $stmt->execute();

        $server = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->setIdServer($server['id_server']);
        $this->setIdCategory($server['id_category']);

        $this->setName($server['name']);
        $this->setIcon($server['icon']);
        $this->setBungeeName($server['bungee_name']);
    }

    /**
     * @return mixed
     */
    public function getIdServer()
    {
        return $this->id_server;
    }

    /**
     * @param mixed $id_server
     * @return Server
     */
    public function setIdServer($id_server)
    {
        $this->id_server = $id_server;
        return $this;
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
     * @return Server
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
     * @return Server
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return Server
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBungeeName()
    {
        return $this->bungee_name;
    }

    /**
     * @param mixed $bungee_name
     * @return Server
     */
    public function setBungeeName($bungee_name)
    {
        $this->bungee_name = $bungee_name;
        return $this;
    }




}