<div class="sidebar">
    <div class="panel panel-default module">
        <div class="panel-heading">
            <div class="pull-left">Status</div>
            <div class="text-right"> <span class="label label-success">Online</span> </div>
        </div>
        <div class="panel-body">
            <div class="server-status">
                <h4>mc.ehaqui.com</h4>
                <p>Venha jogar conosco </p>
            </div>
        </div>
    </div>
    <div class="panel panel-default module">
        <div class="panel-heading">Objetivo de Arrecadações</div>
        <div class="panel-body">
            <div class="donation-goal">
                <p>  Estamos quase lá (<? echo get_percent_arrecadacao() ?>%) </p>
                <div class="progress  progress-striped   active ">
                    <div class="progress-bar" role="progressbar" style="width:<? echo formatar_numero(get_percent_arrecadacao(), true) ?>%;"></div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="panel panel-default module">
        <div class="panel-heading">Top Doador</div>
        <div class="panel-body"> No recent top donator to display.
            <div class="top-donator">
                <div class="avatar"> <span class="mc-skin" data-minecraft-username="GunnerzOVO"></span> </div>
                <div class="info">
                    <div class="ign">GunnerzOVO</div>
                    <div class="amount"> Que mais doou este mês </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default module">
        <div class="panel-heading">Destaque</div>
        <div class="panel-body">
            <div class="featured-package">
                <div class="image"> <a href="javascript:void(0);" data-remote="/package/1122431" class="toggle-modal"> <img src="//dunb17ur4ymx4.cloudfront.net/packages/images/0a446865427866a246bd85493c64d7be6ab89b48.png" class="toggle-tooltip img-rounded" title="" data-original-title="Click for more details"> </a> </div>
                <div class="info">
                    <div class="text">
                        <div class="name">VIP - Permanente.</div>
                        <div class="price"> 49.90 <small>EUR</small> </div>
                    </div>
                    <div class="button"> <a href="javascript::void(0);" data-remote="/package/1122431" class="btn btn-info btn-sm btn-block toggle-modal">Buy</a> </div>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="panel panel-default module">
        <div class="panel-heading">Doadores Recentes</div>
        <div class="panel-body">
            <ul class="payments">
                <? foreach(getRecentOrders() as $order): ?>
                <li>
                    <div class="avatar"> <img src="//cravatar.eu/helmhead/<? echo $order['nick'] ?>/28" /> </div>
                    <div class="info">
                        <div class="ign"> <? echo $order['nick'] ?> &bull; <? echo date('d/m', strtotime($order['date_active'])) . ' às ' . date('H:i', strtotime($order['date_active'])); ?></div>
                        <div class="extra"> <? echo get_product_name($order['id_order']); ?> &bull; <? echo get_price($order['id_order']); ?> <small>Reais</small> </div>
                    </div>
                </li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Precisa de Ajuda?</div>
        <div class="panel-body">
            <p> </p>
            <p style="font-size:13.3333330154419px;line-height:20.8000011444092px;text-align:center;">Em caso de dúvida relacionada à nossa loja, sinta-se livre para entrar em contato pelo endereço de email&nbsp;<strong>contato@ehaqui.com</strong> ou usar o chat no inferior da página.</p>
            <p style="font-size:13.3333330154419px;line-height:20.8000011444092px;text-align:center;">
                <a href="https://facebook.com/EhAquiOficial"><img alt="" src="https://buycraft.s3.amazonaws.com/wysiwyg/219139-489ec163d19d7c098619bd6a5b88215bd15df99f.png" style="height:31px;width:32px;"></a>
                &nbsp; &nbsp;&nbsp;
                <a href="https://twitter.com/ehaqui"><img alt="" src="https://buycraft.s3.amazonaws.com/wysiwyg/219139-3e566329eed10d6a3b2b04b15c40be7c969fea2d.png" style="width:32px;height:33px;"></a></p>
            <p></p>
        </div>
    </div>
</div>
