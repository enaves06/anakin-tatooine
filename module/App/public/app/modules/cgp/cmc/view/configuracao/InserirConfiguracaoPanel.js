Ext.define('CGP.view.configuracao.InserirConfiguracaoPanel', {
    extend: 'Ext.window.Window',
    xtype: 'configuracao-inserirconfiguracaopanel',
    
    width: 700,
    height: 500,
    
    resizable: false,
    maximizable: true,
    modal: true,
    
    layout: 'border',
    title: 'Inserir configuração',

    idMarca: null,

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items:[
                {
                    xtype: 'configuracao-empresagridpanel',
                    title: 'Empresa',
                    region: 'west',
                    width: 300
                },
                {
                    xtype: 'configuracao-fornecedorgridpanel',
                    title: 'Fornecedor',
                    region: 'center',
                    flex: 1
                }
            ],
            dockedItems: me.buildDockedItems()
        });

        me.callParent(arguments);
    },

    buildDockedItems: function(){
        var me = this;
        
        var condPagtoStore = Ext.create('Ext.data.Store', {
            autoLoad: false,
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/listarcondpagto',
                reader: {
                    type: 'json',
                    totalProperty: 'totalData',
                    root: 'data'
                }
            },
            fields: [
               {name: 'idCondPagto'}, {name: 'descricaoCondPagto'}
            ]
        });
        
        var transportadoraStore = Ext.create('Ext.data.Store', {
            autoLoad: false,
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/transportadora/listar',
                reader: {
                    type: 'json',
                    totalProperty: 'totalData',
                    root: 'data'
                }
            },
            fields: [
               {name: 'id_empresa'}, {name: 'idTransportadora'}, {name: 'descricaoTransportadora'}
            ]
        });

        var freteStore = Ext.create('Ext.data.Store', {
            fields: ['idFrete', 'descricao'],
            data : [
                {idFrete: 'S', descricao: 'S'},
                {idFrete: 'N', descricao: 'N'}
            ]
        });        

        var items = [{
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'toolbar',
                    ui: 'footer',
                    items: [
                        {
                            xtype: 'combobox',
                            name: 'cond_pagto',
                            store: condPagtoStore ,
                            queryMode: 'local',
                            displayField: 'descricaoCondPagto',
                            valueField: 'idCondPagto',
                            emptyText: 'Selecione uma cond. pagt.',
                            matchFieldWidth: true   ,
                            width: 250
                        },
                        {
                            xtype: 'combobox',
                            name: 'transportadora',
                            store: transportadoraStore,
                            queryMode: 'local',
                            displayField: 'descricaoTransportadora',
                            valueField: 'idTransportadora',
                            emptyText: 'Selecione um transportadora',
                            width: 250
                        },                        
                        {
                            xtype: 'combobox',
                            name: 'frete',
                            store: freteStore,
                            queryMode: 'local',
                            displayField: 'descricao',
                            valueField: 'idFrete',
                            emptyText: 'Frete',
                            width: 80
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'toolbar',
            dock: 'bottom',
            items: [
                {
                    xtype: 'toolbar',
                    ui: 'footer',
                    items: [                                        
                        {
                            xtype: 'button',
                            text: 'Inserir',
                            action: 'inserir'
                        },
                        {
                            xtype: 'button',
                            text: 'Cancelar',
                            action: 'cancelar',
                            handler:function () {
                                this.up('window').close();
                            }
                        }
                    ]
                }
            ]
        }];
    
        return items;
    }
});