<div id="admin_dash_container">
<p>
    <div id="title2">
        <?php echo $title2; ?> ( <?php echo $count; ?> )
    </div>
</p>

<p>
    <div id="poruke_container">
        <?php foreach ($messages as $messages_item): ?>                
                <div class="poruka">
                    <b>Poruka ID: &nbsp;</b><?php echo $messages_item['id'] ?> <br>
                    <b>Naslov poruke: &nbsp;</b><?php echo $messages_item['title'] ?> <br>
                    <b>Autor: &nbsp;</b><?php echo $messages_item['author'] ?> <br>
                    <b>IP: &nbsp;</b><?php echo $messages_item['user_ip'] ?> <br> 
                    <b>Agent: &nbsp;</b><?php echo $messages_item['user_agent'] ?> <br> 
                    <b>Datum:&nbsp;</b><?php echo substr($messages_item['datecreated'], 8, 2) . '.' . substr($messages_item['datecreated'], 5, 2) .'.'. substr($messages_item['datecreated'], 0, 4).'; '.substr($messages_item['datecreated'], 11, 8); ?><br>
                    <b>Broj pregleda: &nbsp;</b><?php echo $messages_item['views'] ?> <br> 
                    <b>Broj lajkova: &nbsp;</b><?php echo $messages_item['likes'] ?> <br> 
                    <b>Broj dislajkova: &nbsp;</b><?php echo $messages_item['dislikes'] ?> <br> 
                    <b>Status: &nbsp;</b>
                        <?php
                            if (  $messages_item['active'] == 0 )
                                echo "<span class='neodobren'>Poruka nije odobrena</span>";
                            if (  $messages_item['active'] == 1 )
                                echo "<span class='odobren'>Poruka je odobrena i vidljiva</span>";
                        ?>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo site_url('/admin/status_history/'.$messages_item['id']); ?>" target="_blank">Istorija statusa</a><br><br>
                    <b>Tekst poruke:&nbsp;</b>

                    <div class="poruka_txt">
                        <?php echo $messages_item['message'] ?><br>
                    </div>

                    <div class="poruka_menu">
                        <a class="poruka_menu_item" href="<?php echo site_url('/admin/approve_message/'.$messages_item['id']); ?>">Odobri poruku</a>&nbsp;&nbsp;&nbsp;
                        <a class="poruka_menu_item" href="<?php echo site_url('/admin/remove_message/'.$messages_item['id']); ?>">Obrisi poruku</a>&nbsp;&nbsp;&nbsp;
                        <a class="poruka_menu_item" href="#">Arhiviraj poruku</a>&nbsp;&nbsp;&nbsp;
                        <a class="poruka_menu_item" href="#">Opcija 4</a>
                    </div>
                </div>
        <?php endforeach ?>
    </div>    
</p>
Broj poruka: <?php echo $count; ?><br>
</div>