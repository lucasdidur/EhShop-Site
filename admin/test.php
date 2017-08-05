<?

    include "../loader.php";


    $db2 = new PDO("mysql:host=host;dbname=db_name;charset=" . DB_CHARSET . "", "username", "password");
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $package = 3;
    $status = 5;

    $users = $db2->query("SELECT o.id_order, nick, date, date_active, date_disable FROM `eh_order` o JOIN eh_order_products op on o.id_order = op.id_order where status = {$status} AND op.id_package = {$package} ORDER BY o.`date_active` ASC;")->fetchAll(2);


    foreach ($users as $user2)
    {
        $user = new stdClass();
        $user->id_order = $user2['id_order'];
        $user->name = $user2['nick'];
        $user->date = $user2['date'];
        $user->date_active = $user2['date_active'];
        $user->date_expired = $user2['date_disable'];

        $user->package = 4;
        $user->status = Status::EXPIRED;

        $pinfo = $db->query("SELECT * FROM `ehaqui_minecraft`.`mc_user_infos` WHERE `name` = '{$user->name}' ORDER by date DESC ;")->fetch(2);

        if (!$pinfo)
        {
            continue;
            printR($user);
        }

        if ($pinfo['premium'] === 'true')
        {
            $user->uuid = $pinfo['puuid'];
        }
        else
        {
            $user->uuid = $pinfo['ouuid'];
        }

        $stmt = $db->prepare("INSERT INTO ea_orders (`id_order`, `id_package`, `nick`, `uuid`, `date_created`, `date_active`, `date_expired`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($user->id_order, $user->package, $user->name, $user->uuid, $user->date, $user->date_active, $user->date_expired, $user->status));


        $transition = $db2->query("SELECT * FROM  `eh_transation` WHERE id_order = {$user->id_order}")->fetch(PDO::FETCH_OBJ);

        $stmt2 = $db->prepare("INSERT INTO `ea_transation` (`id`, `gateway`, `id_order`, `id_transation`, `type`, `date`, `value` ) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->execute(array($transition->id, $transition->gateway, $transition->id_order, $transition->id_transation, $transition->type, $transition->date, $transition->value));
    }



