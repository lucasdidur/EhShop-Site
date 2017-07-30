<?php

$header = false;
include "../loader.php";

$title = "Ehaqui | Bem vindo";
include ROOT . 'theme/header.php';

if (isset($_REQUEST['send'])) {
    addPagamento($_REQUEST['gateway'], $_REQUEST['id_order'], $_REQUEST['id_transacao'], $_REQUEST['value']);

    setToAtive($_REQUEST['id_order']);

    echo "<h1>Pagamento Confirmado</h1>";
}

$id_pedido = $_REQUEST['id_order'];

$pedido = new Order($id_pedido);
$package = new Package($pedido->getIdPackage());
$transations = Transation::loadByOrder($pedido->getIdOrder());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Flat UI Free 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/vendor/html5shiv.js"></script>
    <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01"><span
                    class="sr-only">Toggle navigation</span></button>
            <a class="navbar-brand" href="#">Flat UI</a></div>
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#fakelink">Products</a></li>
                <li><a href="#fakelink">Features</a></li>
            </ul>
            <form class="navbar-form navbar-right" action="#" role="search">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" id="navbarInput-01" type="search" placeholder="Search">
                        <span class="input-group-btn">
                        <button type="submit" class="btn"><span class="fui-search"></span></button>
                        </span></div>
                </div>
            </form>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <!-- /navbar -->
    <div>
        <div class="order">
            <div class="order-skin"><img src="http://www.minecraft-skin-viewer.net/3d.php?login=<?= $package->getName() ?>" height="350"/>
            </div>
            <div class="order-detail">
                <h3>
                    Informações
                </h3>
                <table class="table">
                    <tbody>
                    <tr>
                        <td scope="row">Id pedido</td>
                        <td><?= $pedido->getIdOrder() ?></td>
                    </tr>
                    <tr>
                        <td scope="row">Status</td>
                        <td><span class="label label-success"><?= getStatusName($pedido->getStatus()) ?></span></td>
                    </tr>
                    <tr>
                        <td scope="row">Tipo</td>
                        <td><?= $package->getName() ?></td>
                    </tr>
                    <tr>
                        <td scope="row">Player</td>
                        <td><?= $pedido->getNick() ?> (<?= $pedido->getUuid() ?>)</td>
                    </tr>
                    <tr>
                        <td scope="row">Data Criado</td>
                        <td><?= $pedido->getDateCreated() ?></td>
                    </tr>
                    <?php if ($pedido->getStatus() != 1 && $pedido->getStatus() != 5): ?>
                        <tr>
                            <td scope="row">Data ativado</td>
                            <td><?= $pedido->getDateActive() ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pedido->getStatus() == 4): ?>
                        <tr>
                            <td scope="row">Data expirado</td>
                            <td><?= $pedido->getDateExpired() ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br clear="all">
        <div class="order-transation">
            <h4>Pagamentos</h4>
            <?php if ($pedido->getStatus() == 5){ ?>
                <div>
                    <div>Não há pagamentos</div>
                    <br/>
                    <form class="form-horizontal" method="post">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Confirmar Pagamento</legend>

                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="gateway">Gateway</label>
                                <div class="col-md-4">
                                    <select id="gateway" name="gateway" class="form-control">
                                        <option value="pagseguro">PagSeguro</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="id_transacao">Id Transação</label>
                                <div class="col-md-4">
                                    <input id="id_transacao" name="id_transacao" type="text" placeholder=""
                                           class="form-control input-md">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="value">Valor</label>
                                <div class="col-md-4">
                                    <input id="value" name="value" type="text" placeholder=""
                                           class="form-control input-md">
                                </div>
                            </div>

                            <input name="id_order" type="hidden" value="<?= $pedido->getIdOrder() ?>"

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="send"></label>
                                <div class="col-md-4">
                                    <button id="send" name="send" class="btn btn-success">Confirmar Pagamento</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?
            }
            if (count($transations) > 0){
            ?>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id pagamento</th>
                            <th>Gateway</th>
                            <th>Id Transação</th>
                            <th>Valor Liquido</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($transations as $transation){ ?>
                            <tr>
                                <td><?= $transation->getId(); ?></td>
                                <td><?= $transation->getGateway(); ?></td>
                                <td><?= $transation->getIdTransation(); ?></td>
                                <td><?= $transation->getValue(); ?></td>
                                <td><?= $transation->getDate(); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.container -->

<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<script src="js/vendor/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
</body>
</html>
