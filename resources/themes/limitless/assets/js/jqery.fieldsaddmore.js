(function($) {
    "use strict";

    $.fieldsaddmore = function(el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;
        var rowId = 0;

        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;

        base.$el.data('fieldsaddmore', base);

        base.init = function() {
            var i;
            base.options = $.extend({}, $.fieldsaddmore.defaultOptions, options);

            //callback before initialize
            base.options.callbackBeforeInit(base.$el, base.options);

            //init events
            base.addClick();
            base.removeClick();

            // Set start row ID
            if($(base.options.rowEle).length>0){
                rowId = parseInt($(base.options.rowEle).last().find(base.options.removebtn).data('rowid'));
            }else{
                rowId = 0;
            }

            if (base.options.min) {
                for (i = 1; i <= base.options.min; i++) {
                    base.content();
                }
            }

        };

        //reflacet content
        base.content = function(id) {
            //callback before add
            base.options.callbackBeforeAdd(base.$el, base.options);

            rowId = (isNaN(rowId) ? 1 : rowId);
            rowId = rowId + 1;

            var template = $(base.options.templateEle).html();
            template = template.replace(/key/g, rowId);
            template = template.replace(/rowId/g, "rowId-" + rowId);

            if(id){
                if(base.options.placement == "prepend"){
                    $('#'+id).prepend(template);
                } else{
                    $('#'+id).append(template);
                }
            } else {
                if(base.options.placement == "prepend"){
                    base.$el.prepend(template);
                } else{
                    base.$el.append(template);
                }
            }

            //callback affter add
            base.options.callbackAfterAdd(base.$el, base.options);
        };

        //add more content Event
        base.addClick = function() {
            $("form").on("click", base.options.addbtn, function(e) {
                //callback before add
                base.options.callbackBeforeAddClick(base.$el, base.options);

                var id = "";
                if(base.options.addType == "internal"){
                    var id = $(this).parents('tbody').prop('id');
                }

                base.content(id);
                $(this).blur();

                //callback before add
                base.options.callbackAfterAddClick(base.$el, base.options);

                if(base.options.addType == "internal"){
                    $(this).die();
                }
                return false;
            });
        };

        //add more content Event
        base.removeClick = function() {
            $("form").on("click", base.options.removebtn, function(event) {
                //callback before add
                var flag = true;

                flag = base.options.callbackBeforeRemoveClick(base.$el, base.options,event);

                if(flag!=false){
                    // var id = "";
                    if(base.options.addType == "internal"){
                        // console.log($('#'+id).find('.rowId-' + $(this).data('rowid')).html());
                        if($(this).parents('tbody').find(base.options.rowEle).length > base.options.min){
                            // var id = $(this).parents('tbody').prop('id');
                            // $('#'+id).find('.rowId-' + $(this).data('rowid')).remove();
                            $(this).closest('tr').remove();
                        }
                    }
                    else{
                        if (base.$el.find(base.options.rowEle).length > base.options.min) {
                            base.$el.find('.rowId-' + $(this).data('rowid')).remove();
                        }
                    }
                }
                $(this).blur();

                //callback before add
                base.options.callbackAfterRemoveClick(base.$el, base.options);
                return false;
            });
        };

        // Run initializer
        base.init();
    };

    //default options
    $.fieldsaddmore.defaultOptions = {
        templateEle: "#fieldsaddmore-template",
        rowEle: ".fieldsaddmore-row",
        addbtn: ".fieldsaddmore-addbtn",
        removebtn: ".fieldsaddmore-removebtn",
        min: 1,
        callbackBeforeInit: function(ele, options) {
        },
        callbackBeforeAdd: function(ele, options) {
        },
        callbackAfterAdd: function(ele, options) {
        },
        callbackBeforeAddClick: function(ele, options) {
        },
        callbackAfterAddClick: function(ele, options) {
        },
        callbackBeforeRemoveClick: function(ele, options) {
        },
        callbackAfterRemoveClick: function(ele, options) {
        }
    };

    //element implementation
    $.fn.fieldsaddmore = function(options) {
        return this.each(function() {

            var fieldsaddmore = new $.fieldsaddmore(this, options);

        });
    };

})(jQuery);