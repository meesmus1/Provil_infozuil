function register(){
    const username = $('#username').val();
    const password = $('#password').val();

    if (!username || !password){
        $('#errorMessage').css({'display':'block'})
        $('#errorMessage').html('Niet alle velden zijn ingevuld.')
    } else{
        $.ajax({
            url:'./inc/signup.php',
            method:'POST',
            data:{
                username,   
                password,
            },
            dataType:'json',

        })
    }
    


}