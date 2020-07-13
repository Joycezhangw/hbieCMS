(function () {
    window.HBIE = window.HBIE || {};
    HBIE.version = '1.0.0';
    HBIE.emptyFn = function () {
    };
    HBIE.returnFn = function (e) {
        return e
    };

    HBIE.string = {
        RegExps: {
            trim: /^\s+|\s+$/g,
            ltrim: /^\s+/,
            rtrim: /\s+$/,
            nl2br: /\n/g,
            s2nb: /[\x20]{2}/g,
            URIencode: /[\x09\x0A\x0D\x20\x21-\x29\x2B\x2C\x2F\x3A-\x3F\x5B-\x5E\x60\x7B-\x7E]/g,
            escHTML: {
                re_amp: /&/g,
                re_lt: /</g,
                re_gt: />/g,
                re_apos: /\x27/g,
                re_quot: /\x22/g
            },
            escString: {
                bsls: /\\/g,
                sls: /\//g,
                nl: /\n/g,
                rt: /\r/g,
                tab: /\t/g
            },
            restXHTML: {
                re_amp: /&amp;/g,
                re_lt: /&lt;/g,
                re_gt: /&gt;/g,
                re_apos: /&(?:apos|#0?39);/g,
                re_quot: /&quot;/g
            },
            write: /\{(\d{1,2})(?:\:([xodQqb]))?\}/g,
            isURL: /^(?:ht|f)tp(?:s)?\:\/\/(?:[\w\-\.]+)\.\w+/i,
            cut: /[\x00-\xFF]/,
            getRealLen: {
                r0: /[^\x00-\xFF]/g,
                r1: /[\x00-\xFF]/g
            },
            format: /\{([\d\w\.]+)\}/g
        },
        commonReplace: function (str, regExp, replacement) {
            return str.replace(regExp, replacement)
        },
        trim: function (str) {
            return HBIE.string.commonReplace(str + "", HBIE.string.RegExps.trim, "")
        },
        ltrim: function (str) {
            return HBIE.string.commonReplace(str + "", HBIE.string.RegExps.ltrim, "")
        },
        rtrim: function (str) {
            return HBIE.string.commonReplace(str + "", HBIE.string.RegExps.rtrim, "")
        },
        isURL: function (str) {
            return HBIE.string.RegExps.isURL.test(str)
        },
        escapeURI: function (str) {
            if (window.encodeURIComponent) {
                return encodeURIComponent(str)
            }
            if (window.escape) {
                return escape(str)
            }
            return ""
        }
    };
    HBIE.table={
        Table:function (options) {
            if (!options) return;
            var _self = this;
            options.parseData = options.parseData || function (data) {
                return {
                    "code": data.code,
                    "msg": data.message,
                    "count": data.data.total,
                    "data": data.data.list
                };
            };
            options.request = options.request || {
                limitName: 'page_size' //每页数据量的参数名，默认：limit
            };
            if (options.page === undefined) {
                options.page = {
                    layout: ['count', 'limit', 'prev', 'page', 'next'],
                    limit: 10
                };
            }
            options.defaultToolbar = options.defaultToolbar || [];//'filter', 'print', 'exports'
            options.toolbar = options.toolbar || "";//头工具栏事件
            options.skin = options.skin || 'line';
            options.size = options.size || 'lg';
            options.async = (options.async !== undefined) ? options.async : true;
            options.done = function (res, curr, count) {
                if (options.callback) options.callback(res, curr, count);
            };
            layui.use('table', function () {
                _self._table = layui.table;
                _self._table.render(options);
            });
            this.filter = options.filter || options.elem.replace(/#/g, "");
            this.elem = options.elem;
            //获取当前选中的数据
            this.checkStatus = function () {
                return this._table.checkStatus(_self.elem.replace(/#/g, ""));
            };
        }
    }
})();
