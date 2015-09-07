$(document).ready(function () {
    $('.modalButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});

// serialize form, render response and close modal
function submitForm($form, id) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function (result) {
            console.log('id : ' + id);
            $("#"+id).html(result);
            $('#modal').modal('hide');
        })
        .fail(function () {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut()
        });
    return false;
}

function submitFormMoreTime($form) {
    $.get(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function (result) {
            $('#modal').modal('show')
                .find('#modalContent').html(result);
        })
        .fail(function () {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut()
        });
    return false;
}

function submitFormMoreTimePost($form) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function (result) {
            $('#modal').modal('show')
                .find('#modalContent').html(result);
        })
        .fail(function () {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut()
        });
    return false;
}