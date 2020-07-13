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
    HBIE.Table = function (options) {
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

        options.text = options.text || {
            none: '<div class="hb-empty hb-empty-normal">\n' +
                '    <div class="hb-empty-image">\n' +
                '        <svg class="hb-empty-img-simple" width="64" height="41" viewBox="0 0 64 41"\n' +
                '             xmlns="http://www.w3.org/2000/svg">\n' +
                '            <g transform="translate(0 1)" fill="none" fill-rule="evenodd">\n' +
                '                <ellipse class="hb-empty-img-simple-ellipse" cx="32" cy="33" rx="32"\n' +
                '                         ry="7"></ellipse>\n' +
                '                <g class="hb-empty-img-simple-g" fill-rule="nonzero">\n' +
                '                    <path\n' +
                '                        d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>\n' +
                '                    <path\n' +
                '                        d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"\n' +
                '                        class="hb-empty-img-simple-path"></path>\n' +
                '                </g>\n' +
                '            </g>\n' +
                '        </svg>\n' +
                '    </div>\n' +
                '    <p class="hb-empty-description">暂无数据</p>\n' +
                '</div>'
        };
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
    };
    HBIE.Table.prototype.tool = function (callback) {
        var _self = this;
        var interval = setInterval(function () {
            if (_self._table) {
                _self._table.on('tool(' + _self.filter + ')', function (obj) {
                    if (callback) callback.call(this, obj);
                });
                clearInterval(interval);
            }
        }, 50);
    }
})();
