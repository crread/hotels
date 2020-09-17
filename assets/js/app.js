/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

 require('bootstrap/js/dist/modal');

$(document).ready(function(){
    $('#showModalLogin').click( function(e) {
        $.ajax({
            url: this.href,
            type: "GET",
            success: function(data){
                $('#modalBodyLogin').html(data);
                $('#modalLoginTitle').html("Connexion");
                $('#loginModal').modal("show");
            }
        });
    });
    $('#signupButtonModalSwitch').click( function(e){
        $('#loginModal').modal("hide");
        $.ajax({
            url: this.href,
            type: "GET",
            success: function(data){
                $('#modalBodyLogin').html(data);
                $('#loginButtonModalSwitch').css("display", "block");
                $('#signupButtonModalSend').css("display", "block");
                $('#loginButtonModalSend').css("display", "none");
                $('#signupButtonModalSwitch').css("display", "none");
                $('#modalLoginTitle').html("Inscription");
                $('#loginModal').modal("show");
            }
        });
    });
    $('#loginButtonModalSwitch').click( function(e){
        $('#loginModal').modal("hide");
        $.ajax({
            url: this.href,
            type: "GET",
            success: function(data){
                $('#modalBodyLogin').html(data);
                $('#loginButtonModalSwitch').css("display", "none");
                $('#signupButtonModalSend').css("display", "none");
                $('#loginButtonModalSend').css("display", "block");
                $('#signupButtonModalSwitch').css("display", "block");
                $('#modalLoginTitle').html("Connéxion");
                $('#loginModal').modal("show");
            }
        });
    });
    $('#loginButtonModalSend').click( function(e){

        const form = $('#loginFormModal').serialize();

        console.log(form);

        $.ajax({
            url : this.href,
            type: "POST",
            data: form, 
            success: function(data){
                $('#loginModal').modal("hide");
                window.location.href = data.url;
            }
        })
    });
    $('#signupButtonModalSend').click(function(){
        $.ajax({
            url : this.href,
            type: "POST",
            data: $('#signupFormModal').serialize(),
            success: function(data){
                window.location.href = data.url;
            }
        })
    });
});