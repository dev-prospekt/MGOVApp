<!DOCTYPE html>
<html>
<head>
    <title>PDF - {{ $animalItems->animal->name }}</title>

    <style>
        body {font-family: DejaVu Sans, sans-serif;}
        strong, h2 {color: rgb(0, 0, 0) !important;}
        p {color: rgb(90, 108, 131);}
        .title {text-align: center;}
    </style>
</head>
<body>

    <div class="title">
        <h1>Izvještaj</h1>
    </div>

    <h2>Životinja</h2>

    <p><strong>Naziv:</strong> {{ $animalItems->animal->name }}</p>
    <p><strong>Latinski naziv:</strong> {{ $animalItems->animal->latin_name }}</p>
    <p><strong>Šifra oporavilišta:</strong> {{ $animalItems->shelterCode }}</p>
    <p><strong>Veličina:</strong> {{ $animalItems->animal_size }}</p>
    <p><strong>Spol:</strong> {{ $animalItems->animal_gender }}</p>
    <p><strong>Lokacija:</strong> {{ $animalItems->location }}</p>

    <hr>
    <h2>Dokumenti</h2>

    @if($animalItems->animalItemsFile->isEmpty())
        <p>Trenutno, ne postoji dokument.</p>
    @else
        @foreach ($animalItems->animalItemsFile as $file)
            <div>
                <a target="_blank" href="/storage/{{ str_replace('"', "", $file->filenames) }}">
                    {{ $file->file_name }}
                </a>
            </div>
        @endforeach
    @endif

    <hr>
    <h2>Oporavilište</h2>

    <p><strong>Oporavilište:</strong> {{ $animalItems->shelter->name }}</p>
    <p><strong>Email:</strong> {{ $animalItems->shelter->email }}</p>
    <p><strong>Adresa:</strong> {{ $animalItems->shelter->address }}</p>
    <p><strong>OIB:</strong> {{ $animalItems->shelter->oib }}</p>
    <p><strong>Poštanski broj:</strong> {{ $animalItems->shelter->place_zip }}</p>
    <p><strong>Telefon:</strong> {{ $animalItems->shelter->telephone }}</p>

</body>
</html>