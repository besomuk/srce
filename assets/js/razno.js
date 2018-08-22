/* 29.9.2015
 * Sitnice za sitne popravke i intervencije
 */

/* AKO SMO SPREMNI, DODELI FUNKCIJE DUGMICIMA I TA JOS TREBA  ********************************  */
$(document).ready(function() 
{            
    $('.msg_comments_button').click( showComments );
    
    // postavi okidace za lightboxove
    $('#skrivac_okidac').click(function(e){
                                    $('#skrivac').lightbox_me({ centered: true });
                                    e.preventDefault();
                                 });        
});
             
/* BROJANJE KARAKTERA U TEKST BOKSU I OGRANICAVANJE NA X KARAKTERA ***************************** */
/* vrednost za maks broj karaktera dolazi iz Code Igniter konfiguracije ( constants.php ), a     */
/* iz stranice se cita direktno iz za to namenjenog, a skrivenog DIV-a                           */
function countChar(val)
{
    var max_char = document.getElementById("msg_val").textContent; // maksimalno karaktera, preuzmi iz PHP-a, sa stranice
    var len = val.value.length;   // trenutno karaktera
    
    if ( len >= max_char ) // dostigli smo plafon      
    {
        val.value = val.value.substring(0, max_char);
        /*$('#char_warning').text( "premasili ste broj karkatera" );*/
        $('#charNum').text( "0" );
    }
    else // jos uvek ima slobodnih karaktera
    {
        /*$('#char_warning').text( "" );*/
        $('#charNum').text( max_char - len);
    }                
};

/* STARI DOBRI ROLOVER ON ********************************************************************** */
function rollover(my_image)
{
    if ( my_image.name == "save" ) my_image.src = 'assets/img/save_hover.png';
    if ( my_image.name == "send" ) my_image.src = 'assets/img/send_hover.png';
    if ( my_image.name == "fb" )   my_image.src = 'assets/img/001_hover.png';
    if ( my_image.name == "tw" )   my_image.src = 'assets/img/002_hover.png';
    if ( my_image.name == "gp" )   my_image.src = 'assets/img/003_hover.png';
    if ( my_image.name == "tu" )   my_image.src = 'assets/img/004_hover.png';
    if ( my_image.name == "pb" )   my_image.src = 'assets/img/005_hover.png';
    if ( my_image.name == "fk" )   my_image.src = 'assets/img/006_hover.png';
    if ( my_image.name == "vote_up" )   my_image.src = 'assets/img/up_hover.png';
    if ( my_image.name == "vote_down" ) my_image.src = 'assets/img/down_hover.png';
}

/* STARI DOBRI ROLOVER OFF ********************************************************************* */
function mouseaway(my_image)
{
    if ( my_image.name == "save" ) my_image.src = 'assets/img/save.png';
    if ( my_image.name == "send" ) my_image.src = 'assets/img/send.png';
    if ( my_image.name == "fb" )   my_image.src = 'assets/img/001.png';
    if ( my_image.name == "tw" )   my_image.src = 'assets/img/002.png';    
    if ( my_image.name == "gp" )   my_image.src = 'assets/img/003.png';
    if ( my_image.name == "tu" )   my_image.src = 'assets/img/004.png';    
    if ( my_image.name == "pb" )   my_image.src = 'assets/img/005.png';
    if ( my_image.name == "fk" )   my_image.src = 'assets/img/006.png';    
    if ( my_image.name == "vote_up" )   my_image.src = 'assets/img/up.png';
    if ( my_image.name == "vote_down" ) my_image.src = 'assets/img/down.png';    
}

/* PRIKAZI ILI SAKRIJ KOMENTARE NA OSNOVU DINAMICKOG ID-A KOJI IM SE DODELJUJE ***************** */
function showComments()
{
    var new_name = "#msg_cmt_" + this.name;
    if ( $(new_name).is(':hidden') )
        $(new_name).slideDown( 500 );
    else
        $(new_name).slideUp( 500 );    
}

/* OBRISI TEKST IZ POLJA AUTORA **************************************************************** */
function bBrisi(val)
{
    if ( val.value == "Anonimus" )
        val.value = "";
}