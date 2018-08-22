
<!-- komentari -->
<div id="<?php echo 'msg_cmt_'.$id;?>">            
    <div id="comments_f">
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
                        <?php foreach ($comments as $comment_item): ?>                                
                                <div id="comments_list_author">by&nbsp;<?php echo $comment_item['comment_author'] ?>  on <?php echo $comment_item['comment_time'] ?></div>
                                <div id="comments_list_msg"><?php echo $comment_item['comment_txt'] ?></div>
                        <?php endforeach ?>
                    </div>
                </td>
            </tr>    
        </table>
    </div>
</div>