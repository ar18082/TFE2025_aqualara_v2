<!DOCTYPE html>
<html lang="nd">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aquatel | Formulaire</title>
        <style>
            header {
                display: flex;
                flex-direction: row;
                gap: 2rem;
                font-size: 12px;
                justify-content: center;
            }

            header h1 {
                position: absolute;
                margin-left: 1.5%;
                margin-top: 0.5%;
                color: white;
                font-size: 20px;
            }

            h2 {
                color: white;
                font-size: 16px;
                text-align: center;
            }

            .aquatel{
                width: 5%;

            }
            .blue_banner{
                width: 36%;
            }
            /*.blue_banner, .aquatel {*/
            /*    width: 50%;*/
            /*    height: auto;*/
            /*}*/

            /*img{*/
            /*    width: 20%;*/
            /*}*/

            .threeboxes {
                display: flex;
                flex-direction: row;
                gap: 0.5rem;

            }

            .box {
                display: flex;
                flex-direction: column;
                width: 250px;
                height: auto;
                border: 1px solid #1f3868;
                padding: 0;
            }

            .box p {
                margin-left: 3%;
            }

            .title {
                background-color: #1f3868;
                width: 250px;
                height: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            main {
                font-size: 12px;
                color: #1f3868;
            }

            .title_table {
                background-color: #1f3868;
                width: 771px;
                height: 20px;
            }

            table {
                border: 1px solid #1f3868;
                width: 771px;

            }

            th, td {
                text-align: center;
                border-left: 1px solid #1f3868;
            }

            table td:nth-child(1) {
                width: 400px;
                text-align: left;
            }

            table td:nth-child(4) {
                width: 150px;
            }

            table td:nth-child(1) {
                border: none;
            }

            table th:nth-child(1) {
                border: none;
            }

            h3 {
                font-size: 16px;
                font-weight: bold;
                color: #1f3868;
            }

            .row_with_case div {
                width: 10px;
                height: 10px;
                background-color: white;
                border: 1px solid #1f3868;
            }

            .row_with_case .rectangle {
                border: 1px solid #1f3868;
                background-color: white;
                height: 15px;
                width: 100px;
            }

            .row_with_case {
                display: flex;
                flex-direction: row;
                gap: 0.5rem;
                align-items: center;
            }

            .row_with_case2 .rectangle {
                border: 1px solid #1f3868;
                background-color: white;
                height: 15px;
                width: 100px;
            }

            .row_with_case2 {
                display: flex;
                flex-direction: row;
                gap: 0.5rem;
                align-items: center;
                margin-left: 24%;
            }

            .down_box {
                width: 771px;
                height: auto;
                display: flex;
                flex-direction: column;
                border: 1px solid #1f3868;
            }

            .down_title {
                width: 771px;
                height: 20px;
                background-color: #1f3868;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .down_whitezone_header {
                display: flex;
                flex-direction: row;
                justify-content: center;
                gap: 1.5rem;
            }

            .down_whitezone_header_left {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 10px;
            }

            .down_whitezone_header_left div {
                height: 15px;
                width: 100px;
                border: 1px solid #1f3868;
            }

            .down_whitezone_header_right {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 10px;
            }

            .down_whitezone_header_right div {
                height: 15px;
                width: 100px;
                border: 1px solid #1f3868;
            }

            .down_whitezone_body h3 {
                text-align: center;
            }

            .down_whitezone_body_text_up {
                display: flex;
                flex-direction: row;
                justify-content: center;
                gap: 0.5rem;
                align-items: center;
            }

            .down_whitezone_body_text_up div {
                width: 10px;
                height: 10px;
                border: 1px solid #1f3868;
            }

            .down_whitezone_body_text_down {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
                margin-left: 20.9%;
            }

            .down_whitezone_body_text_foot {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
            }

            .down_whitezone_body_text_down div {
                width: 10px;
                height: 10px;
                border: 1px solid #1f3868;
            }

            .second_down_whitezone_header {
                display: flex;
                flex-direction: row;
                gap: 2rem;
                justify-content: center;
            }

            .libelle {
                display: flex;
                flex-direction: row;
            }

            .second_down_whitezone_body {
                display: flex;
                flex-direction: row;
                gap: 2rem;
                justify-content: left;
                align-items: center;
            }

            .second_down_whitezone_body_libelle {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 0.5rem;
                margin-left: 1%;
            }

            .second_down_whitezone_body_libelle div {
                width: 10px;
                height: 10px;
                border: 1px solid #1f3868;
            }

            .second_down_whitezone_foot {
                margin-left: 1%;
            }

            .footer_infos {
                display: flex;
                flex-direction: row;
                gap: 1rem;
                width: 400px;
            }

            .foot {
                display: flex;
                flex-direction: row;
                gap: 3rem;
                align-items: center;
            }

            #line {
                padding-left: 3.5%;
                flex-grow: 1;
            }

            footer {
                font-size: 12px;
            }

        </style>
    </head>
    <body>
        <header>
            <div>
                <h1>Formulier voor de verdeling van de stookkosten</h1>
                <img alt="second logo of the company" class="blue_banner" src="{{asset('img/ruban_header.png')}}">
                <img alt="logo of the company" class="aquatel" src="{{asset('img/logo_rond.PNG')}}">
            </div>
        </header>
        <main>
            <section class="threeboxes">
                <div class="box">
                    <div class="title">
                        <h2>Beheeradres</h2>
                    </div>
                    <div class="whitezone">
                        <p>Naam Voornaam : {{$event->client->gerant}} </p>
                        <p>Adres :{{$event->client->rueger}}</p>
                        <p>Plaats : {{$event->client->codepostger . ' ' . $localiteGer}} </p>
                    </div>
                </div>
                <div class="box">
                    <div class="title">
                        <h2>Verwarmingsperiode</h2>
                    </div>
                    <div class="whitezone">
                        <p>van :</p>
                        <p>tot :</p>
                    </div>
                </div>
                <div class="box">
                    <div class="title">
                        <h2>Gebouw</h2>
                    </div>
                    <div class="whitezone">
                        <p>Naam : {{$event->client->nom}} </p>
                        <p>Klantcode : {{$event->client->Codecli}} </p>
                        <p>Adres :{{$event->client->rue}}</p>
                        <p>Plaats : {{$event->client->codepost . ' ' . $localite}}</p>
                    </div>
                </div>
            </section>
            <section class="table">
                <div class="title_table">
                    <h2>Verwarmingskosten</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Hoeveelheid</th>
                            <th>Eenheidsprijs</th>
                            <th>€</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1. Brandstofvoorraad aan het begin van de verwarmingsperiode (indien stookolie)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2. Aankoop van brandstof (stookolie/gas)</td>
                            <td>/</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3. Onderhoudskosten (ketel, brander)</td>
                            <td>/</td>
                            <td>/</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4. Elektriciteitskosten ketel</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5. Af te trekken: Brandstofvoorraad aan het einde van de verwarmingsperiode (indien stookolie)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>6. Totale kosten te verdelen</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <div class="repartition">
                <h3>Verdelingsmethode</h3>
                <div class="row_with_case">
                    <div></div>
                    <p>Alleen volgens eenheden (niet aanbevolen, omdat het geen rekening houdt met gemeenschappelijke warmteverliezen) OF</p>
                </div>
                <div class="row_with_case">
                    <div></div>
                    <p>Door een deel als vaste kosten van het totaal (6. hierboven) af te trekken: ofwel in de vorm van een percentage</p>
                    <div class="rectangle"></div>
                </div>
                <div class="row_with_case2">
                    <p>of in de vorm van een bedrag</p>
                    <div class="rectangle"></div>
                </div>
            </div>
            <section class="downboxes">
                <div class="down_box">
                    <div class="down_title">
                        <h2>Beheeradres</h2>
                    </div>
                    <div class="down_whitezone">
                        <div class="down_whitezone_header">
                            <div class="down_whitezone_header_left">
                                <p>Bedrag koud water volgens factuur:</p>
                                <div></div>
                            </div>
                            <div class="down_whitezone_header_right">
                                <p>OF: Eenheidsprijs 1 HL koud water toe te passen:</p>
                                <div></div>
                            </div>
                        </div>
                        <div class="down_whitezone_body">
                            <h3>Waterverwarming</h3>
                            <div class="down_whitezone_body_text_up">
                                <p>Als enkele ketel voor verwarming en warm water:</p>
                                <div></div>
                                <p>Eenheidsprijs voor het verwarmen van 1HL water toe te passen</p>
                                <p>____________________</p>
                            </div>
                            <div class="down_whitezone_body_text_down">
                                <div></div>
                                <p>OF: Forfaitaire voorstel meestal toegepast door Aquatel</p>
                            </div>
                            <div class="down_whitezone_body_text_foot">
                                <p>OF: Forfaitaire voorstel meestal toegepast door Aquatel</p>
                                <p>(waarde van 1 HL warm water = +- 1HL koud water + kosten van 1,5 m3 gas of stookolie)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="down_box">
                    <div class="down_title">
                        <h2>Diverse kosten</h2>
                    </div>
                    <div class="down_whitezone">
                        <div class="second_down_whitezone_header">
                            <div class="libelle">
                                <p>Rubrieksomschrijving:</p>
                                <p>______________________________</p>
                            </div>
                            <div class="libelle">
                                <p>Te verdelen bedrag:</p>
                                <p>______________________________</p>
                            </div>
                        </div>
                        <div class="second_down_whitezone_body">
                            <div class="second_down_whitezone_body_libelle">
                                <p>Deze kosten worden verdeeld onder de bewoners:</p>
                            </div>
                            <div class="second_down_whitezone_body_libelle">
                                <div></div>
                                <p>volgens QUOTITIES*</p>
                            </div>
                            <p>OF</p>
                            <div class="second_down_whitezone_body_libelle">
                                <div></div>
                                <p>volgens GELIJKE DELEN</p>
                            </div>
                        </div>
                        <div class="second_down_whitezone_foot">
                            <p>Als er meerdere rubrieken zijn, vermeld deze dan op een apart blad <br/>
                                * te communiceren op de achterkant</p>
                        </div>
                    </div>
                </div>
            </section>
            <footer>
                <div class="foot">
                    <div class="footer_infos">
                        <p>datum:</p>
                        <p id="line">______________________________________________________</p>
                    </div>
                    <p>Handtekening:</p>
                </div>
                <div class="footer_infos">
                    <p>E-Mail:</p>
                    <p>______________________________________________________</p>
                </div>
            </footer>
        </main>
    </body>
</html>
