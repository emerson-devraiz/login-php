var submetido = false;

$("button[type='submit']").click(function () {

    let validar = true;
    let msg = '';

    if (!submetido) {

        $("*[obrigatorio='true']").each(function (indice, elemento) {

            //console.log();

            if (elemento.value === '') {

                msg = '<span>O campo <b>' + elemento.getAttribute('nome-validar') + '</b> não pode ser vazio!</span>';
                validar = false;

                if (elemento.getAttribute('type') === 'hidden') {
                    document.getElementById(elemento.getAttribute('id-campo')).focus();
                }
                else {
                    elemento.focus();
                }

                return false;

            }

            /****** CNPJ INVÁLIDO *******/

            if ($(elemento).hasClass('cnpj')) {

                let invalido = 'N';
                let msgCnpj = '<span>O <b>CNPJ</b> digitado é inválido!</span>';
                let numeros, digitos, soma, icnpj, resultado, pos, tamanho, digitos_iguais;
                let cnpj = elemento.value;
                cnpj = cnpj.trim();
                cnpj = cnpj.replace('.', '');
                cnpj = cnpj.replace('.', '');
                cnpj = cnpj.replace('/', '');
                cnpj = cnpj.replace('-', '');

                if (cnpj.length != 14) {

                    msg = msgCnpj;
                    validar = false;
                    elemento.focus();
                    return false;

                }

                if (!digitosIguais(cnpj)) {

                    tamanho = cnpj.length - 2
                    numeros = cnpj.substring(0, tamanho);
                    digitos = cnpj.substring(tamanho);
                    soma = 0;
                    pos = tamanho - 7;

                    for (let icnpj = tamanho; icnpj >= 1; icnpj--) {

                        soma += numeros.charAt(tamanho - icnpj) * pos--;

                        if (pos < 2) {
                            pos = 9;
                        }
                    }

                    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

                    if (resultado != digitos.charAt(0)) {

                        msg = msgCnpj;
                        validar = false;
                        elemento.focus();
                        return false;
                    }

                    tamanho = tamanho + 1;
                    numeros = cnpj.substring(0, tamanho);
                    soma = 0;
                    pos = tamanho - 7;

                    for (let icnpj = tamanho; icnpj >= 1; icnpj--) {

                        soma += numeros.charAt(tamanho - icnpj) * pos--;
                        if (pos < 2) {
                            pos = 9;
                        }

                    }

                    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

                    if (resultado != digitos.charAt(1)) {

                        msg = msgCnpj;
                        validar = false;
                        elemento.focus();
                        return false;
                    }

                } else {

                    msg = msgCnpj;
                    validar = false;
                    elemento.focus();
                    return false;
                }
            }

            /****** CNPJ INVÁLIDO *******/

            /****** CPF INVÁLIDO *******/

            if ($(elemento).hasClass('cpf')) {

                let msgCpf = '<span>O <b>CPF</b> digitado é inválido!</span>';
                let posicao, icpf, soma, dv, dv_informado;
                let digito = new Array(10);

                let cpf = elemento.value;
                cpf = cpf.trim();
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('-', '');

                if (!digitosIguais(cpf)) {

                    dv_informado = cpf.substr(9, 2);

                    for (icpf = 0; icpf <= 8; icpf++) {

                        digito[icpf] = cpf.substr(icpf, 1);
                    }

                    posicao = 10;
                    soma = 0;

                    for (icpf = 0; icpf <= 8; icpf++) {

                        soma = soma + digito[icpf] * posicao;
                        posicao = posicao - 1;
                    }

                    digito[9] = soma % 11;

                    if (digito[9] < 2) {

                        digito[9] = 0;
                    } else {

                        digito[9] = 11 - digito[9];
                    }

                    posicao = 11;
                    soma = 0;

                    for (icpf = 0; icpf <= 9; icpf++) {

                        soma = soma + digito[icpf] * posicao;
                        posicao = posicao - 1;
                    }

                    digito[10] = soma % 11;

                    if (digito[10] < 2) {

                        digito[10] = 0;
                    } else {

                        digito[10] = 11 - digito[10];
                    }

                    dv = digito[9] * 10 + digito[10];

                    if (dv != dv_informado) {

                        msg = msgCpf;
                        validar = false;
                        elemento.focus();
                        return false;
                    }
                } else {
                    msg = msgCpf;
                    validar = false;
                    elemento.focus();
                    return false;
                }
            }

            /****** CPF INVÁLIDO *******/

            /****** E-MAIL INVÁLIDO *******/

            if ($(elemento).hasClass('email')) {

                let msgEmail = '<span>O <b>E-mail</b> digitado é inválido!</span>';
                let parte1 = elemento.value.indexOf("@");
                let parte2 = elemento.value.indexOf(".");
                let parte3 = elemento.value.length;

                if (!(parte1 >= 0 && parte2 >= 1 && parte3 >= 7)) {

                    msg = msgEmail;
                    validar = false;
                    elemento.focus();
                    return false;
                }
            }

            /****** E-MAIL INVÁLIDO *******/

        });

        if ($(this).attr('validar') === 'true') {

            if ($(this).attr('tipo') === 'checkbox') {

                let qtd = $(this).attr('qtd');
                let campo = $(this).attr('campo');
                let selecionou = 'N';

                for (let i = 1; i <= qtd; i++) {

                    if (document.getElementById(campo + i).checked) {

                        selecionou = 'S';
                        break;
                    }
                }

                if (selecionou === 'N') {

                    // Msg padrão
                    msg = 'Selecione ao menos um campo para prosseguir!';

                    if ($(this).attr('msg') != undefined && $(this).attr('msg') != '') {
                        msg = $(this).attr('msg');
                    }

                    validar = false;
                }
            }
        }

        if (!validar) {

            Materialize.toast(msg, 4000, 'rounded red');
            return false;

        } else {

            submetido = true;

            if ($(this).attr('preloader')) {

                $(this).find('i').addClass('hide');
                $(this).find('span').addClass('hide');
                $(this).find('.preloader-wrapper').removeClass('hide');
                $(this).find('.preloader-wrapper').addClass('active');
            } else {
                this.innerHTML = 'Aguarde...';
            }

            return true;
        }

    } else {

        return false;
    }

});

$(".numero").keypress(function (event) {

    let tecla = Number(event.which);

    if (tecla > 47 && tecla < 58) {
        return true;
    } else {
        return false;
    }

});

