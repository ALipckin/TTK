<style type="text/css">
    body {
        font-family: DejaVu Sans;
        font-size: 10px;
    }
    .underline {
        text-decoration: underline;
    }
    .header {
        margin-top: 100px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }
    .title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
    }
    table {
        width: 95%;
        border-collapse: collapse;
        /*margin: 50px auto;*/
        border: 1px solid black;
    }

    tbody {
        /*width: 95%;*/
        border-collapse: collapse;
        /*margin: 50px auto;*/
        border: 1px solid black;
    }

    th {
        /*padding: 10px;*/
        border: 1px solid black;
        text-align: left;
    }
    td{
        /*padding: 10px;*/
        border: 1px solid black;
        text-align: left;
    }
    .tr {
        border: 1px solid black;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTK PDF Download</title>
</head>
<body>
<main>
    <div>
        <div style="float: left; width: 50%; text-align: left;">
            <div>{{$ttk->header->company ?? '- Наименование организации -'}}</div>
            <hr style="border:0.5px solid black; float: left; width: 70%; margin-bottom: 10px; text-align: left;">
            <div style="margin-top: 5px">{{$ttk->header->property ?? '- Наименование организации -'}}</div>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            Утверждаю<br>
            Директор<br>
            <div><span class="underline">{{$ttk->header->approver ?? '__________'}}</span> - ФИО</div>
        </div>
    </div>

    <div class="header">
        Технико-технологическая карта №{{$ttk->header->card}} от {{$ttk->header->created_date}}<br>
        {{$ttk->header->dish}}
    </div>
    <div>
        <div class="title">1. Область применения</div>
        <p>
            @if($ttk->scopes->count() > 0)
                @foreach($ttk->scopes as $scope)
                    {{$scope->description}}<br>
                @endforeach
            @endif
        </p>
    </div>
    <div>
        <div class="title">2. Требования к сырью</div>
        @foreach($ttk->qualityRequirements as $req)
            {{$req->description}}<br>
        @endforeach
    </div>
    <div>
        <div class="title">3. Рецептура</div>
        <div class="row">
            <table class="bg-transparent table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Наименование</th>
                    <th scope="col">Брутто г.</th>
                    <th scope="col">Нетто г.</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ttk->formulations as $i => $formulation)
                    {{$bruttoSumm = 0,
                        $bruttoSumm += $formulation->brutto,
                        $nettoSumm = 0,
                        $nettoSumm += $formulation->netto
                    }}}
                    <tr>
                        <td>
                            {{$formulation->product->name}}
                        </td>
                        <td>
                            {{$formulation->brutto}}
                        </td>
                        <td>
                            {{$formulation->netto}}
                        </td>
                    </tr>
                @endforeach
                <tr class="mb-4">
                    <td class='text-end'>
                        <b>
                            Итого, выход на порцию:
                        </b>
                    </td>
                    <td>
                        <b>
                            {{$bruttoSumm}}
                        </b>
                    </td>
                    <td>
                        <b>
                            {{$nettoSumm}}
                        </b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <div class="title">4. Технологический прогресс</div>
        @foreach($ttk->tps as $tp)
            {{$tp->description}}<br>
        @endforeach
    </div>
    <div>
        <div class="title">5. Требования к оформлению, реализации и хранению
        </div>
        @foreach($ttk->realizationRequirements as $req)
            {{$req->description}}<br>
        @endforeach
    </div>
    <div>
        <div class="title">6. Показатели качества и безопасности <br>
            6.1. Органолептические показатели качества
        </div>
        <div>
            <div class="row">
                <table class="bg-transparent table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Внешний вид</th>
                        <th scope="col">Цвет</th>
                        <th scope="col">Консистенция</th>
                        <th scope="col">Вкус и запах</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{$ttk->orgCharacteristics->view}}
                            </td>
                            <td>
                                {{$ttk->orgCharacteristics->color}}
                            </td>
                            <td>
                                {{$ttk->orgCharacteristics->cons}}
                            </td>
                            <td>
                                {{$ttk->orgCharacteristics->taste}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        <div class="title">6.2. Микробиологические показатели
        </div>
        <p>
            Микробиологические показатели качества блюда (изделия) должны соответствовать требованиям
            Технического регламента Таможенного союза "О безопасности пищевой продукции" ТР ТС 021/2011, или
            гигиеническим нормативам, установленным в соответствии с нормативными правовыми актами или
            нормативными документами, действующими на территории государства, принявшего стандарт.
        </p>
        <table>
            <thead>
            <tr>
                <th colSpan="1" rowSpan="2">КМА-ФАнМ КОЕ/г, не более</th>
                <th colSpan="5">Масса продукта (г), в которой не допускаются:</th>
            </tr>
            <tr>
                <th>БГКП
                    (колиформы)
                </th>
                <th>E/coli</th>
                <th>S.aureus</th>
                <th>Proteus</th>
                <th>Патогенные, в т.ч. сальмонеллы</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$ttk->microbioParams->kma}}</td>
                <td>{{$ttk->microbioParams->bgkp}}</td>
                <td>{{$ttk->microbioParams->ecoli}}</td>
                <td>{{$ttk->microbioParams->saur}}</td>
                <td>{{$ttk->microbioParams->prot}}</td>
                <td>{{$ttk->microbioParams->pato}}</td>
            </tr>
            </tbody>
        </table>
        <p>{{$ttk->microbioParams->rem}}</p>
    </div>
    <div>
        <div class="title">6.3. Нормируемые физико-химические показатели</div>
        <table>
            <thead>
            <tr>
                <th colSpan="2">Массовая доля сухих в-в, %</th>
                <th colSpan="2">Массовая доля жира, %</th>
                <th colSpan="2">Массовая доля, %</th>
            </tr>
            <tr>
                <th>Мин</th>
                <th>Макс</th>
                <th>Мин</th>
                <th>Макс</th>
                <th>Сахара</th>
                <th>Соли</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$ttk->physChemParams['dry']['min']}}</td>
                <td>{{$ttk->physChemParams['dry']['max']}}</td>
                <td>{{$ttk->physChemParams['fat']['min']}}</td>
                <td>{{$ttk->physChemParams['fat']['max']}}</td>
                <td>{{$ttk->physChemParams['sugar']}}</td>
                <td>{{$ttk->physChemParams['salt']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <div class="title">7. Пищевая и энергетическая ценность</div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th rowSpan="2" scope="col">Наименование ингредиента</th>
                <th rowSpan="2" scope="col">Вес нетто, г.</th>
                <th colSpan="5">Содерж. в-в в блюде с учетом потерь, г</th>
            </tr>
            <tr>
                <th scope="col">Белки г.</th>
                <th scope="col">Жиры г.</th>
                <th scope="col">Углев г.</th>
                <th scope="col">ккал</th>
                <th scope="col">кДж г.</th>
            </tr>
            </thead>
            <tbody>
                @foreach($ttk->neValues['ne_values'] as $value)
                <tr>
                    <td>
                        {{$value['elems']['name'] ?? "-"}}
                    </td>
                    <td>
                        {{$value['elems']['netto']}}
                    </td>
                    <td>
                        {{$value['elems']['protein']}}
                    </td>
                    <td>
                        {{$value['elems']['fat']}}
                    </td>
                    <td>
                        {{$value['elems']['carbs']}}
                    </td>
                    <td>
                        {{$value['elems']['kcal']}}
                    </td>
                    <td>
                        {{$value['elems']['kj']}}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="mt-2">
                <tr scope="row" class="mb-4 sum-result">
                    <td>Результат:</td>
                    <td>
                        {{$ttk->neValues['result']['netto']}}
                    </td>
                    <td>
                        {{$ttk->neValues['result']['protein']}}
                    </td>
                    <td>
                        {{$ttk->neValues['result']['fat']}}
                    </td>
                    <td>
                        {{$ttk->neValues['result']['carbs']}}
                    </td>
                    <td>
                        {{$ttk->neValues['result']['kcal']}}
                    </td>
                    <td>
                        {{$ttk->neValues['result']['kj']}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div style="width: 100%; text-align: left; margin-top: 10px">
        <div style="margin: 0 auto; text-align:left">
            Ответственный за оформление ТТК:
            <span class="underline display: inline; float-right" style="margin-right: 50px">{{$ttk->header->dev}}</span>
        </div>
        <div style="margin: 0 auto; text-align:left">
            {{$ttk->header->approver2_position}}:<span class="underline display: inline; float-right" style="margin-right: 50px">{{$ttk->header->approver2}}</span>
        </div>
    </div>
</main>

</body>
</html>
