<!-- <div class="logo"></div> -->

<div class="login-block">
    <h1>Login</h1>
    <?php echo form_open('admin') ?>    
    
        <input type="text" value="" placeholder="username" id="username" name="username"/>
            <div class="input_error"><?php echo form_error('username'); ?></div>
        <br>
        <input type="password" value="" placeholder="password" id="password" name="password"/>
            <div class="input_error"><?php echo form_error('password'); ?></div>
        <br>
        <input type="submit" name="submit" value="Login" />
    </form>
</div>
