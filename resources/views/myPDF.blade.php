<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>

    <style>
        body {font-family: DejaVu Sans, sans-serif;}
        strong, h2 {color: rgb(0, 0, 0);}
        p {color: rgb(90, 108, 131);}
    </style>
</head>
<body>

    <h2>Izvještaj</h2>

    <div>
        <p><strong>Naziv:</strong> {{ $animalItems->animal->name }}</p>
        <p><strong>Latinski naziv:</strong> {{ $animalItems->animal->latin_name }}</p>
        <p><strong>Šifra oporavilišta:</strong> {{ $animalItems->shelterCode }}</p>
        <p><strong>Veličina:</strong> {{ $animalItems->animal_size }}</p>
        <p><strong>Spol:</strong> {{ $animalItems->animal_gender }}</p>
        <p><strong>Lokacija:</strong> {{ $animalItems->location }}</p>
    </div>

</body>
</html>