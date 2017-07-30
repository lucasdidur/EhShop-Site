<?
    class User
    {
        var $id;
        var $id_order;
        var $name;
        var $email;
        var $birthday;

        public function setIdOrder($id_order)
        {
            $this->id_order = $id_order;
        }

        public function setName($name)
        {
            $this->name = $name;
        }
        
        public function setEmail($email)
        {
            $this->email = $email;
        }
		
		public function setBirthday($birthday)
        {
            $this->birthday = $birthday;
        }

		public function save()
        {
            global $db;
            
            $sql = "INSERT IGNORE INTO `ea_buyer` (`id_order`, `full_name`, `email`, `birthday`) VALUES ({$this->id_order}, '{$this->name}', '{$this->email}', '{$this->birthday}');";
            $db->exec($sql);
            
            $this->id = $db->lastInsertId();
            
            return $this->id;
        } 
    }
?>