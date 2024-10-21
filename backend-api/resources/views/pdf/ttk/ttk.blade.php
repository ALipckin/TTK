<main>
    <div>
        Технико-технологическая карта №{{$ttk->header->card}}
        {{$ttk->header->dish}}
    </div>
    <div style="text-align: center">
        <h5>
            <h5>1. Область применения</h5>
            Настоящая технико–технологическая карта распространяется на Сандвич с рыбой, сыром и ананасом,
            вырабатываемый ООО «________» и реализуемый в кафе ООО «________» и филиалах... (указать).
        </h5>
    </div>
    <div>
        <h5>2. Требования к сырью</h5>
        Продовольственное сырье, пищевые продукты и полуфабрикаты, используемые для приготовления Сандвича, должны
        соответствовать требованиям действующих нормативных и технических документов, иметь сопроводительные
        документы, подтверждающие их безопасность и качество (сертификат соответствия, санитарно-эпидемиологическое
        заключение, удостоверение безопасности и качества и пр.).
    </div>
    <div>
        <h5>3. Рецептура</h5>
        <div className="row flex-column">
            <table className="bg-transparent">
                <thead>
                <tr>
                    <th scope="col">Наименование</th>
                    <th scope="col">Брутто г.</th>
                    <th scope="col">Нетто г.</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ttk->formulations as $formulation)
                    <tr scope="row" className="mb-4" key={index}>
                        <td>
                            {{$formulation->product_name}}
                        </td>
                        <td>
                            {{$formulation->brutto}}
                        </td>
                        <td>
                            {{$formulation->netto}}
                        </td>
                    </tr>
                @endforeach
                <tr scope="row" className="mb-4">
                    <td className='text-end'>
                        <b>
                            Итого, выход на порцию:
                        </b>
                    </td>
                    <td/>
                    <td>
                        <b>

                        </b>
                    </td>
                    <td>
                        <b>

                        </b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</main>
