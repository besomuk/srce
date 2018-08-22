<div id="msg_f">            
    <!-- prvi red zaglavlja poruke -->
    <div id="msg_head">
        <!-- uh uh -->
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td id="msg_head_l">
                    <?php echo $title; ?>
                </td>
                <td id="msg_head_r">                            
                </td>
                <td id="msg_head_rr">                            
                    #<?php echo $id; ?>
                </td>                        
            </tr>
        </table>
    </div>   
    
    <!-- drugi red zaglavlja poruke -->
    <div id="msg_head_add">
        by <span id="msg_head_add_auth"><?php echo $author ?> </span>&middot;
        <?php echo substr($datecreated, 8, 2) . '.' . substr($datecreated, 5, 2) .'.'. substr($datecreated, 0, 4).'; '.substr($datecreated, 11, 8); ?> &middot;
        <a href="#/" class="msg_comments_button" name="<?php echo $id;?>">Komentari (<?php echo $comments_count; ?>)</a>
    </div>     
    
    <!-- tekst poruke -->
    <div id="msg_txt">
        <?php echo $title ?> ------ NASLOV PORUKE ------
    </div>    
        
    <!-- tekst poruke -->
    <div id="msg_txt">
        <?php echo $message ?>
    </div>
    
    <!-- podeli, sacuvaj, socijalne mreze slajfna -->
    <div id="msg_f_soc">
        <span id="msg_f_soc_l">
            <span id="msg_soc_save" class="hvr-grow"><a href="<?php echo site_url('/messages/export_message/'.$id); ?>" target="_blank"  ><?php $img = array ('src'=>'assets/img/save.png', 'width'=>'90px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'save');echo img($img);?></a></span>
            <span id="msg_soc_send" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/send.png', 'width'=>'97px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'send');echo img($img);?></a></span>
        </span>    

        <span id="msg_f_soc_r">
            <span id="msg_soc_share"><a href="#"><?php $img = array ('src'=>'assets/img/share.jpg', 'width'=>'55px');echo img($img);?></a></span>
            <span id="msg_soc_share_fb" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/001.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'fb');echo img($img);?></a></span>
            <span id="msg_soc_share_tw" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/002.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'tw');echo img($img);?></a></span>
            <span id="msg_soc_share_gp" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/003.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'gp');echo img($img);?></a></span>
            <span id="msg_soc_share_tu" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/004.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'tu');echo img($img);?></a></span>
            <span id="msg_soc_share_pb" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/005.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'pb');echo img($img);?></a></span>
            <span id="msg_soc_share_fk" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/006.png', 'width'=>'26px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'fk');echo img($img);?></a></span>
        </span>
    </div>
    
    <!-- lajk, dislajk slajfna -->
    <div id="msg_likes">
        <div id="msg_likes_l">&nbsp;</div>

        <div id="msg_likes_r">
            <span id="msg_likes_down" class="hvr-grow"><a href="<?php echo site_url('messages/dislike_message'.'/'.$id); ?>">NE SVIDJA MI SE</a> (<?php echo $dislikes ?>)</span>                    
            <span id="msg_likes_up"   class="hvr-grow"><a href="<?php echo site_url('messages/like_message'.'/'.$id); ?>">SVIDJA MI SE</a> (<?php echo $likes ?>)</span>
        </div>
    </div>    
    
    <!-- forma za pisanje komentara -->
    <div id="pisanje_cont">
        <?php echo form_open('comments/write_comment'); ?>
            <input type="input" name="id" value="<?php echo $id ?>" id="id" /><br />
        
            <label for="author">Pseudonim autora (Anonimus)</label><br />
            <input type="input" name="author" value="Anonimus" id="author" onclick="bBrisi(this)" maxlength="30"/><br />

            <div id="msg_val" style="display:none"><?php echo MAX_CHARS_COM ?></div>
            <label for="text">Komentar (preostalo <span id="charNum"><?php echo MAX_CHARS_COM ?></span> karaktera)</label><br />
            <textarea name="text" rows="10" cols="30" id="text" maxlength="<?php echo MAX_CHARS_COM ?>" onkeyup="countChar(this)" ><?php echo set_value('text'); ?></textarea>
            <div><?php echo form_error('text'); ?></div>

            <div id="dugmad">
                <input type="submit" name="submit" value="Pošalji komentar" class="but" />
            </div>

        <?php echo form_close() ?>    
    </div>   
    
</div>            

