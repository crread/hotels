import '../css/administration.scss';
import $ from 'jquery';

var collectionHolder;
var addNewItem = $('<a href="#" class="btn btn-info">Add new item </a>');

$(document).ready(function(){
    $('.linkSectionContent').click(function(){
        $.ajax({
            url: this.attributes.href.nodeValue,
            type: "GET",
            success: function(data){
                $('#content').html(data);
                collectionHolder = $('#exp_list');
                collectionHolder.data('index', collectionHolder.find('.div-room').length);
                collectionHolder.find('.div-room').each(function(){
                    deleteForm($(this));
                });
                collectionHolder.append(addNewItem);
            }
        });
    });
    addNewItem.click(function(e){
        e.preventDefault();
        addForm();
    }); 
});

$(document).on('click', '#submitNewHotel', function() {
    
    let form = new FormData();
    const formCollection = $('.div-room');
    form.append( "hotels_new_form[img]", $('#hotels_new_form_img')[0].files[0] );
    form.append( "hotels_new_form[name]" , $('#hotels_new_form_name').val() );
    form.append( "hotels_new_form[street]" , $('#hotels_new_form_street').val() );
    form.append( "hotels_new_form[country]", $('#hotels_new_form_country').val() );
    form.append( "hotels_new_form[_token]" , $('#hotels_new_form__token').val() );
    let rooms = [];
    formCollection.each( function(index) {
        const newRoom = {};
        newRoom['numberRoom'] = $(`#hotels_new_form_rooms_${index}_numberRoom`).val();
        newRoom['numberBeds'] = $(`#hotels_new_form_rooms_${index}_numberBeds`).val();
        rooms.push(newRoom);
    })
    rooms = JSON.stringify(rooms);
    form.append( "hotels_new_form[rooms]" , formCollection.length > 0 ? rooms : null );

    $.ajax({
        url: $('#createHotelLink').attr('href'),
        type: "POST",
        data: form,
        processData: false,
        contentType: false, 
        success: function(data){
            console.log(data);
        }
    });
});
function addForm(){
    const prototype = collectionHolder.data('prototype');
    const body = $('<div class="div-room"></div>');
    const div = $('<div></div>');
    let index = collectionHolder.data('index');
    let newForm = prototype.replace(/__name__/g, index);
    div.append(newForm);
    body.append(div);
    deleteForm(body);
    addNewItem.before(body);
    collectionHolder.data('index', index + 1);
}
function deleteForm(form){
        const $removeButton = $('<a href="#" class="btn btn-danger removeButton">Remove</a>');
        $removeButton.click(function(e){
            $(e.target).parent($(".div-room")).slideUp(750, function(){
                $(this).remove();
            });
            let index = collectionHolder.data('index');
            collectionHolder.data('index' , index - 1);
        });
        form.append( $removeButton );
}