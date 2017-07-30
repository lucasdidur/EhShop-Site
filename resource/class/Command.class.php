<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 05/07/2016
 * Time: 17:59
 */
class Command
{
    var $id_command;
    var $id_package;

    var $order;
    var $type;
    var $need_online;
    var $require_slots;

    var $command;

    var $servers;

    public function __construct($id_command = null)
    {
        global $db;

        if (is_null($id_command))
            return;

        $stmt = $db->prepare("SELECT * FROM `ea_packages_commands` WHERE id_command = {$id_command}");
        $stmt->execute();
        $command = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setIdCommand($command['id_command']);
        $this->setIdPackage($command['id_package']);

        $this->setOrder($command['order']);
        $this->setType($command['type']);
        $this->setNeedOnline($command['need_online']);
        $this->setRequireSlots($command['require_slots']);
        $this->setCommand($command['command']);

        $stmt = $db->prepare("SELECT s.id_server FROM `ea_packages_commands_servers` pc JOIN ea_servers s ON pc.id_server = s.id_server WHERE id_command = {$id_command}");
        $stmt->execute();
        $command_servers = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($command_servers as $command_server)
        {
            $this->addServer($command_server['id_server']);
        }
    }

    /**
     * @return mixed
     */
    public function getIdCommand()
    {
        return $this->id_command;
    }

    /**
     * @param mixed $id_command
     */
    public function setIdCommand($id_command)
    {
        $this->id_command = $id_command;
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
     */
    public function setIdPackage($id_package)
    {
        $this->id_package = $id_package;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
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
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getNeedOnline()
    {
        return $this->need_online;
    }

    /**
     * @param mixed $need_online
     */
    public function setNeedOnline($need_online)
    {
        $this->need_online = $need_online;
    }

    /**
     * @return mixed
     */
    public function getRequireSlots()
    {
        return $this->require_slots;
    }

    /**
     * @param mixed $require_slots
     */
    public function setRequireSlots($require_slots)
    {
        $this->require_slots = $require_slots;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @param mixed $servers
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
    }

    public function addServer($id_server)
    {
        $this->servers[] = $id_server;
    }

    public function clearServers()
    {
        $this->servers = array();
    }

    public function save()
    {
        global $db;

        $stmt = $db->prepare("INSERT INTO `ea_packages_commands` (`id_package`, `order`, `type`, `require_slots`, `need_online`, `command`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $this->id_package,
            $this->order,
            $this->type,
            $this->require_slots,
            $this->need_online,
            $this->command
        ));

        $this->id_command = $db->lastInsertId();

        foreach($this->servers as $server)
        {
            $stmt2 = $db->prepare("INSERT INTO `ea_packages_commands_servers` (`id_command`, `id_server`) VALUES (?, ?)");
            $stmt2->execute(array(
                $this->id_command,
                $server
            ));
        }
    }

    public function update()
    {
        global $db;

        $stmt = $db->prepare("UPDATE `ea_packages_commands` SET
                              `id_package` = ?,
                              `order` = ?,
                              `type` = ?,
                              `require_slots` = ?,
                              `need_online` = ?,
                              `command` = ?
                              WHERE `id_command` = ?");
        $stmt->execute(array(
            $this->id_package,
            $this->order,
            $this->type,
            $this->require_slots,
            $this->need_online,
            $this->command,
            $this->id_command
        ));

        $stmt = $db->prepare("DELETE FROM `ea_packages_commands_servers` WHERE `id_command` = ?");
        $stmt->execute(array($this->id_command));

        foreach($this->servers as $server)
        {
            $stmt2 = $db->prepare("INSERT INTO `ea_packages_commands_servers` (`id_command`, `id_server`) VALUES (?, ?)");
            $stmt2->execute(array(
                $this->id_command,
                $server
            ));
        }
    }

    public function delete()
    {
        global $db;

        $stmt = $db->prepare("DELETE FROM `ea_packages_commands` WHERE `id_command` = ?");
        $stmt->execute(array($this->id_command));
    }


}