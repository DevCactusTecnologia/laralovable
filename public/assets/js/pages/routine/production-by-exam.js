$('[data-submit-production-exam]').click(function (event) {
    event.preventDefault();

    const alert = $('[data-alert]');
    const dateStart = $('[data-started-at]').val();
    const checkDateStart = Date.parse(dateStart);
    const dateEnd = $('[data-finished-at]').val();
    const checkDateEnd = Date.parse(dateEnd);
    
    if (isNaN(checkDateStart)) {
        return alert
            .css({ display: 'block' })
            .text('A data inicial está inválida ou vazia!')
            .delay(3000)
            .hide('fast');
    }

    if (isNaN(checkDateEnd)) {
        return alert
            .css({ display: 'block' })
            .text('A data final está inválida ou vazia!')
            .delay(3000)
            .hide('fast');
    }

    if (compareDates(dateStart, dateEnd)) {
        return alert
            .css({display: 'block'})
            .text('A data inicial deve ser menor ou igual a data final!')
            .delay(3000)
            .hide('fast');
    }

    if (diffInDays(dateStart, dateEnd) > 60) {
        const diffIDays = diffInDays(dateStart, dateEnd);
        return alert
            .css({display: 'block'})
            .text(`O período informado não deve ser superior a 60 dias. Diferença atual: ${Math.round(diffIDays)} dias`)
            .delay(3000)
            .hide('fast');
    }

    $('[data-container]').css({ display: 'none' });

    $.ajax({
        url: $('[data-form-production-exam]').attr('action'),
        type: 'POST',
        data: {
            date_start: dateStart,
            date_end: dateEnd,
            _token: $('[name="_token"]').val(),
        },
        beforeSend: () => {
            $(this).html(loader());
            $(this).prop('disabled', true);
        },
        success: (response) => {
            response.exams.length <= 0 
                ? $('[data-content]').html(notFound())
                : $('[data-content]').html(getContent(response.exams))
        },
        error: function (response) {
            toastr.error(response.responseJSON.message);
        },
        complete: () => {
            $('[data-container]').css({ display: 'block' });

            $(this).prop('disabled', false);
            $(this).html( 
                `<i class="fa fa-search"></i>
                <span class="ml-2">Buscar</span>`
            );
        },
    }); 
    
});

const compareDates = (dateStart, dateEnd) => {
    const timeStart = new Date(dateStart).getTime();
    const timeEnd = new Date(dateEnd).getTime();

    if (timeStart > timeEnd) {
        return true;
    }

    return false;
};

const diffInDays = (startedAt, finishedAt) => {
    const start = new Date(startedAt);
    const end = new Date(finishedAt);
    const diffInMilliSeconds = end - start;
    
    return  diffInMilliSeconds / (1000 * 60 * 60 * 24);;
};

const loader = () =>
    `<span class="spinner-border spinner-border-sm mr-2" 
        role="status" aria-hidden="true">
    </span>Aguarde...`

const notFound = () =>
    `<tr>
        <td class="text-center p-3" colspan="4">Nenhum resultado encontrado</td>
    </tr>`

const getContent = (exams) => {
    return `
        <div class="px-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" onchange="selectAllExams(this)" id="selectAll">
                <label class="custom-control-label text-dark mb-2" for="selectAll">Marcar todos</label>
            </div>
            <hr class="mt-1 mb-2">
            <div class="d-flex flex-wrap">
                ${exams.reduce((acumulator, exam) => 
                    acumulator + `
                        <div class="col-md-4 custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="exams[]" value="${exam.id}" 
                                id="exam-${exam.id}" onchange="selectExam(this)" data-exams
                            >
                            <label class="custom-control-label mb-1" for="exam-${exam.id}">${exam.name}</label>
                        </div>
                    `
                , '')}
            </div>
        </div>
    `;
}

let examsIds = [];

const selectAllExams = (element) => {
    const exams = document.querySelectorAll('[data-exams]');

    if (!element.checked) {
        examsIds = [];
        let params = examsIds.join('|');
        setUrlPrintProductionExams(params);

        return exams.forEach(exam => {
            exam.checked = false;
        });
    }

    exams.forEach(exam => {
        exam.checked = true;
        examsIds.push(exam.value);
    });

    let params = examsIds.join('|');
    setUrlPrintProductionExams(params);
}

const selectExam = (exam) => {
    if (exam.checked) {
        examsIds.push(exam.value);
        let params = examsIds.join('|');
        setUrlPrintProductionExams(params);
    } else {
        const index = examsIds.indexOf(exam.value);
        examsIds.splice(index, 1);
        let params = examsIds.join('|');
        setUrlPrintProductionExams(params);
    }
}

const setUrlPrintProductionExams = (params) => {
    if (!params) {
        $('[data-print-production-exam]').attr('href', '');
        $('[data-print-production-exam]').addClass('d-none');
        return
    }

    const baseUrl = $('[data-base-url]').val();
    const startedAt = $('[data-started-at]').val();
    const finishedAt = $('[data-finished-at]').val();
    const url = `${baseUrl}/routine/production-by-exam/between/${startedAt}/${finishedAt}/print?exams_ids=${params}`;

    $('[data-print-production-exam]').removeClass('d-none');
    $('[data-print-production-exam]').attr('href', url);
}
