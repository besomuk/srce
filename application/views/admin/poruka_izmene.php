<div>
    <h2>Istorija statusa poruke <?php echo $id_poruke; ?></h2>
</div>    

<div id="poruke_container">
    <?php foreach ($items as $item): ?>   
       <div class="poruka">
            <b>Datum:&nbsp;</b><?php echo substr($item['change_date'], 5, 2) . '.' . substr($item['change_date'], 8, 2) .'.'. substr($item['change_date'], 0, 4).'; '.substr($item['change_date'], 11, 8); ?><br>                
            <b>Izmenu uradio: &nbsp;</b><?php echo $item['user_name'] ?> <br>
            <b>Vrsta izmene: &nbsp;</b><?php echo $item['change_type'] ?> <br>
            <b>IP: &nbsp;</b><?php echo $item['change_ip'] ?> <br>
            <b>Browser: &nbsp;</b><?php echo $item['change_agent'] ?> <br>
        </div>   
    <?php endforeach ?>
</div>    
<hr>
<hr>