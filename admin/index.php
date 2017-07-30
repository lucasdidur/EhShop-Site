<?php
    include("../loader.php");

    //printR($_REQUEST);

    switch ($_REQUEST['action'])
    {
        case 'edit':
            $item = $_REQUEST['item'];

            $package = new Package($_REQUEST['id']);
            $package->setName($item['nome']);

            $package->setDescription($item['descricao']);

            $package->setGuiName($item['ingame']['nome']);
            $package->setGuiSlot($item['ingame']['slot']);
            $package->setGuiItem($item['ingame']['icon']);
            $package->setGuiDescription(MinecraftColors::convertToMinecraft($item['ingame']['descricao']));

            //echo $package->getGuiDescription();
            //exit();

            $package->setIdCategory($item['categoria']);
            $package->setOrder($item['ordem']);
            $package->setType($item['tipo']);

            $package->clearServers();
            if (isset($item['servers']))
            {
                foreach ($item['servers'] as $id_server)
                {
                    $package->addServer($id_server);
                }
            }

            $package->setPrice($item['preco']['valor']);
            $package->setPriceType($item['preco']['tipo']);

            $package->setDurationValue($item['duracao']['valor']);
            $package->setDurationTime($item['duracao']['tipo']);

            //TODO Upload images
            $package->setImage("");

            $package->setActive(isset($item['disabled']) ? false : true);

            $package->update();

            $order = 1;
            // Atualizar comandos
            if (isset($_REQUEST['command']))
            {
                foreach ($_REQUEST['command'] as $key => $id_command)
                {
                    $command = new Command($key);

                    $command->setIdPackage($package->getIdPackage());

                    $command->setOrder($order);

                    $command->setType($id_command['type']);
                    $command->setCommand($id_command['command']);
                    $command->setRequireSlots($id_command['require_slots']);
                    $command->setNeedOnline($id_command['require_online']);

                    $command->clearServers();
                    foreach ($id_command['server'] as $server)
                    {
                        $command->addServer($server);
                    }

                    $command->update();
                    $order++;
                }
            }

            // Adicionar novos comandos
            if (isset($_REQUEST['new_command']))
            {
                foreach ($_REQUEST['new_command'] as $id_command)
                {
                    $command = new Command();

                    $command->setIdPackage($package->getIdPackage());

                    $command->setOrder($order);

                    $command->setType($id_command['type']);
                    $command->setCommand($id_command['command']);
                    $command->setRequireSlots($id_command['require_slots']);
                    $command->setNeedOnline($id_command['require_online']);

                    foreach ($id_command['server'] as $server)
                    {
                        $command->addServer($server);
                    }

                    $command->save();
                    $order++;
                }
            }

            // Apagar comandos
            if (isset($_REQUEST['delete_command']))
            {
                foreach ($_REQUEST['delete_command'] as $id_command)
                {
                    $command = new Command($id_command);
                    $command->delete();
                }
            }

            $data['type'] = "success";
            $data['action'] = "edit";
            $data['id'] = $package->getIdPackage();
            $data['message'] = "Item {$package->getIdPackage()} atualizado!";

            echo json_encode($data);

            break;
        case 'add':
            $item = $_REQUEST['item'];

            $package = new Package();

            $package->setName($item['nome']);
            $package->setDescription($item['descricao']);

            $package->setGuiName($item['ingame']['nome']);
            $package->setGuiSlot($item['ingame']['slot']);
            $package->setGuiItem($item['ingame']['icon']);
            $package->setGuiDescription(MinecraftColors::convertToMinecraft($item['ingame']['descricao']));

            $package->setIdCategory($item['categoria']);
            $package->setOrder($item['ordem']);
            $package->setType($item['tipo']);

            if (isset($item['servers']))
            {
                foreach ($item['servers'] as $id_server)
                {
                    $package->addServer($id_server);
                }
            }

            $package->setPrice($item['preco']['valor']);
            $package->setPriceType($item['preco']['tipo']);

            $package->setDurationValue($item['duracao']['valor']);
            $package->setDurationTime($item['duracao']['tipo']);

            //TODO Upload images
            $package->setImage("");

            $package->setActive(isset($item['disabled']) ? false : true);

            $package->save();

            if (isset($_REQUEST['new_command']))
            {
                $order = 1;
                foreach ($_REQUEST['new_command'] as $new_command)
                {
                    $command = new Command();

                    $command->setIdPackage($package->getIdPackage());

                    $command->setOrder($order);

                    $command->setType($new_command['type']);
                    $command->setCommand($new_command['command']);
                    $command->setRequireSlots($new_command['require_slots']);
                    $command->setNeedOnline($new_command['require_online']);

                    foreach ($new_command['server'] as $server)
                    {
                        $command->addServer($server);
                    }

                    $command->save();

                    $package->addCommand($command);
                    $order++;
                }
            }

            $data['type'] = "success";
            $data['action'] = "add";
            $data['id'] = $package->getIdPackage();
            $data['message'] = "Item {$package->getIdPackage()} adicionado!";

            echo json_encode($data);

            break;
    }


    function showError($error)
    {
        $data['type'] = 'error';
        $data['message'] = $error;

        echo json_encode($data);
        exit();
    }


