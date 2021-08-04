const articles = document.getElementById('myTable');

if(articles)
{
    articles.addEventListener('click', e=> {
        if(e.target.className === 'delete-article')
        {
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');
                const classesId = e.target.getAttribute('data-id2');

                fetch(`/teacherHomepage/finalgrades/${classesId}/${id}/delete`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}