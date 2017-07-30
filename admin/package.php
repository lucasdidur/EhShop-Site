<?
    $header = true;
    include "../loader.php";

    $title = "Ehaqui | Bem vindo";
    include ROOT . 'theme/header.php';

    $id_package = @$_REQUEST['id'];

    $package = new Package($id_package);


    function isSelected($needed, $value, $colum = null)
    {
        if (is_array($value))
        {
            if (!is_null($colum))
                $key = array_search($needed, array_column($value, $colum));
            else
                $key = array_search($needed, $value);

            if (is_integer($key))
                return "selected";
        }
        else
        {
            if (strcmp($needed, $value) == 0)
                return "selected";
        }

        return "";
    }

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <form action="<?= URL ?>admin/index.php" method="post" id="package_form">
                    <? if (isset($id_package))
                    {
                        echo '<input type="hidden" name="action" value="edit" />';
                        echo '<input type="hidden" name="id" value="' . $id_package . '" />';
                    }
                    else
                    {
                        echo '<input type="hidden" name="action" value="add" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-seperator">Descrição</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="item[nome]" class="control-label">Nome</label>
                                        <input type="text" class="form-control" id="item[nome]" value="<?= $package->getName() ?>" name="item[nome]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="item[descricao]">Descrição</label>
                                                    <textarea class="form-control trumbowyg" id="item[descricao]" name="item[descricao]"
                                                              rows="11"><?= $package->getDescription() ?></textarea>
                                    </div>
                                </div>

                                <div class="panel-heading panel-seperator">Descrição In Game</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="item[ingame][nome]" class="control-label">Nome InGame</label>
                                                <input type="text" class="form-control" id="item[ingame][nome]" value="<?= $package->getGuiName() ?>"
                                                       name="item[ingame][nome]">
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label for="item[ingame][slot]" class="control-label">Slot</label>
                                                <input type="text" class="form-control" id="item[ingame][slot]" value="<?= $package->getGuiSlot() ?>"
                                                       name="item[ingame][slot]">
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label for="item[ingame][icon]" class="control-label">Icone</label>
                                                <input type="text" class="form-control" id="item[ingame][icon]" name="item[ingame][icon]"
                                                       value="<?= $package->getGuiItem() ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Textarea http://getbootstrap.com/css/#textarea -->
                                    <div class="form-group">
                                        <label class="control-label" for="item[ingame][descricao]">Descrição InGame</label>

                                        <div class="" id="description" >
                                            <?
                                                $text = MinecraftColors::convertToHTML($package->getGuiDescription(), true);
                                                if(strlen ($text) > 0)
                                                    echo $text;
                                                else
                                                    echo '<span style="color:#FFFFFF;">&nbsp;</span>';
                                            ?>
                                        </div>
                                        <textarea name="item[ingame][descricao]" id="gui_description" style="display: none;"></textarea>
                                    </div>
                                </div>

                                <div class="panel-heading panel-seperator">Opções</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="item[categoria]">Categoria</label>

                                            <div class="controls ">
                                                <select id="item[categoria]" name="item[categoria]" class="form-control">
                                                    <? foreach (getCategorias() as $categoria)
                                                    {
                                                        echo ' <option value="' . $categoria["id_category"] . '"' . isSelected($categoria["id_category"], $package->getIdCategory()) . '>' . $categoria['name'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="item[ordem]" class="control-label">Ordem</label>
                                            <input type="number" class="form-control" id="item[ordem]" name="item[ordem]" value="<?= $package->getOrder() ?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <label class="control-label" for="item[tipo]">Tipo do Pacote</label>

                                            <div class="controls ">
                                                <select id="item[tipo]" name="item[tipo]" class="form-control">
                                                    <option value="TIMED" <?= isSelected("TIMED", $package->getType()) ?>>Cronometrado</option>
                                                    <option value="ONE_TIME" <?= isSelected("ONE_TIME", $package->getType()) ?>>Uma vez</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="item[servers]">Servidores</label>

                                            <div class="controls ">
                                                <select id="item[servers]" name="item[servers][]" class="form-control" multiple="multiple">
                                                    <? foreach (getServidores() as $server)
                                                    {
                                                        echo ' <option value="' . $server["id_server"] . '" ' . isSelected($server["id_server"], $package->getServers()) . '>' . $server['name'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="0" name="item[disabled]" <? if(!$package->getActive()) echo "checked"; ?>>
                                                    Desativar este item - não vai aparecer na loja.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-heading panel-seperator">Preço</div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="item[preco][valor]" class="control-label">Valor</label>
                                            <input type="number" class="form-control" id="item[preco][valor]" name="item[preco][valor]" value="<?= $package->getPrice() ?>">
                                        </div>
                                        <div class="col-xs-5">
                                            <label class="control-label" for="item[preco][tipo]">Tipo do Valor</label>

                                            <div class="controls">
                                                <select id="item[preco][tipo]" name="item[preco][tipo]" class="form-control">
                                                    <option value="POINT" <?= isSelected("POINT", $package->getPriceType()) ?>>Pontos</option>
                                                    <option value="MONEY" <?= isSelected("MONEY", $package->getPriceType()) ?>>Dinheiro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading panel-seperator">Duração</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="item[duracao][valor]" class="control-label">Expirar </label>
                                                <input type="number" class="form-control" id="item[duracao][valor]" name="item[duracao][valor]"
                                                       value="<?= $package->getDurationValue() ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="form-group">
                                                <label class="control-label" for="item[duracao][tipo]">depois de: </label>

                                                <div class="controls ">
                                                    <select id="item[duracao][tipo]" name="item[duracao][tipo]" class="form-control">
                                                        <option value="minutes" <?= isSelected("minutes", $package->getDurationTime()) ?>>Minutos</option>
                                                        <option value="hours" <?= isSelected("hours", $package->getDurationTime()) ?>>Horas</option>
                                                        <option value="days" <?= isSelected("days", $package->getDurationTime()) ?>>Dias</option>
                                                        <option value="weeks" <?= isSelected("weeks", $package->getDurationTime()) ?>>Semanas</option>
                                                        <option value="months" <?= isSelected("months", $package->getDurationTime()) ?>>Meses</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading panel-seperator">
                                    <p class="pull-left">Comandos</p>

                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-success" id="add-package-command"><span class="fa fa-plus"></span> Adicionar</button>
                                        <a href="https://server.buycraft.net/packages/add#" data-remote="/packages/help" role="button" class="btn btn-primary toggle-modal">Help</a>
                                    </div>
                                </div>
                                <div class="panel-body" style="padding-bottom:3px;">
                                    <?
                                        $test = $package->getCommands();
                                        if (!isset($test))
                                        {
                                            ?>
                                            <ul class="package-commands ui-sortable">
                                                <li class="command">
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <div class="form-group">
                                                                <select class="form-control" name="new_command[0][type]">
                                                                    <option value="1">Inicial</option>
                                                                    <option value="2">Expiração</option>
                                                                    <option value="3">Renovar</option>
                                                                    <option value="4">Reembolsar</option>
                                                                    <option value="5">Chargeback</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5 col-sm-6" style="padding-left:0;">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control command" name="new_command[0][command]" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4 col-sm-3" style="padding-left:0;">
                                                            <div class="btn-group btn-group-justified">
                                                                <a href="javascript:void(0);" class="btn btn-default command-move"><span class="fa fa-arrows"></span></a>
                                                                <a href="javascript:void(0);" class="btn btn-info edit-package-command"><span class="fa fa-wrench"></span></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger delete-package-command"><span class="fa fa-trash-o"></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="advanced well">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Executar no servidor:</label> <a href="#" data-toggle="popover"
                                                                                                            data-content="Select which server this command will execute upon."
                                                                                                            data-original-title="" title="">(?)</a>
                                                                    <select name="new_command[0][server][]" class="form-control" multiple="multiple" required>
                                                                        <? foreach (getServidores() as $server)
                                                                        {
                                                                            echo ' <option value="' . $server["id_server"] . '">' . $server['name'] . '</option>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 col-xs-6">
                                                                <div class="form-group">
                                                                    <label>Inv slots:</label> <a data-toggle="popover"
                                                                                                 data-content="Only execute this command if the player has a specified amount of free inventory space."
                                                                                                 data-original-title="" title="">(?)</a>
                                                                    <select name="new_command[0][require_slots]" class="form-control">
                                                                        <? for ($i = 0; $i <= 36; $i++)
                                                                        {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>' . "\n";
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 col-xs-6">
                                                                <div class="form-group">
                                                                    <label>Player online:</label>
                                                                    <select name="new_command[0][require_online]" class="form-control command-require-online">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0" selected>Não</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <?
                                        }
                                        else
                                        { ?>

                                            <?
                                            foreach ($package->getCommands() as $id_command)
                                            {
                                                $command = new Command($id_command);
                                                ?>
                                                <ul class="package-commands ui-sortable">
                                                    <li class="command" command_id="<?= $command->getIdCommand() ?>">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="command[<?= $command->getIdCommand() ?>][type]">
                                                                        <option value="1" <?= isSelected('1', $command->getType()) ?>>Inicial</option>
                                                                        <option value="2" <?= isSelected('2', $command->getType()) ?>>Expiração</option>
                                                                        <option value="3" <?= isSelected('3', $command->getType()) ?>>Renovar</option>
                                                                        <option value="4" <?= isSelected('4', $command->getType()) ?>>Reembolsar</option>
                                                                        <option value="5" <?= isSelected('5', $command->getType()) ?>>Chargeback</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-5 col-sm-6" style="padding-left:0;">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control command" name="command[<?= $command->getIdCommand() ?>][command]"
                                                                           value="<?= $command->getCommand(); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-3" style="padding-left:0;">
                                                                <div class="btn-group btn-group-justified">
                                                                    <a href="javascript:void(0);" class="btn btn-default command-move"><span class="fa fa-arrows"></span></a>
                                                                    <a href="javascript:void(0);" class="btn btn-info edit-package-command"><span class="fa fa-wrench"></span></a>
                                                                    <a href="javascript:void(0);" class="btn btn-danger delete-package-command"><span
                                                                            class="fa fa-trash-o"></span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="advanced well">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Executar no servidor:</label> <a href="#" data-toggle="popover"
                                                                                                                data-content="Select which server this command will execute upon."
                                                                                                                data-original-title="" title="">(?)</a>
                                                                        <select name="command[<?= $command->getIdCommand() ?>][server][]" class="form-control" multiple="multiple"
                                                                                required>
                                                                            <? foreach (getServidores() as $server)
                                                                            {
                                                                                echo ' <option value="' . $server["id_server"] . '" ' . isSelected($server["id_server"], $command->getServers()) . '>' . $server['name'] . '</option>';
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 col-xs-6">
                                                                    <div class="form-group">
                                                                        <label>Inv slots:</label> <a data-toggle="popover"
                                                                                                     data-content="Only execute this command if the player has a specified amount of free inventory space."
                                                                                                     data-original-title="" title="">(?)</a>
                                                                        <select name="command[<?= $command->getIdCommand() ?>][require_slots]" class="form-control">
                                                                            <? for ($i = 0; $i <= 36; $i++)
                                                                            {
                                                                                echo '<option value="' . $i . '" ' . isSelected((string)$i, $command->getRequireSlots()) . '>' . $i . '</option>' . "\n";
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 col-xs-6">
                                                                    <div class="form-group">
                                                                        <label>Player online:</label>
                                                                        <select name="command[<?= $command->getIdCommand() ?>][require_online]"
                                                                                class="form-control command-require-online">
                                                                            <option value="1" <?= isSelected('1', $command->getNeedOnline()) ?>>Sim</option>
                                                                            <option value="0" <?= isSelected('0', $command->getNeedOnline()) ?>>Não</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <? }
                                        } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default" data-spy="affix" data-offset-top="205">
                                <div class="panel-heading panel-seperator">Imagem descrição</div>
                                <div class="panel-body">
                                    <div class="package-image">
                                        <div class="image"></div>
                                        <div class="upload-button btn btn-success btn-block" data-loading-text="Please wait..." data-package-id=""><i class="fa fa-upload"></i> Enviar
                                            Imagem
                                        </div>
                                        <div class="remove-button btn btn-danger btn-block" style="display:none;"><i class="fa fa-trash-o"></i> Apagar imagem</div>
                                        <div class="info">Tamanho recomendado 190x165px.</div>
                                        <div class="hide-border hidden">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="hide_border">
                                                    Hide the image border.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-success" id="submit_button"><? if (isset($id_package)) echo "Atualizar"; else echo "Adicionar"; ?> item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <ul style="display: none">
                    <li class="command" id="package-command-template">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select class="form-control" name="new_command[][type]">
                                        <option value="1">Inicial</option>
                                        <option value="2">Expiração</option>
                                        <option value="3">Renovar</option>
                                        <option value="4">Reembolsar</option>
                                        <option value="5">Chargeback</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-6" style="padding-left:0;">
                                <div class="form-group">
                                    <input type="text" class="form-control command" name="new_command[][command]" value="">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3" style="padding-left:0;">
                                <div class="btn-group btn-group-justified">
                                    <a href="javascript:void(0);" class="btn btn-default command-move"><span class="fa fa-arrows"></span></a>
                                    <a href="javascript:void(0);" class="btn btn-info edit-package-command"><span class="fa fa-wrench"></span></a>
                                    <a href="javascript:void(0);" class="btn btn-danger delete-package-command"><span class="fa fa-trash-o"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="advanced well">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Executar no servidor:</label> <a href="#" data-toggle="popover"
                                                                                data-content="Select which server this command will execute upon."
                                                                                data-original-title="" title="">(?)</a>
                                        <select name="new_command[][server][]" class="form-control" multiple="multiple" required>
                                            <? foreach (getServidores() as $server)
                                            {
                                                echo ' <option value="' . $server["id_server"] . '">' . $server['name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Inv slots:</label> <a data-toggle="popover"
                                                                     data-content="Only execute this command if the player has a specified amount of free inventory space."
                                                                     data-original-title="" title="">(?)</a>
                                        <select name="new_command[][require_slots]" class="form-control">
                                            <? for ($i = 0; $i <= 36; $i++)
                                            {
                                                echo '<option value="' . $i . '">' . $i . '</option>' . "\n";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Player online:</label>
                                        <select name="new_command[][require_online]" class="form-control command-require-online">
                                            <option value="1">Sim</option>
                                            <option value="0" selected>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>


<?
    include ROOT . 'theme/foother.php';
?>