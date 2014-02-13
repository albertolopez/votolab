(function (global, factory) {
    global.barlovento = factory();
})(this, function () {
    "use strict";
    var
        barlovento = function (namespace, as, giveMe5) {
            var ui = {
                componentSettings: {
                    tinymce: {
                        toolbar: 'link',
                        plugins: 'link'
                    }
                }
            };
            var objects = {

            };
            var R = $('[data-alias="' + namespace.ALIAS + '"]'), e, key, value, dataValue, result, obj, component;
            R.find('[data-key]').each(function (index, element) {
                e = $(element);
                key = e.attr('data-key');
                value = (function (e) {
                    dataValue = e.attr('data-value');
                    if (!barlovento.core.isEmpty(dataValue)) {
                        if (barlovento.core.isHtmlAttr(dataValue)) {
                            return e.attr(dataValue);
                        } else {
                            return dataValue;
                        }
                    } else {
                        result = [];
                        e.find('[data-value]').each(function (i, elem) {
                            var dataValue = $(elem).attr('data-value');
                            if (barlovento.core.isHtmlAttr(dataValue)) {
                                result.push($(elem).attr(dataValue));
                            } else {
                                result.push(dataValue);
                            }
                        });
                        if (result.length === 1) {
                            result = result[0];
                        } else {
                            if (result.length === 0) {
                                result = null
                            }
                        }
                        if (result !== null) {
                            return result;
                        }
                    }
                    dataValue = e.val();
                    if (!barlovento.core.isEmpty(dataValue)) {
                        return dataValue;
                    }
                })(e);
                obj = e.parents('[data-object]').attr('data-object');
                if (barlovento.core.isEmpty(objects[obj])) {
                    objects[obj] = {};
                }
                objects[obj][key] = value;
                if (e.is('[data-ui-component]')) {
                    component = e.attr('data-ui-component');
                    if (!barlovento.core.isEmpty(namespace.ui.componentSettings[component])) {
                        e[component](namespace.ui.componentSettings[component]);
                    } else {
                        e[component](ui.componentSettings[component]);
                    }

                }

            });
            var procObjects = {};
            for (var obj in objects) {
                if (!barlovento.core.isEmpty(namespace.Models) && !barlovento.core.isEmpty(namespace.Models[obj])) {
                    procObjects[obj] = new namespace.Models[obj](objects[obj]);
                } else {
                    procObjects[obj] = objects[obj];
                }
            }
            namespace.loadedObjects = procObjects;
            if (!namespace.binded) {
                R.find('[data-action]').each($.proxy(function (index, element) {
                    var $this = $(element), actionName = $this.attr('data-action');
                    if ($this.checkScope($this, this)) {
                        $this.on('click.' + actionName, $.proxy(function (event) {
                            barlovento(this);
                            var fn = this.actions[actionName],
                                args = this.loadedObjects[$this.attr('data-object')];
                            $this.data('action', actionName);
                            fn.call(this, $this, args);
                        }, namespace));
                    } else if ($this) {

                    }
                }, namespace));
            }
            namespace.binded = true;
            return namespace;
        };


    $.extend(true, barlovento.prototype, {
        app: {},
        NAMESPACE_M: 'M',
        name: 'barlovento',
        ancestor: null,
        toString: function () {
            return ((this.ancestor !== null) ? (this.ancestor.toString() + "\\") : '') + this.name;
        },
        getNamespace: function () {
            return this.toString().replace(/\\/g, '_');
        },
        base: function (ancestor, ancestorName) {
            return {
                name: ancestorName,
                ancestor: ancestor,
                __autoInit: true,
                ui: {
                    componentSettings: {}
                },
                getNamespace: function () {
                    return barlovento.prototype.getNamespace.apply(this);
                },
                toString: barlovento.prototype.toString,
                __init: barlovento.prototype.__init
            };
        },
        /**
         * With this funcion, you can create a module that should inizialiced when $(document).ready if has init function
         * @param {Object|Function} module
         * @return {*}
         */
        library: function (targetNamespace) {
            $(document).trigger(targetNamespace.getNamespace() + '_preInit', targetNamespace);
            if (!this.isEmpty(targetNamespace.component) && !this.isEmpty(targetNamespace.component.DOM)) {
                targetNamespace.jDOM = $(targetNamespace.component.DOM);
            }
            targetNamespace.__init(targetNamespace);
            $(document).trigger(targetNamespace.getNamespace(), targetNamespace);
            return targetNamespace;
        },
        /**
         * Create a Namespace in this object.
         * @todo remove dependency
         * @param namespaceString
         * @return {*|Object}
         */
        namespace: function (namespaceString, object, autoInit) {
            if (namespaceString === undefined) {
                return this;
            }
            var parts = namespaceString.split("."), ancestor = this, ancestorsLength, i, ancestorsName;
            ancestorsLength = parts.length;
            for (i = 0; i < ancestorsLength; i++) {
                if (this.isEmpty(ancestor[parts[i]]) && parts[i] !== this.name && parts[i] !== this.NAMESPACE_M) {
                    ancestorsName = parts[i];
                    ancestor[parts[i]] = new this.base(ancestor, ancestorsName);
                }
                if (parts[i] !== this.name) {
                    ancestor = ancestor[parts[i]];
                }
            }
            if (this.isEmpty(object)) {
                return ancestor;
            } else {
                var obj = jQuery.extend(true, ancestor, object);
                if (autoInit === undefined || autoInit === true) {
                    return this.library(obj);
                } else {
                    return obj;
                }

            }
        },
        isEmpty: function (data) {
            var undef, key, i, len, emptyValues = [undef, null, false, 0, "", "0"];
            for (i = 0, len = emptyValues.length; i < len; i++) {
                if (data === emptyValues[i]) {
                    return true;
                }
            }
            if (typeof data === "object") {
                for (key in data) {
                    if (data.hasOwnProperty(key)) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        },
        isHtmlAttr: function (attr) {
            return true;
        },
        __init: function (namespace) {
            jQuery.fn.extend({
                con: function (types, selector, data, fn, /*INTERNAL*/ one) {
                    var type, origFn;
                    // Types can be a map of types/handlers
                    if (typeof types === "object") {
                        // ( types-Object, selector, data )
                        if (typeof selector !== "string") {
                            // ( types-Object, data )
                            data = data || selector;
                            selector = undefined;
                        }
                        for (type in types) {
                            this.on(type, selector, data, types[ type ], one);
                        }
                        return this;
                    }
                    if (data == null && fn == null) {
                        // ( types, fn )
                        fn = selector;
                        data = selector = undefined;
                    } else if (fn == null) {
                        if (typeof selector === "string") {
                            // ( types, selector, fn )
                            fn = data;
                            data = undefined;
                        } else {
                            // ( types, data, fn )
                            fn = data;
                            data = selector;
                            selector = undefined;
                        }
                    }
                    if (fn === false) {
                        fn = returnFalse;
                    } else if (!fn) {
                        return this;
                    }

                    if (one === 1) {
                        origFn = fn;
                        fn = function (event) {
                            // Can use an empty set, since event contains the info
                            jQuery().off(event);
                            return origFn.apply(this, arguments);
                        };
                        // Use same guid so caller can remove using origFn
                        fn.guid = origFn.guid || ( origFn.guid = jQuery.guid++ );
                    }


                    return this.each(function () {
                        jQuery.event.add(this, types, $.proxy(fn, namespace), data, selector);
                    });
                },

                removeAction: function (actionName) {
                    $(this).off('click.' + actionName);
                },
                checkScope: function ($this, $scope) {
                    return $this.parents('[data-alias]').attr('data-alias') === $scope.ALIAS ||
                        $this.attr('data-alias') === $scope.ALIAS;
                }
            });
            if (this.__autoInit === true && typeof this.beforeInit === "function") {
                this.beforeInit();
            }
            barlovento(namespace);
            if (this.__autoInit === true && typeof this.init === "function") {
                this.init();
            }
        }
    });
    barlovento.core = barlovento.prototype;
    return barlovento;
});