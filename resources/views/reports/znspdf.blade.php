<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZAHTJEV ZA NADOKNADU SREDSTAVA ZA OSNOVNU I PROŠIRENU SKRB ZA
      ŽIVOTINJE U OPORAVILIŠTU TE USMRĆIVANJE</title>

    <style>
      body {
        font-family: DejaVu Sans, sans-serif !important;
        font-size: 12px !important;
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
        font-size: 16px !important;
        font-weight: 700 !important;
        text-align: center;
      }
      .subtitle {
        font-size: 15px !important;
        font-weight: 700 !important;
        text-align: left;
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
      .underline {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>

    <p class="title">ZAHTJEV ZA NADOKNADU SREDSTAVA ZA OSNOVNU I PROŠIRENU SKRB ZA ŽIVOTINJE U OPORAVILIŠTU TE USMRĆIVANJE</p>

    <div>
      <table style="width:100%">
        <tr>
          <td>Datum podnošenja zahtjeva</td>
          <td>{{ $nowDate }}</td>
        </tr>
        <tr>
          <td>Datum izrade izvješća u aplikaciji</td>
          <td>{{ $nowDate }}</td>
        </tr>
        <tr>
          <td>Izvješće u aplikaciji izradio/la</td>
          <td>{{ $username }}</td>
        </tr>
      </table>
    </div>

    <div>
      <p class="subtitle">Opći podaci</p>

      <table style="width:100%">
        <tr>
          <td>Naziv oporavilišta</td>
          <td>{{ $shelter->name }}</td>
        </tr>
        <tr>
          <td>OIB oporavilišta</td>
          <td>{{ $shelter->oib }}</td>
        </tr>
        <tr>
          <td>Datum ovlaštenja oporavilišta</td>
          <td>{{ $shelter->register_date }}</td>
        </tr>
        <tr>
          <td>Ovlaštena osoba</td>
          <td></td>
        </tr>
        <tr>
          <td>IBAN računa</td>
          <td>{{ $shelter->iban }}</td>
        </tr>
        <tr>
          <td>Naziv banke kod koje je otvoren račun</td>
          <td>{{ $shelter->bank_name }}</td>
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
          <td> <input type="checkbox" {{ $kvartal['kvartal'] == 1 ? 'checked' : '' }}  /> </td>
          <td>
            1.1.{{$year}}. - 31.3.{{$year}}.
            {{-- @if ($kvartal['kvartal'] == 1)
              {{ $kvartal['date']['startDate'] . ' - ' . $kvartal['date']['endDate'] }}
            @endif --}}
          </td>
        </tr>
        <tr>
          <td>II. kvartal</td>
          <td> <input type="checkbox" {{ $kvartal['kvartal'] == 2 ? 'checked' : '' }}  /> </td>
          <td>
            1.4.{{$year}}. - 30.6.{{$year}}.
            {{-- @if ($kvartal['kvartal'] == 2)
              {{ $kvartal['date']['startDate'] . ' - ' . $kvartal['date']['endDate'] }}
            @endif --}}
          </td>
        </tr>
        <tr>
          <td>III. kvartal</td>
          <td> <input type="checkbox" {{ $kvartal['kvartal'] == 3 ? 'checked' : '' }}  /> </td>
          <td>
            1.7.{{$year}}. - 30.9.{{$year}}.
            {{-- @if ($kvartal['kvartal'] == 3)
              {{ $kvartal['date']['startDate'] . ' - ' . $kvartal['date']['endDate'] }}
            @endif --}}
          </td>
        </tr>
        <tr>
          <td>IV. kvartal</td>
          <td> <input type="checkbox" {{ $kvartal['kvartal'] == 4 ? 'checked' : '' }} /> </td>
          <td>
            1.10.{{$year}}. - 31.12.{{$year}}.
            {{-- @if ($kvartal['kvartal'] == 4)
              {{ $kvartal['date']['startDate'] . ' - ' . $kvartal['date']['endDate'] }}
            @endif --}}
          </td>
        </tr>
      </table>
    </div>

    <div>
      <p class="subtitle">Potraživani troškovi za izvještajno razdoblje:</p>

      <table style="width:100%">
        <tr>
          <td>Za strogo zaštićene vrste iz prirode</td>
          <td>{{ $SZJTotalPrice . 'kn' }}</td>
        </tr>
        <tr>
          <td>Za oduzete i/ili zaplijenjene jedinke</td>
          <td>{{ $seizedTotalPrice . 'kn' }}</td>
        </tr>
        <tr>
          <td>Ukupan broj eutanazija prema paušalu</td>
          <td>
            <div>
              <div>Od toga:</div>
              <div style="margin-left: 60px;">
                <p style="margin: 0px;"><span class="underline">{{ $priceVetSZJ . 'kn' }}</span> za strogo zaštićene jedinke</p>
                <p style="margin: 0px;"><span class="underline">{{ $priceVetZJ . 'kn' }}</span> za zaplijenjene jedinke</p>
                <p style="margin: 0px;"><span class="underline">{{ $priceVetIJ . 'kn' }}</span> za jedinke stranih invazivnih vrsta</p>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Broj eutanazija prema dostavljenim računima</td>
          <td>
            <div>
              <div>Od toga:</div>
              <div style="margin-left: 60px;">
                <p style="margin: 0px;"><span class="underline">{{ $priceVetOutSZJ . 'kn' }}</span> za strogo zaštićene jedinke</p>
                <p style="margin: 0px;"><span class="underline">{{ $priceVetOutZJ . 'kn' }}</span> za zaplijenjene jedinke</p>
                <p style="margin: 0px;"><span class="underline">{{ $priceVetOutIJ . 'kn' }}</span> za jedinke stranih invazivnih vrsta</p>
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
          <td>{{ $totalPrice .'kn' }}</td>
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
