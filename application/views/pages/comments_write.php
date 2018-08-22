<hr>
<h2>Novi komentar</h2>
<p>
    <?php echo form_open('view_message/' . $id) ?>
        
        Autor:<input type="text" name="author" value="Anonimus"><br>
        Teekst:<textarea name="text" rows="10" cols="30"></textarea><br />
        <input type="submit" name="submit" value="Posalji komentar" />
    </form>
</p>