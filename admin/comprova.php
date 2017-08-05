<?

    $header = true;
    include "../loader.php";

    $title = "Ehaqui | Bem vindo";
    include ROOT . 'theme/header.php';
	
	if(isset($_REQUEST['send']))
	{
      	$gateway = getGatewayFromString($_REQUEST['gateway']);

      	// Check if the gateway is invalid
      	if (is_null($gateway)) {
        	exit("Invalid gateway!");
      	}

      	// Check if Gateway has a valid payment
      	if ($gateway->isPayed($id_transacao))
	  	{

		  	addPagamento($_REQUEST['gateway'], $_REQUEST['id_order'], $_REQUEST['id_transacao'], $_REQUEST['value']);
	      		setToAtive($_REQUEST['id_order']);
		  
			echo "Pagamento Confirmado";
		}
	}
	
?>

<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Confirmar Pagamento</legend>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-4 control-label" for="gateway">Gateway</label>
  <div class="col-md-4">
  <div class="radio">
    <label for="gateway-0">
      <input type="radio" name="gateway" id="gateway-0" value="pagseguro" checked="checked">
      PagSeguro
    </label>
	</div>
  <div class="radio">
    <label for="gateway-1">
      <input type="radio" name="gateway" id="gateway-1" value="paypal">
      PayPal
    </label>
	</div>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="id_transacao">Id Transação</label>  
  <div class="col-md-4">
  <input id="id_transacao" name="id_transacao" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="value">Valor</label>  
  <div class="col-md-4">
  <input id="value" name="value" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="id_order">Id pedido</label>  
  <div class="col-md-4">
  <input id="id_order" name="id_order" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="send"></label>
  <div class="col-md-4">
    <button id="send" name="send" class="btn btn-success">Confirmar Pagamento</button>
  </div>
</div>

</fieldset>
</form>



