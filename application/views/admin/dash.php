<div id="admin_dash_container">
    <div id="admin_dash_title">
        administratorski panel
    </div>    
    <div id="admin_dash_content">
        Ukupan broj poruka: <?php echo $count_sve; ?> <br>
        Broj odobrenih poruka: <?php echo $count_odo; ?> <br>
        Broj neodobrenih poruka: <?php echo $count_neodo; ?> <br>
        Broj arhiviranih poruka: <?php echo $count_arh; ?> <br>
        Broj komentara: <br>
        Ukupan broj pregleda: <br>
    </div>
    
    <div id="admin_dash_content">
        Platform: <?php echo $db_platform; ?> <br>
        Version : <?php echo $db_version; ?> <br>
        DB Size : <?php echo $db_size; ?> MB<br><br>
        <a href="#">Optimize table</a><br>
        <a href="#">Repair table</a><br>
        <a href="#">Optimize database</a><br>
        <a href="#">Export CSV</a><br>
        <a href="#">Export XML</a><br>
        <a href="<?php echo site_url('dbtools/backup_db'); ?>">Backup database</a><br>
        <a href="<?php echo site_url('dbtools/backup_table'); ?>">Backup table</a><br>
    </div>    
</div>
