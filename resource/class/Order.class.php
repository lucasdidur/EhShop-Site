<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 05/07/2016
 * Time: 17:59
 */
class Order
{
    var $id_order;
    var $id_package;

    var $nick;
    var $uuid;
    
    var $date_created;
    var $date_active;
    var $date_expired;
    
    var $status;
    private var $isValid = false;

    public function __construct($id_order = null)
    {
        global $db;

        if (is_null($id_order))
            return;

        $stmt = $db->prepare("SELECT * FROM `ea_orders` WHERE id_order = ? LIMIT 1");
        $stmt->execute(array($id_order));
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($order))
            return;

        $this->setIdOrder($order['id_order']);
        $this->setIdPackage($order['id_package']);

        $this->setNick($order['nick']);
        $this->setUuid($order['uuid']);

        $this->setDateCreated($order['date_created']);
        $this->setDateActive($order['date_active']);
        $this->setDateExpired($order['date_expired']);

        $this->setStatus($order['status']);

        $this->isValid = true;
    }

    /**
     * @return mixed
     */
    public function getIdOrder()
    {
        return $this->id_order;
    }

    /**
     * @param mixed $id_order
     * @return Category
     */
    public function setIdOrder($id_order)
    {
        $this->id_order = $id_order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPackage()
    {
        return $this->id_package;
    }

    /**
     * @param mixed $id_package
     * @return Category
     */
    public function setIdPackage($id_package)
    {
        $this->id_package = $id_package;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param mixed $nick
     * @return Category
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     * @return Category
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     * @return Category
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateActive()
    {
        return $this->date_active;
    }

    /**
     * @param mixed $date_active
     * @return Category
     */
    public function setDateActive($date_active)
    {
        $this->date_active = $date_active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateExpired()
    {
        return $this->date_expired;
    }

    /**
     * @param mixed $date_expired
     * @return Category
     */
    public function setDateExpired($date_expired)
    {
        $this->date_expired = $date_expired;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Category
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     *  Check if the Order is valid.
     *
     *  @return true if is validm otherwise false
     */
    public function isValid()
    {
        return $this->valid;
    }

    
}