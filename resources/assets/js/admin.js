const { isEmpty } = require("lodash");

$(function () {

    /**
     * Função responsável por validar e liberar os botões de Inserção, Alteração e Remoção de acordo com o tipo de requisição. - Contrato
     */
    let inputIdContrato = $("input#id_contrato").val();

    if(inputIdContrato == null || inputIdContrato == '') {
        $("button#btn-incluir-contrato").removeAttr("disabled");
        $("button#btn-alterar-contrato").attr("disabled", "disabled");
        $("button#btn-remover-contrato").attr("disabled", "disabled");


    } else {
        $("button#btn-incluir-contrato").attr("disabled", "disabled");
        $("button#btn-alterar-contrato").removeAttr("disabled");
        $("button#btn-remover-contrato").removeAttr("disabled");
    }

    /**
     * Função responsável por validar e liberar os botões de Inserção, Alteração e Remoção de acordo com o tipo de requisição. - Unidade
     */
    let inputIdUnidade = $("input#id_unidade").val();
    
    if((inputIdContrato != null  || inputIdContrato != '') && (inputIdUnidade != null || inputIdUnidade != '') && inputIdUnidade != undefined  && inputIdUnidade.length > 0) {
        
        $("button#btn-incluir-unidade").attr("disabled", "disabled");
        $("button#btn-alterar-unidade").removeAttr("disabled");
        $("button#btn-remover-unidade").removeAttr("disabled");
    } else {
        
        $("button#btn-incluir-unidade").removeAttr("disabled");
        $("button#btn-alterar-unidade").attr("disabled", "disabled");
        $("button#btn-remover-unidade").attr("disabled", "disabled");
    }



    /**
     * Função responsável por consultar os dados de um contrato a partir de um cnpj
     */
    $('a#btn-search-cnpj').on('click', function() {

        let cnpj = $("input#cnpj").val();
        
        $.ajax({
            url: '/admin/find-parameter/1/' + cnpj,
            headers: {
                Accept: 'application/json'
            },
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                var idContrato = response;
      
                if(idContrato != null || idContrato != '') {

                    window.location.href = "../admin/find/" + idContrato;
                }
               

            },
            error: function(err) {
                console.log('Ocorreu um erro.')
            }
        })
        
    })


    /**
     * Função responsável por consultar os dados de um contrato a partir de uma razão social
     */
    $('a#btn-search-razao_social').on('click', function() {

        let razaoSocial = $("input#razao_social").val();
        
        $.ajax({
            url: '/admin/find-parameter/2/' + razaoSocial,
            headers: {
                Accept: 'application/json'
            },
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                console.log(response);
                var idContrato = response;
      
                if(idContrato != null || idContrato != '') {
                    
                    window.location.href = "../admin/find/" + idContrato;
                }
               

            },
            error: function(err) {
                console.log('Ocorreu um erro.')
            }
        })
        
    })

    /**
     * Função responsável por consultar os dados de um contrato a partir de um nome fantasia
     */
    $('a#btn-search-nome-fantasia').on('click', function() {

        let nome_fantasia = $("input#nome_fantasia").val();
        
        $.ajax({
            url: '/admin/find-parameter/3/' + nome_fantasia,
            headers: {
                Accept: 'application/json'
            },
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                var idContrato = response;
      
                if(idContrato != null || idContrato != '') {
                    
                    window.location.href = "../admin/find/" + idContrato;
                }
               

            },
            error: function(err) {
                console.log('Ocorreu um erro.')
            }
        })
        
    })


    /**
     * Função responsável por carregar um endereço via API- VIACEP. Responsável por popular os campos Municipio e UF
     */
    $('button#btn-search-cep').on('click', function () {

        let searchCep = $("input#cep").val();

        if(searchCep != null) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + searchCep + '/json/',
                headers: {
                    Accept: 'application/json'
                },
                method: 'GET',
                dataType: 'html',
                success: function(response) {

                    var json = JSON.parse(response);
                    
                    $("input#municipio").val(json['localidade']);
                    $("select#uf").val(json['uf']);
                   
    
                },
                error: function(err) {
                    console.log('Ocorreu um erro.')
                }
            })
        }
    });


    /**
     * Função responsável por alterar o nome do campo input file, no momento em que o usuário for fazer um upload de imagem - Contrato
     */
    $("input#logomarca").change(function () {
        $('label#nome_logomarca').html($("input#logomarca").val());
    });

    /**
     * Função responsável por alterar o nome do campo input file, no momento em que o usuário for fazer um upload de imagem - Unidade
     */
    $("input#logomarca_unidade").change(function () {
        $('label#label_logomarca_unidade').html($("input#logomarca_unidade").val());
    });


    /**
     * Função responsável por consultar se um cpf já esta cadastrado na base. - CPF
     */
    $('a#btn-search-cpf').on('click', function() {

        let sCpf = $("input#cpf").val();

        
        $.ajax({
            url: '/contrato-usuario/find-parameter/1/' + sCpf,
            headers: {
                Accept: 'application/json'
            },
            method: 'GET',
            dataType: 'html',
            success: function(response) {

                var json = JSON.parse(response);
                $("input#nome").val(json.nome);
                

            },
            error: function(err) {
                $("input#nome").val();
                console.log('Ocorreu um erro.')
            }
        })
        
    })

    /**
     * Função responsável por consultar se um cpf já esta cadastrado na base. - NOME
     */
    $('a#btn-search-razao_social').on('click', function() {

        let sNome = $("input#nome").val();
        
        $.ajax({
            url: '/admin/find-parameter/2/' + sNome,
            headers: {
                Accept: 'application/json'
            },
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                
                var json = JSON.parse(response);
                $("input#cpf").val(json.cpf);
                
            },
            error: function(err) {
                $("input#cpf").val();
                console.log('Ocorreu um erro.')
            }
        })
        
    })





});