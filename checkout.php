<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$title = "Ehaqui | Pagamento";
include 'theme/header.php';

$id_pedido = $_REQUEST['id'];

if (!isPaid($id_pedido))
{
    ?>

    <div class="body">
        <div class="full-width">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left"><b>Pedido:</b> <? echo get_product_name($id_pedido) ?> (Nick: <? echo get_nick($id_pedido); ?>)</div>
                    <div class="text-right"><b>Valor:</b> <? echo get_price($id_pedido, false) ?>
                        <small>Reais</small>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="checkout">
                        <form method="post" action="<? echo URL ?>api.php" class="gateway">
                            <input type="hidden" name="action" value="process_order"/>
                            <input type="hidden" name="oid" value="<? echo $id_pedido ?>"/>

                            <div class="page-header">
                                <h4>Método de Pagamento</h4>
                            </div>
                            <div class="gateways">
                                <?
                                foreach ($gateways as $gateway)
                                {
                                    if (!$gateway->isEnabled())
                                        continue;
                                    ?>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gateway" id="gateway" value="<? echo strtolower($gateway->getName()) ?>">
                                            <img src="<? echo URL . $gateway->getURLSignature() ?>"/> <? echo $gateway->getName() ?> </label>
                                    </div>

                                    <?
                                }
                                ?>
                            </div>
                            <div class="page-header">
                                <h4>Detalhes do Pagamento</h4>
                            </div>
                            <div class="details">
                                <div class="row">
                                    <div class="name">
                                        <div class="form-group">
                                            <label>Nome Completo:</label>
                                            <input type="input" class="form-control" name="name"/>
                                        </div>
                                    </div>
                                    <div class="email">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="input" class="form-control" name="email"/>
                                        </div>
                                    </div>
									<div class="email">
                                        <div class="form-group">
                                            <label>Data de Nascimento de quem vai fazer o pagamento:</label>
                                            <input type="date" class="form-control" name="birthday"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tax"></div>

                            <div class="row">
                                <div class="col-sm-4 pull-right">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Confirmar &raquo;</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
} else
{
    ?>
    <div class="bs-calltoaction bs-calltoaction-success">
        <div class="row">
            <div class="col-md-9 cta-contents">
                <h1 class="cta-title">Seu pedido já foi concluído!</h1>
                <div class="cta-desc">
                    <br>
                    <br>
                    <p>Obrigado por concluir seu pedido!</p>
                    <br>
                    <p>Caso tenha dúvida ou algum problema, entre em contato com a staff utilizando o chat abaixo. Informado o id do pedido e o código de transação do pagamento.</p>
                </div>
            </div>
        </div>
    </div>
    <?
}
include 'theme/foother.php';
?>