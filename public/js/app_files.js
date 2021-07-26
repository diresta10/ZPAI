var $files_group = $("#files_group")
var $token = $("#post_token")

$files_group.change(function ()
{
    var $form = $(this).closest('form')

    var data = {}

    data[$token.attr('name')] = $token.val()
    data[$files_group.attr('name')] = $files_group.val()

    $.post($form.attr('action'), data).then(function (response)
    {
        $("#files_subject").replaceWith(
            $(response).find("#files_subject")
        )
    })
})

function log($msg)
{
    console.log($msg)
}