function Signup() {
    const username = $('#username').val();
    const password = $('#password').val();
    if (!username || !password ) {
        $('#fout').text('Niet alle velden zijn ingevuld!').removeClass('alert-danger').addClass('alert alert-primary'); // Voeg tekst toe aan het element met id 'fout'
    
    } else {
        $.ajax({
            url: './inc/signup.php',
            method: 'POST',
            data: {
                username,
                password,
            },
            dataType: 'json',
            success: function() {
            
            }
        })
    }

    console.log(username);
    console.log(password);
}