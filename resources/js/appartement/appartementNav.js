document.addEventListener("DOMContentLoaded", function() {
    if (/^\/immeubles\/\d+\/appartement\/\d+/.test(window.location.pathname)) {
        // buttons
        var btnDetailAppartement = document.getElementById('btnDetailAppartement');
       // var btnRapportApp = document.getElementById('btnRapportApp');
       //  var btnIndexApp = document.getElementById('btnIndexApp');
        var btnNotesCommentaires = document.getElementById('btnNotesCommentaires');
        var btnPiecesJointes = document.getElementById('btnPiecesJointes');
        var btnAppareilAppartement = document.getElementById('btnAppareilAppartement');

        //pages
        var detailApp = document.getElementById('detailApp');
        // var addIndexApp = document.getElementById('addIndexApp');
        var notesAppartement = document.getElementById('notesAppartement');
        var piecesJointesAppartement = document.getElementById('piecesJointesAppartement');
        // var rapportAppartement = document.getElementById('rapportAppartement');
        var showAppareils = document.getElementById('showAppareils');


        // traitement des pages
        detailApp.style.display = 'block';
        showAppareils.style.display = 'none';
        // addIndexApp.style.display = 'none';
        notesAppartement.style.display = 'none';
        piecesJointesAppartement.style.display = 'none';
        // rapportAppartement.style.display = 'none';

        // traitement des boutons
        btnDetailAppartement.style.backgroundColor = '#023c7b';
        btnDetailAppartement.style.color = '#ffff';

        // btnIndexApp.style.backgroundColor = '#fff';
        // btnIndexApp.style.color = 'black';

        btnNotesCommentaires.style.backgroundColor = '#fff';
        btnNotesCommentaires.style.color = 'black';

        btnPiecesJointes.style.backgroundColor = '#fff';
        btnPiecesJointes.style.color = 'black';

        // btnRapportApp.style.backgroundColor = '#fff';
        // btnRapportApp.style.color = 'black';

        btnAppareilAppartement.style.backgroundColor = '#fff';
        btnAppareilAppartement.style.color = 'black';

        btnDetailAppartement.addEventListener('click', function () {
            detailApp.style.display = 'block';
            showAppareils.style.display = 'none';
            // addIndexApp.style.display = 'none';
            notesAppartement.style.display = 'none';
            piecesJointesAppartement.style.display = 'none';
            // rapportAppartement.style.display = 'none';

            btnDetailAppartement.style.backgroundColor = '#023c7b';
            btnDetailAppartement.style.color = '#ffff';

            // btnIndexApp.style.backgroundColor = '#fff';
            // btnIndexApp.style.color = 'black';

            btnNotesCommentaires.style.backgroundColor = '#fff';
            btnNotesCommentaires.style.color = 'black';

            btnPiecesJointes.style.backgroundColor = '#fff';
            btnPiecesJointes.style.color = 'black';

            // btnRapportApp.style.backgroundColor = '#fff';
            // btnRapportApp.style.color = 'black';

            btnAppareilAppartement.style.backgroundColor = '#fff';
            btnAppareilAppartement.style.color = 'black';
        });

        // btnIndexApp.addEventListener('click', function () {
        //     detailApp.style.display = 'none';
        //     showAppareils.style.display = 'none';
        //     addIndexApp.style.display = 'block';
        //     notesAppartement.style.display = 'none';
        //     piecesJointesAppartement.style.display = 'none';
        //     // rapportAppartement.style.display = 'none';
        //
        //     btnDetailAppartement.style.backgroundColor = '#fff';
        //     btnDetailAppartement.style.color = 'black';
        //
        //     btnIndexApp.style.backgroundColor = '#023c7b';
        //     btnIndexApp.style.color = '#ffff';
        //
        //     btnNotesCommentaires.style.backgroundColor = '#fff';
        //     btnNotesCommentaires.style.color = 'black';
        //
        //     btnPiecesJointes.style.backgroundColor = '#fff';
        //     btnPiecesJointes.style.color = 'black';
        //
        //     // btnRapportApp.style.backgroundColor = '#fff';
        //     // btnRapportApp.style.color = 'black';
        //
        //     btnAppareilAppartement.style.backgroundColor = '#fff';
        //     btnAppareilAppartement.style.color = 'black';
        // });

        btnNotesCommentaires.addEventListener('click', function () {
            detailApp.style.display = 'none';
            showAppareils.style.display = 'none';
            // addIndexApp.style.display = 'none';
            notesAppartement.style.display = 'block';
            piecesJointesAppartement.style.display = 'none';
            // rapportAppartement.style.display = 'none';

            btnDetailAppartement.style.backgroundColor = '#fff';
            btnDetailAppartement.style.color = 'black';

            // btnIndexApp.style.backgroundColor = '#fff';
            // btnIndexApp.style.color = 'black';

            btnNotesCommentaires.style.backgroundColor = '#023c7b';
            btnNotesCommentaires.style.color = '#ffff';

            btnPiecesJointes.style.backgroundColor = '#fff';
            btnPiecesJointes.style.color = 'black';

            // btnRapportApp.style.backgroundColor = '#fff';
            // btnRapportApp.style.color = 'black';

            btnAppareilAppartement.style.backgroundColor = '#fff';
            btnAppareilAppartement.style.color = 'black';
        });

        btnPiecesJointes.addEventListener('click', function () {
            detailApp.style.display = 'none';
            showAppareils.style.display = 'none';
            // addIndexApp.style.display = 'none';
            notesAppartement.style.display = 'none';
            piecesJointesAppartement.style.display = 'block';
            // rapportAppartement.style.display = 'none';

            btnDetailAppartement.style.backgroundColor = '#fff';
            btnDetailAppartement.style.color = 'black';

            // btnIndexApp.style.backgroundColor = '#fff';
            // btnIndexApp.style.color = 'black';

            btnNotesCommentaires.style.backgroundColor = '#fff';
            btnNotesCommentaires.style.color = 'black';

            btnPiecesJointes.style.backgroundColor = '#023c7b';
            btnPiecesJointes.style.color = '#ffff';

            // btnRapportApp.style.backgroundColor = '#fff';
            // btnRapportApp.style.color = 'black';

            btnAppareilAppartement.style.backgroundColor = '#fff';
            btnAppareilAppartement.style.color = 'black';
        });

        // btnRapportApp.addEventListener('click', function () {
        //
        //     detailApp.style.display = 'none';
        //     showAppareils.style.display = 'none';
        //     addIndexApp.style.display = 'none';
        //     notesAppartement.style.display = 'none';
        //     piecesJointesAppartement.style.display = 'none';
        //     // rapportAppartement.style.display = 'block';
        //
        //     btnDetailAppartement.style.backgroundColor = '#fff';
        //     btnDetailAppartement.style.color = 'black';
        //
        //     btnIndexApp.style.backgroundColor = '#fff';
        //     btnIndexApp.style.color = 'black';
        //
        //     btnNotesCommentaires.style.backgroundColor = '#fff';
        //     btnNotesCommentaires.style.color = 'black';
        //
        //     btnPiecesJointes.style.backgroundColor = '#fff';
        //     btnPiecesJointes.style.color = 'black';
        //
        //     // btnRapportApp.style.backgroundColor = '#023c7b';
        //     // btnRapportApp.style.color = '#ffff';
        //
        //     btnAppareilAppartement.style.backgroundColor = '#fff';
        //     btnAppareilAppartement.style.color = 'black';
        // });

        btnAppareilAppartement.addEventListener('click', function () {
            detailApp.style.display = 'none';
            showAppareils.style.display = 'block';
            // addIndexApp.style.display = 'none';
            notesAppartement.style.display = 'none';
            piecesJointesAppartement.style.display = 'none';
            // rapportAppartement.style.display = 'none';

            btnDetailAppartement.style.backgroundColor = '#fff';
            btnDetailAppartement.style.color = 'black';

            // btnIndexApp.style.backgroundColor = '#fff';
            // btnIndexApp.style.color = 'black';

            btnNotesCommentaires.style.backgroundColor = '#fff';
            btnNotesCommentaires.style.color = 'black';

            btnPiecesJointes.style.backgroundColor = '#fff';
            btnPiecesJointes.style.color = 'black';

            // btnRapportApp.style.backgroundColor = '#fff';
            // btnRapportApp.style.color = 'black';

            btnAppareilAppartement.style.backgroundColor = '#023c7b';
            btnAppareilAppartement.style.color = '#ffff';
        });


    };








});
