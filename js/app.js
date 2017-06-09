/**
 * Created by JWright on 5/25/2017.
 */

// use jQuery for a Delete confirmation pop-up
$('.confirmation').on('click', function(){
    return confirm('Are you sure you want to delete this item?');
});

//check that the passwords are the same
$('.btnRegister').on('click', function(){
    if ($('#password').val() != $('#confirm').val()){
        $('#message').html('Password do not match');
        $('#message').removeClass();
        $('#message').addClass('alert alert-danger');
        return false;
    }
    else
        return true;
});