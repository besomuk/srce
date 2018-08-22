<div id="main">
    
<?php foreach ($messages as $messages_item): ?>        
                
        <!-- poruka -->
        <div id="msg">
            
            <!-- prvi red zaglavlja poruke -->
            <div id="msg_head">
                <!-- uh uh -->
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td id="msg_head_l">
                            <?php echo $messages_item['title'] ?>
                        </td>
                        <td id="msg_head_r">                            
                        </td>
                        <td id="msg_head_rr">                            
                            #<?php echo $messages_item['id']; ?>
                        </td>                        
                    </tr>
                </table>
            </div>
            
            <!-- drugi red zaglavlja poruke -->
            <div id="msg_head_add">
                by <span id="msg_head_add_auth"><?php echo $messages_item['author'] ?> </span>&middot;
                <?php echo substr($messages_item['datecreated'], 8, 2) . '.' . substr($messages_item['datecreated'], 5, 2) .'.'. substr($messages_item['datecreated'], 0, 4).'; '.substr($messages_item['datecreated'], 11, 8); ?> &middot;
                <a href="<?php if ($messages_item['comments_no']>0) echo '#/'; else echo site_url('view_message/' . $messages_item['id']); ?>" class="msg_comments_button" name="<?php echo $messages_item['id'];?>">Komentari (<?php echo $messages_item['comments_no']; ?>)</a>
            </div>            
    
            <!-- tekst poruke -->
            <div id="msg_txt">
                <?php echo $messages_item['message'] ?>
            </div>
            
            <!-- citaj dalje slajfna -->
            <div id="msg_show">
                <a href="<?php echo site_url('view_message/' . $messages_item['id']); ?>">Prikaži sve...</a>
            </div>
                        
            <!-- podeli, sacuvaj, socijalne mreze slajfna -->
            <div id="msg_soc">
                <span id="msg_soc_l">
                    <span id="msg_soc_save" class="hvr-grow"><a href="<?php echo site_url('/messages/export_message/'.$messages_item['id']); ?>" target="_blank"  ><?php $img = array ('src'=>'assets/img/save.png', 'width'=>'90px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'save');echo img($img);?></a></span>
                    <span id="msg_soc_send" class="hvr-grow"><a href="#"><?php $img = array ('src'=>'assets/img/send.png', 'width'=>'97px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'send');echo img($img);?></a></span>
                </span>    

                <span id="msg_soc_r">
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
                    <span id="msg_likes_up"   class="hvr-grow"><a href="<?php echo site_url('messages/dislike_message'.'/'.$messages_item['id']); ?>">NE SVIDJA MI SE</a> (<?php echo $messages_item['dislikes'] ?>)</span>                    
                    <span id="msg_likes_down" class="hvr-grow"><a href="<?php echo site_url('messages/like_message'.'/'.$messages_item['id']); ?>">SVIDJA MI SE</a> (<?php echo $messages_item['likes'] ?>)</span>                    
                </div>
            </div>
    
            <!-- komentari -->
            <div id="<?php echo 'msg_cmt_'.$messages_item['id'];?>" style="display:none">            
                <div id="comments">
                    <table cellspacing="0" cellpadding="0" id="comments_head">
                        <tr>
                            <td id="comments_head_01"></td>
                            <td id="comments_head_02">&nbsp;Komentari&nbsp;</td>
                            <td id="comments_head_03"></td>
                        </tr>
                    </table>    
                    <table cellspacing="0" cellpadding="0" id="comments_body">
                        <tr>
                            <td id="comments_body_01">
                                <div id="comments_list">
                                    <?php foreach ($messages_item['comments'] as $comment_item): ?>                                
                                            <div id="comments_list_author">by&nbsp;<?php echo $comment_item['comment_author'] ?> on <?php echo $comment_item['comment_time'] ?></div>
                                            <div id="comments_list_msg"><?php echo $comment_item['comment_txt'] ?></div>
                                    <?php endforeach ?>
                                </div>
                            </td>
                        </tr>    
                    </table>
                </div>
            </div>
        </div>

<?php endforeach ?>

</div>