var $subject_group = $("#subject_group")
var $token = $("#post_token")

$subject_group.change(function ()
{
    var $form = $(this).closest('form')

    var data = {}

    data[$token.attr('name')] = $token.val()
    data[$subject_group.attr('name')] = $subject_group.val()

    $.post($form.attr('action'), data).then(function (response)
    {
        $("#subject_subject_name").replaceWith(
            $(response).find("#subject_subject_name")
        )
    })
})

function log($msg)
{
    console.log($msg)
}