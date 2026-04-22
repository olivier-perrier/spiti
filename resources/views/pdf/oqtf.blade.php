<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>OQTF</title>
</head>

<body>

    <div style="padding: 3rem">

        <div>
            <img style="width: 10rem"
                src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo-full.png'))) }}">
        </div>

        <p>{{ $user->name }} <br>
            {{ $beneficiary->birth_city }}<br>
            <b>Greffe du tribunale administratif de Montpellier</b><br>
            Montpellier, le {{ $date }}<br>
            Lettre recommandée AR<br>
        </p>

        <h3 style="margin-top: 1rem">
            <b>Objet : recours contentieux contre une obligation de quitter le territoire</b>
        </h3>

        <div style="margin-top: 1rem">

            <p>Madame, Monsieur,</p>

            <p>Je soussigné(e) Monsieur {{ $user->name }}, né(e) le {{ $beneficiary->birthday }} à
                {{ $beneficiary->birth_city }}, par la présente, forme auprès
                de votre juridiction un recours contentieux contre une
                décision préfectorale m'enjoignant de quitter le territoire
                français. Cette décision fut prise par la préfecture de {{ $beneficiary->birth_city }} en date du
                {{ $date }}
                et me fut notifiée le {{ $oqtf->date_notification_48h }}.
            </p>

            @if ($oqtf->date_notification_48h)
                <p>Or, je m'oppose à
                    cette obligation de quitter le territoire avec un délai de départ fixé au
                    <b>{{ $oqtf->date_notification_48h }}</b>
                    puisque
                    <b>{{ $oqtf->decision_TA }}</b>.
                </p>
            @else
                <p>Or, je m'oppose à cette obligation de quitter le territoire sans délai de départ puisque
                    <b>{{ $oqtf->decision_TA }}</b>.
                </p>
            @endif

            <p>En vous remerciant de l'attention que vous porterez à ma demande, je vous
                prie d'agréer, Madame, Monsieur, l'expression de mes salutations
                distinguées.</p>

            <div style="margin-top: 5rem">
                <img style="width: 10rem; margin-left: auto; display: block; margin-right: 5rem;"
                    src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/signature.png'))) }}">
            </div>
        </div>

    </div>

</body>

</html>
