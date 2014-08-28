Ext.define('CGP.view.Viewport', {
    extend: 'Ext.container.Viewport',
    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            layout: 'border',
            items: [
                {
                    
                    region: 'west',
                    title: 'Marca',
                    xtype: 'marcagridpanel',
                    width: 300
                },
                {  
                    region: 'center',
                    title: 'Configurações',
                    xtype: 'configuracaogridpanel',
                    flex: 1
                }
            ]
        });
        me.callParent(arguments);
    }
});