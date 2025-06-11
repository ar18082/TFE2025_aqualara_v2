<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> Bon de route </title>

        <style>
            body {
                width: 90%;
            }

            .header-container {
                display: grid;
                grid-template-columns: auto 1fr;
                padding: 10px 20px;
            }

            .header-title {
                color: #fff;
                background-color: #023062;
                margin-left: 20px;
                grid-column: 1/4;
            }

            .header-title h2 {
                margin-left: 2rem;
            }

            .header-logo {
                margin-top: 1rem;
                grid-column: 4;
            }

            .header-logo img {
                max-width: 120px;
            }

            .client {
                float: left;
                width: 50%;
                padding: 0 15px;
                margin: 2rem 0 0 3rem;
            }

            .container {

                width: 100%;

                display: grid;
                grid-template-columns: auto 1fr;
                gap: 3rem;

            }
            .personneContact{
                grid-column: 1/2;
                width: 100%;
                margin: 0 3rem 3rem;
                padding: 4rem 4rem 0 4rem;
            }

            .infoPratique {
                grid-column: 2/3;
                width: 50%;
                margin: 0 3rem 3rem;
                padding: 4rem 4rem 0 4rem;
            }

            .commentaire{
                grid-column: 1/3;
                grid-row: 2;
                width: 100%;
                margin: 0 0 0 4rem;

            }

            #commentaire{
                width: 80%;
                height: 10rem;


            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            input[type="text"] {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
                box-sizing: border-box;
            }



            @media print {
                body {
                    width: 90%;
                }

                .header-container {
                    display: grid;
                    grid-template-columns: auto 1fr;
                    padding: 10px 20px;
                }

                .header-title {
                    color: #fff;
                    background-color: #023062;
                    margin-left: 20px;
                    grid-column: 1/4;
                }

                .header-title h2 {
                    margin-left: 2rem;
                }

                .header-logo {
                    margin-top: 1rem;
                    grid-column: 4;
                }

                .header-logo img {
                    max-width: 120px;
                }

                .client {
                    float: left;
                    width: 50%;
                    padding: 0 15px;
                    margin: 2rem 0 0 3rem;
                }

                .container {

                    width: 100%;

                    display: grid;
                    grid-template-columns: auto 1fr;
                    gap: 3rem;

                }
                .personneContact{
                    grid-column: 1/2;
                    width: 100%;
                    margin: 0 3rem 3rem;
                    padding: 4rem 4rem 0 4rem;
                }

                .infoPratique {
                    grid-column: 2/3;
                    width: 50%;
                    margin: 0 3rem 3rem;
                    padding: 4rem 4rem 0 4rem;
                }

                .commentaire{
                    grid-column: 1/3;
                    grid-row: 2;
                    width: 100%;
                    margin: 0 0 0 4rem;

                }

                #commentaire{
                    width: 80%;
                    height: 10rem;


                }

                label {
                    display: block;
                    margin-bottom: 5px;
                }

                input[type="text"] {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 10px;
                    box-sizing: border-box;
                }
            }
        </style>

    </head>
    <body>
        <header>
            <div class="header-container">
                <div class="header-title">
                    <h2>Formulaire Appartements</h2>
                </div>
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ public_path('img/logo.png') }}" alt="Aquatel" height="auto" width="120"/>
                    </a>
                </div>
            </div>
        </header>
        <main>
            <div class="client">
                <label for="Nom">Nom du batiment :  </label>
                <input type="text" id="Nom" name="Nom" value="{{$client->nom}}">

                <label for="adresse">Adresse : </label>
                <input type="text" id="adresse" name="adresse" value="{{$client->rue}}">

                <label for="numero">Numero : </label>
                <input type="text" id="numero" name="numero" value="">

                <label for="codepost">Code Postal : </label>
                <input type="text" id="codepost" name="codepost" value="{{$client->codepost}}">

                <label for="localite">Localite : </label>
                <input type="text" id="localite" name="localite" value="{{$localite}}">
            </div>
            <div class="container">
                <div class="personneContact">
                    <label for="nbr_Appartement">Nombre d'appartements : </label>
                    <input type="text" id="nbr_Appartement" name="nbr_Appartement">

                    <label for="nbr_Quot">Nombre Quotités : </label>
                    <input type="text" id="nbr_Quot" name="nbr_Quot">

                    <label for="NomProp">Nom propriétaire : </label>
                    <input type="text" id="NomProp" name="NomProp">

                    <label for="NomLoc">Nom locataire : </label>
                    <input type="text" id="NomLoc" name="NomLoc">
                </div>
                <div class="infoPratique">
                    <label for="nbr_radiateur">Nombre Radiateur : </label>
                    <input type="text" id="nbr_radiateur" name="nbr_radiateur">

                    <label for="nbr_ComptEC">Nombre Compteur EC : </label>
                    <input type="text" id="nbr_ComptEC" name="nbr_ComptEC">

                    <label for="nbr_ComptEF">Nombre Compteur EF : </label>
                    <input type="text" id="nbr_ComptEF" name="nbr_ComptEF">

                    <label for="nbr_Int">Nombre d'intégrateur : </label>
                    <input type="text" id="nbr_Int" name="nbr_Int">
                </div>
                <div class="commentaire">
                    <label for="commentaire">Commentaire : </label>
                    <textarea id="commentaire" name="commentaire" ></textarea>
                </div>

            </div>

        </main>

        <footer>
            <img src="{{ public_path('img/footer_aquatel.png') }}" alt="footer_aquatel" height="30" width="200"/>
        </footer>


    </body>
</html>
