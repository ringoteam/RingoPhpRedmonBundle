// Récupère le div qui contient la collection de tags
var collectionHolder = $('ul.databases');

var $addDbLink = $('.add_database_link');
var $db = $('<span class="db">Database n° <span class="number"></span></span>');

jQuery(document).ready(function() {
    $addDbLink.on('click', function(e) {
        e.preventDefault();

        addDbForm(collectionHolder, $db);
        majDB(collectionHolder, $db);
    });

    collectionHolder.find('li').each(function() {
        addDbFormDeleteLink(collectionHolder, $(this), $db);

    });

    $('.del_database').click(function(e){
        e.preventDefault();
        collectionHolder.children().remove();
        majDB(collectionHolder, $db);
    });

    majDB(collectionHolder, $db);
});

function addDbForm(collectionHolder, $db) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li></li>').append(newForm);
    addDbFormDeleteLink(collectionHolder, $newFormLi, $db);
    collectionHolder.append($newFormLi);

}

function majDB(collectionHolder, $db) {

    $('.db').remove();
    collectionHolder.children().each(function(index) {
        var $clone = $db.clone(true);
        $clone.find('.number').text(index);
        $(this).find('div:first').before($clone);
    });

    if(collectionHolder.children().length == 0) {
        $('.del_database').hide();
    }else {
        $('.del_database').show();
    }

}

function addDbFormDeleteLink(collectionHolder, $dbFormLi, $db) {
    var $removeFormA = $('<a class="pull-right del" href="#"><img  width="10" src="/bundles/ringophpredmon/images/del.png"></a>');
    $dbFormLi.find('div:last').append($removeFormA);

    $removeFormA.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de tag
        $dbFormLi.remove();
        majDB(collectionHolder, $db);
    });
}