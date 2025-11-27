<?php

///////////////////////////////////
$title = 'Правила сайта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
///////////////////////////////////
if (strlen($api_settings['rules'])>1){
echo '<div class="apicms_subhead">'.apicms_br(apicms_bb_code(apicms_smiles($api_settings['rules']))).'</div>';
}else{
echo '<div class="erors"><center>Правил еще нету.</center></div>';
}
///////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>