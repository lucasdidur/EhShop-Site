<?php

    /**
     * Created by IntelliJ IDEA.
     * User: Lucas
     * Date: 05/07/2016
     * Time: 09:56
     */
    class Package
    {
        private $id_package;

        private $id_category;

        private $order;
        private $name;
        private $type;
        private $description;

        private $price;
        private $price_type;


        private $duration_value;
        private $duration_time;

        private $gui_slot;
        private $gui_name;
        private $gui_item;
        private $gui_description;

        private $image;
        private $active;

        private $servers;
        private $commands;

        public function __construct($id_package = null)
        {
            global $db;

            if (is_null($id_package))
                return;

            $stmt = $db->prepare("SELECT * FROM ea_packages WHERE id_package = ? LIMIT 1");
            $stmt->execute(array($id_package));
            $package = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->setIdPackage($package['id_package']);
            $this->setIdCategory($package['id_category']);

            $this->setOrder($package['order']);
            $this->setName($package['name']);
            $this->setType($package['type']);
            $this->setDescription($package['description']);

            $this->setPrice($package['price']);
            $this->setPriceType($package['price_type']);

            $this->setDurationValue($package['duration_value']);
            $this->setDurationTime($package['duration_time']);

            $this->setGuiSlot($package['gui_slot']);
            $this->setGuiName($package['gui_name']);
            $this->setGuiItem($package['gui_item']);
            $this->setGuiDescription($package['gui_description']);

            $this->setImage($package['image']);
            $this->setActive($package['active']);

            $stmt = $db->prepare("SELECT `id_server` FROM `ea_packages_servers` WHERE `id_package` = ?");
            $stmt->execute(array($this->getIdPackage()));
            $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($servers as $server)
            {
                $this->addServer($server['id_server']);
            }

            $stmt = $db->prepare("SELECT `id_command` FROM `ea_packages_commands` WHERE `id_package` = ? ORDER BY `order`");
            $stmt->execute(array($this->getIdPackage()));
            $commands = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($commands as $command)
            {
                $this->addCommand($command['id_command']);
            }
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
         * @return Package
         */
        public function setIdPackage($id_package)
        {
            $this->id_package = $id_package;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCategory()
        {
            return new Category($this->id_category);
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
         * @return Package
         */
        public function setIdCategory($id_category)
        {
            $this->id_category = $id_category;

            return $this;
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
         * @return Package
         */
        public function setOrder($order)
        {
            $this->order = $order;

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
         * @return Package
         */
        public function setName($name)
        {
            $this->name = $name;

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
         * @return Package
         */
        public function setType($type)
        {
            $this->type = $type;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         * @return Package
         */
        public function setDescription($description)
        {
            $this->description = $description;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPrice()
        {
            return $this->price;
        }

        /**
         * @param mixed $price
         * @return Package
         */
        public function setPrice($price)
        {
            $this->price = $price;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPriceType()
        {
            return $this->price_type;
        }

        /**
         * @param mixed $price_type
         * @return Package
         */
        public function setPriceType($price_type)
        {
            $this->price_type = $price_type;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDurationValue()
        {
            return $this->duration_value;
        }

        /**
         * @param mixed $duration_value
         * @return Package
         */
        public function setDurationValue($duration_value)
        {
            $this->duration_value = $duration_value;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDurationTime()
        {
            return $this->duration_time;
        }

        /**
         * @param mixed $duration_time
         * @return Package
         */
        public function setDurationTime($duration_time)
        {
            $this->duration_time = $duration_time;

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
         * @return Package
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
         * @return Package
         */
        public function setGuiName($gui_name)
        {
            $this->gui_name = $gui_name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getGuiItem()
        {
            return $this->gui_item;
        }

        /**
         * @param mixed $gui_item
         * @return Package
         */
        public function setGuiItem($gui_item)
        {
            $this->gui_item = $gui_item;

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
         * @return Package
         */
        public function setGuiDescription($gui_description)
        {
            $this->gui_description = $gui_description;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * @param mixed $image
         * @return Package
         */
        public function setImage($image)
        {
            $this->image = $image;

            return $this;
        }


        /**
         * @return mixed
         */
        public function getActive()
        {
            return $this->active;
        }

        /**
         * @param mixed $active
         * @return Package
         */
        public function setActive($active)
        {
            if($active)
            {
                $this->active = 1;
            }
            else
            {
                $this->active = 0;
            }

            return $this;
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

        public function addServer($server)
        {
            $this->servers[] = $server;
        }

        public function clearServers()
        {
            $this->servers = array();
        }

        /**
         * @return mixed
         */
        public function getCommands()
        {
            return $this->commands;
        }

        /**
         * @param mixed $commands
         * @return Package
         */
        public function setCommands($commands)
        {
            $this->commands = $commands;

            return $this;
        }

        public function addCommand($command)
        {
            $this->commands[] = $command;
        }

        public function save()
        {
            global $db;

            $stmt = $db->prepare("INSERT INTO `ea_packages` (`id_category`, `order`, `price`, `price_type`, `name`, `description`, `type`, `duration_value`, `duration_time`, `gui_slot`, `gui_name`, `gui_item`, `gui_description`, `image`, `active`)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array(
                $this->id_category,
                $this->order,
                $this->price,
                $this->price_type,
                $this->name,
                $this->description,
                $this->type,
                $this->duration_value,
                $this->duration_time,
                $this->gui_slot,
                $this->gui_name,
                $this->gui_item,
                $this->gui_description,
                $this->image,
                $this->active,
            ));

            $this->id_package = $db->lastInsertId();

            if (isset($this->servers))
            {
                foreach ($this->servers as $server)
                {
                    if (strcmp($server, '0') == 0)
                        break;

                    $stmt = $db->prepare("INSERT INTO `ea_packages_servers` (`id_package`, `id_server`) VALUES (?, ?)");
                    $stmt->execute(array(
                        $this->id_package,
                        $server,
                    ));
                }
            }

        }

        public function update()
        {
            global $db;

            $stmt = $db->prepare("UPDATE `ea_packages` SET `id_category` = ?, `order` = ?, `price` = ?, `price_type` = ?, `name` = ?, `description` = ?, `type` = ?, `duration_value` = ?, `duration_time` = ?, `gui_slot` = ?, `gui_name` = ?, `gui_item` = ?, `gui_description` = ?, `image` = ?, `active` = ? WHERE `id_package` = ?");
            $stmt->execute(array(
                $this->id_category,
                $this->order,
                $this->price,
                $this->price_type,
                $this->name,
                $this->description,
                $this->type,
                $this->duration_value,
                $this->duration_time,
                $this->gui_slot,
                $this->gui_name,
                $this->gui_item,
                $this->gui_description,
                $this->image,
                $this->active,
                $this->id_package,
            ));

            $stmt = $db->prepare("DELETE FROM `ea_packages_servers` WHERE `id_package` = ?");
            $stmt->execute(array($this->id_package));

            foreach ($this->servers as $server)
            {
                if (strcmp($server, '0') == 0)
                    break;

                $stmt = $db->prepare("INSERT INTO `ea_packages_servers` (`id_package`, `id_server`) VALUES (?, ?)");
                $stmt->execute(array(
                    $this->id_package,
                    $server,
                ));
            }
        }
    }