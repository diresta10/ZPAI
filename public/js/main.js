const articles = document.getElementById('articles');

if(articles)
{
    articles.addEventListener('click', e=> {
        if(e.target.className === 'delete-article')
        {
            if(confirm('Czy na pewno chce usunąć ogłoszenie?')){
                const id = e.target.getAttribute('data-id');

                fetch(`/teacherHomepage/mynotice/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}