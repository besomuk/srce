<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title><?php echo $title;?></title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sr.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sidebar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/footer.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/hover.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/message_full.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/skriveni.css" />
    
    <!-- <script src="http://code.jquery.com/jquery-1.5.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.5.js" /></script>
    <script src="<?php echo base_url(); ?>assets/js/razno.js" /></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.lightbox_me.js" /></script>
</head>
<body>


<div id="headers">
    <div id="header_soc">
        Header, soc
    </div>    
    
    <div id="header">
        <div id="logo_holder">            
            <a href="<?php echo site_url('/'); ?>">
            <?php echo img('/assets/img/srcelogo.png'); ?>
                </a>
        </div>
        <div id="uvod_txt">
            ReciSrcu.com je mesto na kome možete ostaviti anonimnu poruku nekom posebnom,
            napisati sve ono što vam neizrečeno leži na srcu. Taj korak može pomoći da skupite hrabrost,
            sagledate stvari iz drukčije perspektive ili da se rasteretite kako bi nastavili dalje.
        </div>
    </div>
    
    <div id="nav">
        <ul>
            <li><a href="<?php echo site_url('pages/sta_je_to'); ?>">Šta je to ReciSrce</a></li>
            <li><a href="<?php echo site_url('write_message'); ?>">Pošaljite poruku</a></li>
            <li><a href="#">Najpopularnije poruke</a></li>
            <li><a href="<?php echo site_url('pages/pravila'); ?>">Pravila</a></li>
        </ul>
    </div>            
    
    <div id="header_banner">
        Ja sam banner
    </div>
</div>
    
<!-- <div id="skrivac_okidac">okidac</div> -->
    
<div id="skrivac">
    <p>
        Ja sam skriveni div
    </p>
</div>
    
<div id="wrap">