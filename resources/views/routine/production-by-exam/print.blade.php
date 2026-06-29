<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Produção por exame</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Sistema para Laboratórios, Clinicas e Hospitais" />
    <meta name="author" content="Sislac" />
</head>

<body style="font-family: Arial, Helvetica, sans-serif;">

    <div style="display: flex; margin-bottom: 5px; align-items: center;">
        <div style="margin-right: 10px;">
            <img src="{{ asset('assets/images/brasao.png') }}" width="60px" alt="brasão">
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: flex-start;">
            <h5 style="font-size: 14px; font-weight: 700; margin: 1px 0px;">
                PREFEITURA DE COREMAS
            </h5>
            <h5 style="font-size: 14px; font-weight: 700; margin: 1px 0px;">
                SECRETARIA MUNICIPAL DE SAÚDE
            </h5>
            <h5 style="font-size: 14px; font-weight: 700; margin: 1px 0px;">
                LABORATORIO DE ANALISES CLINICAS DE COREMAS
            </h5>
        </div>
    </div>
    <hr>

    <div style="text-align: center; margin-top: 0px; margin-bottom: 15px;">
        PRODUÇÃO DE EXAMES REALIZADA ENTRE 
        <strong>({{ date('d/m/Y', strtotime(request('dateStart'))) }} à {{ date('d/m/Y', strtotime(request('dateEnd'))) }})</strong>
    </div>

    @foreach ($exams as $exam => $registers)
        <h3 style="text-align: center; background-color: #e9e9e9; padding: 5px;">{{ $exam }}</h3>
        <div style="width: 100%; margin-bottom: 20px;">
            <table style="border-collapse: collapse; border: 1px solid #000; width: 100%;">
                <thead>
                    <tr style="background-color: #eff2f7;">
                        <th style="padding: 5px; border: 1px solid #000; text-align: center;">Nº</th>
                        <th style="padding: 5px; border: 1px solid #000;">Nome do paciente</th>
                        <th style="text-align: center; padding: 5px; border: 1px solid #000;">Data e hora</th>
                    </tr>
                </thead>
                <tbody>
                    @php $examTotal = 0; @endphp
                    @foreach ($registers as $register)
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px 4px; text-align: center;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 3px 4px">{{ $register->patient }}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 3px 4px">{{ $register->registered_at }}</td>
                        </tr>
                        @php $examTotal++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</body>

<script>
    window.print()

    if ('matchMedia' in window) {
        window.matchMedia('print').addListener((mediaQueryListEvent) => {
            if (!mediaQueryListEvent.matches) {
                window.close()
            }
        })
    } else {
        window.onafterprint = function () {
            window.close()
        }
    }
</script>

</html>
