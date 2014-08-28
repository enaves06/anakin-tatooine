Ext.define('CGP.controller.Configuracao', {
    extend: 'Ext.app.Controller',
    models: [       
    ],
    
    stores: [
    ],

    views: [
        'ConfiguracaoGridPanel',
        'configuracao.InserirConfiguracaoPanel',        
        'configuracao.EmpresaGridPanel',        
        'configuracao.FornecedorGridPanel'
    ],
    
    refs: [
        {
            ref: 'configuracaogridpanel',
            selector: 'configuracaogridpanel'
        },
        {
            ref: 'inserirconfiguracaopanel',
            selector: 'configuracao-inserirconfiguracaopanel'
        },
        {
            ref: 'empresagridpanel',
            selector: 'configuracao-empresagridpanel'
        },
        {
            ref: 'fornecedorgridpanel',
            selector: 'configuracao-fornecedorgridpanel'
        }
    ],

    init: function() {
    	var me = this;

        me.control({
            'configuracaogridpanel': {
                itemclick: function(grid, record, item, index, e, eOpts){
                    //console.log(me.getConfiguracaogridpanel().columns[index].down('combobox[name=transportadora]'));
                    me.enableButtonExcluir();
                },   
                beforeedit: function(pluging, context, eOpts){

                    var comboxTransportadora = pluging.editor.down('combobox[name=transportadora]');
                    var comboxCondPagto = pluging.editor.down('combobox[name=cond_pagto]');
                    var idMarca = me.getController('Marca').recuperarMarca();

                    var params = {
                        idMarca: idMarca
                    };

                    comboxTransportadora.getStore().load({
                        params: params,
                        callback: function(records, operation, success) {
                            if(Ext.decode(operation.response.responseText).success){

                                comboxTransportadora.setValue(me.getLastRecordConfiguracaoGrid().get('idTransportadora').toString());
                                comboxCondPagto.setValue(me.getLastRecordConfiguracaoGrid().get('idCondPagto').toString());
                            }
                        }    
                    });
                    //getLastRecordConfiguracaoGrid
                },
                edit: function(){
                    me.getConfiguracaogridpanel().getStore().sync({
                        success: function(batch) {
                            Ext.Msg.alert("Failed", batch.operations[0].request.scope.reader.jsonData["msg"]);

                            var idMarca = me.getController('Marca').recuperarMarca();
                            me.loadConfiguracaoGridPanel(idMarca);
                        },
                        failure: function(batch) {
                            Ext.Msg.alert("Failed", batch.operations[0].request.scope.reader.jsonData["msg"]);
                        }
                    });
                }   
            },
            'configuracaogridpanel button[action=inserir]': {
                click: function(){

                    me.inserirConfiguracaoPanel();
                }   
            },
            'configuracao-inserirconfiguracaopanel': {
                show: function(){
                    me.carregarConfiguracaoEmpresaGridPanel();
                    me.carregarComboboxCondPagto();
                    me.carregarConfiguracaoFornecedorGridPanel();
                    me.carregarComboboxTransportadora();
                }
            },
            'configuracao-inserirconfiguracaopanel button[action=inserir]': {
                click: function(btn){

                    me.inserirConfiguracoes(btn);
                }   
            },
            'configuracaogridpanel button[action=excluir]': {
                click: function(){

                    me.excluirConfiguracoes();
                }   
            }   
        });        
    },

    getConfiguracaoEmpresaGrid: function(){
        var me = this;

        return me.getInserirconfiguracaopanel().down('configuracao-empresagridpanel');
    },

    getConfiguracaoFornecedorGrid: function(){
        var me = this;

        return me.getInserirconfiguracaopanel().down('configuracao-fornecedorgridpanel');
    },

    getCondPagtoCombobox: function(){
        var me = this;

        return me.getInserirconfiguracaopanel().down('combobox[name=cond_pagto]');
    },

    getTransportadoraCombobox: function(){
        var me = this;

        return me.getInserirconfiguracaopanel().down('combobox[name=transportadora]');
    },

    getFreteCombobox: function(){
        var me = this;

        return me.getInserirconfiguracaopanel().down('combobox[name=frete]');
    },

    getLastRecordConfiguracaoGrid: function(){
        var me = this;

        return me.getConfiguracaogridpanel().getSelectionModel().getLastSelected();
    },

    enableButtonExcluir: function(){
        var me = this;

        me.getConfiguracaogridpanel().down('button[action=excluir]').enable();
    },

    disableButtonExcluir: function(){
        var me = this;

        me.getConfiguracaogridpanel().down('button[action=excluir]').disable();
    },

    loadConfiguracaoGridPanel: function(idMarca){
        var me = this;

        var params = {
            idMarca: idMarca
        };

        me.getConfiguracaogridpanel().getStore().load({params: params});
    },

    inserirConfiguracaoPanel: function(){
        var me = this;
        var idMarca = me.getController('Marca').recuperarMarca();

        var InserirPanel = Ext.create('CGP.view.configuracao.InserirConfiguracaoPanel',{
            idMarca: idMarca
        }).show();
    },

    carregarConfiguracaoEmpresaGridPanel: function(){

        var me = this;
        var idMarca = me.getController('Marca').recuperarMarca();

        var params = {
            idMarca: idMarca
        };

        me.getEmpresagridpanel().getStore().load({params: params});
    },

    carregarComboboxCondPagto: function(){
        var me = this;
        me.getInserirconfiguracaopanel().down('combobox[name=cond_pagto]').getStore().load();
    },

    carregarConfiguracaoFornecedorGridPanel: function(){

        var me = this;
        var idMarca = me.getController('Marca').recuperarMarca();

        var params = {
            idMarca: idMarca
        };

        me.getFornecedorgridpanel().getStore().load({params: params});
    },

    carregarComboboxTransportadora: function(){
        var me = this;
        var idMarca = me.getController('Marca').recuperarMarca();

        var params = {
            idMarca: idMarca
        };

        me.getInserirconfiguracaopanel().down('combobox[name=transportadora]').getStore().load({params: params});
    },

    inserirConfiguracoes: function(btn){
        var me = this;

        var params = me.recuperarConfiguracoes();

        Ext.Ajax.request({
            url: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/inserir',
            params: params,
            success: function(response){

                var text = Ext.decode(response.responseText);

                if(text.success){

                    var idMarca = me.getController('Marca').recuperarMarca();
                    me.loadConfiguracaoGridPanel(idMarca);

                    btn.up('window').close();
                }

                Ext.Msg.show({
                     title:'Informativo',
                     msg: text.msg,
                     buttons: Ext.Msg.OK,
                     icon: Ext.Msg.INFO
                });
            },
            failure: function(response){
                var text = Ext.decode(response.responseText);

                Ext.Msg.show({
                     title:'Error',
                     msg: text.msg,
                     buttons: Ext.Msg.OK,
                     icon: Ext.Msg.ERROR
                });
            }
        });
    },

    recuperarConfiguracoes: function(){
        var me = this;
        var recordEmpresas = me.getConfiguracaoEmpresaGrid().getSelectionModel().getSelection();

        var empresas = 'null';
        recordEmpresas.forEach(function(record){

            if(empresas != 'null'){
                empresas = empresas + ', ' + record.get('idEmpresa'); 
            }else{
                empresas = record.get('idEmpresa');
            }         

        });

        var recordFornecedores = me.getConfiguracaoFornecedorGrid().getSelectionModel().getSelection();

        var fornecedores  = 'null';

        recordFornecedores.forEach(function(record){

            if(fornecedores != 'null'){
                fornecedores = fornecedores + ', ' + record.get('idPessoa'); 
            }else{
                fornecedores = record.get('idPessoa');
            }             
        });

        var condPagto = me.getCondPagtoCombobox().getValue();
        var transportadora = me.getTransportadoraCombobox().getValue();
        var frete = me.getFreteCombobox().getValue();
        var idMarca = me.getController('Marca').recuperarMarca();

        params = {
            idMarca: idMarca,
            empresas: empresas,
            fornecedores: JSON.stringify(fornecedores),
            idCondPagto: condPagto,
            idTransportadora: transportadora,
            frete: frete
         };

       
        return params;
    },

    excluirConfiguracoes: function(){
        var me = this;

        me.disableButtonExcluir();

        var records = me.getConfiguracaogridpanel().getSelectionModel().getSelection();
        
        var recordsPreparados = new Array ();

        records.forEach(function(record){

            var aux = new Array(record.get('idMarca'), record.get('idEmpresa'), record.get('idPessoa'));
            recordsPreparados.push(aux);       

        });

        params = {
            configuracoes: JSON.stringify(recordsPreparados)
        };

        Ext.Ajax.request({
            url: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/excluir',
            params: params,
            success: function(response){
                var text = Ext.decode(response.responseText);

                var idMarca = me.getController('Marca').recuperarMarca();
                me.loadConfiguracaoGridPanel(idMarca);
                
                Ext.Msg.show({
                     title:'Successo',
                     msg: text.msg,
                     buttons: Ext.Msg.OK,
                     icon: Ext.Msg.INFO
                });
            },
            failure: function(response){
                var text = Ext.decode(response.responseText);

                Ext.Msg.show({
                     title:'Error',
                     msg: text.msg,
                     buttons: Ext.Msg.OK,
                     icon: Ext.Msg.ERROR
                });
            }
        });
    }
});