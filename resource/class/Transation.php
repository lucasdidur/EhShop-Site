<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 11/02/2017
 * Time: 18:36
 */
class Transation
{
    var $id;
    var $id_order;

    var $gateway;
    var $id_transation;

    var $date;

    var $value;

    public function __construct($id_transation = null)
    {
        global $db;

        if (is_null($id_transation))
            return;

        $stmt = $db->prepare("SELECT * FROM `ea_transation` WHERE id = {$id_transation}");
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setId($order['id']);
        $this->setIdOrder($order['id_order']);

        $this->setGateway($order['gateway']);
        $this->setIdTransation($order['id_transation']);
        $this->setDate($order['date']);

        $this->setValue($order['value']);
    }

    public static function loadByOrder($id_order)
    {
        global $db;

        $stmt = $db->prepare("SELECT id FROM `ea_transation` WHERE id_order = {$id_order}");
        $stmt->execute();
        $order = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = array();

        foreach($order as $id)
        {
            $orders[] = new Transation($id['id']);
        }

        return $orders;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Transation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return Transation
     */
    public function setIdOrder($id_order)
    {
        $this->id_order = $id_order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     * @return Transation
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTransation()
    {
        return $this->id_transation;
    }

    /**
     * @param mixed $id_transation
     * @return Transation
     */
    public function setIdTransation($id_transation)
    {
        $this->id_transation = $id_transation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Transation
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Transation
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }




}