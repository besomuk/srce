<div id="admin_dash_container">
<div id="title2">
    <?php echo $title2; ?>
</div>

<div id="poruke_container">
    <?php foreach ($comments as $comment_item): ?>                
            <div class="poruka">
    <b>Komentar ID: &nbsp;</b><?php echo $comment_item['id'] ?> <br>
    <b>Autor: &nbsp;</b><?php echo $comment_item['comment_author'] ?> <br>
    <b>Komentar na poruku: &nbsp;</b><a href="<?php echo site_url('/view_message/'.$comment_item['message_id']); ?>" target="_blank"><?php echo $comment_item['message_id'] ?></a><br>    
    <b>Vreme: &nbsp;</b><?php echo $comment_item['comment_time'] ?> <br>
    <b>IP: &nbsp;</b><?php echo $comment_item['user_ip'] ?> <br>
    <b>Status: </b>
    <?php
        if (  $comment_item['status'] == 0 )
            echo "<span class='neodobren'>Komentar nije odobren</span>";
        if (  $comment_item['status'] == 1 )
            echo "<span class='odobren'>Komentar je odobren i vidljiv</span>";
    ?><br><br>
    <b>Tekst komentara:&nbsp;</b><br>
    <div class="poruka_txt">
        <?php echo $comment_item['comment_txt'] ?><br>
    </div>    
                <div class="poruka_menu">
                    <a class="poruka_menu_item" href="<?php echo site_url('/admin/approve_comment/'.$comment_item['id']); ?>">Odobri komentar</a>&nbsp;&nbsp;&nbsp;
                    <a class="poruka_menu_item" href="<?php echo site_url('/admin/remove_comment/'.$comment_item['id']); ?>">Obrisi komentar</a>&nbsp;&nbsp;&nbsp;
                    <a class="poruka_menu_item" href="#">Arhiviraj komentar</a>&nbsp;&nbsp;&nbsp;
                    <a class="poruka_menu_item" href="#">Opcija 4</a>
                </div>
            </div>
    <?php endforeach ?>
</div>   
</div>