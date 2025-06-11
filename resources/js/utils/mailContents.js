if(window.location.pathname.includes('mailContents')) {
    var containerListe = document.getElementById('containerListe');
    var containerForm = document.getElementById('containerForm');
    var btnListe = document.getElementById('btnListe');
    var btnForm = document.getElementById('btnForm');

    containerListe.style.display = 'block';
    containerForm.style.display = 'none';

    btnListe.addEventListener('click', function() {
        containerListe.style.display = 'block';
        containerForm.style.display = 'none';
    });

    btnForm.addEventListener('click', function() {
        containerListe.style.display = 'none';
        containerForm.style.display = 'block';
    });

}
