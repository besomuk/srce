<div id="msg_head">
    <!-- uh uh -->
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td id="msg_head_l" style="padding-left:10px;">Pošaljite poruku</td>
            <td id="msg_head_r"></td>
            <td id="msg_head_rr"></td>    
        </tr>
    </table>
</div>

<div id="write_msg_uvod">
    Skupili ste hrabrost da kažete šta osećate. Bravo za vas!
</div>

<!-- forma za poruku -->
<div id="pisanje_cont">
    <?php echo form_open('write_message'); ?>
        
        <label for="author">Pseudonim autora (Anonimus)</label><br />
        <input type="input" name="author" value="Anonimus" id="author" onclick="bBrisi(this)" maxlength="30"/><br />

        <label for="title">Naslov*</label><br />
        <input type="input" name="title" id="title" maxlength="60" value="<?php echo set_value('title'); ?>"/>
        <?php echo form_error('title'); ?>
        <br />

        <div id="msg_val" style="display:none"><?php echo MAX_CHARS_MSG ?></div>
        <label for="text">Poruka* (preostalo <span id="charNum"><?php echo MAX_CHARS_MSG ?></span> karaktera)</label><br />
        <textarea name="text" rows="10" cols="30" id="text" maxlength="<?php echo MAX_CHARS_MSG ?>" onkeyup="countChar(this)" ><?php echo set_value('text'); ?></textarea>
        <div><?php echo form_error('text'); ?></div>

        <table>
            <tr>
                <td valign="top"><?php echo $image; ?></td>
                <td valign="top"><input type="input" name="captcha" id="captcha"/></td>
                <td valign="top"><?php echo form_error('captcha'); ?></td>
            </tr>
        </table>

        <div id="dugmad">
            <input type="submit" name="submit" value="Pregledaj poruku" class="but" />
            <input type="submit" name="submit" value="Pošalji poruku" class="but" />
        </div>
    
    <?php echo form_close() ?>    
</div>    



<div id="podeli_txt">
    <p>* obavezna polja</p>
    <div id="podeli_txt_n">
        Podeli ovu poruku sa nekim posebnim
    </div>
    <p>
        Ukoliko želite svoju tajnu podeliti s nekim posebnim možete to učiniti odmah. Potpuno anonimno, slanjem direktno
        na email ili preko društvenih mreža.            
    </p>
</div>



<div id="write_podglavlje">
    <div id="msg_soc">
        <span id="msg_soc_l">
            <span id="msg_soc_save" class="hvr-grow"><a href="#" target="_blank"  ><?php $img = array ('src'=>'assets/img/save.png', 'width'=>'90px', 'onmouseover'=>'rollover(this)', 'onmouseout'=>'mouseaway(this)', 'name'=>'save');echo img($img);?></a></span>
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
</div>    