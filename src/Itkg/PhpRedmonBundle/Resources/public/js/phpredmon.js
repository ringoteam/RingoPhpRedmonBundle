$(document).ready(function(){
    var collectionHolder = $('ul.databases');
    var index =  collectionHolder.find(':input').length;
    if(index > 0) {
        $('.del_database').show();
    }else {
        $('.del_database').hide();
    }
    $('.add_database').click(function(e){
        e.preventDefault();
        var index = collectionHolder.find(':input').length;
        collectionHolder.data('index', index);
        addDatabase(collectionHolder);
       
        $('.del_database').show();
        
    }); 
    
    $('.del_database').click(function(e){
        e.preventDefault();
        $('.del_database').hide();
       
        collectionHolder.children().remove();
    });
});

function addDatabase(collectionHolder) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');
   
    // get the new index
    var index = collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/\__name__/g, index);
    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);
    var li = $('<li></li>').append('Base n° '+index).append(newForm);
    // Display the form in the page in an li, before the "Add a tag" link li
    collectionHolder.append(li);
}