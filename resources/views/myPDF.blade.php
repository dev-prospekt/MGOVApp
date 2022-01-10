<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>PDF</title>
  </head>
  <style>
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

      body {
        font-family: 'Montserrat', sans-serif !important;
      }
      table, td {
        border: 1px solid #333;
        border-collapse: collapse;
      }
      td {
        text-align: left;
        padding: 5px;
        padding-top: 0px;
        font-size: 14px;
        font-weight: 400;
      }
      .title {
        font-size: 16px;
        font-weight: 700;
        text-align: center;
      }
      .subtitle {
        font-size: 17px;
        font-weight: 600;
      }
      .gray {
        background: lightgray;
        padding: 10px;
        font-weight: 600;
      }
      .italic {
        font-style: italic;
        font-size: 13px;
      }
      .txt {
        font-size: 14px;
      }
  </style>
  <body>

    <p class="title">ZAHTJEV ZA NADOKNADU SREDSTAVA ZA OSNOVNU I PROŠIRENU SKRB ZA ŽIVOTINJE U OPORAVILIŠTU TE USMRĆIVANJE</p>
    
    <div>
      <table style="width:100%">
        <tr>
          <td>Datum podnošenja zahtjeva</td>
          <td>10.01.2022</td>
        </tr>
        <tr>
          <td>Datum izrade izvješća u aplikaciji</td>
          <td>10.01.2022</td>
        </tr>
        <tr>
          <td>Izvješće u aplikaciji izradio/la</td>
          <td>Pero Perić</td>
        </tr>
      </table>
    </div>

    <div>
      <p class="subtitle">Opći podaci</p>

      <table style="width:100%">
        <tr>
          <td>Naziv oporavilišta</td>
          <td>{{ $animalItems->shelter->name }}</td>
        </tr>
        <tr>
          <td>OIB oporavilišta</td>
          <td>{{ $animalItems->shelter->oib }}</td>
        </tr>
        <tr>
          <td>Datum ovlaštenja oporavilišta</td>
          <td>{{ $animalItems->shelter->register_date }}</td>
        </tr>
        <tr>
          <td>Ovlaštena osoba</td>
          <td></td>
        </tr>
        <tr>
          <td>IBAN računa</td>
          <td>{{ $animalItems->shelter->iban }}</td>
        </tr>
        <tr>
          <td>Naziv banke kod koje je otvoren račun</td>
          <td>{{ $animalItems->shelter->bank_name }}</td>
        </tr>
      </table>
    </div>

    <div>
      <p class="subtitle">Izvještajno razdoblje</p>

      <table style="width:100%">
        <tr>
          <td class="gray">Kvartal</td>
          <td class="gray">Označiti</td>
          <td class="gray">Datum izvještajnog razdoblja (od-do)</td>
        </tr>
        <tr>
          <td>I. kvartal</td>
          <td> <input type="checkbox" /> </td>
          <td>10.01.2022</td>
        </tr>
        <tr>
          <td>II. kvartal</td>
          <td> <input type="checkbox" /> </td>
          <td>10.01.2022</td>
        </tr>
        <tr>
          <td>III. kvartal</td>
          <td> <input type="checkbox" /> </td>
          <td>10.01.2022</td>
        </tr>
        <tr>
          <td>IV. kvartal</td>
          <td> <input type="checkbox" /> </td>
          <td>10.01.2022</td>
        </tr>
      </table>
    </div>

    <div>
      <p class="subtitle">Potraživani troškovi za izvještajno razdoblje:</p>

      <table style="width:100%">
        <tr>
          <td>Za strogo zaštićene vrste iz prirode</td>
          <td></td>
        </tr>
        <tr>
          <td>Za oduzete i/ili zaplijenjene jedinke</td>
          <td></td>
        </tr>
        <tr>
          <td>Ukupan broj eutanazija prema paušalu</td>
          <td>
            <div>
              <div>Od toga:</div>
              <div>
                <p style="margin: 0px;"><span>test</span> za strogo zaštićene jedinke</p>
                <p style="margin: 0px;"><span>test</span> za zaplijenjene jedinke</p>
                <p style="margin: 0px;"><span>test</span> za jedinke stranih invazivnih vrsta</p>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Broj eutanazija prema dostavljenim računima</td>
          <td>
            <div>
              <div>Od toga:</div>
              <div>
                <p style="margin: 0px;"><span>test</span> za strogo zaštićene jedinke</p>
                <p style="margin: 0px;"><span>test</span> za zaplijenjene jedinke</p>
                <p style="margin: 0px;"><span>test</span> za jedinke stranih invazivnih vrsta</p>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Ostalo</td>
          <td></td>
        </tr>
        <tr>
          <td>Ukupno*:</td>
          <td></td>
        </tr>
      </table>
    </div>

    <div>
      <p class="txt">
        Svojim potpisom u svojstvu odgovorne osobe u oporavilištu te pod punom 
        materijalnom i kaznenom odgovornošću potvrđujem da su podaci prikazani 
        u ovom Zahtjevu za nadoknadom potpuni, vjerodostojni i pouzdani.
      </p>

      <p class="italic">
        *Detaljni troškovi kao temelj ovog zahtjeva iskazani su u 
        popratnom izvješću generiranom iz elektronske evidencije za 
        oporavilišta, koje je priloženo iz ovaj zahtjev
      </p>
    </div>

    <div>
      <p style="font-weight: bold; float: left;">
        Ime i prezime <br>
        odgovorne osobe
      </p>

      <p style="font-weight: bold; float: right;">
        Vlastoručni potpis odgovorne osobe <br>
        i pečat oporavilišta
      </p>
    </div>


  </body>
</html>