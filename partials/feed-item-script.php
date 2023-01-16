<script>
window.onload = function() {
    //selecionando a class like-btn
    document.querySelectorAll('.like-btn').forEach(item=>{
        item.addEventListener('click', ()=>{
            //pegando o primeiro item de feed
            let id = item.closest('.feed-item').getAttribute('data-id');
            let count = parseInt(item.innerText);
            //verificando se tem a class on dentro do botao like, se nao ele add
            if(item.classList.contains('on') === false) {
                item.classList.add('on');
                item.innerText = ++count;
            } else {
                item.classList.remove('on');
                item.innerText = --count;
            }

            fetch('ajax_like.php?id='+id);
        });
    });

};

</script>