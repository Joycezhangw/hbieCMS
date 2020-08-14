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
            isUserName: /^[a-zA-Z0-9_]{5,16}$/,
            isRealName: /^[a-zA-Z\u4e00-\u9fa5]+$/,
            isCreditCode: /^[0-9A-HJ-NPQRTUWXY]{2}\d{6}[0-9A-HJ-NPQRTUWXY]{10}$/g,
            isChineseName: /^[\u4e00-\u9fa5]+$/gi,
            isIDCardNew: /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/,
            email: /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/,
            mobile: /^1[23456789]\d{9}$/,
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
        email: function (value) {
            return HBIE.string.RegExps.email.test(value);
        },
        mobile: function (value) {
            return HBIE.string.RegExps.mobile.test(value)
        },
        //验证统一社会信用代码
        isCreditCode: function (str) {
            return HBIE.string.RegExps.isCreditCode.test(str)
        },
        /**
         * 验证中文姓名
         * @param str
         * @returns {boolean}
         */
        isChineseName: function (str) {
            return HBIE.string.RegExps.isChineseName.test(str)
        },
        //验证二代身份号
        isIDCardNew: function (str) {
            return HBIE.string.RegExps.isIDCardNew.test(str);
        },
        /**
         * 用户名正则，5到16位（字母，数字，下划线）
         * @param str
         * @returns {boolean}
         */
        isUserName: function (str) {
            return HBIE.string.RegExps.isUserName.test(str)
        },
        /**
         * 判断是否中文英文名
         * @param str
         * @returns {boolean}
         */
        isRealName: function (str) {
            return HBIE.string.RegExps.isRealName.test(str)
        },
        escapeURI: function (str) {
            if (window.encodeURIComponent) {
                return encodeURIComponent(str)
            }
            if (window.escape) {
                return escape(str)
            }
            return ""
        },
        random: function (len) {
            return Number(Math.random().toString().substr(3, len) + Date.now()).toString(36);
        }
    };
    HBIE.validate = {
        rules: {}
    }
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
        options.loading = options.loading || true;
        options.done = function (res, curr, count) {
            HBIE.image.loadImgMagnify();
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
    };
    /**
     * 刷新数据
     * @param options 参数，参考layui数据表格参数
     */
    HBIE.Table.prototype.reload = function (options) {
        options = options || {
            page: {
                curr: 1
            }
        };
        var _self = this;
        var interval = setInterval(function () {
            if (_self._table) {
                _self._table.reload(_self.elem.replace(/#/g, ""), options);
                clearInterval(interval);
            }
        }, 50);
    };
    HBIE.image = {
        IMG_COUNT: 0,
        IMG_MAX_RECURSIVE_COUNT: 6,
        loadImgMagnify: function () {
            setTimeout(function () {
                try {
                    if (layer) {
                        $("img[src!=''][layer-src]").each(function () {
                            var id = HBIE.image.getImgId($(this).parent());
                            layer.photos({
                                photos: "#" + id,
                                anim: 5
                            });
                            HBIE.image.IMG_COUNT = 0;
                        });
                    }
                } catch (e) {

                }
            }, 200);
        },
        getImgId: function (obj) {
            HBIE.image.IMG_COUNT++;
            var id = obj.attr("id");
            if (id === undefined && HBIE.image.IMG_COUNT < HBIE.image.IMG_MAX_RECURSIVE_COUNT) {
                id = HBIE.image.getImgId(obj.parent());
            }
            if (id === undefined) {
                id = HBIE.string.random(10);
                obj.attr("id", id);
            }
            return id;
        }
    };
    HBIE.date = {
        DEFAULT_TIME_FORMAT: 'YYYY-MM-DD h:m:s',
        formatParseTime: function (timestamp, format = '') {
            format = format === '' ? HBIE.date.DEFAULT_TIME_FORMAT : format;
            if (timestamp > 0) {
                var date = new Date();
                date.setTime(timestamp * 1000);
                var y = date.getFullYear();
                var m = date.getMonth() + 1;
                m = m < 10 ? ('0' + m) : m;
                var d = date.getDate();
                d = d < 10 ? ('0' + d) : d;
                var h = date.getHours();
                h = h < 10 ? ('0' + h) : h;
                var minute = date.getMinutes();
                var second = date.getSeconds();
                minute = minute < 10 ? ('0' + minute) : minute;
                second = second < 10 ? ('0' + second) : second;
                var time = '';
                time += format.indexOf('Y') > -1 ? y : '';
                time += format.indexOf('M') > -1 ? '-' + m : '';
                time += format.indexOf('D') > -1 ? '-' + d : '';
                time += format.indexOf('h') > -1 ? ' ' + h : '';
                time += format.indexOf('m') > -1 ? ':' + minute : '';
                time += format.indexOf('s') > -1 ? ':' + second : '';
                return time;
            } else {
                return "";
            }
        }
    };
    let timer, flag;
    HBIE.func = {
        /**
         * 函数节流
         * 节流原理：在一定时间内，只能触发一次
         * @param {Function} func 要执行的回调函数
         * @param {Number} wait 延时的时间
         * @param {Boolean} immediate 是否立即执行
         * @returns {function(...[*]=)}
         */
        throttle: function (func, wait = 500, immediate = true) {
            let timer, flag;
            return function () {
                if (immediate) {
                    if (!flag) {
                        flag = true;
                        // 如果是立即执行，则在wait毫秒内开始时执行
                        typeof func === 'function' && func();
                        timer = setTimeout(() => {
                            flag = false;
                        }, wait);
                    }
                } else {
                    if (!flag) {
                        flag = true
                        // 如果是非立即执行，则在wait毫秒内的结束处执行
                        timer = setTimeout(() => {
                            flag = false
                            typeof func === 'function' && func();
                        }, wait);
                    }

                }
            }
        },
        /**
         * 函数防抖
         * 防抖原理：一定时间内，只有最后一次操作，再过wait毫秒后才执行函数
         * @param {Function} func 要执行的回调函数
         * @param {Number} wait 延时的时间
         * @param {Boolean} immediate 是否立即执行
         * @returns {function(...[*]=)}
         */
        debounce: function (func, wait = 500, immediate = false) {
            let timeout;
            return function () {
                // 清除定时器
                if (timeout !== null) clearTimeout(timeout);
                // 立即执行，此类情况一般用不到
                if (immediate) {
                    var callNow = !timeout;
                    timeout = setTimeout(function () {
                        timeout = null;
                    }, wait);
                    if (callNow) typeof func === 'function' && func();
                } else {
                    // 设置定时器，当最后一次操作后，timeout不会再被清除，所以在延时wait毫秒后执行func回调方法
                    timeout = setTimeout(function () {
                        typeof func === 'function' && func();
                    }, wait);
                }
            }
        }
    }

})();
