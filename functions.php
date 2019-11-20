<?php


function format_price($vlprice){
    if(!$vlprice > 0) $vlprice = 0;
    return number_format($vlprice,2,",",".");
}

function formatDate($date)
{
	return date('d/m/Y', strtotime($date));
}










?>