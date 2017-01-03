function statusChangeCallback(e) {
    "connected" === e.status ? testAPI() : "not_authorized" === e.status
}

function checkLoginState() {
    FB.getLoginStatus(function(e) {
        statusChangeCallback(e)
    })
}

function testAPI() {
    FB.api("/me", function(e) {
        $("#js-send-the-app-modal").addClass("facebook-sent"), $("#js-send-the-app-success-facebook").append($("#sendTheApp")), $("#js-send-the-app-success-facebook").append($("#js-send-the-app-submit")), ga("send", "event", "download", "facebookLogin")
    })
}! function(e, t) {
    function n(e) {
        var t = e.length,
            n = oe.type(e);
        return oe.isWindow(e) ? !1 : 1 === e.nodeType && t ? !0 : "array" === n || "function" !== n && (0 === t || "number" == typeof t && t > 0 && t - 1 in e)
    }

    function i(e) {
        var t = fe[e] = {};
        return oe.each(e.match(ae) || [], function(e, n) {
            t[n] = !0
        }), t
    }

    function r() {
        Object.defineProperty(this.cache = {}, 0, {
            get: function() {
                return {}
            }
        }), this.expando = oe.expando + Math.random()
    }

    function o(e, n, i) {
        var r;
        if (i === t && 1 === e.nodeType)
            if (r = "data-" + n.replace(ye, "-$1").toLowerCase(), i = e.getAttribute(r), "string" == typeof i) {
                try {
                    i = "true" === i ? !0 : "false" === i ? !1 : "null" === i ? null : +i + "" === i ? +i : ve.test(i) ? JSON.parse(i) : i
                } catch (o) {}
                ge.set(e, n, i)
            } else i = t;
        return i
    }

    function s() {
        return !0
    }

    function a() {
        return !1
    }

    function l() {
        try {
            return U.activeElement
        } catch (e) {}
    }

    function c(e, t) {
        for (;
            (e = e[t]) && 1 !== e.nodeType;);
        return e
    }

    function u(e, t, n) {
        if (oe.isFunction(t)) return oe.grep(e, function(e, i) {
            return !!t.call(e, i, e) !== n
        });
        if (t.nodeType) return oe.grep(e, function(e) {
            return e === t !== n
        });
        if ("string" == typeof t) {
            if ($e.test(t)) return oe.filter(t, e, n);
            t = oe.filter(t, e)
        }
        return oe.grep(e, function(e) {
            return te.call(t, e) >= 0 !== n
        })
    }

    function d(e, t) {
        return oe.nodeName(e, "table") && oe.nodeName(1 === t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
    }

    function p(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function h(e) {
        var t = Oe.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function f(e, t) {
        for (var n = e.length, i = 0; n > i; i++) me.set(e[i], "globalEval", !t || me.get(t[i], "globalEval"))
    }

    function g(e, t) {
        var n, i, r, o, s, a, l, c;
        if (1 === t.nodeType) {
            if (me.hasData(e) && (o = me.access(e), s = oe.extend({}, o), c = o.events, me.set(t, s), c)) {
                delete s.handle, s.events = {};
                for (r in c)
                    for (n = 0, i = c[r].length; i > n; n++) oe.event.add(t, r, c[r][n])
            }
            ge.hasData(e) && (a = ge.access(e), l = oe.extend({}, a), ge.set(t, l))
        }
    }

    function m(e, n) {
        var i = e.getElementsByTagName ? e.getElementsByTagName(n || "*") : e.querySelectorAll ? e.querySelectorAll(n || "*") : [];
        return n === t || n && oe.nodeName(e, n) ? oe.merge([e], i) : i
    }

    function v(e, t) {
        var n = t.nodeName.toLowerCase();
        "input" === n && Ie.test(e.type) ? t.checked = e.checked : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
    }

    function y(e, t) {
        if (t in e) return t;
        for (var n = t.charAt(0).toUpperCase() + t.slice(1), i = t, r = Je.length; r--;)
            if (t = Je[r] + n, t in e) return t;
        return i
    }

    function b(e, t) {
        return e = t || e, "none" === oe.css(e, "display") || !oe.contains(e.ownerDocument, e)
    }

    function x(t) {
        return e.getComputedStyle(t, null)
    }

    function w(e, t) {
        for (var n, i, r, o = [], s = 0, a = e.length; a > s; s++) i = e[s], i.style && (o[s] = me.get(i, "olddisplay"), n = i.style.display, t ? (o[s] || "none" !== n || (i.style.display = ""), "" === i.style.display && b(i) && (o[s] = me.access(i, "olddisplay", E(i.nodeName)))) : o[s] || (r = b(i), (n && "none" !== n || !r) && me.set(i, "olddisplay", r ? n : oe.css(i, "display"))));
        for (s = 0; a > s; s++) i = e[s], i.style && (t && "none" !== i.style.display && "" !== i.style.display || (i.style.display = t ? o[s] || "" : "none"));
        return e
    }

    function C(e, t, n) {
        var i = Ue.exec(t);
        return i ? Math.max(0, i[1] - (n || 0)) + (i[2] || "px") : t
    }

    function S(e, t, n, i, r) {
        for (var o = n === (i ? "border" : "content") ? 4 : "width" === t ? 1 : 0, s = 0; 4 > o; o += 2) "margin" === n && (s += oe.css(e, n + Qe[o], !0, r)), i ? ("content" === n && (s -= oe.css(e, "padding" + Qe[o], !0, r)), "margin" !== n && (s -= oe.css(e, "border" + Qe[o] + "Width", !0, r))) : (s += oe.css(e, "padding" + Qe[o], !0, r), "padding" !== n && (s += oe.css(e, "border" + Qe[o] + "Width", !0, r)));
        return s
    }

    function T(e, t, n) {
        var i = !0,
            r = "width" === t ? e.offsetWidth : e.offsetHeight,
            o = x(e),
            s = oe.support.boxSizing && "border-box" === oe.css(e, "boxSizing", !1, o);
        if (0 >= r || null == r) {
            if (r = He(e, t, o), (0 > r || null == r) && (r = e.style[t]), Ve.test(r)) return r;
            i = s && (oe.support.boxSizingReliable || r === e.style[t]), r = parseFloat(r) || 0
        }
        return r + S(e, t, n || (s ? "border" : "content"), i, o) + "px"
    }

    function E(e) {
        var t = U,
            n = Xe[e];
        return n || (n = k(e, t), "none" !== n && n || (_e = (_e || oe("<iframe frameborder='0' width='0' height='0'/>").css("cssText", "display:block !important")).appendTo(t.documentElement), t = (_e[0].contentWindow || _e[0].contentDocument).document, t.write("<!doctype html><html><body>"), t.close(), n = k(e, t), _e.detach()), Xe[e] = n), n
    }

    function k(e, t) {
        var n = oe(t.createElement(e)).appendTo(t.body),
            i = oe.css(n[0], "display");
        return n.remove(), i
    }

    function L(e, t, n, i) {
        var r;
        if (oe.isArray(t)) oe.each(t, function(t, r) {
            n || et.test(e) ? i(e, r) : L(e + "[" + ("object" == typeof r ? t : "") + "]", r, n, i)
        });
        else if (n || "object" !== oe.type(t)) i(e, t);
        else
            for (r in t) L(e + "[" + r + "]", t[r], n, i)
    }

    function $(e) {
        return function(t, n) {
            "string" != typeof t && (n = t, t = "*");
            var i, r = 0,
                o = t.toLowerCase().match(ae) || [];
            if (oe.isFunction(n))
                for (; i = o[r++];) "+" === i[0] ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
        }
    }

    function j(e, n, i, r) {
        function o(l) {
            var c;
            return s[l] = !0, oe.each(e[l] || [], function(e, l) {
                var u = l(n, i, r);
                return "string" != typeof u || a || s[u] ? a ? !(c = u) : t : (n.dataTypes.unshift(u), o(u), !1)
            }), c
        }
        var s = {},
            a = e === vt;
        return o(n.dataTypes[0]) || !s["*"] && o("*")
    }

    function P(e, n) {
        var i, r, o = oe.ajaxSettings.flatOptions || {};
        for (i in n) n[i] !== t && ((o[i] ? e : r || (r = {}))[i] = n[i]);
        return r && oe.extend(!0, e, r), e
    }

    function A(e, n, i) {
        for (var r, o, s, a, l = e.contents, c = e.dataTypes;
            "*" === c[0];) c.shift(), r === t && (r = e.mimeType || n.getResponseHeader("Content-Type"));
        if (r)
            for (o in l)
                if (l[o] && l[o].test(r)) {
                    c.unshift(o);
                    break
                }
        if (c[0] in i) s = c[0];
        else {
            for (o in i) {
                if (!c[0] || e.converters[o + " " + c[0]]) {
                    s = o;
                    break
                }
                a || (a = o)
            }
            s = s || a
        }
        return s ? (s !== c[0] && c.unshift(s), i[s]) : t
    }

    function D(e, t, n, i) {
        var r, o, s, a, l, c = {},
            u = e.dataTypes.slice();
        if (u[1])
            for (s in e.converters) c[s.toLowerCase()] = e.converters[s];
        for (o = u.shift(); o;)
            if (e.responseFields[o] && (n[e.responseFields[o]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = o, o = u.shift())
                if ("*" === o) o = l;
                else if ("*" !== l && l !== o) {
            if (s = c[l + " " + o] || c["* " + o], !s)
                for (r in c)
                    if (a = r.split(" "), a[1] === o && (s = c[l + " " + a[0]] || c["* " + a[0]])) {
                        s === !0 ? s = c[r] : c[r] !== !0 && (o = a[0], u.unshift(a[1]));
                        break
                    }
            if (s !== !0)
                if (s && e["throws"]) t = s(t);
                else try {
                    t = s(t)
                } catch (d) {
                    return {
                        state: "parsererror",
                        error: s ? d : "No conversion from " + l + " to " + o
                    }
                }
        }
        return {
            state: "success",
            data: t
        }
    }

    function F() {
        return setTimeout(function() {
            kt = t
        }), kt = oe.now()
    }

    function N(e, t) {
        oe.each(t, function(t, n) {
            for (var i = (Dt[t] || []).concat(Dt["*"]), r = 0, o = i.length; o > r; r++)
                if (i[r].call(e, t, n)) return
        })
    }

    function I(e, t, n) {
        var i, r, o = 0,
            s = At.length,
            a = oe.Deferred().always(function() {
                delete l.elem
            }),
            l = function() {
                if (r) return !1;
                for (var t = kt || F(), n = Math.max(0, c.startTime + c.duration - t), i = n / c.duration || 0, o = 1 - i, s = 0, l = c.tweens.length; l > s; s++) c.tweens[s].run(o);
                return a.notifyWith(e, [c, o, n]), 1 > o && l ? n : (a.resolveWith(e, [c]), !1)
            },
            c = a.promise({
                elem: e,
                props: oe.extend({}, t),
                opts: oe.extend(!0, {
                    specialEasing: {}
                }, n),
                originalProperties: t,
                originalOptions: n,
                startTime: kt || F(),
                duration: n.duration,
                tweens: [],
                createTween: function(t, n) {
                    var i = oe.Tween(e, c.opts, t, n, c.opts.specialEasing[t] || c.opts.easing);
                    return c.tweens.push(i), i
                },
                stop: function(t) {
                    var n = 0,
                        i = t ? c.tweens.length : 0;
                    if (r) return this;
                    for (r = !0; i > n; n++) c.tweens[n].run(1);
                    return t ? a.resolveWith(e, [c, t]) : a.rejectWith(e, [c, t]), this
                }
            }),
            u = c.props;
        for (M(u, c.opts.specialEasing); s > o; o++)
            if (i = At[o].call(c, e, u, c.opts)) return i;
        return N(c, u), oe.isFunction(c.opts.start) && c.opts.start.call(e, c), oe.fx.timer(oe.extend(l, {
            elem: e,
            anim: c,
            queue: c.opts.queue
        })), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always)
    }

    function M(e, t) {
        var n, i, r, o, s;
        for (n in e)
            if (i = oe.camelCase(n), r = t[i], o = e[n], oe.isArray(o) && (r = o[1], o = e[n] = o[0]), n !== i && (e[i] = o, delete e[n]), s = oe.cssHooks[i], s && "expand" in s) {
                o = s.expand(o), delete e[i];
                for (n in o) n in e || (e[n] = o[n], t[n] = r)
            } else t[i] = r
    }

    function R(e, n, i) {
        var r, o, s, a, l, c, u, d, p, h = this,
            f = e.style,
            g = {},
            m = [],
            v = e.nodeType && b(e);
        i.queue || (d = oe._queueHooks(e, "fx"), null == d.unqueued && (d.unqueued = 0, p = d.empty.fire, d.empty.fire = function() {
            d.unqueued || p()
        }), d.unqueued++, h.always(function() {
            h.always(function() {
                d.unqueued--, oe.queue(e, "fx").length || d.empty.fire()
            })
        })), 1 === e.nodeType && ("height" in n || "width" in n) && (i.overflow = [f.overflow, f.overflowX, f.overflowY], "inline" === oe.css(e, "display") && "none" === oe.css(e, "float") && (f.display = "inline-block")), i.overflow && (f.overflow = "hidden", h.always(function() {
            f.overflow = i.overflow[0], f.overflowX = i.overflow[1], f.overflowY = i.overflow[2]
        })), l = me.get(e, "fxshow");
        for (r in n)
            if (s = n[r], $t.exec(s)) {
                if (delete n[r], c = c || "toggle" === s, s === (v ? "hide" : "show")) {
                    if ("show" !== s || l === t || l[r] === t) continue;
                    v = !0
                }
                m.push(r)
            }
        if (a = m.length) {
            l = me.get(e, "fxshow") || me.access(e, "fxshow", {}), "hidden" in l && (v = l.hidden), c && (l.hidden = !v), v ? oe(e).show() : h.done(function() {
                oe(e).hide()
            }), h.done(function() {
                var t;
                me.remove(e, "fxshow");
                for (t in g) oe.style(e, t, g[t])
            });
            for (r = 0; a > r; r++) o = m[r], u = h.createTween(o, v ? l[o] : 0), g[o] = l[o] || oe.style(e, o), o in l || (l[o] = u.start, v && (u.end = u.start, u.start = "width" === o || "height" === o ? 1 : 0))
        }
    }

    function O(e, t, n, i, r) {
        return new O.prototype.init(e, t, n, i, r)
    }

    function z(e, t) {
        var n, i = {
                height: e
            },
            r = 0;
        for (t = t ? 1 : 0; 4 > r; r += 2 - t) n = Qe[r], i["margin" + n] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i
    }

    function q(e) {
        return oe.isWindow(e) ? e : 9 === e.nodeType && e.defaultView
    }
    var H, _, W = typeof t,
        B = e.location,
        U = e.document,
        V = U.documentElement,
        Y = e.jQuery,
        X = e.$,
        Z = {},
        G = [],
        Q = "2.0.0",
        J = G.concat,
        K = G.push,
        ee = G.slice,
        te = G.indexOf,
        ne = Z.toString,
        ie = Z.hasOwnProperty,
        re = Q.trim,
        oe = function(e, t) {
            return new oe.fn.init(e, t, H)
        },
        se = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        ae = /\S+/g,
        le = /^(?:(<[\w\W]+>)[^>]*|#([\w-]*))$/,
        ce = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
        ue = /^-ms-/,
        de = /-([\da-z])/gi,
        pe = function(e, t) {
            return t.toUpperCase()
        },
        he = function() {
            U.removeEventListener("DOMContentLoaded", he, !1), e.removeEventListener("load", he, !1), oe.ready()
        };
    oe.fn = oe.prototype = {
            jquery: Q,
            constructor: oe,
            init: function(e, n, i) {
                var r, o;
                if (!e) return this;
                if ("string" == typeof e) {
                    if (r = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : le.exec(e), !r || !r[1] && n) return !n || n.jquery ? (n || i).find(e) : this.constructor(n).find(e);
                    if (r[1]) {
                        if (n = n instanceof oe ? n[0] : n, oe.merge(this, oe.parseHTML(r[1], n && n.nodeType ? n.ownerDocument || n : U, !0)), ce.test(r[1]) && oe.isPlainObject(n))
                            for (r in n) oe.isFunction(this[r]) ? this[r](n[r]) : this.attr(r, n[r]);
                        return this
                    }
                    return o = U.getElementById(r[2]), o && o.parentNode && (this.length = 1, this[0] = o), this.context = U, this.selector = e, this
                }
                return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : oe.isFunction(e) ? i.ready(e) : (e.selector !== t && (this.selector = e.selector, this.context = e.context), oe.makeArray(e, this))
            },
            selector: "",
            length: 0,
            toArray: function() {
                return ee.call(this)
            },
            get: function(e) {
                return null == e ? this.toArray() : 0 > e ? this[this.length + e] : this[e]
            },
            pushStack: function(e) {
                var t = oe.merge(this.constructor(), e);
                return t.prevObject = this, t.context = this.context, t
            },
            each: function(e, t) {
                return oe.each(this, e, t)
            },
            ready: function(e) {
                return oe.ready.promise().done(e), this
            },
            slice: function() {
                return this.pushStack(ee.apply(this, arguments))
            },
            first: function() {
                return this.eq(0)
            },
            last: function() {
                return this.eq(-1)
            },
            eq: function(e) {
                var t = this.length,
                    n = +e + (0 > e ? t : 0);
                return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
            },
            map: function(e) {
                return this.pushStack(oe.map(this, function(t, n) {
                    return e.call(t, n, t)
                }))
            },
            end: function() {
                return this.prevObject || this.constructor(null)
            },
            push: K,
            sort: [].sort,
            splice: [].splice
        }, oe.fn.init.prototype = oe.fn, oe.extend = oe.fn.extend = function() {
            var e, n, i, r, o, s, a = arguments[0] || {},
                l = 1,
                c = arguments.length,
                u = !1;
            for ("boolean" == typeof a && (u = a, a = arguments[1] || {}, l = 2), "object" == typeof a || oe.isFunction(a) || (a = {}), c === l && (a = this, --l); c > l; l++)
                if (null != (e = arguments[l]))
                    for (n in e) i = a[n], r = e[n], a !== r && (u && r && (oe.isPlainObject(r) || (o = oe.isArray(r))) ? (o ? (o = !1, s = i && oe.isArray(i) ? i : []) : s = i && oe.isPlainObject(i) ? i : {}, a[n] = oe.extend(u, s, r)) : r !== t && (a[n] = r));
            return a
        }, oe.extend({
            expando: "jQuery" + (Q + Math.random()).replace(/\D/g, ""),
            noConflict: function(t) {
                return e.$ === oe && (e.$ = X), t && e.jQuery === oe && (e.jQuery = Y), oe
            },
            isReady: !1,
            readyWait: 1,
            holdReady: function(e) {
                e ? oe.readyWait++ : oe.ready(!0)
            },
            ready: function(e) {
                (e === !0 ? --oe.readyWait : oe.isReady) || (oe.isReady = !0, e !== !0 && --oe.readyWait > 0 || (_.resolveWith(U, [oe]), oe.fn.trigger && oe(U).trigger("ready").off("ready")))
            },
            isFunction: function(e) {
                return "function" === oe.type(e)
            },
            isArray: Array.isArray,
            isWindow: function(e) {
                return null != e && e === e.window
            },
            isNumeric: function(e) {
                return !isNaN(parseFloat(e)) && isFinite(e)
            },
            type: function(e) {
                return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? Z[ne.call(e)] || "object" : typeof e
            },
            isPlainObject: function(e) {
                if ("object" !== oe.type(e) || e.nodeType || oe.isWindow(e)) return !1;
                try {
                    if (e.constructor && !ie.call(e.constructor.prototype, "isPrototypeOf")) return !1
                } catch (t) {
                    return !1
                }
                return !0
            },
            isEmptyObject: function(e) {
                var t;
                for (t in e) return !1;
                return !0
            },
            error: function(e) {
                throw Error(e)
            },
            parseHTML: function(e, t, n) {
                if (!e || "string" != typeof e) return null;
                "boolean" == typeof t && (n = t, t = !1), t = t || U;
                var i = ce.exec(e),
                    r = !n && [];
                return i ? [t.createElement(i[1])] : (i = oe.buildFragment([e], t, r), r && oe(r).remove(), oe.merge([], i.childNodes))
            },
            parseJSON: JSON.parse,
            parseXML: function(e) {
                var n, i;
                if (!e || "string" != typeof e) return null;
                try {
                    i = new DOMParser, n = i.parseFromString(e, "text/xml")
                } catch (r) {
                    n = t
                }
                return (!n || n.getElementsByTagName("parsererror").length) && oe.error("Invalid XML: " + e), n
            },
            noop: function() {},
            globalEval: function(e) {
                var t, n = eval;
                e = oe.trim(e), e && (1 === e.indexOf("use strict") ? (t = U.createElement("script"), t.text = e, U.head.appendChild(t).parentNode.removeChild(t)) : n(e))
            },
            camelCase: function(e) {
                return e.replace(ue, "ms-").replace(de, pe)
            },
            nodeName: function(e, t) {
                return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
            },
            each: function(e, t, i) {
                var r, o = 0,
                    s = e.length,
                    a = n(e);
                if (i) {
                    if (a)
                        for (; s > o && (r = t.apply(e[o], i), r !== !1); o++);
                    else
                        for (o in e)
                            if (r = t.apply(e[o], i), r === !1) break
                } else if (a)
                    for (; s > o && (r = t.call(e[o], o, e[o]), r !== !1); o++);
                else
                    for (o in e)
                        if (r = t.call(e[o], o, e[o]), r === !1) break; return e
            },
            trim: function(e) {
                return null == e ? "" : re.call(e)
            },
            makeArray: function(e, t) {
                var i = t || [];
                return null != e && (n(Object(e)) ? oe.merge(i, "string" == typeof e ? [e] : e) : K.call(i, e)), i
            },
            inArray: function(e, t, n) {
                return null == t ? -1 : te.call(t, e, n)
            },
            merge: function(e, n) {
                var i = n.length,
                    r = e.length,
                    o = 0;
                if ("number" == typeof i)
                    for (; i > o; o++) e[r++] = n[o];
                else
                    for (; n[o] !== t;) e[r++] = n[o++];
                return e.length = r, e
            },
            grep: function(e, t, n) {
                var i, r = [],
                    o = 0,
                    s = e.length;
                for (n = !!n; s > o; o++) i = !!t(e[o], o), n !== i && r.push(e[o]);
                return r
            },
            map: function(e, t, i) {
                var r, o = 0,
                    s = e.length,
                    a = n(e),
                    l = [];
                if (a)
                    for (; s > o; o++) r = t(e[o], o, i), null != r && (l[l.length] = r);
                else
                    for (o in e) r = t(e[o], o, i), null != r && (l[l.length] = r);
                return J.apply([], l)
            },
            guid: 1,
            proxy: function(e, n) {
                var i, r, o;
                return "string" == typeof n && (i = e[n], n = e, e = i), oe.isFunction(e) ? (r = ee.call(arguments, 2), o = function() {
                    return e.apply(n || this, r.concat(ee.call(arguments)))
                }, o.guid = e.guid = e.guid || oe.guid++, o) : t
            },
            access: function(e, n, i, r, o, s, a) {
                var l = 0,
                    c = e.length,
                    u = null == i;
                if ("object" === oe.type(i)) {
                    o = !0;
                    for (l in i) oe.access(e, n, l, i[l], !0, s, a)
                } else if (r !== t && (o = !0, oe.isFunction(r) || (a = !0), u && (a ? (n.call(e, r), n = null) : (u = n, n = function(e, t, n) {
                        return u.call(oe(e), n)
                    })), n))
                    for (; c > l; l++) n(e[l], i, a ? r : r.call(e[l], l, n(e[l], i)));
                return o ? e : u ? n.call(e) : c ? n(e[0], i) : s
            },
            now: Date.now,
            swap: function(e, t, n, i) {
                var r, o, s = {};
                for (o in t) s[o] = e.style[o], e.style[o] = t[o];
                r = n.apply(e, i || []);
                for (o in t) e.style[o] = s[o];
                return r
            }
        }), oe.ready.promise = function(t) {
            return _ || (_ = oe.Deferred(), "complete" === U.readyState ? setTimeout(oe.ready) : (U.addEventListener("DOMContentLoaded", he, !1), e.addEventListener("load", he, !1))), _.promise(t)
        }, oe.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(e, t) {
            Z["[object " + t + "]"] = t.toLowerCase()
        }), H = oe(U),
        function(e, t) {
            function n(e) {
                return be.test(e + "")
            }

            function i() {
                var e, t = [];
                return e = function(n, i) {
                    return t.push(n += " ") > k.cacheLength && delete e[t.shift()], e[n] = i
                }
            }

            function r(e) {
                return e[q] = !0, e
            }

            function o(e) {
                var t = F.createElement("div");
                try {
                    return !!e(t)
                } catch (n) {
                    return !1
                } finally {
                    t.parentNode && t.parentNode.removeChild(t), t = null
                }
            }

            function s(e, t, n, i) {
                var r, o, s, a, l, c, u, d, p, g;
                if ((t ? t.ownerDocument || t : H) !== F && D(t), t = t || F, n = n || [], !e || "string" != typeof e) return n;
                if (1 !== (a = t.nodeType) && 9 !== a) return [];
                if (I && !i) {
                    if (r = xe.exec(e))
                        if (s = r[1]) {
                            if (9 === a) {
                                if (o = t.getElementById(s), !o || !o.parentNode) return n;
                                if (o.id === s) return n.push(o), n
                            } else if (t.ownerDocument && (o = t.ownerDocument.getElementById(s)) && z(t, o) && o.id === s) return n.push(o), n
                        } else {
                            if (r[2]) return te.apply(n, t.getElementsByTagName(e)), n;
                            if ((s = r[3]) && _.getElementsByClassName && t.getElementsByClassName) return te.apply(n, t.getElementsByClassName(s)), n
                        }
                    if (_.qsa && (!M || !M.test(e))) {
                        if (d = u = q, p = t, g = 9 === a && e, 1 === a && "object" !== t.nodeName.toLowerCase()) {
                            for (c = h(e), (u = t.getAttribute("id")) ? d = u.replace(Se, "\\$&") : t.setAttribute("id", d), d = "[id='" + d + "'] ", l = c.length; l--;) c[l] = d + f(c[l]);
                            p = fe.test(e) && t.parentNode || t, g = c.join(",")
                        }
                        if (g) try {
                            return te.apply(n, p.querySelectorAll(g)), n
                        } catch (m) {} finally {
                            u || t.removeAttribute("id")
                        }
                    }
                }
                return C(e.replace(de, "$1"), t, n, i)
            }

            function a(e, t) {
                var n = t && e,
                    i = n && (~t.sourceIndex || Q) - (~e.sourceIndex || Q);
                if (i) return i;
                if (n)
                    for (; n = n.nextSibling;)
                        if (n === t) return -1;
                return e ? 1 : -1
            }

            function l(e, n, i) {
                var r;
                return i ? t : (r = e.getAttributeNode(n)) && r.specified ? r.value : e[n] === !0 ? n.toLowerCase() : null
            }

            function c(e, n, i) {
                var r;
                return i ? t : r = e.getAttribute(n, "type" === n.toLowerCase() ? 1 : 2)
            }

            function u(e) {
                return function(t) {
                    var n = t.nodeName.toLowerCase();
                    return "input" === n && t.type === e
                }
            }

            function d(e) {
                return function(t) {
                    var n = t.nodeName.toLowerCase();
                    return ("input" === n || "button" === n) && t.type === e
                }
            }

            function p(e) {
                return r(function(t) {
                    return t = +t, r(function(n, i) {
                        for (var r, o = e([], n.length, t), s = o.length; s--;) n[r = o[s]] && (n[r] = !(i[r] = n[r]))
                    })
                })
            }

            function h(e, t) {
                var n, i, r, o, a, l, c, u = V[e + " "];
                if (u) return t ? 0 : u.slice(0);
                for (a = e, l = [], c = k.preFilter; a;) {
                    (!n || (i = pe.exec(a))) && (i && (a = a.slice(i[0].length) || a), l.push(r = [])), n = !1, (i = he.exec(a)) && (n = i.shift(), r.push({
                        value: n,
                        type: i[0].replace(de, " ")
                    }), a = a.slice(n.length));
                    for (o in k.filter) !(i = ye[o].exec(a)) || c[o] && !(i = c[o](i)) || (n = i.shift(), r.push({
                        value: n,
                        type: o,
                        matches: i
                    }), a = a.slice(n.length));
                    if (!n) break
                }
                return t ? a.length : a ? s.error(e) : V(e, l).slice(0)
            }

            function f(e) {
                for (var t = 0, n = e.length, i = ""; n > t; t++) i += e[t].value;
                return i
            }

            function g(e, t, n) {
                var i = t.dir,
                    r = n && "parentNode" === i,
                    o = B++;
                return t.first ? function(t, n, o) {
                    for (; t = t[i];)
                        if (1 === t.nodeType || r) return e(t, n, o)
                } : function(t, n, s) {
                    var a, l, c, u = W + " " + o;
                    if (s) {
                        for (; t = t[i];)
                            if ((1 === t.nodeType || r) && e(t, n, s)) return !0
                    } else
                        for (; t = t[i];)
                            if (1 === t.nodeType || r)
                                if (c = t[q] || (t[q] = {}), (l = c[i]) && l[0] === u) {
                                    if ((a = l[1]) === !0 || a === E) return a === !0
                                } else if (l = c[i] = [u], l[1] = e(t, n, s) || E, l[1] === !0) return !0
                }
            }

            function m(e) {
                return e.length > 1 ? function(t, n, i) {
                    for (var r = e.length; r--;)
                        if (!e[r](t, n, i)) return !1;
                    return !0
                } : e[0]
            }

            function v(e, t, n, i, r) {
                for (var o, s = [], a = 0, l = e.length, c = null != t; l > a; a++)(o = e[a]) && (!n || n(o, i, r)) && (s.push(o), c && t.push(a));
                return s
            }

            function y(e, t, n, i, o, s) {
                return i && !i[q] && (i = y(i)), o && !o[q] && (o = y(o, s)), r(function(r, s, a, l) {
                    var c, u, d, p = [],
                        h = [],
                        f = s.length,
                        g = r || w(t || "*", a.nodeType ? [a] : a, []),
                        m = !e || !r && t ? g : v(g, p, e, a, l),
                        y = n ? o || (r ? e : f || i) ? [] : s : m;
                    if (n && n(m, y, a, l), i)
                        for (c = v(y, h), i(c, [], a, l), u = c.length; u--;)(d = c[u]) && (y[h[u]] = !(m[h[u]] = d));
                    if (r) {
                        if (o || e) {
                            if (o) {
                                for (c = [], u = y.length; u--;)(d = y[u]) && c.push(m[u] = d);
                                o(null, y = [], c, l)
                            }
                            for (u = y.length; u--;)(d = y[u]) && (c = o ? ie.call(r, d) : p[u]) > -1 && (r[c] = !(s[c] = d))
                        }
                    } else y = v(y === s ? y.splice(f, y.length) : y), o ? o(null, s, y, l) : te.apply(s, y)
                })
            }

            function b(e) {
                for (var t, n, i, r = e.length, o = k.relative[e[0].type], s = o || k.relative[" "], a = o ? 1 : 0, l = g(function(e) {
                        return e === t
                    }, s, !0), c = g(function(e) {
                        return ie.call(t, e) > -1
                    }, s, !0), u = [function(e, n, i) {
                        return !o && (i || n !== P) || ((t = n).nodeType ? l(e, n, i) : c(e, n, i))
                    }]; r > a; a++)
                    if (n = k.relative[e[a].type]) u = [g(m(u), n)];
                    else {
                        if (n = k.filter[e[a].type].apply(null, e[a].matches), n[q]) {
                            for (i = ++a; r > i && !k.relative[e[i].type]; i++);
                            return y(a > 1 && m(u), a > 1 && f(e.slice(0, a - 1)).replace(de, "$1"), n, i > a && b(e.slice(a, i)), r > i && b(e = e.slice(i)), r > i && f(e))
                        }
                        u.push(n)
                    }
                return m(u)
            }

            function x(e, t) {
                var n = 0,
                    i = t.length > 0,
                    o = e.length > 0,
                    a = function(r, a, l, c, u) {
                        var d, p, h, f = [],
                            g = 0,
                            m = "0",
                            y = r && [],
                            b = null != u,
                            x = P,
                            w = r || o && k.find.TAG("*", u && a.parentNode || a),
                            C = W += null == x ? 1 : Math.random() || .1;
                        for (b && (P = a !== F && a, E = n); null != (d = w[m]); m++) {
                            if (o && d) {
                                for (p = 0; h = e[p++];)
                                    if (h(d, a, l)) {
                                        c.push(d);
                                        break
                                    }
                                b && (W = C, E = ++n)
                            }
                            i && ((d = !h && d) && g--, r && y.push(d))
                        }
                        if (g += m, i && m !== g) {
                            for (p = 0; h = t[p++];) h(y, f, a, l);
                            if (r) {
                                if (g > 0)
                                    for (; m--;) y[m] || f[m] || (f[m] = K.call(c));
                                f = v(f)
                            }
                            te.apply(c, f), b && !r && f.length > 0 && g + t.length > 1 && s.uniqueSort(c)
                        }
                        return b && (W = C, P = x), y
                    };
                return i ? r(a) : a
            }

            function w(e, t, n) {
                for (var i = 0, r = t.length; r > i; i++) s(e, t[i], n);
                return n
            }

            function C(e, t, n, i) {
                var r, o, s, a, l, c = h(e);
                if (!i && 1 === c.length) {
                    if (o = c[0] = c[0].slice(0), o.length > 2 && "ID" === (s = o[0]).type && 9 === t.nodeType && I && k.relative[o[1].type]) {
                        if (t = (k.find.ID(s.matches[0].replace(Te, Ee), t) || [])[0], !t) return n;
                        e = e.slice(o.shift().value.length)
                    }
                    for (r = ye.needsContext.test(e) ? 0 : o.length; r-- && (s = o[r], !k.relative[a = s.type]);)
                        if ((l = k.find[a]) && (i = l(s.matches[0].replace(Te, Ee), fe.test(o[0].type) && t.parentNode || t))) {
                            if (o.splice(r, 1), e = i.length && f(o), !e) return te.apply(n, i), n;
                            break
                        }
                }
                return j(e, c)(i, t, !I, n, fe.test(e)), n
            }

            function S() {}
            var T, E, k, L, $, j, P, A, D, F, N, I, M, R, O, z, q = "sizzle" + -new Date,
                H = e.document,
                _ = {},
                W = 0,
                B = 0,
                U = i(),
                V = i(),
                Y = i(),
                X = !1,
                Z = function() {
                    return 0
                },
                G = typeof t,
                Q = 1 << 31,
                J = [],
                K = J.pop,
                ee = J.push,
                te = J.push,
                ne = J.slice,
                ie = J.indexOf || function(e) {
                    for (var t = 0, n = this.length; n > t; t++)
                        if (this[t] === e) return t;
                    return -1
                },
                re = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                se = "[\\x20\\t\\r\\n\\f]",
                ae = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
                le = ae.replace("w", "w#"),
                ce = "\\[" + se + "*(" + ae + ")" + se + "*(?:([*^$|!~]?=)" + se + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + le + ")|)|)" + se + "*\\]",
                ue = ":(" + ae + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + ce.replace(3, 8) + ")*)|.*)\\)|)",
                de = RegExp("^" + se + "+|((?:^|[^\\\\])(?:\\\\.)*)" + se + "+$", "g"),
                pe = RegExp("^" + se + "*," + se + "*"),
                he = RegExp("^" + se + "*([>+~]|" + se + ")" + se + "*"),
                fe = RegExp(se + "*[+~]"),
                ge = RegExp("=" + se + "*([^\\]'\"]*)" + se + "*\\]", "g"),
                me = RegExp(ue),
                ve = RegExp("^" + le + "$"),
                ye = {
                    ID: RegExp("^#(" + ae + ")"),
                    CLASS: RegExp("^\\.(" + ae + ")"),
                    TAG: RegExp("^(" + ae.replace("w", "w*") + ")"),
                    ATTR: RegExp("^" + ce),
                    PSEUDO: RegExp("^" + ue),
                    CHILD: RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + se + "*(even|odd|(([+-]|)(\\d*)n|)" + se + "*(?:([+-]|)" + se + "*(\\d+)|))" + se + "*\\)|)", "i"),
                    "boolean": RegExp("^(?:" + re + ")$", "i"),
                    needsContext: RegExp("^" + se + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + se + "*((?:-\\d)?\\d*)" + se + "*\\)|)(?=[^-]|$)", "i")
                },
                be = /^[^{]+\{\s*\[native \w/,
                xe = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                we = /^(?:input|select|textarea|button)$/i,
                Ce = /^h\d$/i,
                Se = /'|\\/g,
                Te = /\\([\da-fA-F]{1,6}[\x20\t\r\n\f]?|.)/g,
                Ee = function(e, t) {
                    var n = "0x" + t - 65536;
                    return n !== n ? t : 0 > n ? String.fromCharCode(n + 65536) : String.fromCharCode(55296 | n >> 10, 56320 | 1023 & n)
                };
            try {
                te.apply(J = ne.call(H.childNodes), H.childNodes), J[H.childNodes.length].nodeType
            } catch (ke) {
                te = {
                    apply: J.length ? function(e, t) {
                        ee.apply(e, ne.call(t))
                    } : function(e, t) {
                        for (var n = e.length, i = 0; e[n++] = t[i++];);
                        e.length = n - 1
                    }
                }
            }
            $ = s.isXML = function(e) {
                var t = e && (e.ownerDocument || e).documentElement;
                return t ? "HTML" !== t.nodeName : !1
            }, D = s.setDocument = function(e) {
                var i = e ? e.ownerDocument || e : H;
                return i !== F && 9 === i.nodeType && i.documentElement ? (F = i, N = i.documentElement, I = !$(i), _.getElementsByTagName = o(function(e) {
                    return e.appendChild(i.createComment("")), !e.getElementsByTagName("*").length
                }), _.attributes = o(function(e) {
                    return e.className = "i", !e.getAttribute("className")
                }), _.getElementsByClassName = o(function(e) {
                    return e.innerHTML = "<div class='a'></div><div class='a i'></div>", e.firstChild.className = "i", 2 === e.getElementsByClassName("i").length
                }), _.sortDetached = o(function(e) {
                    return 1 & e.compareDocumentPosition(F.createElement("div"))
                }), _.getById = o(function(e) {
                    return N.appendChild(e).id = q, !i.getElementsByName || !i.getElementsByName(q).length
                }), _.getById ? (k.find.ID = function(e, t) {
                    if (typeof t.getElementById !== G && I) {
                        var n = t.getElementById(e);
                        return n && n.parentNode ? [n] : []
                    }
                }, k.filter.ID = function(e) {
                    var t = e.replace(Te, Ee);
                    return function(e) {
                        return e.getAttribute("id") === t
                    }
                }) : (k.find.ID = function(e, n) {
                    if (typeof n.getElementById !== G && I) {
                        var i = n.getElementById(e);
                        return i ? i.id === e || typeof i.getAttributeNode !== G && i.getAttributeNode("id").value === e ? [i] : t : []
                    }
                }, k.filter.ID = function(e) {
                    var t = e.replace(Te, Ee);
                    return function(e) {
                        var n = typeof e.getAttributeNode !== G && e.getAttributeNode("id");
                        return n && n.value === t
                    }
                }), k.find.TAG = _.getElementsByTagName ? function(e, n) {
                    return typeof n.getElementsByTagName !== G ? n.getElementsByTagName(e) : t
                } : function(e, t) {
                    var n, i = [],
                        r = 0,
                        o = t.getElementsByTagName(e);
                    if ("*" === e) {
                        for (; n = o[r++];) 1 === n.nodeType && i.push(n);
                        return i
                    }
                    return o
                }, k.find.CLASS = _.getElementsByClassName && function(e, n) {
                    return typeof n.getElementsByClassName !== G && I ? n.getElementsByClassName(e) : t
                }, R = [], M = [], (_.qsa = n(i.querySelectorAll)) && (o(function(e) {
                    e.innerHTML = "<select><option selected=''></option></select>", e.querySelectorAll("[selected]").length || M.push("\\[" + se + "*(?:value|" + re + ")"), e.querySelectorAll(":checked").length || M.push(":checked")
                }), o(function(e) {
                    var t = F.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("t", ""), e.querySelectorAll("[t^='']").length && M.push("[*^$]=" + se + "*(?:''|\"\")"), e.querySelectorAll(":enabled").length || M.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), M.push(",.*:")
                })), (_.matchesSelector = n(O = N.webkitMatchesSelector || N.mozMatchesSelector || N.oMatchesSelector || N.msMatchesSelector)) && o(function(e) {
                    _.disconnectedMatch = O.call(e, "div"), O.call(e, "[s!='']:x"), R.push("!=", ue)
                }), M = M.length && RegExp(M.join("|")), R = R.length && RegExp(R.join("|")), z = n(N.contains) || N.compareDocumentPosition ? function(e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        i = t && t.parentNode;
                    return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
                } : function(e, t) {
                    if (t)
                        for (; t = t.parentNode;)
                            if (t === e) return !0;
                    return !1
                }, Z = N.compareDocumentPosition ? function(e, t) {
                    if (e === t) return X = !0, 0;
                    var n = t.compareDocumentPosition && e.compareDocumentPosition && e.compareDocumentPosition(t);
                    return n ? 1 & n || !_.sortDetached && t.compareDocumentPosition(e) === n ? e === i || z(H, e) ? -1 : t === i || z(H, t) ? 1 : A ? ie.call(A, e) - ie.call(A, t) : 0 : 4 & n ? -1 : 1 : e.compareDocumentPosition ? -1 : 1
                } : function(e, t) {
                    var n, r = 0,
                        o = e.parentNode,
                        s = t.parentNode,
                        l = [e],
                        c = [t];
                    if (e === t) return X = !0, 0;
                    if (!o || !s) return e === i ? -1 : t === i ? 1 : o ? -1 : s ? 1 : A ? ie.call(A, e) - ie.call(A, t) : 0;
                    if (o === s) return a(e, t);
                    for (n = e; n = n.parentNode;) l.unshift(n);
                    for (n = t; n = n.parentNode;) c.unshift(n);
                    for (; l[r] === c[r];) r++;
                    return r ? a(l[r], c[r]) : l[r] === H ? -1 : c[r] === H ? 1 : 0
                }, F) : F
            }, s.matches = function(e, t) {
                return s(e, null, null, t)
            }, s.matchesSelector = function(e, t) {
                if ((e.ownerDocument || e) !== F && D(e), t = t.replace(ge, "='$1']"), !(!_.matchesSelector || !I || R && R.test(t) || M && M.test(t))) try {
                    var n = O.call(e, t);
                    if (n || _.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
                } catch (i) {}
                return s(t, F, null, [e]).length > 0
            }, s.contains = function(e, t) {
                return (e.ownerDocument || e) !== F && D(e), z(e, t)
            }, s.attr = function(e, n) {
                (e.ownerDocument || e) !== F && D(e);
                var i = k.attrHandle[n.toLowerCase()],
                    r = i && i(e, n, !I);
                return r === t ? _.attributes || !I ? e.getAttribute(n) : (r = e.getAttributeNode(n)) && r.specified ? r.value : null : r
            }, s.error = function(e) {
                throw Error("Syntax error, unrecognized expression: " + e)
            }, s.uniqueSort = function(e) {
                var t, n = [],
                    i = 0,
                    r = 0;
                if (X = !_.detectDuplicates, A = !_.sortStable && e.slice(0), e.sort(Z), X) {
                    for (; t = e[r++];) t === e[r] && (i = n.push(r));
                    for (; i--;) e.splice(n[i], 1)
                }
                return e
            }, L = s.getText = function(e) {
                var t, n = "",
                    i = 0,
                    r = e.nodeType;
                if (r) {
                    if (1 === r || 9 === r || 11 === r) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += L(e)
                    } else if (3 === r || 4 === r) return e.nodeValue
                } else
                    for (; t = e[i]; i++) n += L(t);
                return n
            }, k = s.selectors = {
                cacheLength: 50,
                createPseudo: r,
                match: ye,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(e) {
                        return e[1] = e[1].replace(Te, Ee), e[3] = (e[4] || e[5] || "").replace(Te, Ee), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function(e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || s.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && s.error(e[0]), e
                    },
                    PSEUDO: function(e) {
                        var t, n = !e[5] && e[2];
                        return ye.CHILD.test(e[0]) ? null : (e[4] ? e[2] = e[4] : n && me.test(n) && (t = h(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(e) {
                        var t = e.replace(Te, Ee).toLowerCase();
                        return "*" === e ? function() {
                            return !0
                        } : function(e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function(e) {
                        var t = U[e + " "];
                        return t || (t = RegExp("(^|" + se + ")" + e + "(" + se + "|$)")) && U(e, function(e) {
                            return t.test("string" == typeof e.className && e.className || typeof e.getAttribute !== G && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(e, t, n) {
                        return function(i) {
                            var r = s.attr(i, e);
                            return null == r ? "!=" === t : t ? (r += "", "=" === t ? r === n : "!=" === t ? r !== n : "^=" === t ? n && 0 === r.indexOf(n) : "*=" === t ? n && r.indexOf(n) > -1 : "$=" === t ? n && r.slice(-n.length) === n : "~=" === t ? (" " + r + " ").indexOf(n) > -1 : "|=" === t ? r === n || r.slice(0, n.length + 1) === n + "-" : !1) : !0
                        }
                    },
                    CHILD: function(e, t, n, i, r) {
                        var o = "nth" !== e.slice(0, 3),
                            s = "last" !== e.slice(-4),
                            a = "of-type" === t;
                        return 1 === i && 0 === r ? function(e) {
                            return !!e.parentNode
                        } : function(t, n, l) {
                            var c, u, d, p, h, f, g = o !== s ? "nextSibling" : "previousSibling",
                                m = t.parentNode,
                                v = a && t.nodeName.toLowerCase(),
                                y = !l && !a;
                            if (m) {
                                if (o) {
                                    for (; g;) {
                                        for (d = t; d = d[g];)
                                            if (a ? d.nodeName.toLowerCase() === v : 1 === d.nodeType) return !1;
                                        f = g = "only" === e && !f && "nextSibling"
                                    }
                                    return !0
                                }
                                if (f = [s ? m.firstChild : m.lastChild], s && y) {
                                    for (u = m[q] || (m[q] = {}), c = u[e] || [], h = c[0] === W && c[1], p = c[0] === W && c[2], d = h && m.childNodes[h]; d = ++h && d && d[g] || (p = h = 0) || f.pop();)
                                        if (1 === d.nodeType && ++p && d === t) {
                                            u[e] = [W, h, p];
                                            break
                                        }
                                } else if (y && (c = (t[q] || (t[q] = {}))[e]) && c[0] === W) p = c[1];
                                else
                                    for (;
                                        (d = ++h && d && d[g] || (p = h = 0) || f.pop()) && ((a ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++p || (y && ((d[q] || (d[q] = {}))[e] = [W, p]), d !== t)););
                                return p -= r, p === i || 0 === p % i && p / i >= 0
                            }
                        }
                    },
                    PSEUDO: function(e, t) {
                        var n, i = k.pseudos[e] || k.setFilters[e.toLowerCase()] || s.error("unsupported pseudo: " + e);
                        return i[q] ? i(t) : i.length > 1 ? (n = [e, e, "", t], k.setFilters.hasOwnProperty(e.toLowerCase()) ? r(function(e, n) {
                            for (var r, o = i(e, t), s = o.length; s--;) r = ie.call(e, o[s]), e[r] = !(n[r] = o[s])
                        }) : function(e) {
                            return i(e, 0, n)
                        }) : i
                    }
                },
                pseudos: {
                    not: r(function(e) {
                        var t = [],
                            n = [],
                            i = j(e.replace(de, "$1"));
                        return i[q] ? r(function(e, t, n, r) {
                            for (var o, s = i(e, null, r, []), a = e.length; a--;)(o = s[a]) && (e[a] = !(t[a] = o))
                        }) : function(e, r, o) {
                            return t[0] = e, i(t, null, o, n), !n.pop()
                        }
                    }),
                    has: r(function(e) {
                        return function(t) {
                            return s(e, t).length > 0
                        }
                    }),
                    contains: r(function(e) {
                        return function(t) {
                            return (t.textContent || t.innerText || L(t)).indexOf(e) > -1
                        }
                    }),
                    lang: r(function(e) {
                        return ve.test(e || "") || s.error("unsupported lang: " + e), e = e.replace(Te, Ee).toLowerCase(),
                            function(t) {
                                var n;
                                do
                                    if (n = I ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-");
                                while ((t = t.parentNode) && 1 === t.nodeType);
                                return !1
                            }
                    }),
                    target: function(t) {
                        var n = e.location && e.location.hash;
                        return n && n.slice(1) === t.id
                    },
                    root: function(e) {
                        return e === N
                    },
                    focus: function(e) {
                        return e === F.activeElement && (!F.hasFocus || F.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: function(e) {
                        return e.disabled === !1
                    },
                    disabled: function(e) {
                        return e.disabled === !0
                    },
                    checked: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function(e) {
                        return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
                    },
                    empty: function(e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeName > "@" || 3 === e.nodeType || 4 === e.nodeType) return !1;
                        return !0
                    },
                    parent: function(e) {
                        return !k.pseudos.empty(e)
                    },
                    header: function(e) {
                        return Ce.test(e.nodeName)
                    },
                    input: function(e) {
                        return we.test(e.nodeName)
                    },
                    button: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function(e) {
                        var t;
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || t.toLowerCase() === e.type)
                    },
                    first: p(function() {
                        return [0]
                    }),
                    last: p(function(e, t) {
                        return [t - 1]
                    }),
                    eq: p(function(e, t, n) {
                        return [0 > n ? n + t : n]
                    }),
                    even: p(function(e, t) {
                        for (var n = 0; t > n; n += 2) e.push(n);
                        return e
                    }),
                    odd: p(function(e, t) {
                        for (var n = 1; t > n; n += 2) e.push(n);
                        return e
                    }),
                    lt: p(function(e, t, n) {
                        for (var i = 0 > n ? n + t : n; --i >= 0;) e.push(i);
                        return e
                    }),
                    gt: p(function(e, t, n) {
                        for (var i = 0 > n ? n + t : n; t > ++i;) e.push(i);
                        return e
                    })
                }
            };
            for (T in {
                    radio: !0,
                    checkbox: !0,
                    file: !0,
                    password: !0,
                    image: !0
                }) k.pseudos[T] = u(T);
            for (T in {
                    submit: !0,
                    reset: !0
                }) k.pseudos[T] = d(T);
            j = s.compile = function(e, t) {
                var n, i = [],
                    r = [],
                    o = Y[e + " "];
                if (!o) {
                    for (t || (t = h(e)), n = t.length; n--;) o = b(t[n]), o[q] ? i.push(o) : r.push(o);
                    o = Y(e, x(r, i))
                }
                return o
            }, k.pseudos.nth = k.pseudos.eq, S.prototype = k.filters = k.pseudos, k.setFilters = new S, _.sortStable = q.split("").sort(Z).join("") === q, D(), [0, 0].sort(Z), _.detectDuplicates = X, o(function(e) {
                if (e.innerHTML = "<a href='#'></a>", "#" !== e.firstChild.getAttribute("href"))
                    for (var t = "type|href|height|width".split("|"), n = t.length; n--;) k.attrHandle[t[n]] = c
            }), o(function(e) {
                if (null != e.getAttribute("disabled"))
                    for (var t = re.split("|"), n = t.length; n--;) k.attrHandle[t[n]] = l
            }), oe.find = s, oe.expr = s.selectors, oe.expr[":"] = oe.expr.pseudos, oe.unique = s.uniqueSort, oe.text = s.getText, oe.isXMLDoc = s.isXML, oe.contains = s.contains
        }(e);
    var fe = {};
    oe.Callbacks = function(e) {
        e = "string" == typeof e ? fe[e] || i(e) : oe.extend({}, e);
        var n, r, o, s, a, l, c = [],
            u = !e.once && [],
            d = function(t) {
                for (n = e.memory && t, r = !0, l = s || 0, s = 0, a = c.length, o = !0; c && a > l; l++)
                    if (c[l].apply(t[0], t[1]) === !1 && e.stopOnFalse) {
                        n = !1;
                        break
                    }
                o = !1, c && (u ? u.length && d(u.shift()) : n ? c = [] : p.disable())
            },
            p = {
                add: function() {
                    if (c) {
                        var t = c.length;
                        ! function i(t) {
                            oe.each(t, function(t, n) {
                                var r = oe.type(n);
                                "function" === r ? e.unique && p.has(n) || c.push(n) : n && n.length && "string" !== r && i(n)
                            })
                        }(arguments), o ? a = c.length : n && (s = t, d(n))
                    }
                    return this
                },
                remove: function() {
                    return c && oe.each(arguments, function(e, t) {
                        for (var n;
                            (n = oe.inArray(t, c, n)) > -1;) c.splice(n, 1), o && (a >= n && a--, l >= n && l--)
                    }), this
                },
                has: function(e) {
                    return e ? oe.inArray(e, c) > -1 : !(!c || !c.length)
                },
                empty: function() {
                    return c = [], a = 0, this
                },
                disable: function() {
                    return c = u = n = t, this
                },
                disabled: function() {
                    return !c
                },
                lock: function() {
                    return u = t, n || p.disable(), this
                },
                locked: function() {
                    return !u
                },
                fireWith: function(e, t) {
                    return t = t || [], t = [e, t.slice ? t.slice() : t], !c || r && !u || (o ? u.push(t) : d(t)), this
                },
                fire: function() {
                    return p.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!r
                }
            };
        return p
    }, oe.extend({
        Deferred: function(e) {
            var t = [
                    ["resolve", "done", oe.Callbacks("once memory"), "resolved"],
                    ["reject", "fail", oe.Callbacks("once memory"), "rejected"],
                    ["notify", "progress", oe.Callbacks("memory")]
                ],
                n = "pending",
                i = {
                    state: function() {
                        return n
                    },
                    always: function() {
                        return r.done(arguments).fail(arguments), this
                    },
                    then: function() {
                        var e = arguments;
                        return oe.Deferred(function(n) {
                            oe.each(t, function(t, o) {
                                var s = o[0],
                                    a = oe.isFunction(e[t]) && e[t];
                                r[o[1]](function() {
                                    var e = a && a.apply(this, arguments);
                                    e && oe.isFunction(e.promise) ? e.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[s + "With"](this === i ? n.promise() : this, a ? [e] : arguments)
                                })
                            }), e = null
                        }).promise()
                    },
                    promise: function(e) {
                        return null != e ? oe.extend(e, i) : i
                    }
                },
                r = {};
            return i.pipe = i.then, oe.each(t, function(e, o) {
                var s = o[2],
                    a = o[3];
                i[o[1]] = s.add, a && s.add(function() {
                    n = a
                }, t[1 ^ e][2].disable, t[2][2].lock), r[o[0]] = function() {
                    return r[o[0] + "With"](this === r ? i : this, arguments), this
                }, r[o[0] + "With"] = s.fireWith
            }), i.promise(r), e && e.call(r, r), r
        },
        when: function(e) {
            var t, n, i, r = 0,
                o = ee.call(arguments),
                s = o.length,
                a = 1 !== s || e && oe.isFunction(e.promise) ? s : 0,
                l = 1 === a ? e : oe.Deferred(),
                c = function(e, n, i) {
                    return function(r) {
                        n[e] = this, i[e] = arguments.length > 1 ? ee.call(arguments) : r, i === t ? l.notifyWith(n, i) : --a || l.resolveWith(n, i)
                    }
                };
            if (s > 1)
                for (t = Array(s), n = Array(s), i = Array(s); s > r; r++) o[r] && oe.isFunction(o[r].promise) ? o[r].promise().done(c(r, i, o)).fail(l.reject).progress(c(r, n, t)) : --a;
            return a || l.resolveWith(i, o), l.promise()
        }
    }), oe.support = function(t) {
        var n = U.createElement("input"),
            i = U.createDocumentFragment(),
            r = U.createElement("div"),
            o = U.createElement("select"),
            s = o.appendChild(U.createElement("option"));
        return n.type ? (n.type = "checkbox", t.checkOn = "" !== n.value, t.optSelected = s.selected, t.reliableMarginRight = !0, t.boxSizingReliable = !0, t.pixelPosition = !1, n.checked = !0, t.noCloneChecked = n.cloneNode(!0).checked, o.disabled = !0, t.optDisabled = !s.disabled, n = U.createElement("input"), n.value = "t", n.type = "radio", t.radioValue = "t" === n.value, n.setAttribute("checked", "t"), n.setAttribute("name", "t"), i.appendChild(n), t.checkClone = i.cloneNode(!0).cloneNode(!0).lastChild.checked, t.focusinBubbles = "onfocusin" in e, r.style.backgroundClip = "content-box", r.cloneNode(!0).style.backgroundClip = "", t.clearCloneStyle = "content-box" === r.style.backgroundClip, oe(function() {
            var n, i, o = "padding:0;margin:0;border:0;display:block;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box",
                s = U.getElementsByTagName("body")[0];
            s && (n = U.createElement("div"), n.style.cssText = "border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px", s.appendChild(n).appendChild(r), r.innerHTML = "", r.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%", oe.swap(s, null != s.style.zoom ? {
                zoom: 1
            } : {}, function() {
                t.boxSizing = 4 === r.offsetWidth
            }), e.getComputedStyle && (t.pixelPosition = "1%" !== (e.getComputedStyle(r, null) || {}).top, t.boxSizingReliable = "4px" === (e.getComputedStyle(r, null) || {
                width: "4px"
            }).width, i = r.appendChild(U.createElement("div")), i.style.cssText = r.style.cssText = o, i.style.marginRight = i.style.width = "0", r.style.width = "1px", t.reliableMarginRight = !parseFloat((e.getComputedStyle(i, null) || {}).marginRight)), s.removeChild(n))
        }), t) : t
    }({});
    var ge, me, ve = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/,
        ye = /([A-Z])/g;
    r.uid = 1, r.accepts = function(e) {
        return e.nodeType ? 1 === e.nodeType || 9 === e.nodeType : !0
    }, r.prototype = {
        key: function(e) {
            if (!r.accepts(e)) return 0;
            var t = {},
                n = e[this.expando];
            if (!n) {
                n = r.uid++;
                try {
                    t[this.expando] = {
                        value: n
                    }, Object.defineProperties(e, t)
                } catch (i) {
                    t[this.expando] = n, oe.extend(e, t)
                }
            }
            return this.cache[n] || (this.cache[n] = {}), n
        },
        set: function(e, t, n) {
            var i, r = this.key(e),
                o = this.cache[r];
            if ("string" == typeof t) o[t] = n;
            else if (oe.isEmptyObject(o)) this.cache[r] = t;
            else
                for (i in t) o[i] = t[i]
        },
        get: function(e, n) {
            var i = this.cache[this.key(e)];
            return n === t ? i : i[n]
        },
        access: function(e, n, i) {
            return n === t || n && "string" == typeof n && i === t ? this.get(e, n) : (this.set(e, n, i), i !== t ? i : n)
        },
        remove: function(e, n) {
            var i, r, o = this.key(e),
                s = this.cache[o];
            if (n === t) this.cache[o] = {};
            else {
                oe.isArray(n) ? r = n.concat(n.map(oe.camelCase)) : n in s ? r = [n] : (r = oe.camelCase(n), r = r in s ? [r] : r.match(ae) || []), i = r.length;
                for (; i--;) delete s[r[i]]
            }
        },
        hasData: function(e) {
            return !oe.isEmptyObject(this.cache[e[this.expando]] || {})
        },
        discard: function(e) {
            delete this.cache[this.key(e)]
        }
    }, ge = new r, me = new r, oe.extend({
        acceptData: r.accepts,
        hasData: function(e) {
            return ge.hasData(e) || me.hasData(e)
        },
        data: function(e, t, n) {
            return ge.access(e, t, n)
        },
        removeData: function(e, t) {
            ge.remove(e, t)
        },
        _data: function(e, t, n) {
            return me.access(e, t, n)
        },
        _removeData: function(e, t) {
            me.remove(e, t)
        }
    }), oe.fn.extend({
        data: function(e, n) {
            var i, r, s = this[0],
                a = 0,
                l = null;
            if (e === t) {
                if (this.length && (l = ge.get(s), 1 === s.nodeType && !me.get(s, "hasDataAttrs"))) {
                    for (i = s.attributes; i.length > a; a++) r = i[a].name, 0 === r.indexOf("data-") && (r = oe.camelCase(r.substring(5)), o(s, r, l[r]));
                    me.set(s, "hasDataAttrs", !0)
                }
                return l
            }
            return "object" == typeof e ? this.each(function() {
                ge.set(this, e)
            }) : oe.access(this, function(n) {
                var i, r = oe.camelCase(e);
                if (s && n === t) {
                    if (i = ge.get(s, e), i !== t) return i;
                    if (i = ge.get(s, r), i !== t) return i;
                    if (i = o(s, r, t), i !== t) return i
                } else this.each(function() {
                    var i = ge.get(this, r);
                    ge.set(this, r, n), -1 !== e.indexOf("-") && i !== t && ge.set(this, e, n)
                })
            }, null, n, arguments.length > 1, null, !0)
        },
        removeData: function(e) {
            return this.each(function() {
                ge.remove(this, e)
            })
        }
    }), oe.extend({
        queue: function(e, n, i) {
            var r;
            return e ? (n = (n || "fx") + "queue", r = me.get(e, n), i && (!r || oe.isArray(i) ? r = me.access(e, n, oe.makeArray(i)) : r.push(i)), r || []) : t
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = oe.queue(e, t),
                i = n.length,
                r = n.shift(),
                o = oe._queueHooks(e, t),
                s = function() {
                    oe.dequeue(e, t)
                };
            "inprogress" === r && (r = n.shift(), i--), o.cur = r, r && ("fx" === t && n.unshift("inprogress"), delete o.stop, r.call(e, s, o)), !i && o && o.empty.fire()
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return me.get(e, n) || me.access(e, n, {
                empty: oe.Callbacks("once memory").add(function() {
                    me.remove(e, [t + "queue", n])
                })
            })
        }
    }), oe.fn.extend({
        queue: function(e, n) {
            var i = 2;
            return "string" != typeof e && (n = e, e = "fx", i--), i > arguments.length ? oe.queue(this[0], e) : n === t ? this : this.each(function() {
                var t = oe.queue(this, e, n);
                oe._queueHooks(this, e), "fx" === e && "inprogress" !== t[0] && oe.dequeue(this, e)
            })
        },
        dequeue: function(e) {
            return this.each(function() {
                oe.dequeue(this, e)
            })
        },
        delay: function(e, t) {
            return e = oe.fx ? oe.fx.speeds[e] || e : e, t = t || "fx", this.queue(t, function(t, n) {
                var i = setTimeout(t, e);
                n.stop = function() {
                    clearTimeout(i)
                }
            })
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, n) {
            var i, r = 1,
                o = oe.Deferred(),
                s = this,
                a = this.length,
                l = function() {
                    --r || o.resolveWith(s, [s])
                };
            for ("string" != typeof e && (n = e, e = t), e = e || "fx"; a--;) i = me.get(s[a], e + "queueHooks"), i && i.empty && (r++, i.empty.add(l));
            return l(), o.promise(n)
        }
    });
    var be, xe, we = /[\t\r\n]/g,
        Ce = /\r/g,
        Se = /^(?:input|select|textarea|button)$/i;
    oe.fn.extend({
        attr: function(e, t) {
            return oe.access(this, oe.attr, e, t, arguments.length > 1)
        },
        removeAttr: function(e) {
            return this.each(function() {
                oe.removeAttr(this, e)
            })
        },
        prop: function(e, t) {
            return oe.access(this, oe.prop, e, t, arguments.length > 1)
        },
        removeProp: function(e) {
            return this.each(function() {
                delete this[oe.propFix[e] || e]
            })
        },
        addClass: function(e) {
            var t, n, i, r, o, s = 0,
                a = this.length,
                l = "string" == typeof e && e;
            if (oe.isFunction(e)) return this.each(function(t) {
                oe(this).addClass(e.call(this, t, this.className))
            });
            if (l)
                for (t = (e || "").match(ae) || []; a > s; s++)
                    if (n = this[s], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(we, " ") : " ")) {
                        for (o = 0; r = t[o++];) 0 > i.indexOf(" " + r + " ") && (i += r + " ");
                        n.className = oe.trim(i)
                    }
            return this
        },
        removeClass: function(e) {
            var t, n, i, r, o, s = 0,
                a = this.length,
                l = 0 === arguments.length || "string" == typeof e && e;
            if (oe.isFunction(e)) return this.each(function(t) {
                oe(this).removeClass(e.call(this, t, this.className))
            });
            if (l)
                for (t = (e || "").match(ae) || []; a > s; s++)
                    if (n = this[s], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(we, " ") : "")) {
                        for (o = 0; r = t[o++];)
                            for (; i.indexOf(" " + r + " ") >= 0;) i = i.replace(" " + r + " ", " ");
                        n.className = e ? oe.trim(i) : ""
                    }
            return this
        },
        toggleClass: function(e, t) {
            var n = typeof e,
                i = "boolean" == typeof t;
            return oe.isFunction(e) ? this.each(function(n) {
                oe(this).toggleClass(e.call(this, n, this.className, t), t)
            }) : this.each(function() {
                if ("string" === n)
                    for (var r, o = 0, s = oe(this), a = t, l = e.match(ae) || []; r = l[o++];) a = i ? a : !s.hasClass(r), s[a ? "addClass" : "removeClass"](r);
                else(n === W || "boolean" === n) && (this.className && me.set(this, "__className__", this.className), this.className = this.className || e === !1 ? "" : me.get(this, "__className__") || "")
            })
        },
        hasClass: function(e) {
            for (var t = " " + e + " ", n = 0, i = this.length; i > n; n++)
                if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(we, " ").indexOf(t) >= 0) return !0;
            return !1
        },
        val: function(e) {
            var n, i, r, o = this[0];
            return arguments.length ? (r = oe.isFunction(e), this.each(function(i) {
                var o, s = oe(this);
                1 === this.nodeType && (o = r ? e.call(this, i, s.val()) : e, null == o ? o = "" : "number" == typeof o ? o += "" : oe.isArray(o) && (o = oe.map(o, function(e) {
                    return null == e ? "" : e + ""
                })), n = oe.valHooks[this.type] || oe.valHooks[this.nodeName.toLowerCase()], n && "set" in n && n.set(this, o, "value") !== t || (this.value = o))
            })) : o ? (n = oe.valHooks[o.type] || oe.valHooks[o.nodeName.toLowerCase()], n && "get" in n && (i = n.get(o, "value")) !== t ? i : (i = o.value, "string" == typeof i ? i.replace(Ce, "") : null == i ? "" : i)) : void 0
        }
    }), oe.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = e.attributes.value;
                    return !t || t.specified ? e.value : e.text
                }
            },
            select: {
                get: function(e) {
                    for (var t, n, i = e.options, r = e.selectedIndex, o = "select-one" === e.type || 0 > r, s = o ? null : [], a = o ? r + 1 : i.length, l = 0 > r ? a : o ? r : 0; a > l; l++)
                        if (n = i[l], !(!n.selected && l !== r || (oe.support.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && oe.nodeName(n.parentNode, "optgroup"))) {
                            if (t = oe(n).val(), o) return t;
                            s.push(t)
                        }
                    return s
                },
                set: function(e, t) {
                    for (var n, i, r = e.options, o = oe.makeArray(t), s = r.length; s--;) i = r[s], (i.selected = oe.inArray(oe(i).val(), o) >= 0) && (n = !0);
                    return n || (e.selectedIndex = -1), o
                }
            }
        },
        attr: function(e, n, i) {
            var r, o, s = e.nodeType;
            return e && 3 !== s && 8 !== s && 2 !== s ? typeof e.getAttribute === W ? oe.prop(e, n, i) : (1 === s && oe.isXMLDoc(e) || (n = n.toLowerCase(), r = oe.attrHooks[n] || (oe.expr.match["boolean"].test(n) ? xe : be)), i === t ? r && "get" in r && null !== (o = r.get(e, n)) ? o : (o = oe.find.attr(e, n), null == o ? t : o) : null !== i ? r && "set" in r && (o = r.set(e, i, n)) !== t ? o : (e.setAttribute(n, i + ""), i) : (oe.removeAttr(e, n), t)) : void 0
        },
        removeAttr: function(e, t) {
            var n, i, r = 0,
                o = t && t.match(ae);
            if (o && 1 === e.nodeType)
                for (; n = o[r++];) i = oe.propFix[n] || n, oe.expr.match["boolean"].test(n) && (e[i] = !1), e.removeAttribute(n)
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!oe.support.radioValue && "radio" === t && oe.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        propFix: {
            "for": "htmlFor",
            "class": "className"
        },
        prop: function(e, n, i) {
            var r, o, s, a = e.nodeType;
            return e && 3 !== a && 8 !== a && 2 !== a ? (s = 1 !== a || !oe.isXMLDoc(e), s && (n = oe.propFix[n] || n, o = oe.propHooks[n]), i !== t ? o && "set" in o && (r = o.set(e, i, n)) !== t ? r : e[n] = i : o && "get" in o && null !== (r = o.get(e, n)) ? r : e[n]) : void 0
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    return e.hasAttribute("tabindex") || Se.test(e.nodeName) || e.href ? e.tabIndex : -1
                }
            }
        }
    }), xe = {
        set: function(e, t, n) {
            return t === !1 ? oe.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, oe.each(oe.expr.match["boolean"].source.match(/\w+/g), function(e, n) {
        var i = oe.expr.attrHandle[n] || oe.find.attr;
        oe.expr.attrHandle[n] = function(e, n, r) {
            var o = oe.expr.attrHandle[n],
                s = r ? t : (oe.expr.attrHandle[n] = t) != i(e, n, r) ? n.toLowerCase() : null;
            return oe.expr.attrHandle[n] = o, s
        }
    }), oe.support.optSelected || (oe.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        }
    }), oe.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        oe.propFix[this.toLowerCase()] = this
    }), oe.each(["radio", "checkbox"], function() {
        oe.valHooks[this] = {
            set: function(e, n) {
                return oe.isArray(n) ? e.checked = oe.inArray(oe(e).val(), n) >= 0 : t
            }
        }, oe.support.checkOn || (oe.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    });
    var Te = /^key/,
        Ee = /^(?:mouse|contextmenu)|click/,
        ke = /^(?:focusinfocus|focusoutblur)$/,
        Le = /^([^.]*)(?:\.(.+)|)$/;
    oe.event = {
        global: {},
        add: function(e, n, i, r, o) {
            var s, a, l, c, u, d, p, h, f, g, m, v = me.get(e);
            if (v) {
                for (i.handler && (s = i, i = s.handler, o = s.selector), i.guid || (i.guid = oe.guid++), (c = v.events) || (c = v.events = {}), (a = v.handle) || (a = v.handle = function(e) {
                        return typeof oe === W || e && oe.event.triggered === e.type ? t : oe.event.dispatch.apply(a.elem, arguments)
                    }, a.elem = e), n = (n || "").match(ae) || [""], u = n.length; u--;) l = Le.exec(n[u]) || [], f = m = l[1], g = (l[2] || "").split(".").sort(), f && (p = oe.event.special[f] || {}, f = (o ? p.delegateType : p.bindType) || f, p = oe.event.special[f] || {}, d = oe.extend({
                    type: f,
                    origType: m,
                    data: r,
                    handler: i,
                    guid: i.guid,
                    selector: o,
                    needsContext: o && oe.expr.match.needsContext.test(o),
                    namespace: g.join(".")
                }, s), (h = c[f]) || (h = c[f] = [], h.delegateCount = 0, p.setup && p.setup.call(e, r, g, a) !== !1 || e.addEventListener && e.addEventListener(f, a, !1)), p.add && (p.add.call(e, d), d.handler.guid || (d.handler.guid = i.guid)), o ? h.splice(h.delegateCount++, 0, d) : h.push(d), oe.event.global[f] = !0);
                e = null
            }
        },
        remove: function(e, t, n, i, r) {
            var o, s, a, l, c, u, d, p, h, f, g, m = me.hasData(e) && me.get(e);
            if (m && (l = m.events)) {
                for (t = (t || "").match(ae) || [""], c = t.length; c--;)
                    if (a = Le.exec(t[c]) || [], h = g = a[1], f = (a[2] || "").split(".").sort(), h) {
                        for (d = oe.event.special[h] || {}, h = (i ? d.delegateType : d.bindType) || h, p = l[h] || [], a = a[2] && RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = o = p.length; o--;) u = p[o], !r && g !== u.origType || n && n.guid !== u.guid || a && !a.test(u.namespace) || i && i !== u.selector && ("**" !== i || !u.selector) || (p.splice(o, 1), u.selector && p.delegateCount--, d.remove && d.remove.call(e, u));
                        s && !p.length && (d.teardown && d.teardown.call(e, f, m.handle) !== !1 || oe.removeEvent(e, h, m.handle), delete l[h])
                    } else
                        for (h in l) oe.event.remove(e, h + t[c], n, i, !0);
                oe.isEmptyObject(l) && (delete m.handle, me.remove(e, "events"))
            }
        },
        trigger: function(n, i, r, o) {
            var s, a, l, c, u, d, p, h = [r || U],
                f = ie.call(n, "type") ? n.type : n,
                g = ie.call(n, "namespace") ? n.namespace.split(".") : [];
            if (a = l = r = r || U, 3 !== r.nodeType && 8 !== r.nodeType && !ke.test(f + oe.event.triggered) && (f.indexOf(".") >= 0 && (g = f.split("."), f = g.shift(), g.sort()), u = 0 > f.indexOf(":") && "on" + f, n = n[oe.expando] ? n : new oe.Event(f, "object" == typeof n && n), n.isTrigger = o ? 2 : 3, n.namespace = g.join("."), n.namespace_re = n.namespace ? RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, n.result = t, n.target || (n.target = r), i = null == i ? [n] : oe.makeArray(i, [n]), p = oe.event.special[f] || {}, o || !p.trigger || p.trigger.apply(r, i) !== !1)) {
                if (!o && !p.noBubble && !oe.isWindow(r)) {
                    for (c = p.delegateType || f, ke.test(c + f) || (a = a.parentNode); a; a = a.parentNode) h.push(a), l = a;
                    l === (r.ownerDocument || U) && h.push(l.defaultView || l.parentWindow || e)
                }
                for (s = 0;
                    (a = h[s++]) && !n.isPropagationStopped();) n.type = s > 1 ? c : p.bindType || f, d = (me.get(a, "events") || {})[n.type] && me.get(a, "handle"), d && d.apply(a, i), d = u && a[u], d && oe.acceptData(a) && d.apply && d.apply(a, i) === !1 && n.preventDefault();
                return n.type = f, o || n.isDefaultPrevented() || p._default && p._default.apply(h.pop(), i) !== !1 || !oe.acceptData(r) || u && oe.isFunction(r[f]) && !oe.isWindow(r) && (l = r[u], l && (r[u] = null), oe.event.triggered = f, r[f](), oe.event.triggered = t, l && (r[u] = l)), n.result
            }
        },
        dispatch: function(e) {
            e = oe.event.fix(e);
            var n, i, r, o, s, a = [],
                l = ee.call(arguments),
                c = (me.get(this, "events") || {})[e.type] || [],
                u = oe.event.special[e.type] || {};
            if (l[0] = e, e.delegateTarget = this, !u.preDispatch || u.preDispatch.call(this, e) !== !1) {
                for (a = oe.event.handlers.call(this, e, c), n = 0;
                    (o = a[n++]) && !e.isPropagationStopped();)
                    for (e.currentTarget = o.elem, i = 0;
                        (s = o.handlers[i++]) && !e.isImmediatePropagationStopped();)(!e.namespace_re || e.namespace_re.test(s.namespace)) && (e.handleObj = s, e.data = s.data, r = ((oe.event.special[s.origType] || {}).handle || s.handler).apply(o.elem, l), r !== t && (e.result = r) === !1 && (e.preventDefault(), e.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, e), e.result
            }
        },
        handlers: function(e, n) {
            var i, r, o, s, a = [],
                l = n.delegateCount,
                c = e.target;
            if (l && c.nodeType && (!e.button || "click" !== e.type))
                for (; c !== this; c = c.parentNode || this)
                    if (c.disabled !== !0 || "click" !== e.type) {
                        for (r = [], i = 0; l > i; i++) s = n[i], o = s.selector + " ", r[o] === t && (r[o] = s.needsContext ? oe(o, this).index(c) >= 0 : oe.find(o, this, null, [c]).length), r[o] && r.push(s);
                        r.length && a.push({
                            elem: c,
                            handlers: r
                        })
                    }
            return n.length > l && a.push({
                elem: this,
                handlers: n.slice(l)
            }), a
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "),
            filter: function(e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function(e, n) {
                var i, r, o, s = n.button;
                return null == e.pageX && null != n.clientX && (i = e.target.ownerDocument || U, r = i.documentElement, o = i.body, e.pageX = n.clientX + (r && r.scrollLeft || o && o.scrollLeft || 0) - (r && r.clientLeft || o && o.clientLeft || 0), e.pageY = n.clientY + (r && r.scrollTop || o && o.scrollTop || 0) - (r && r.clientTop || o && o.clientTop || 0)), e.which || s === t || (e.which = 1 & s ? 1 : 2 & s ? 3 : 4 & s ? 2 : 0), e
            }
        },
        fix: function(e) {
            if (e[oe.expando]) return e;
            var t, n, i, r = e.type,
                o = e,
                s = this.fixHooks[r];
            for (s || (this.fixHooks[r] = s = Ee.test(r) ? this.mouseHooks : Te.test(r) ? this.keyHooks : {}), i = s.props ? this.props.concat(s.props) : this.props, e = new oe.Event(o), t = i.length; t--;) n = i[t], e[n] = o[n];
            return 3 === e.target.nodeType && (e.target = e.target.parentNode), s.filter ? s.filter(e, o) : e
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    return this !== l() && this.focus ? (this.focus(), !1) : t
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    return this === l() && this.blur ? (this.blur(), !1) : t
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    return "checkbox" === this.type && this.click && oe.nodeName(this, "input") ? (this.click(), !1) : t
                },
                _default: function(e) {
                    return oe.nodeName(e.target, "a")
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    e.result !== t && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        simulate: function(e, t, n, i) {
            var r = oe.extend(new oe.Event, n, {
                type: e,
                isSimulated: !0,
                originalEvent: {}
            });
            i ? oe.event.trigger(r, null, t) : oe.event.dispatch.call(t, r), r.isDefaultPrevented() && n.preventDefault()
        }
    }, oe.removeEvent = function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    }, oe.Event = function(e, n) {
        return this instanceof oe.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || e.getPreventDefault && e.getPreventDefault() ? s : a) : this.type = e, n && oe.extend(this, n), this.timeStamp = e && e.timeStamp || oe.now(), this[oe.expando] = !0, t) : new oe.Event(e, n)
    }, oe.Event.prototype = {
        isDefaultPrevented: a,
        isPropagationStopped: a,
        isImmediatePropagationStopped: a,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = s, e && e.preventDefault && e.preventDefault()
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = s, e && e.stopPropagation && e.stopPropagation()
        },
        stopImmediatePropagation: function() {
            this.isImmediatePropagationStopped = s, this.stopPropagation()
        }
    }, oe.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout"
    }, function(e, t) {
        oe.event.special[e] = {
            delegateType: t,
            bindType: t,
            handle: function(e) {
                var n, i = this,
                    r = e.relatedTarget,
                    o = e.handleObj;
                return (!r || r !== i && !oe.contains(i, r)) && (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), oe.support.focusinBubbles || oe.each({
        focus: "focusin",
        blur: "focusout"
    }, function(e, t) {
        var n = 0,
            i = function(e) {
                oe.event.simulate(t, e.target, oe.event.fix(e), !0)
            };
        oe.event.special[t] = {
            setup: function() {
                0 === n++ && U.addEventListener(e, i, !0)
            },
            teardown: function() {
                0 === --n && U.removeEventListener(e, i, !0)
            }
        }
    }), oe.fn.extend({
        on: function(e, n, i, r, o) {
            var s, l;
            if ("object" == typeof e) {
                "string" != typeof n && (i = i || n, n = t);
                for (l in e) this.on(l, n, i, e[l], o);
                return this
            }
            if (null == i && null == r ? (r = n, i = n = t) : null == r && ("string" == typeof n ? (r = i, i = t) : (r = i, i = n, n = t)), r === !1) r = a;
            else if (!r) return this;
            return 1 === o && (s = r, r = function(e) {
                return oe().off(e), s.apply(this, arguments)
            }, r.guid = s.guid || (s.guid = oe.guid++)), this.each(function() {
                oe.event.add(this, e, r, i, n)
            })
        },
        one: function(e, t, n, i) {
            return this.on(e, t, n, i, 1)
        },
        off: function(e, n, i) {
            var r, o;
            if (e && e.preventDefault && e.handleObj) return r = e.handleObj, oe(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (o in e) this.off(o, n, e[o]);
                return this
            }
            return (n === !1 || "function" == typeof n) && (i = n, n = t), i === !1 && (i = a), this.each(function() {
                oe.event.remove(this, e, i, n)
            })
        },
        trigger: function(e, t) {
            return this.each(function() {
                oe.event.trigger(e, t, this)
            })
        },
        triggerHandler: function(e, n) {
            var i = this[0];
            return i ? oe.event.trigger(e, n, i, !0) : t
        }
    });
    var $e = /^.[^:#\[\.,]*$/,
        je = oe.expr.match.needsContext,
        Pe = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };
    oe.fn.extend({
        find: function(e) {
            var t, n, i, r = this.length;
            if ("string" != typeof e) return t = this, this.pushStack(oe(e).filter(function() {
                for (i = 0; r > i; i++)
                    if (oe.contains(t[i], this)) return !0
            }));
            for (n = [], i = 0; r > i; i++) oe.find(e, this[i], n);
            return n = this.pushStack(r > 1 ? oe.unique(n) : n), n.selector = (this.selector ? this.selector + " " : "") + e, n
        },
        has: function(e) {
            var t = oe(e, this),
                n = t.length;
            return this.filter(function() {
                for (var e = 0; n > e; e++)
                    if (oe.contains(this, t[e])) return !0
            })
        },
        not: function(e) {
            return this.pushStack(u(this, e || [], !0))
        },
        filter: function(e) {
            return this.pushStack(u(this, e || [], !1))
        },
        is: function(e) {
            return !!e && ("string" == typeof e ? je.test(e) ? oe(e, this.context).index(this[0]) >= 0 : oe.filter(e, this).length > 0 : this.filter(e).length > 0)
        },
        closest: function(e, t) {
            for (var n, i = 0, r = this.length, o = [], s = je.test(e) || "string" != typeof e ? oe(e, t || this.context) : 0; r > i; i++)
                for (n = this[i]; n && n !== t; n = n.parentNode)
                    if (11 > n.nodeType && (s ? s.index(n) > -1 : 1 === n.nodeType && oe.find.matchesSelector(n, e))) {
                        n = o.push(n);
                        break
                    }
            return this.pushStack(o.length > 1 ? oe.unique(o) : o)
        },
        index: function(e) {
            return e ? "string" == typeof e ? te.call(oe(e), this[0]) : te.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(e, t) {
            var n = "string" == typeof e ? oe(e, t) : oe.makeArray(e && e.nodeType ? [e] : e),
                i = oe.merge(this.get(), n);
            return this.pushStack(oe.unique(i))
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), oe.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(e) {
            return oe.dir(e, "parentNode")
        },
        parentsUntil: function(e, t, n) {
            return oe.dir(e, "parentNode", n)
        },
        next: function(e) {
            return c(e, "nextSibling")
        },
        prev: function(e) {
            return c(e, "previousSibling")
        },
        nextAll: function(e) {
            return oe.dir(e, "nextSibling")
        },
        prevAll: function(e) {
            return oe.dir(e, "previousSibling")
        },
        nextUntil: function(e, t, n) {
            return oe.dir(e, "nextSibling", n)
        },
        prevUntil: function(e, t, n) {
            return oe.dir(e, "previousSibling", n)
        },
        siblings: function(e) {
            return oe.sibling((e.parentNode || {}).firstChild, e)
        },
        children: function(e) {
            return oe.sibling(e.firstChild)
        },
        contents: function(e) {
            return oe.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : oe.merge([], e.childNodes)
        }
    }, function(e, t) {
        oe.fn[e] = function(n, i) {
            var r = oe.map(this, t, n);
            return "Until" !== e.slice(-5) && (i = n), i && "string" == typeof i && (r = oe.filter(i, r)), this.length > 1 && (Pe[e] || oe.unique(r), "p" === e[0] && r.reverse()), this.pushStack(r)
        }
    }), oe.extend({
        filter: function(e, t, n) {
            var i = t[0];
            return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? oe.find.matchesSelector(i, e) ? [i] : [] : oe.find.matches(e, oe.grep(t, function(e) {
                return 1 === e.nodeType
            }))
        },
        dir: function(e, n, i) {
            for (var r = [], o = i !== t;
                (e = e[n]) && 9 !== e.nodeType;)
                if (1 === e.nodeType) {
                    if (o && oe(e).is(i)) break;
                    r.push(e)
                }
            return r
        },
        sibling: function(e, t) {
            for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        }
    });
    var Ae = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
        De = /<([\w:]+)/,
        Fe = /<|&#?\w+;/,
        Ne = /<(?:script|style|link)/i,
        Ie = /^(?:checkbox|radio)$/i,
        Me = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Re = /^$|\/(?:java|ecma)script/i,
        Oe = /^true\/(.*)/,
        ze = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
        qe = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            thead: [1, "<table>", "</table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
        };
    qe.optgroup = qe.option, qe.tbody = qe.tfoot = qe.colgroup = qe.caption = qe.col = qe.thead, qe.th = qe.td, oe.fn.extend({
        text: function(e) {
            return oe.access(this, function(e) {
                return e === t ? oe.text(this) : this.empty().append((this[0] && this[0].ownerDocument || U).createTextNode(e))
            }, null, e, arguments.length)
        },
        append: function() {
            return this.domManip(arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = d(this, e);
                    t.appendChild(e)
                }
            })
        },
        prepend: function() {
            return this.domManip(arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = d(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        },
        before: function() {
            return this.domManip(arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        },
        after: function() {
            return this.domManip(arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        },
        remove: function(e, t) {
            for (var n, i = e ? oe.filter(e, this) : this, r = 0; null != (n = i[r]); r++) t || 1 !== n.nodeType || oe.cleanData(m(n)), n.parentNode && (t && oe.contains(n.ownerDocument, n) && f(m(n, "script")), n.parentNode.removeChild(n));
            return this
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (oe.cleanData(m(e, !1)), e.textContent = "");
            return this
        },
        clone: function(e, t) {
            return e = null == e ? !1 : e, t = null == t ? e : t, this.map(function() {
                return oe.clone(this, e, t)
            })
        },
        html: function(e) {
            return oe.access(this, function(e) {
                var n = this[0] || {},
                    i = 0,
                    r = this.length;
                if (e === t && 1 === n.nodeType) return n.innerHTML;
                if ("string" == typeof e && !Ne.test(e) && !qe[(De.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = e.replace(Ae, "<$1></$2>");
                    try {
                        for (; r > i; i++) n = this[i] || {}, 1 === n.nodeType && (oe.cleanData(m(n, !1)), n.innerHTML = e);
                        n = 0
                    } catch (o) {}
                }
                n && this.empty().append(e)
            }, null, e, arguments.length)
        },
        replaceWith: function() {
            var e = oe.map(this, function(e) {
                    return [e.nextSibling, e.parentNode]
                }),
                t = 0;
            return this.domManip(arguments, function(n) {
                var i = e[t++],
                    r = e[t++];
                r && (oe(this).remove(), r.insertBefore(n, i))
            }, !0), t ? this : this.remove()
        },
        detach: function(e) {
            return this.remove(e, !0)
        },
        domManip: function(e, t, n) {
            e = J.apply([], e);
            var i, r, o, s, a, l, c = 0,
                u = this.length,
                d = this,
                f = u - 1,
                g = e[0],
                v = oe.isFunction(g);
            if (v || !(1 >= u || "string" != typeof g || oe.support.checkClone) && Me.test(g)) return this.each(function(i) {
                var r = d.eq(i);
                v && (e[0] = g.call(this, i, r.html())), r.domManip(e, t, n)
            });
            if (u && (i = oe.buildFragment(e, this[0].ownerDocument, !1, !n && this), r = i.firstChild, 1 === i.childNodes.length && (i = r), r)) {
                for (o = oe.map(m(i, "script"), p), s = o.length; u > c; c++) a = i, c !== f && (a = oe.clone(a, !0, !0), s && oe.merge(o, m(a, "script"))), t.call(this[c], a, c);
                if (s)
                    for (l = o[o.length - 1].ownerDocument, oe.map(o, h), c = 0; s > c; c++) a = o[c], Re.test(a.type || "") && !me.access(a, "globalEval") && oe.contains(l, a) && (a.src ? oe._evalUrl(a.src) : oe.globalEval(a.textContent.replace(ze, "")))
            }
            return this
        }
    }), oe.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(e, t) {
        oe.fn[e] = function(e) {
            for (var n, i = [], r = oe(e), o = r.length - 1, s = 0; o >= s; s++) n = s === o ? this : this.clone(!0), oe(r[s])[t](n), K.apply(i, n.get());
            return this.pushStack(i)
        }
    }), oe.extend({
        clone: function(e, t, n) {
            var i, r, o, s, a = e.cloneNode(!0),
                l = oe.contains(e.ownerDocument, e);
            if (!(oe.support.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || oe.isXMLDoc(e)))
                for (s = m(a), o = m(e), i = 0, r = o.length; r > i; i++) v(o[i], s[i]);
            if (t)
                if (n)
                    for (o = o || m(e), s = s || m(a), i = 0, r = o.length; r > i; i++) g(o[i], s[i]);
                else g(e, a);
            return s = m(a, "script"), s.length > 0 && f(s, !l && m(e, "script")), a
        },
        buildFragment: function(e, t, n, i) {
            for (var r, o, s, a, l, c, u = 0, d = e.length, p = t.createDocumentFragment(), h = []; d > u; u++)
                if (r = e[u], r || 0 === r)
                    if ("object" === oe.type(r)) oe.merge(h, r.nodeType ? [r] : r);
                    else if (Fe.test(r)) {
                for (o = o || p.appendChild(t.createElement("div")), s = (De.exec(r) || ["", ""])[1].toLowerCase(), a = qe[s] || qe._default, o.innerHTML = a[1] + r.replace(Ae, "<$1></$2>") + a[2], c = a[0]; c--;) o = o.firstChild;
                oe.merge(h, o.childNodes), o = p.firstChild, o.textContent = ""
            } else h.push(t.createTextNode(r));
            for (p.textContent = "", u = 0; r = h[u++];)
                if ((!i || -1 === oe.inArray(r, i)) && (l = oe.contains(r.ownerDocument, r), o = m(p.appendChild(r), "script"), l && f(o), n))
                    for (c = 0; r = o[c++];) Re.test(r.type || "") && n.push(r);
            return p
        },
        cleanData: function(e) {
            for (var t, n, i, r = e.length, o = 0, s = oe.event.special; r > o; o++) {
                if (n = e[o], oe.acceptData(n) && (t = me.access(n)))
                    for (i in t.events) s[i] ? oe.event.remove(n, i) : oe.removeEvent(n, i, t.handle);
                ge.discard(n), me.discard(n)
            }
        },
        _evalUrl: function(e) {
            return oe.ajax({
                url: e,
                type: "GET",
                dataType: "text",
                async: !1,
                global: !1,
                success: oe.globalEval
            })
        }
    }), oe.fn.extend({
        wrapAll: function(e) {
            var t;
            return oe.isFunction(e) ? this.each(function(t) {
                oe(this).wrapAll(e.call(this, t))
            }) : (this[0] && (t = oe(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            }).append(this)), this)
        },
        wrapInner: function(e) {
            return oe.isFunction(e) ? this.each(function(t) {
                oe(this).wrapInner(e.call(this, t))
            }) : this.each(function() {
                var t = oe(this),
                    n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        },
        wrap: function(e) {
            var t = oe.isFunction(e);
            return this.each(function(n) {
                oe(this).wrapAll(t ? e.call(this, n) : e)
            })
        },
        unwrap: function() {
            return this.parent().each(function() {
                oe.nodeName(this, "body") || oe(this).replaceWith(this.childNodes)
            }).end()
        }
    });
    var He, _e, We = /^(none|table(?!-c[ea]).+)/,
        Be = /^margin/,
        Ue = RegExp("^(" + se + ")(.*)$", "i"),
        Ve = RegExp("^(" + se + ")(?!px)[a-z%]+$", "i"),
        Ye = RegExp("^([+-])=(" + se + ")", "i"),
        Xe = {
            BODY: "block"
        },
        Ze = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        Ge = {
            letterSpacing: 0,
            fontWeight: 400
        },
        Qe = ["Top", "Right", "Bottom", "Left"],
        Je = ["Webkit", "O", "Moz", "ms"];
    oe.fn.extend({
        css: function(e, n) {
            return oe.access(this, function(e, n, i) {
                var r, o, s = {},
                    a = 0;
                if (oe.isArray(n)) {
                    for (r = x(e), o = n.length; o > a; a++) s[n[a]] = oe.css(e, n[a], !1, r);
                    return s
                }
                return i !== t ? oe.style(e, n, i) : oe.css(e, n)
            }, e, n, arguments.length > 1)
        },
        show: function() {
            return w(this, !0)
        },
        hide: function() {
            return w(this)
        },
        toggle: function(e) {
            var t = "boolean" == typeof e;
            return this.each(function() {
                (t ? e : b(this)) ? oe(this).show(): oe(this).hide()
            })
        }
    }), oe.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = He(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {
            "float": "cssFloat"
        },
        style: function(e, n, i, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var o, s, a, l = oe.camelCase(n),
                    c = e.style;
                return n = oe.cssProps[l] || (oe.cssProps[l] = y(c, l)), a = oe.cssHooks[n] || oe.cssHooks[l], i === t ? a && "get" in a && (o = a.get(e, !1, r)) !== t ? o : c[n] : (s = typeof i, "string" === s && (o = Ye.exec(i)) && (i = (o[1] + 1) * o[2] + parseFloat(oe.css(e, n)), s = "number"), null == i || "number" === s && isNaN(i) || ("number" !== s || oe.cssNumber[l] || (i += "px"), oe.support.clearCloneStyle || "" !== i || 0 !== n.indexOf("background") || (c[n] = "inherit"), a && "set" in a && (i = a.set(e, i, r)) === t || (c[n] = i)), t)
            }
        },
        css: function(e, n, i, r) {
            var o, s, a, l = oe.camelCase(n);
            return n = oe.cssProps[l] || (oe.cssProps[l] = y(e.style, l)), a = oe.cssHooks[n] || oe.cssHooks[l], a && "get" in a && (o = a.get(e, !0, i)), o === t && (o = He(e, n, r)), "normal" === o && n in Ge && (o = Ge[n]), "" === i || i ? (s = parseFloat(o), i === !0 || oe.isNumeric(s) ? s || 0 : o) : o
        }
    }), He = function(e, n, i) {
        var r, o, s, a = i || x(e),
            l = a ? a.getPropertyValue(n) || a[n] : t,
            c = e.style;
        return a && ("" !== l || oe.contains(e.ownerDocument, e) || (l = oe.style(e, n)), Ve.test(l) && Be.test(n) && (r = c.width, o = c.minWidth, s = c.maxWidth, c.minWidth = c.maxWidth = c.width = l, l = a.width, c.width = r, c.minWidth = o, c.maxWidth = s)), l
    }, oe.each(["height", "width"], function(e, n) {
        oe.cssHooks[n] = {
            get: function(e, i, r) {
                return i ? 0 === e.offsetWidth && We.test(oe.css(e, "display")) ? oe.swap(e, Ze, function() {
                    return T(e, n, r)
                }) : T(e, n, r) : t
            },
            set: function(e, t, i) {
                var r = i && x(e);
                return C(e, t, i ? S(e, n, i, oe.support.boxSizing && "border-box" === oe.css(e, "boxSizing", !1, r), r) : 0)
            }
        }
    }), oe(function() {
        oe.support.reliableMarginRight || (oe.cssHooks.marginRight = {
            get: function(e, n) {
                return n ? oe.swap(e, {
                    display: "inline-block"
                }, He, [e, "marginRight"]) : t
            }
        }), !oe.support.pixelPosition && oe.fn.position && oe.each(["top", "left"], function(e, n) {
            oe.cssHooks[n] = {
                get: function(e, i) {
                    return i ? (i = He(e, n), Ve.test(i) ? oe(e).position()[n] + "px" : i) : t
                }
            }
        })
    }), oe.expr && oe.expr.filters && (oe.expr.filters.hidden = function(e) {
        return 0 >= e.offsetWidth && 0 >= e.offsetHeight
    }, oe.expr.filters.visible = function(e) {
        return !oe.expr.filters.hidden(e)
    }), oe.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(e, t) {
        oe.cssHooks[e + t] = {
            expand: function(n) {
                for (var i = 0, r = {}, o = "string" == typeof n ? n.split(" ") : [n]; 4 > i; i++) r[e + Qe[i] + t] = o[i] || o[i - 2] || o[0];
                return r
            }
        }, Be.test(e) || (oe.cssHooks[e + t].set = C)
    });
    var Ke = /%20/g,
        et = /\[\]$/,
        tt = /\r?\n/g,
        nt = /^(?:submit|button|image|reset|file)$/i,
        it = /^(?:input|select|textarea|keygen)/i;
    oe.fn.extend({
        serialize: function() {
            return oe.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var e = oe.prop(this, "elements");
                return e ? oe.makeArray(e) : this
            }).filter(function() {
                var e = this.type;
                return this.name && !oe(this).is(":disabled") && it.test(this.nodeName) && !nt.test(e) && (this.checked || !Ie.test(e))
            }).map(function(e, t) {
                var n = oe(this).val();
                return null == n ? null : oe.isArray(n) ? oe.map(n, function(e) {
                    return {
                        name: t.name,
                        value: e.replace(tt, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: n.replace(tt, "\r\n")
                }
            }).get()
        }
    }), oe.param = function(e, n) {
        var i, r = [],
            o = function(e, t) {
                t = oe.isFunction(t) ? t() : null == t ? "" : t, r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
            };
        if (n === t && (n = oe.ajaxSettings && oe.ajaxSettings.traditional), oe.isArray(e) || e.jquery && !oe.isPlainObject(e)) oe.each(e, function() {
            o(this.name, this.value)
        });
        else
            for (i in e) L(i, e[i], n, o);
        return r.join("&").replace(Ke, "+")
    }, oe.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(e, t) {
        oe.fn[t] = function(e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), oe.fn.extend({
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        },
        bind: function(e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function(e, t) {
            return this.off(e, null, t)
        },
        delegate: function(e, t, n, i) {
            return this.on(t, e, n, i)
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }
    });
    var rt, ot, st = oe.now(),
        at = /\?/,
        lt = /#.*$/,
        ct = /([?&])_=[^&]*/,
        ut = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        dt = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
        pt = /^(?:GET|HEAD)$/,
        ht = /^\/\//,
        ft = /^([\w.+-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,
        gt = oe.fn.load,
        mt = {},
        vt = {},
        yt = "*/".concat("*");
    try {
        ot = B.href
    } catch (bt) {
        ot = U.createElement("a"), ot.href = "", ot = ot.href
    }
    rt = ft.exec(ot.toLowerCase()) || [], oe.fn.load = function(e, n, i) {
        if ("string" != typeof e && gt) return gt.apply(this, arguments);
        var r, o, s, a = this,
            l = e.indexOf(" ");
        return l >= 0 && (r = e.slice(l), e = e.slice(0, l)), oe.isFunction(n) ? (i = n, n = t) : n && "object" == typeof n && (o = "POST"), a.length > 0 && oe.ajax({
            url: e,
            type: o,
            dataType: "html",
            data: n
        }).done(function(e) {
            s = arguments, a.html(r ? oe("<div>").append(oe.parseHTML(e)).find(r) : e)
        }).complete(i && function(e, t) {
            a.each(i, s || [e.responseText, t, e])
        }), this
    }, oe.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
        oe.fn[t] = function(e) {
            return this.on(t, e)
        }
    }), oe.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: ot,
            type: "GET",
            isLocal: dt.test(rt[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": yt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /xml/,
                html: /html/,
                json: /json/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": oe.parseJSON,
                "text xml": oe.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? P(P(e, oe.ajaxSettings), t) : P(oe.ajaxSettings, e)
        },
        ajaxPrefilter: $(mt),
        ajaxTransport: $(vt),
        ajax: function(e, n) {
            function i(e, n, i, a) {
                var c, d, y, b, w, S = n;
                2 !== x && (x = 2, l && clearTimeout(l), r = t, s = a || "", C.readyState = e > 0 ? 4 : 0, c = e >= 200 && 300 > e || 304 === e, i && (b = A(p, C, i)), b = D(p, b, C, c), c ? (p.ifModified && (w = C.getResponseHeader("Last-Modified"), w && (oe.lastModified[o] = w), w = C.getResponseHeader("etag"), w && (oe.etag[o] = w)), 204 === e ? S = "nocontent" : 304 === e ? S = "notmodified" : (S = b.state, d = b.data, y = b.error, c = !y)) : (y = S, (e || !S) && (S = "error", 0 > e && (e = 0))), C.status = e, C.statusText = (n || S) + "", c ? g.resolveWith(h, [d, S, C]) : g.rejectWith(h, [C, S, y]), C.statusCode(v), v = t, u && f.trigger(c ? "ajaxSuccess" : "ajaxError", [C, p, c ? d : y]), m.fireWith(h, [C, S]), u && (f.trigger("ajaxComplete", [C, p]), --oe.active || oe.event.trigger("ajaxStop")))
            }
            "object" == typeof e && (n = e, e = t), n = n || {};
            var r, o, s, a, l, c, u, d, p = oe.ajaxSetup({}, n),
                h = p.context || p,
                f = p.context && (h.nodeType || h.jquery) ? oe(h) : oe.event,
                g = oe.Deferred(),
                m = oe.Callbacks("once memory"),
                v = p.statusCode || {},
                y = {},
                b = {},
                x = 0,
                w = "canceled",
                C = {
                    readyState: 0,
                    getResponseHeader: function(e) {
                        var t;
                        if (2 === x) {
                            if (!a)
                                for (a = {}; t = ut.exec(s);) a[t[1].toLowerCase()] = t[2];
                            t = a[e.toLowerCase()]
                        }
                        return null == t ? null : t
                    },
                    getAllResponseHeaders: function() {
                        return 2 === x ? s : null
                    },
                    setRequestHeader: function(e, t) {
                        var n = e.toLowerCase();
                        return x || (e = b[n] = b[n] || e, y[e] = t), this
                    },
                    overrideMimeType: function(e) {
                        return x || (p.mimeType = e), this
                    },
                    statusCode: function(e) {
                        var t;
                        if (e)
                            if (2 > x)
                                for (t in e) v[t] = [v[t], e[t]];
                            else C.always(e[C.status]);
                        return this
                    },
                    abort: function(e) {
                        var t = e || w;
                        return r && r.abort(t), i(0, t), this
                    }
                };
            if (g.promise(C).complete = m.add, C.success = C.done, C.error = C.fail, p.url = ((e || p.url || ot) + "").replace(lt, "").replace(ht, rt[1] + "//"), p.type = n.method || n.type || p.method || p.type, p.dataTypes = oe.trim(p.dataType || "*").toLowerCase().match(ae) || [""], null == p.crossDomain && (c = ft.exec(p.url.toLowerCase()), p.crossDomain = !(!c || c[1] === rt[1] && c[2] === rt[2] && (c[3] || ("http:" === c[1] ? "80" : "443")) === (rt[3] || ("http:" === rt[1] ? "80" : "443")))), p.data && p.processData && "string" != typeof p.data && (p.data = oe.param(p.data, p.traditional)), j(mt, p, n, C), 2 === x) return C;
            u = p.global, u && 0 === oe.active++ && oe.event.trigger("ajaxStart"), p.type = p.type.toUpperCase(), p.hasContent = !pt.test(p.type), o = p.url, p.hasContent || (p.data && (o = p.url += (at.test(o) ? "&" : "?") + p.data, delete p.data), p.cache === !1 && (p.url = ct.test(o) ? o.replace(ct, "$1_=" + st++) : o + (at.test(o) ? "&" : "?") + "_=" + st++)), p.ifModified && (oe.lastModified[o] && C.setRequestHeader("If-Modified-Since", oe.lastModified[o]), oe.etag[o] && C.setRequestHeader("If-None-Match", oe.etag[o])), (p.data && p.hasContent && p.contentType !== !1 || n.contentType) && C.setRequestHeader("Content-Type", p.contentType), C.setRequestHeader("Accept", p.dataTypes[0] && p.accepts[p.dataTypes[0]] ? p.accepts[p.dataTypes[0]] + ("*" !== p.dataTypes[0] ? ", " + yt + "; q=0.01" : "") : p.accepts["*"]);
            for (d in p.headers) C.setRequestHeader(d, p.headers[d]);
            if (p.beforeSend && (p.beforeSend.call(h, C, p) === !1 || 2 === x)) return C.abort();
            w = "abort";
            for (d in {
                    success: 1,
                    error: 1,
                    complete: 1
                }) C[d](p[d]);
            if (r = j(vt, p, n, C)) {
                C.readyState = 1, u && f.trigger("ajaxSend", [C, p]), p.async && p.timeout > 0 && (l = setTimeout(function() {
                    C.abort("timeout")
                }, p.timeout));
                try {
                    x = 1, r.send(y, i)
                } catch (S) {
                    if (!(2 > x)) throw S;
                    i(-1, S)
                }
            } else i(-1, "No Transport");
            return C
        },
        getJSON: function(e, t, n) {
            return oe.get(e, t, n, "json")
        },
        getScript: function(e, n) {
            return oe.get(e, t, n, "script")
        }
    }), oe.each(["get", "post"], function(e, n) {
        oe[n] = function(e, i, r, o) {
            return oe.isFunction(i) && (o = o || r, r = i, i = t), oe.ajax({
                url: e,
                type: n,
                dataType: o,
                data: i,
                success: r
            })
        }
    }), oe.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /(?:java|ecma)script/
        },
        converters: {
            "text script": function(e) {
                return oe.globalEval(e), e
            }
        }
    }), oe.ajaxPrefilter("script", function(e) {
        e.cache === t && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), oe.ajaxTransport("script", function(e) {
        if (e.crossDomain) {
            var t, n;
            return {
                send: function(i, r) {
                    t = oe("<script>").prop({
                        async: !0,
                        charset: e.scriptCharset,
                        src: e.url
                    }).on("load error", n = function(e) {
                        t.remove(), n = null, e && r("error" === e.type ? 404 : 200, e.type)
                    }), U.head.appendChild(t[0])
                },
                abort: function() {
                    n && n()
                }
            }
        }
    });
    var xt = [],
        wt = /(=)\?(?=&|$)|\?\?/;
    oe.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = xt.pop() || oe.expando + "_" + st++;
            return this[e] = !0, e
        }
    }), oe.ajaxPrefilter("json jsonp", function(n, i, r) {
        var o, s, a, l = n.jsonp !== !1 && (wt.test(n.url) ? "url" : "string" == typeof n.data && !(n.contentType || "").indexOf("application/x-www-form-urlencoded") && wt.test(n.data) && "data");
        return l || "jsonp" === n.dataTypes[0] ? (o = n.jsonpCallback = oe.isFunction(n.jsonpCallback) ? n.jsonpCallback() : n.jsonpCallback, l ? n[l] = n[l].replace(wt, "$1" + o) : n.jsonp !== !1 && (n.url += (at.test(n.url) ? "&" : "?") + n.jsonp + "=" + o), n.converters["script json"] = function() {
            return a || oe.error(o + " was not called"), a[0]
        }, n.dataTypes[0] = "json", s = e[o], e[o] = function() {
            a = arguments
        }, r.always(function() {
            e[o] = s, n[o] && (n.jsonpCallback = i.jsonpCallback, xt.push(o)), a && oe.isFunction(s) && s(a[0]), a = s = t
        }), "script") : t
    }), oe.ajaxSettings.xhr = function() {
        try {
            return new XMLHttpRequest
        } catch (e) {}
    };
    var Ct = oe.ajaxSettings.xhr(),
        St = {
            0: 200,
            1223: 204
        },
        Tt = 0,
        Et = {};
    e.ActiveXObject && oe(e).on("unload", function() {
        for (var e in Et) Et[e]();
        Et = t
    }), oe.support.cors = !!Ct && "withCredentials" in Ct, oe.support.ajax = Ct = !!Ct, oe.ajaxTransport(function(e) {
        var n;
        return oe.support.cors || Ct && !e.crossDomain ? {
            send: function(i, r) {
                var o, s, a = e.xhr();
                if (a.open(e.type, e.url, e.async, e.username, e.password), e.xhrFields)
                    for (o in e.xhrFields) a[o] = e.xhrFields[o];
                e.mimeType && a.overrideMimeType && a.overrideMimeType(e.mimeType), e.crossDomain || i["X-Requested-With"] || (i["X-Requested-With"] = "XMLHttpRequest");
                for (o in i) a.setRequestHeader(o, i[o]);
                n = function(e) {
                    return function() {
                        n && (delete Et[s], n = a.onload = a.onerror = null, "abort" === e ? a.abort() : "error" === e ? r(a.status || 404, a.statusText) : r(St[a.status] || a.status, a.statusText, "string" == typeof a.responseText ? {
                            text: a.responseText
                        } : t, a.getAllResponseHeaders()))
                    }
                }, a.onload = n(), a.onerror = n("error"), n = Et[s = Tt++] = n("abort"), a.send(e.hasContent && e.data || null)
            },
            abort: function() {
                n && n()
            }
        } : t
    });
    var kt, Lt, $t = /^(?:toggle|show|hide)$/,
        jt = RegExp("^(?:([+-])=|)(" + se + ")([a-z%]*)$", "i"),
        Pt = /queueHooks$/,
        At = [R],
        Dt = {
            "*": [function(e, t) {
                var n, i, r = this.createTween(e, t),
                    o = jt.exec(t),
                    s = r.cur(),
                    a = +s || 0,
                    l = 1,
                    c = 20;
                if (o) {
                    if (n = +o[2], i = o[3] || (oe.cssNumber[e] ? "" : "px"), "px" !== i && a) {
                        a = oe.css(r.elem, e, !0) || n || 1;
                        do l = l || ".5", a /= l, oe.style(r.elem, e, a + i); while (l !== (l = r.cur() / s) && 1 !== l && --c)
                    }
                    r.unit = i, r.start = a, r.end = o[1] ? a + (o[1] + 1) * n : n
                }
                return r
            }]
        };
    oe.Animation = oe.extend(I, {
        tweener: function(e, t) {
            oe.isFunction(e) ? (t = e, e = ["*"]) : e = e.split(" ");
            for (var n, i = 0, r = e.length; r > i; i++) n = e[i], Dt[n] = Dt[n] || [], Dt[n].unshift(t)
        },
        prefilter: function(e, t) {
            t ? At.unshift(e) : At.push(e)
        }
    }), oe.Tween = O, O.prototype = {
        constructor: O,
        init: function(e, t, n, i, r, o) {
            this.elem = e, this.prop = n, this.easing = r || "swing", this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = o || (oe.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var e = O.propHooks[this.prop];
            return e && e.get ? e.get(this) : O.propHooks._default.get(this)
        },
        run: function(e) {
            var t, n = O.propHooks[this.prop];
            return this.pos = t = this.options.duration ? oe.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : O.propHooks._default.set(this), this
        }
    }, O.prototype.init.prototype = O.prototype, O.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return null == e.elem[e.prop] || e.elem.style && null != e.elem.style[e.prop] ? (t = oe.css(e.elem, e.prop, ""), t && "auto" !== t ? t : 0) : e.elem[e.prop]
            },
            set: function(e) {
                oe.fx.step[e.prop] ? oe.fx.step[e.prop](e) : e.elem.style && (null != e.elem.style[oe.cssProps[e.prop]] || oe.cssHooks[e.prop]) ? oe.style(e.elem, e.prop, e.now + e.unit) : e.elem[e.prop] = e.now
            }
        }
    }, O.propHooks.scrollTop = O.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, oe.each(["toggle", "show", "hide"], function(e, t) {
        var n = oe.fn[t];
        oe.fn[t] = function(e, i, r) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(z(t, !0), e, i, r)
        }
    }), oe.fn.extend({
        fadeTo: function(e, t, n, i) {
            return this.filter(b).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, i)
        },
        animate: function(e, t, n, i) {
            var r = oe.isEmptyObject(e),
                o = oe.speed(t, n, i),
                s = function() {
                    var t = I(this, oe.extend({}, e), o);
                    s.finish = function() {
                        t.stop(!0)
                    }, (r || me.get(this, "finish")) && t.stop(!0)
                };
            return s.finish = s, r || o.queue === !1 ? this.each(s) : this.queue(o.queue, s)
        },
        stop: function(e, n, i) {
            var r = function(e) {
                var t = e.stop;
                delete e.stop, t(i)
            };
            return "string" != typeof e && (i = n, n = e, e = t), n && e !== !1 && this.queue(e || "fx", []), this.each(function() {
                var t = !0,
                    n = null != e && e + "queueHooks",
                    o = oe.timers,
                    s = me.get(this);
                if (n) s[n] && s[n].stop && r(s[n]);
                else
                    for (n in s) s[n] && s[n].stop && Pt.test(n) && r(s[n]);
                for (n = o.length; n--;) o[n].elem !== this || null != e && o[n].queue !== e || (o[n].anim.stop(i), t = !1, o.splice(n, 1));
                (t || !i) && oe.dequeue(this, e)
            })
        },
        finish: function(e) {
            return e !== !1 && (e = e || "fx"), this.each(function() {
                var t, n = me.get(this),
                    i = n[e + "queue"],
                    r = n[e + "queueHooks"],
                    o = oe.timers,
                    s = i ? i.length : 0;
                for (n.finish = !0, oe.queue(this, e, []), r && r.cur && r.cur.finish && r.cur.finish.call(this), t = o.length; t--;) o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; s > t; t++) i[t] && i[t].finish && i[t].finish.call(this);
                delete n.finish
            })
        }
    }), oe.each({
        slideDown: z("show"),
        slideUp: z("hide"),
        slideToggle: z("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(e, t) {
        oe.fn[e] = function(e, n, i) {
            return this.animate(t, e, n, i)
        }
    }), oe.speed = function(e, t, n) {
        var i = e && "object" == typeof e ? oe.extend({}, e) : {
            complete: n || !n && t || oe.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !oe.isFunction(t) && t
        };
        return i.duration = oe.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in oe.fx.speeds ? oe.fx.speeds[i.duration] : oe.fx.speeds._default, (null == i.queue || i.queue === !0) && (i.queue = "fx"), i.old = i.complete, i.complete = function() {
            oe.isFunction(i.old) && i.old.call(this), i.queue && oe.dequeue(this, i.queue)
        }, i
    }, oe.easing = {
        linear: function(e) {
            return e
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }
    }, oe.timers = [], oe.fx = O.prototype.init, oe.fx.tick = function() {
        var e, n = oe.timers,
            i = 0;
        for (kt = oe.now(); n.length > i; i++) e = n[i], e() || n[i] !== e || n.splice(i--, 1);
        n.length || oe.fx.stop(), kt = t
    }, oe.fx.timer = function(e) {
        e() && oe.timers.push(e) && oe.fx.start()
    }, oe.fx.interval = 13, oe.fx.start = function() {
        Lt || (Lt = setInterval(oe.fx.tick, oe.fx.interval))
    }, oe.fx.stop = function() {
        clearInterval(Lt), Lt = null
    }, oe.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, oe.fx.step = {}, oe.expr && oe.expr.filters && (oe.expr.filters.animated = function(e) {
        return oe.grep(oe.timers, function(t) {
            return e === t.elem
        }).length
    }), oe.fn.offset = function(e) {
        if (arguments.length) return e === t ? this : this.each(function(t) {
            oe.offset.setOffset(this, e, t)
        });
        var n, i, r = this[0],
            o = {
                top: 0,
                left: 0
            },
            s = r && r.ownerDocument;
        return s ? (n = s.documentElement, oe.contains(n, r) ? (typeof r.getBoundingClientRect !== W && (o = r.getBoundingClientRect()), i = q(s), {
            top: o.top + i.pageYOffset - n.clientTop,
            left: o.left + i.pageXOffset - n.clientLeft
        }) : o) : void 0
    }, oe.offset = {
        setOffset: function(e, t, n) {
            var i, r, o, s, a, l, c, u = oe.css(e, "position"),
                d = oe(e),
                p = {};
            "static" === u && (e.style.position = "relative"), a = d.offset(), o = oe.css(e, "top"), l = oe.css(e, "left"), c = ("absolute" === u || "fixed" === u) && (o + l).indexOf("auto") > -1, c ? (i = d.position(), s = i.top, r = i.left) : (s = parseFloat(o) || 0, r = parseFloat(l) || 0), oe.isFunction(t) && (t = t.call(e, n, a)), null != t.top && (p.top = t.top - a.top + s), null != t.left && (p.left = t.left - a.left + r), "using" in t ? t.using.call(e, p) : d.css(p)
        }
    }, oe.fn.extend({
        position: function() {
            if (this[0]) {
                var e, t, n = this[0],
                    i = {
                        top: 0,
                        left: 0
                    };
                return "fixed" === oe.css(n, "position") ? t = n.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), oe.nodeName(e[0], "html") || (i = e.offset()), i.top += oe.css(e[0], "borderTopWidth", !0), i.left += oe.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - i.top - oe.css(n, "marginTop", !0),
                    left: t.left - i.left - oe.css(n, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var e = this.offsetParent || V; e && !oe.nodeName(e, "html") && "static" === oe.css(e, "position");) e = e.offsetParent;
                return e || V
            })
        }
    }), oe.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(n, i) {
        var r = "pageYOffset" === i;
        oe.fn[n] = function(o) {
            return oe.access(this, function(n, o, s) {
                var a = q(n);
                return s === t ? a ? a[i] : n[o] : (a ? a.scrollTo(r ? e.pageXOffset : s, r ? s : e.pageYOffset) : n[o] = s, t)
            }, n, o, arguments.length, null)
        }
    }), oe.each({
        Height: "height",
        Width: "width"
    }, function(e, n) {
        oe.each({
            padding: "inner" + e,
            content: n,
            "": "outer" + e
        }, function(i, r) {
            oe.fn[r] = function(r, o) {
                var s = arguments.length && (i || "boolean" != typeof r),
                    a = i || (r === !0 || o === !0 ? "margin" : "border");
                return oe.access(this, function(n, i, r) {
                    var o;
                    return oe.isWindow(n) ? n.document.documentElement["client" + e] : 9 === n.nodeType ? (o = n.documentElement, Math.max(n.body["scroll" + e], o["scroll" + e], n.body["offset" + e], o["offset" + e], o["client" + e])) : r === t ? oe.css(n, i, a) : oe.style(n, i, r, a)
                }, n, s ? r : t, s, null)
            }
        })
    }), oe.fn.size = function() {
        return this.length
    }, oe.fn.andSelf = oe.fn.addBack, "object" == typeof module && "object" == typeof module.exports ? module.exports = oe : "function" == typeof define && define.amd && define("jquery", [], function() {
        return oe
    }), "object" == typeof e && "object" == typeof e.document && (e.jQuery = e.$ = oe)
}(window),
function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e("object" == typeof exports ? require("jquery") : jQuery)
}(function(e) {
    function t(e) {
        return a.raw ? e : encodeURIComponent(e)
    }

    function n(e) {
        return a.raw ? e : decodeURIComponent(e)
    }

    function i(e) {
        return t(a.json ? JSON.stringify(e) : String(e))
    }

    function r(e) {
        0 === e.indexOf('"') && (e = e.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return e = decodeURIComponent(e.replace(s, " ")), a.json ? JSON.parse(e) : e
        } catch (t) {}
    }

    function o(t, n) {
        var i = a.raw ? t : r(t);
        return e.isFunction(n) ? n(i) : i
    }
    var s = /\+/g,
        a = e.cookie = function(r, s, l) {
            if (void 0 !== s && !e.isFunction(s)) {
                if (l = e.extend({}, a.defaults, l), "number" == typeof l.expires) {
                    var c = l.expires,
                        u = l.expires = new Date;
                    u.setTime(+u + 864e5 * c)
                }
                return document.cookie = [t(r), "=", i(s), l.expires ? "; expires=" + l.expires.toUTCString() : "", l.path ? "; path=" + l.path : "", l.domain ? "; domain=" + l.domain : "", l.secure ? "; secure" : ""].join("")
            }
            for (var d = r ? void 0 : {}, p = document.cookie ? document.cookie.split("; ") : [], h = 0, f = p.length; f > h; h++) {
                var g = p[h].split("="),
                    m = n(g.shift()),
                    v = g.join("=");
                if (r && r === m) {
                    d = o(v, s);
                    break
                }
                r || void 0 === (v = o(v)) || (d[m] = v)
            }
            return d
        };
    a.defaults = {}, e.removeCookie = function(t, n) {
        return void 0 === e.cookie(t) ? !1 : (e.cookie(t, "", e.extend({}, n, {
            expires: -1
        })), !e.cookie(t))
    }
}),
function(e, t) {
    "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? module.exports = t() : e.Handlebars = e.Handlebars || t()
}(this, function() {
    var e = function() {
            "use strict";

            function e(e) {
                this.string = e
            }
            var t;
            return e.prototype.toString = function() {
                return "" + this.string
            }, t = e
        }(),
        t = function(e) {
            "use strict";

            function t(e) {
                return l[e]
            }

            function n(e) {
                for (var t = 1; t < arguments.length; t++)
                    for (var n in arguments[t]) Object.prototype.hasOwnProperty.call(arguments[t], n) && (e[n] = arguments[t][n]);
                return e
            }

            function i(e) {
                return e instanceof a ? e.toString() : null == e ? "" : e ? (e = "" + e, u.test(e) ? e.replace(c, t) : e) : e + ""
            }

            function r(e) {
                return e || 0 === e ? !(!h(e) || 0 !== e.length) : !0
            }

            function o(e, t) {
                return (e ? e + "." : "") + t
            }
            var s = {},
                a = e,
                l = {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#x27;",
                    "`": "&#x60;"
                },
                c = /[&<>"'`]/g,
                u = /[&<>"'`]/;
            s.extend = n;
            var d = Object.prototype.toString;
            s.toString = d;
            var p = function(e) {
                return "function" == typeof e
            };
            p(/x/) && (p = function(e) {
                return "function" == typeof e && "[object Function]" === d.call(e)
            });
            var p;
            s.isFunction = p;
            var h = Array.isArray || function(e) {
                return e && "object" == typeof e ? "[object Array]" === d.call(e) : !1
            };
            return s.isArray = h, s.escapeExpression = i, s.isEmpty = r, s.appendContextPath = o, s
        }(e),
        n = function() {
            "use strict";

            function e(e, t) {
                var i;
                t && t.firstLine && (i = t.firstLine, e += " - " + i + ":" + t.firstColumn);
                for (var r = Error.prototype.constructor.call(this, e), o = 0; o < n.length; o++) this[n[o]] = r[n[o]];
                i && (this.lineNumber = i, this.column = t.firstColumn)
            }
            var t, n = ["description", "fileName", "lineNumber", "message", "name", "number", "stack"];
            return e.prototype = new Error, t = e
        }(),
        i = function(e, t) {
            "use strict";

            function n(e, t) {
                this.helpers = e || {}, this.partials = t || {}, i(this)
            }

            function i(e) {
                e.registerHelper("helperMissing", function() {
                    if (1 !== arguments.length) throw new s("Missing helper: '" + arguments[arguments.length - 1].name + "'")
                }), e.registerHelper("blockHelperMissing", function(t, n) {
                    var i = n.inverse,
                        r = n.fn;
                    if (t === !0) return r(this);
                    if (t === !1 || null == t) return i(this);
                    if (u(t)) return t.length > 0 ? (n.ids && (n.ids = [n.name]), e.helpers.each(t, n)) : i(this);
                    if (n.data && n.ids) {
                        var s = m(n.data);
                        s.contextPath = o.appendContextPath(n.data.contextPath, n.name), n = {
                            data: s
                        }
                    }
                    return r(t, n)
                }), e.registerHelper("each", function(e, t) {
                    if (!t) throw new s("Must pass iterator to #each");
                    var n, i, r = t.fn,
                        a = t.inverse,
                        l = 0,
                        c = "";
                    if (t.data && t.ids && (i = o.appendContextPath(t.data.contextPath, t.ids[0]) + "."), d(e) && (e = e.call(this)), t.data && (n = m(t.data)), e && "object" == typeof e)
                        if (u(e))
                            for (var p = e.length; p > l; l++) n && (n.index = l, n.first = 0 === l, n.last = l === e.length - 1, i && (n.contextPath = i + l)), c += r(e[l], {
                                data: n
                            });
                        else
                            for (var h in e) e.hasOwnProperty(h) && (n && (n.key = h, n.index = l, n.first = 0 === l, i && (n.contextPath = i + h)), c += r(e[h], {
                                data: n
                            }), l++);
                    return 0 === l && (c = a(this)), c
                }), e.registerHelper("if", function(e, t) {
                    return d(e) && (e = e.call(this)), !t.hash.includeZero && !e || o.isEmpty(e) ? t.inverse(this) : t.fn(this)
                }), e.registerHelper("unless", function(t, n) {
                    return e.helpers["if"].call(this, t, {
                        fn: n.inverse,
                        inverse: n.fn,
                        hash: n.hash
                    })
                }), e.registerHelper("with", function(e, t) {
                    d(e) && (e = e.call(this));
                    var n = t.fn;
                    if (o.isEmpty(e)) return t.inverse(this);
                    if (t.data && t.ids) {
                        var i = m(t.data);
                        i.contextPath = o.appendContextPath(t.data.contextPath, t.ids[0]), t = {
                            data: i
                        }
                    }
                    return n(e, t)
                }), e.registerHelper("log", function(t, n) {
                    var i = n.data && null != n.data.level ? parseInt(n.data.level, 10) : 1;
                    e.log(i, t)
                }), e.registerHelper("lookup", function(e, t) {
                    return e && e[t]
                })
            }
            var r = {},
                o = e,
                s = t,
                a = "2.0.0";
            r.VERSION = a;
            var l = 6;
            r.COMPILER_REVISION = l;
            var c = {
                1: "<= 1.0.rc.2",
                2: "== 1.0.0-rc.3",
                3: "== 1.0.0-rc.4",
                4: "== 1.x.x",
                5: "== 2.0.0-alpha.x",
                6: ">= 2.0.0-beta.1"
            };
            r.REVISION_CHANGES = c;
            var u = o.isArray,
                d = o.isFunction,
                p = o.toString,
                h = "[object Object]";
            r.HandlebarsEnvironment = n, n.prototype = {
                constructor: n,
                logger: f,
                log: g,
                registerHelper: function(e, t) {
                    if (p.call(e) === h) {
                        if (t) throw new s("Arg not supported with multiple helpers");
                        o.extend(this.helpers, e)
                    } else this.helpers[e] = t
                },
                unregisterHelper: function(e) {
                    delete this.helpers[e]
                },
                registerPartial: function(e, t) {
                    p.call(e) === h ? o.extend(this.partials, e) : this.partials[e] = t
                },
                unregisterPartial: function(e) {
                    delete this.partials[e]
                }
            };
            var f = {
                methodMap: {
                    0: "debug",
                    1: "info",
                    2: "warn",
                    3: "error"
                },
                DEBUG: 0,
                INFO: 1,
                WARN: 2,
                ERROR: 3,
                level: 3,
                log: function(e, t) {
                    if (f.level <= e) {
                        var n = f.methodMap[e];
                        "undefined" != typeof console && console[n] && console[n].call(console, t)
                    }
                }
            };
            r.logger = f;
            var g = f.log;
            r.log = g;
            var m = function(e) {
                var t = o.extend({}, e);
                return t._parent = e, t
            };
            return r.createFrame = m, r
        }(t, n),
        r = function(e, t, n) {
            "use strict";

            function i(e) {
                var t = e && e[0] || 1,
                    n = p;
                if (t !== n) {
                    if (n > t) {
                        var i = h[n],
                            r = h[t];
                        throw new d("Template was precompiled with an older version of Handlebars than the current runtime. Please update your precompiler to a newer version (" + i + ") or downgrade your runtime to an older version (" + r + ").")
                    }
                    throw new d("Template was precompiled with a newer version of Handlebars than the current runtime. Please update your runtime to a newer version (" + e[1] + ").")
                }
            }

            function r(e, t) {
                if (!t) throw new d("No environment passed to template");
                if (!e || !e.main) throw new d("Unknown template object: " + typeof e);
                t.VM.checkRevision(e.compiler);
                var n = function(n, i, r, o, s, a, l, c, p) {
                        s && (o = u.extend({}, o, s));
                        var h = t.VM.invokePartial.call(this, n, r, o, a, l, c, p);
                        if (null == h && t.compile) {
                            var f = {
                                helpers: a,
                                partials: l,
                                data: c,
                                depths: p
                            };
                            l[r] = t.compile(n, {
                                data: void 0 !== c,
                                compat: e.compat
                            }, t), h = l[r](o, f)
                        }
                        if (null != h) {
                            if (i) {
                                for (var g = h.split("\n"), m = 0, v = g.length; v > m && (g[m] || m + 1 !== v); m++) g[m] = i + g[m];
                                h = g.join("\n")
                            }
                            return h
                        }
                        throw new d("The partial " + r + " could not be compiled when running in runtime-only mode")
                    },
                    i = {
                        lookup: function(e, t) {
                            for (var n = e.length, i = 0; n > i; i++)
                                if (e[i] && null != e[i][t]) return e[i][t]
                        },
                        lambda: function(e, t) {
                            return "function" == typeof e ? e.call(t) : e
                        },
                        escapeExpression: u.escapeExpression,
                        invokePartial: n,
                        fn: function(t) {
                            return e[t]
                        },
                        programs: [],
                        program: function(e, t, n) {
                            var i = this.programs[e],
                                r = this.fn(e);
                            return t || n ? i = o(this, e, r, t, n) : i || (i = this.programs[e] = o(this, e, r)), i
                        },
                        data: function(e, t) {
                            for (; e && t--;) e = e._parent;
                            return e
                        },
                        merge: function(e, t) {
                            var n = e || t;
                            return e && t && e !== t && (n = u.extend({}, t, e)), n
                        },
                        noop: t.VM.noop,
                        compilerInfo: e.compiler
                    },
                    r = function(t, n) {
                        n = n || {};
                        var o = n.data;
                        r._setup(n), !n.partial && e.useData && (o = l(t, o));
                        var s;
                        return e.useDepths && (s = n.depths ? [t].concat(n.depths) : [t]), e.main.call(i, t, i.helpers, i.partials, o, s)
                    };
                return r.isTop = !0, r._setup = function(n) {
                    n.partial ? (i.helpers = n.helpers, i.partials = n.partials) : (i.helpers = i.merge(n.helpers, t.helpers), e.usePartial && (i.partials = i.merge(n.partials, t.partials)))
                }, r._child = function(t, n, r) {
                    if (e.useDepths && !r) throw new d("must pass parent depths");
                    return o(i, t, e[t], n, r)
                }, r
            }

            function o(e, t, n, i, r) {
                var o = function(t, o) {
                    return o = o || {}, n.call(e, t, e.helpers, e.partials, o.data || i, r && [t].concat(r))
                };
                return o.program = t, o.depth = r ? r.length : 0, o
            }

            function s(e, t, n, i, r, o, s) {
                var a = {
                    partial: !0,
                    helpers: i,
                    partials: r,
                    data: o,
                    depths: s
                };
                if (void 0 === e) throw new d("The partial " + t + " could not be found");
                return e instanceof Function ? e(n, a) : void 0
            }

            function a() {
                return ""
            }

            function l(e, t) {
                return t && "root" in t || (t = t ? f(t) : {}, t.root = e), t
            }
            var c = {},
                u = e,
                d = t,
                p = n.COMPILER_REVISION,
                h = n.REVISION_CHANGES,
                f = n.createFrame;
            return c.checkRevision = i, c.template = r, c.program = o, c.invokePartial = s, c.noop = a, c
        }(t, n, i),
        o = function(e, t, n, i, r) {
            "use strict";
            var o, s = e,
                a = t,
                l = n,
                c = i,
                u = r,
                d = function() {
                    var e = new s.HandlebarsEnvironment;
                    return c.extend(e, s), e.SafeString = a, e.Exception = l, e.Utils = c, e.escapeExpression = c.escapeExpression, e.VM = u, e.template = function(t) {
                        return u.template(t, e)
                    }, e
                },
                p = d();
            return p.create = d, p["default"] = p, o = p
        }(i, e, n, t, r);
    return o
}), ! function(e) {
    var t = {},
        n = {
            mode: "horizontal",
            slideSelector: "",
            infiniteLoop: !0,
            hideControlOnEnd: !1,
            speed: 500,
            easing: null,
            slideMargin: 0,
            startSlide: 0,
            randomStart: !1,
            captions: !1,
            ticker: !1,
            tickerHover: !1,
            adaptiveHeight: !1,
            adaptiveHeightSpeed: 500,
            video: !1,
            useCSS: !0,
            preloadImages: "visible",
            responsive: !0,
            slideZIndex: 50,
            touchEnabled: !0,
            swipeThreshold: 50,
            oneToOneTouch: !0,
            preventDefaultSwipeX: !0,
            preventDefaultSwipeY: !1,
            pager: !0,
            pagerType: "full",
            pagerShortSeparator: " / ",
            pagerSelector: null,
            buildPager: null,
            pagerCustom: null,
            controls: !0,
            nextText: "Next",
            prevText: "Prev",
            nextSelector: null,
            prevSelector: null,
            autoControls: !1,
            startText: "Start",
            stopText: "Stop",
            autoControlsCombine: !1,
            autoControlsSelector: null,
            auto: !1,
            pause: 4e3,
            autoStart: !0,
            autoDirection: "next",
            autoHover: !1,
            autoDelay: 0,
            minSlides: 1,
            maxSlides: 1,
            moveSlides: 0,
            slideWidth: 0,
            onSliderLoad: function() {},
            onSlideBefore: function() {},
            onSlideAfter: function() {},
            onSlideNext: function() {},
            onSlidePrev: function() {},
            onSliderResize: function() {}
        };
    e.fn.bxSlider = function(r) {
        if (0 == this.length) return this;
        if (this.length > 1) return this.each(function() {
            e(this).bxSlider(r)
        }), this;
        var o = {},
            s = this;
        t.el = this;
        var a = e(window).width(),
            l = e(window).height(),
            c = function() {
                o.settings = e.extend({}, n, r), o.settings.slideWidth = parseInt(o.settings.slideWidth), o.children = s.children(o.settings.slideSelector), o.children.length < o.settings.minSlides && (o.settings.minSlides = o.children.length), o.children.length < o.settings.maxSlides && (o.settings.maxSlides = o.children.length), o.settings.randomStart && (o.settings.startSlide = Math.floor(Math.random() * o.children.length)), o.active = {
                    index: o.settings.startSlide
                }, o.carousel = o.settings.minSlides > 1 || o.settings.maxSlides > 1, o.carousel && (o.settings.preloadImages = "all"), o.minThreshold = o.settings.minSlides * o.settings.slideWidth + (o.settings.minSlides - 1) * o.settings.slideMargin, o.maxThreshold = o.settings.maxSlides * o.settings.slideWidth + (o.settings.maxSlides - 1) * o.settings.slideMargin, o.working = !1, o.controls = {}, o.interval = null, o.animProp = "vertical" == o.settings.mode ? "top" : "left", o.usingCSS = o.settings.useCSS && "fade" != o.settings.mode && function() {
                    var e = document.createElement("div"),
                        t = ["WebkitPerspective", "MozPerspective", "OPerspective", "msPerspective"];
                    for (var n in t)
                        if (void 0 !== e.style[t[n]]) return o.cssPrefix = t[n].replace("Perspective", "").toLowerCase(), o.animProp = "-" + o.cssPrefix + "-transform", !0;
                    return !1
                }(), "vertical" == o.settings.mode && (o.settings.maxSlides = o.settings.minSlides), s.data("origStyle", s.attr("style")), s.children(o.settings.slideSelector).each(function() {
                    e(this).data("origStyle", e(this).attr("style"))
                }), u()
            },
            u = function() {
                s.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'), o.viewport = s.parent(), o.loader = e('<div class="bx-loading" />'), o.viewport.prepend(o.loader), s.css({
                    width: "horizontal" == o.settings.mode ? 100 * o.children.length + 215 + "%" : "auto",
                    position: "relative"
                }), o.usingCSS && o.settings.easing ? s.css("-" + o.cssPrefix + "-transition-timing-function", o.settings.easing) : o.settings.easing || (o.settings.easing = "swing"), m(), o.viewport.css({
                    width: "100%",
                    overflow: "hidden",
                    position: "relative"
                }), o.viewport.parent().css({
                    maxWidth: f()
                }), o.settings.pager || o.viewport.parent().css({
                    margin: "0 auto 0px"
                }), o.children.css({
                    "float": "horizontal" == o.settings.mode ? "left" : "none",
                    listStyle: "none",
                    position: "relative"
                }), o.children.css("width", g()), "horizontal" == o.settings.mode && o.settings.slideMargin > 0 && o.children.css("marginRight", o.settings.slideMargin), "vertical" == o.settings.mode && o.settings.slideMargin > 0 && o.children.css("marginBottom", o.settings.slideMargin), "fade" == o.settings.mode && (o.children.css({
                    position: "absolute",
                    zIndex: 0,
                    display: "none"
                }), o.children.eq(o.settings.startSlide).css({
                    zIndex: o.settings.slideZIndex,
                    display: "block"
                })), o.controls.el = e('<div class="bx-controls" />'), o.settings.captions && E(), o.active.last = o.settings.startSlide == v() - 1, o.settings.video && s.fitVids();
                var t = o.children.eq(o.settings.startSlide);
                "all" == o.settings.preloadImages && (t = o.children), o.settings.ticker ? o.settings.pager = !1 : (o.settings.pager && C(), o.settings.controls && S(), o.settings.auto && o.settings.autoControls && T(), (o.settings.controls || o.settings.autoControls || o.settings.pager) && o.viewport.after(o.controls.el)), d(t, p)
            },
            d = function(t, n) {
                var i = t.find("img, iframe").length;
                if (0 == i) return void n();
                var r = 0;
                t.find("img, iframe").each(function() {
                    e(this).one("load", function() {
                        ++r == i && n()
                    }).each(function() {
                        this.complete && e(this).load()
                    })
                })
            },
            p = function() {
                if (o.settings.infiniteLoop && "fade" != o.settings.mode && !o.settings.ticker) {
                    var t = "vertical" == o.settings.mode ? o.settings.minSlides : o.settings.maxSlides,
                        n = o.children.slice(0, t).clone().addClass("bx-clone"),
                        i = o.children.slice(-t).clone().addClass("bx-clone");
                    s.append(n).prepend(i)
                }
                o.loader.remove(), b(), "vertical" == o.settings.mode && (o.settings.adaptiveHeight = !0), o.viewport.height(h()), s.redrawSlider(), o.settings.onSliderLoad(o.active.index), o.initialized = !0, o.settings.responsive && e(window).bind("resize", _), o.settings.auto && o.settings.autoStart && I(), o.settings.ticker && M(), o.settings.pager && A(o.settings.startSlide), o.settings.controls && N(), o.settings.touchEnabled && !o.settings.ticker && O()
            },
            h = function() {
                var t = 0,
                    n = e();
                if ("vertical" == o.settings.mode || o.settings.adaptiveHeight)
                    if (o.carousel) {
                        var r = 1 == o.settings.moveSlides ? o.active.index : o.active.index * y();
                        for (n = o.children.eq(r), i = 1; i <= o.settings.maxSlides - 1; i++) n = r + i >= o.children.length ? n.add(o.children.eq(i - 1)) : n.add(o.children.eq(r + i))
                    } else n = o.children.eq(o.active.index);
                else n = o.children;
                return "vertical" == o.settings.mode ? (n.each(function() {
                    t += e(this).outerHeight()
                }), o.settings.slideMargin > 0 && (t += o.settings.slideMargin * (o.settings.minSlides - 1))) : t = Math.max.apply(Math, n.map(function() {
                    return e(this).outerHeight(!1)
                }).get()), t
            },
            f = function() {
                var e = "100%";
                return o.settings.slideWidth > 0 && (e = "horizontal" == o.settings.mode ? o.settings.maxSlides * o.settings.slideWidth + (o.settings.maxSlides - 1) * o.settings.slideMargin : o.settings.slideWidth), e
            },
            g = function() {
                var e = o.settings.slideWidth,
                    t = o.viewport.width();
                return 0 == o.settings.slideWidth || o.settings.slideWidth > t && !o.carousel || "vertical" == o.settings.mode ? e = t : o.settings.maxSlides > 1 && "horizontal" == o.settings.mode && (t > o.maxThreshold || t < o.minThreshold && (e = (t - o.settings.slideMargin * (o.settings.minSlides - 1)) / o.settings.minSlides)), e
            },
            m = function() {
                var e = 1;
                if ("horizontal" == o.settings.mode && o.settings.slideWidth > 0)
                    if (o.viewport.width() < o.minThreshold) e = o.settings.minSlides;
                    else if (o.viewport.width() > o.maxThreshold) e = o.settings.maxSlides;
                else {
                    var t = o.children.first().width();
                    e = Math.floor(o.viewport.width() / t)
                } else "vertical" == o.settings.mode && (e = o.settings.minSlides);
                return e
            },
            v = function() {
                var e = 0;
                if (o.settings.moveSlides > 0)
                    if (o.settings.infiniteLoop) e = o.children.length / y();
                    else
                        for (var t = 0, n = 0; t < o.children.length;) ++e, t = n + m(), n += o.settings.moveSlides <= m() ? o.settings.moveSlides : m();
                else e = Math.ceil(o.children.length / m());
                return e
            },
            y = function() {
                return o.settings.moveSlides > 0 && o.settings.moveSlides <= m() ? o.settings.moveSlides : m()
            },
            b = function() {
                if (o.children.length > o.settings.maxSlides && o.active.last && !o.settings.infiniteLoop) {
                    if ("horizontal" == o.settings.mode) {
                        var e = o.children.last(),
                            t = e.position();
                        x(-(t.left - (o.viewport.width() - e.width())), "reset", 0)
                    } else if ("vertical" == o.settings.mode) {
                        var n = o.children.length - o.settings.minSlides,
                            t = o.children.eq(n).position();
                        x(-t.top, "reset", 0)
                    }
                } else {
                    var t = o.children.eq(o.active.index * y()).position();
                    o.active.index == v() - 1 && (o.active.last = !0), void 0 != t && ("horizontal" == o.settings.mode ? x(-t.left, "reset", 0) : "vertical" == o.settings.mode && x(-t.top, "reset", 0))
                }
            },
            x = function(e, t, n, i) {
                if (o.usingCSS) {
                    var r = "vertical" == o.settings.mode ? "translate3d(0, " + e + "px, 0)" : "translate3d(" + e + "px, 0, 0)";
                    s.css("-" + o.cssPrefix + "-transition-duration", n / 1e3 + "s"), "slide" == t ? (s.css(o.animProp, r), s.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                        s.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"), D()
                    })) : "reset" == t ? s.css(o.animProp, r) : "ticker" == t && (s.css("-" + o.cssPrefix + "-transition-timing-function", "linear"), s.css(o.animProp, r), s.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                        s.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"), x(i.resetValue, "reset", 0), R()
                    }))
                } else {
                    var a = {};
                    a[o.animProp] = e, "slide" == t ? s.animate(a, n, o.settings.easing, function() {
                        D()
                    }) : "reset" == t ? s.css(o.animProp, e) : "ticker" == t && s.animate(a, speed, "linear", function() {
                        x(i.resetValue, "reset", 0), R()
                    })
                }
            },
            w = function() {
                for (var t = "", n = v(), i = 0; n > i; i++) {
                    var r = "";
                    o.settings.buildPager && e.isFunction(o.settings.buildPager) ? (r = o.settings.buildPager(i), o.pagerEl.addClass("bx-custom-pager")) : (r = i + 1, o.pagerEl.addClass("bx-default-pager")), t += '<div class="bx-pager-item"><a href="" data-slide-index="' + i + '" class="bx-pager-link">' + r + "</a></div>"
                }
                o.pagerEl.html(t)
            },
            C = function() {
                o.settings.pagerCustom ? o.pagerEl = e(o.settings.pagerCustom) : (o.pagerEl = e('<div class="bx-pager" />'), o.settings.pagerSelector ? e(o.settings.pagerSelector).html(o.pagerEl) : o.controls.el.addClass("bx-has-pager").append(o.pagerEl), w()), o.pagerEl.on("click", "a", P)
            },
            S = function() {
                o.controls.next = e('<a class="bx-next" href="">' + o.settings.nextText + "</a>"), o.controls.prev = e('<a class="bx-prev" href="">' + o.settings.prevText + "</a>"), o.controls.next.bind("click", k), o.controls.prev.bind("click", L), o.settings.nextSelector && e(o.settings.nextSelector).append(o.controls.next), o.settings.prevSelector && e(o.settings.prevSelector).append(o.controls.prev), o.settings.nextSelector || o.settings.prevSelector || (o.controls.directionEl = e('<div class="bx-controls-direction" />'), o.controls.directionEl.append(o.controls.prev).append(o.controls.next), o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))
            },
            T = function() {
                o.controls.start = e('<div class="bx-controls-auto-item"><a class="bx-start" href="">' + o.settings.startText + "</a></div>"), o.controls.stop = e('<div class="bx-controls-auto-item"><a class="bx-stop" href="">' + o.settings.stopText + "</a></div>"), o.controls.autoEl = e('<div class="bx-controls-auto" />'), o.controls.autoEl.on("click", ".bx-start", $), o.controls.autoEl.on("click", ".bx-stop", j), o.settings.autoControlsCombine ? o.controls.autoEl.append(o.controls.start) : o.controls.autoEl.append(o.controls.start).append(o.controls.stop), o.settings.autoControlsSelector ? e(o.settings.autoControlsSelector).html(o.controls.autoEl) : o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl), F(o.settings.autoStart ? "stop" : "start")
            },
            E = function() {
                o.children.each(function() {
                    var t = e(this).find("img:first").attr("title");
                    void 0 != t && ("" + t).length && e(this).append('<div class="bx-caption"><span>' + t + "</span></div>")
                })
            },
            k = function(e) {
                o.settings.auto && s.stopAuto(), s.goToNextSlide(), e.preventDefault()
            },
            L = function(e) {
                o.settings.auto && s.stopAuto(), s.goToPrevSlide(), e.preventDefault()
            },
            $ = function(e) {
                s.startAuto(), e.preventDefault()
            },
            j = function(e) {
                s.stopAuto(), e.preventDefault()
            },
            P = function(t) {
                o.settings.auto && s.stopAuto();
                var n = e(t.currentTarget),
                    i = parseInt(n.attr("data-slide-index"));
                i != o.active.index && s.goToSlide(i), t.preventDefault()
            },
            A = function(t) {
                var n = o.children.length;
                return "short" == o.settings.pagerType ? (o.settings.maxSlides > 1 && (n = Math.ceil(o.children.length / o.settings.maxSlides)), void o.pagerEl.html(t + 1 + o.settings.pagerShortSeparator + n)) : (o.pagerEl.find("a").removeClass("active"), void o.pagerEl.each(function(n, i) {
                    e(i).find("a").eq(t).addClass("active")
                }))
            },
            D = function() {
                if (o.settings.infiniteLoop) {
                    var e = "";
                    0 == o.active.index ? e = o.children.eq(0).position() : o.active.index == v() - 1 && o.carousel ? e = o.children.eq((v() - 1) * y()).position() : o.active.index == o.children.length - 1 && (e = o.children.eq(o.children.length - 1).position()), e && ("horizontal" == o.settings.mode ? x(-e.left, "reset", 0) : "vertical" == o.settings.mode && x(-e.top, "reset", 0))
                }
                o.working = !1, o.settings.onSlideAfter(o.children.eq(o.active.index), o.oldIndex, o.active.index)
            },
            F = function(e) {
                o.settings.autoControlsCombine ? o.controls.autoEl.html(o.controls[e]) : (o.controls.autoEl.find("a").removeClass("active"), o.controls.autoEl.find("a:not(.bx-" + e + ")").addClass("active"))
            },
            N = function() {
                1 == v() ? (o.controls.prev.addClass("disabled"), o.controls.next.addClass("disabled")) : !o.settings.infiniteLoop && o.settings.hideControlOnEnd && (0 == o.active.index ? (o.controls.prev.addClass("disabled"), o.controls.next.removeClass("disabled")) : o.active.index == v() - 1 ? (o.controls.next.addClass("disabled"), o.controls.prev.removeClass("disabled")) : (o.controls.prev.removeClass("disabled"), o.controls.next.removeClass("disabled")))
            },
            I = function() {
                o.settings.autoDelay > 0 ? setTimeout(s.startAuto, o.settings.autoDelay) : s.startAuto(), o.settings.autoHover && s.hover(function() {
                    o.interval && (s.stopAuto(!0), o.autoPaused = !0)
                }, function() {
                    o.autoPaused && (s.startAuto(!0), o.autoPaused = null)
                })
            },
            M = function() {
                var t = 0;
                if ("next" == o.settings.autoDirection) s.append(o.children.clone().addClass("bx-clone"));
                else {
                    s.prepend(o.children.clone().addClass("bx-clone"));
                    var n = o.children.first().position();
                    t = "horizontal" == o.settings.mode ? -n.left : -n.top
                }
                x(t, "reset", 0), o.settings.pager = !1, o.settings.controls = !1, o.settings.autoControls = !1, o.settings.tickerHover && !o.usingCSS && o.viewport.hover(function() {
                    s.stop()
                }, function() {
                    var t = 0;
                    o.children.each(function() {
                        t += "horizontal" == o.settings.mode ? e(this).outerWidth(!0) : e(this).outerHeight(!0)
                    });
                    var n = o.settings.speed / t,
                        i = "horizontal" == o.settings.mode ? "left" : "top",
                        r = n * (t - Math.abs(parseInt(s.css(i))));
                    R(r)
                }), R()
            },
            R = function(e) {
                speed = e ? e : o.settings.speed;
                var t = {
                        left: 0,
                        top: 0
                    },
                    n = {
                        left: 0,
                        top: 0
                    };
                "next" == o.settings.autoDirection ? t = s.find(".bx-clone").first().position() : n = o.children.first().position();
                var i = "horizontal" == o.settings.mode ? -t.left : -t.top,
                    r = "horizontal" == o.settings.mode ? -n.left : -n.top,
                    a = {
                        resetValue: r
                    };
                x(i, "ticker", speed, a)
            },
            O = function() {
                o.touch = {
                    start: {
                        x: 0,
                        y: 0
                    },
                    end: {
                        x: 0,
                        y: 0
                    }
                }, o.viewport.bind("touchstart", z)
            },
            z = function(e) {
                if (o.working) e.preventDefault();
                else {
                    o.touch.originalPos = s.position();
                    var t = e.originalEvent;
                    o.touch.start.x = t.changedTouches[0].pageX, o.touch.start.y = t.changedTouches[0].pageY, o.viewport.bind("touchmove", q), o.viewport.bind("touchend", H)
                }
            },
            q = function(e) {
                var t = e.originalEvent,
                    n = Math.abs(t.changedTouches[0].pageX - o.touch.start.x),
                    i = Math.abs(t.changedTouches[0].pageY - o.touch.start.y);
                if (3 * n > i && o.settings.preventDefaultSwipeX ? e.preventDefault() : 3 * i > n && o.settings.preventDefaultSwipeY && e.preventDefault(), "fade" != o.settings.mode && o.settings.oneToOneTouch) {
                    var r = 0;
                    if ("horizontal" == o.settings.mode) {
                        var s = t.changedTouches[0].pageX - o.touch.start.x;
                        r = o.touch.originalPos.left + s
                    } else {
                        var s = t.changedTouches[0].pageY - o.touch.start.y;
                        r = o.touch.originalPos.top + s
                    }
                    x(r, "reset", 0)
                }
            },
            H = function(e) {
                o.viewport.unbind("touchmove", q);
                var t = e.originalEvent,
                    n = 0;
                if (o.touch.end.x = t.changedTouches[0].pageX, o.touch.end.y = t.changedTouches[0].pageY, "fade" == o.settings.mode) {
                    var i = Math.abs(o.touch.start.x - o.touch.end.x);
                    i >= o.settings.swipeThreshold && (o.touch.start.x > o.touch.end.x ? s.goToNextSlide() : s.goToPrevSlide(), s.stopAuto())
                } else {
                    var i = 0;
                    "horizontal" == o.settings.mode ? (i = o.touch.end.x - o.touch.start.x, n = o.touch.originalPos.left) : (i = o.touch.end.y - o.touch.start.y, n = o.touch.originalPos.top), !o.settings.infiniteLoop && (0 == o.active.index && i > 0 || o.active.last && 0 > i) ? x(n, "reset", 200) : Math.abs(i) >= o.settings.swipeThreshold ? (0 > i ? s.goToNextSlide() : s.goToPrevSlide(), s.stopAuto()) : x(n, "reset", 200)
                }
                o.viewport.unbind("touchend", H)
            },
            _ = function() {
                var t = e(window).width(),
                    n = e(window).height();
                (a != t || l != n) && (a = t, l = n, s.redrawSlider(), o.settings.onSliderResize.call(s, o.active.index))
            };
        return s.goToSlide = function(t, n) {
            if (!o.working && o.active.index != t)
                if (o.working = !0, o.oldIndex = o.active.index, o.active.index = 0 > t ? v() - 1 : t >= v() ? 0 : t, o.settings.onSlideBefore(o.children.eq(o.active.index), o.oldIndex, o.active.index), "next" == n ? o.settings.onSlideNext(o.children.eq(o.active.index), o.oldIndex, o.active.index) : "prev" == n && o.settings.onSlidePrev(o.children.eq(o.active.index), o.oldIndex, o.active.index), o.active.last = o.active.index >= v() - 1, o.settings.pager && A(o.active.index), o.settings.controls && N(), "fade" == o.settings.mode) o.settings.adaptiveHeight && o.viewport.height() != h() && o.viewport.animate({
                    height: h()
                }, o.settings.adaptiveHeightSpeed), o.children.filter(":visible").fadeOut(o.settings.speed).css({
                    zIndex: 0
                }), o.children.eq(o.active.index).css("zIndex", o.settings.slideZIndex + 1).fadeIn(o.settings.speed, function() {
                    e(this).css("zIndex", o.settings.slideZIndex), D()
                });
                else {
                    o.settings.adaptiveHeight && o.viewport.height() != h() && o.viewport.animate({
                        height: h()
                    }, o.settings.adaptiveHeightSpeed);
                    var i = 0,
                        r = {
                            left: 0,
                            top: 0
                        };
                    if (!o.settings.infiniteLoop && o.carousel && o.active.last)
                        if ("horizontal" == o.settings.mode) {
                            var a = o.children.eq(o.children.length - 1);
                            r = a.position(), i = o.viewport.width() - a.outerWidth()
                        } else {
                            var l = o.children.length - o.settings.minSlides;
                            r = o.children.eq(l).position()
                        }
                    else if (o.carousel && o.active.last && "prev" == n) {
                        var c = 1 == o.settings.moveSlides ? o.settings.maxSlides - y() : (v() - 1) * y() - (o.children.length - o.settings.maxSlides),
                            a = s.children(".bx-clone").eq(c);
                        r = a.position()
                    } else if ("next" == n && 0 == o.active.index) r = s.find("> .bx-clone").eq(o.settings.maxSlides).position(), o.active.last = !1;
                    else if (t >= 0) {
                        var u = t * y();
                        r = o.children.eq(u).position()
                    }
                    if ("undefined" != typeof r) {
                        var d = "horizontal" == o.settings.mode ? -(r.left - i) : -r.top;
                        x(d, "slide", o.settings.speed)
                    }
                }
        }, s.goToNextSlide = function() {
            if (o.settings.infiniteLoop || !o.active.last) {
                var e = parseInt(o.active.index) + 1;
                s.goToSlide(e, "next")
            }
        }, s.goToPrevSlide = function() {
            if (o.settings.infiniteLoop || 0 != o.active.index) {
                var e = parseInt(o.active.index) - 1;
                s.goToSlide(e, "prev")
            }
        }, s.startAuto = function(e) {
            o.interval || (o.interval = setInterval(function() {
                "next" == o.settings.autoDirection ? s.goToNextSlide() : s.goToPrevSlide()
            }, o.settings.pause), o.settings.autoControls && 1 != e && F("stop"))
        }, s.stopAuto = function(e) {
            o.interval && (clearInterval(o.interval), o.interval = null, o.settings.autoControls && 1 != e && F("start"))
        }, s.getCurrentSlide = function() {
            return o.active.index
        }, s.getCurrentSlideElement = function() {
            return o.children.eq(o.active.index)
        }, s.getSlideCount = function() {
            return o.children.length
        }, s.redrawSlider = function() {
            o.children.add(s.find(".bx-clone")).outerWidth(g()), o.viewport.css("height", h()), o.settings.ticker || b(), o.active.last && (o.active.index = v() - 1), o.active.index >= v() && (o.active.last = !0), o.settings.pager && !o.settings.pagerCustom && (w(), A(o.active.index))
        }, s.destroySlider = function() {
            o.initialized && (o.initialized = !1, e(".bx-clone", this).remove(), o.children.each(function() {
                void 0 != e(this).data("origStyle") ? e(this).attr("style", e(this).data("origStyle")) : e(this).removeAttr("style")
            }), void 0 != e(this).data("origStyle") ? this.attr("style", e(this).data("origStyle")) : e(this).removeAttr("style"), e(this).unwrap().unwrap(), o.controls.el && o.controls.el.remove(), o.controls.next && o.controls.next.remove(), o.controls.prev && o.controls.prev.remove(), o.pagerEl && o.settings.controls && o.pagerEl.remove(), e(".bx-caption", this).remove(), o.controls.autoEl && o.controls.autoEl.remove(), clearInterval(o.interval), o.settings.responsive && e(window).unbind("resize", _))
        }, s.reloadSlider = function(e) {
            void 0 != e && (r = e), s.destroySlider(), c()
        }, c(), this
    }
}(jQuery),
function(e, t) {
    function n(t) {
        return t.map(function() {
            return this.elements ? e.makeArray(this.elements) : this
        }).filter(":input:not(:disabled)").get()
    }

    function i(n) {
        var i, r = {};
        return e.each(n, function(n, o) {
            i = r[o.name], r[o.name] = i === t ? o : e.isArray(i) ? i.concat(o) : [i, o]
        }), r
    }
    var r = Array.prototype.push,
        o = /^(?:radio|checkbox)$/i,
        s = /\+/g,
        a = /^(?:option|select-one|select-multiple)$/i,
        l = /^(?:button|color|date|datetime|datetime-local|email|hidden|month|number|password|range|reset|search|submit|tel|text|textarea|time|url|week)$/i;
    e.fn.deserialize = function(c, u) {
        var d, p, h = n(this),
            f = [];
        if (!c || !h.length) return this;
        if (e.isArray(c)) f = c;
        else if (e.isPlainObject(c)) {
            var g, m;
            for (g in c) e.isArray(m = c[g]) ? r.apply(f, e.map(m, function(e) {
                return {
                    name: g,
                    value: e
                }
            })) : r.call(f, {
                name: g,
                value: m
            })
        } else if ("string" == typeof c) {
            var v;
            for (c = c.split("&"), d = 0, p = c.length; p > d; d++) v = c[d].split("="), r.call(f, {
                name: decodeURIComponent(v[0].replace(s, "%20")),
                value: decodeURIComponent(v[1].replace(s, "%20"))
            })
        }
        if (!(p = f.length)) return this;
        var y, b, x, w, C, S, T, m, E = e.noop,
            k = e.noop,
            L = {};
        for (u = u || {}, h = i(h), e.isFunction(u) ? k = u : (E = e.isFunction(u.change) ? u.change : E, k = e.isFunction(u.complete) ? u.complete : k), d = 0; p > d; d++)
            if (y = f[d], C = y.name, m = y.value, (b = h[C]) && (T = (w = b.length) ? b[0] : b, T = (T.type || T.nodeName).toLowerCase(), S = null, l.test(T) ? (w && (x = L[C], b = b[L[C] = x == t ? 0 : ++x]), E.call(b, b.value = m)) : o.test(T) ? S = "checked" : a.test(T) && (S = "selected"), S))
                for (w || (b = [b], w = 1), x = 0; w > x; x++) y = b[x], y.value == m && E.call(y, (y[S] = !0) && m);
        return k.call(this), this
    }
}(jQuery), ! function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e(jQuery)
}(function(e) {
    e.extend(e.fn, {
        validate: function(t) {
            if (!this.length) return void(t && t.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing."));
            var n = e.data(this[0], "validator");
            return n ? n : (this.attr("novalidate", "novalidate"), n = new e.validator(t, this[0]), e.data(this[0], "validator", n), n.settings.onsubmit && (this.validateDelegate(":submit", "click", function(t) {
                n.settings.submitHandler && (n.submitButton = t.target), e(t.target).hasClass("cancel") && (n.cancelSubmit = !0), void 0 !== e(t.target).attr("formnovalidate") && (n.cancelSubmit = !0)
            }), this.submit(function(t) {
                function i() {
                    var i, r;
                    return n.settings.submitHandler ? (n.submitButton && (i = e("<input type='hidden'/>").attr("name", n.submitButton.name).val(e(n.submitButton).val()).appendTo(n.currentForm)), r = n.settings.submitHandler.call(n, n.currentForm, t), n.submitButton && i.remove(), void 0 !== r ? r : !1) : !0
                }
                return n.settings.debug && t.preventDefault(), n.cancelSubmit ? (n.cancelSubmit = !1, i()) : n.form() ? n.pendingRequest ? (n.formSubmitted = !0, !1) : i() : (n.focusInvalid(), !1)
            })), n)
        },
        valid: function() {
            var t, n;
            return e(this[0]).is("form") ? t = this.validate().form() : (t = !0, n = e(this[0].form).validate(), this.each(function() {
                t = n.element(this) && t
            })), t
        },
        removeAttrs: function(t) {
            var n = {},
                i = this;
            return e.each(t.split(/\s/), function(e, t) {
                n[t] = i.attr(t), i.removeAttr(t)
            }), n
        },
        rules: function(t, n) {
            var i, r, o, s, a, l, c = this[0];
            if (t) switch (i = e.data(c.form, "validator").settings, r = i.rules, o = e.validator.staticRules(c), t) {
                case "add":
                    e.extend(o, e.validator.normalizeRule(n)), delete o.messages, r[c.name] = o, n.messages && (i.messages[c.name] = e.extend(i.messages[c.name], n.messages));
                    break;
                case "remove":
                    return n ? (l = {}, e.each(n.split(/\s/), function(t, n) {
                        l[n] = o[n], delete o[n], "required" === n && e(c).removeAttr("aria-required")
                    }), l) : (delete r[c.name], o)
            }
            return s = e.validator.normalizeRules(e.extend({}, e.validator.classRules(c), e.validator.attributeRules(c), e.validator.dataRules(c), e.validator.staticRules(c)), c), s.required && (a = s.required, delete s.required, s = e.extend({
                required: a
            }, s), e(c).attr("aria-required", "true")), s.remote && (a = s.remote, delete s.remote, s = e.extend(s, {
                remote: a
            })), s
        }
    }), e.extend(e.expr[":"], {
        blank: function(t) {
            return !e.trim("" + e(t).val())
        },
        filled: function(t) {
            return !!e.trim("" + e(t).val())
        },
        unchecked: function(t) {
            return !e(t).prop("checked")
        }
    }), e.validator = function(t, n) {
        this.settings = e.extend(!0, {}, e.validator.defaults, t), this.currentForm = n, this.init()
    }, e.validator.format = function(t, n) {
        return 1 === arguments.length ? function() {
            var n = e.makeArray(arguments);
            return n.unshift(t), e.validator.format.apply(this, n)
        } : (arguments.length > 2 && n.constructor !== Array && (n = e.makeArray(arguments).slice(1)), n.constructor !== Array && (n = [n]), e.each(n, function(e, n) {
            t = t.replace(new RegExp("\\{" + e + "\\}", "g"), function() {
                return n
            })
        }), t)
    }, e.extend(e.validator, {
        defaults: {
            messages: {},
            groups: {},
            rules: {},
            errorClass: "error",
            validClass: "valid",
            errorElement: "label",
            focusCleanup: !1,
            focusInvalid: !0,
            errorContainer: e([]),
            errorLabelContainer: e([]),
            onsubmit: !0,
            ignore: ":hidden",
            ignoreTitle: !1,
            onfocusin: function(e) {
                this.lastActive = e, this.settings.focusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, e, this.settings.errorClass, this.settings.validClass), this.hideThese(this.errorsFor(e)))
            },
            onfocusout: function(e) {
                this.checkable(e) || !(e.name in this.submitted) && this.optional(e) || this.element(e)
            },
            onkeyup: function(e, t) {
                (9 !== t.which || "" !== this.elementValue(e)) && (e.name in this.submitted || e === this.lastElement) && this.element(e)
            },
            onclick: function(e) {
                e.name in this.submitted ? this.element(e) : e.parentNode.name in this.submitted && this.element(e.parentNode)
            },
            highlight: function(t, n, i) {
                "radio" === t.type ? this.findByName(t.name).addClass(n).removeClass(i) : e(t).addClass(n).removeClass(i)
            },
            unhighlight: function(t, n, i) {
                "radio" === t.type ? this.findByName(t.name).removeClass(n).addClass(i) : e(t).removeClass(n).addClass(i)
            }
        },
        setDefaults: function(t) {
            e.extend(e.validator.defaults, t)
        },
        messages: {
            required: "This field is required.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date ( ISO ).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            maxlength: e.validator.format("Please enter no more than {0} characters."),
            minlength: e.validator.format("Please enter at least {0} characters."),
            rangelength: e.validator.format("Please enter a value between {0} and {1} characters long."),
            range: e.validator.format("Please enter a value between {0} and {1}."),
            max: e.validator.format("Please enter a value less than or equal to {0}."),
            min: e.validator.format("Please enter a value greater than or equal to {0}.")
        },
        autoCreateRanges: !1,
        prototype: {
            init: function() {
                function t(t) {
                    var n = e.data(this[0].form, "validator"),
                        i = "on" + t.type.replace(/^validate/, ""),
                        r = n.settings;
                    r[i] && !this.is(r.ignore) && r[i].call(n, this[0], t)
                }
                this.labelContainer = e(this.settings.errorLabelContainer), this.errorContext = this.labelContainer.length && this.labelContainer || e(this.currentForm), this.containers = e(this.settings.errorContainer).add(this.settings.errorLabelContainer), this.submitted = {}, this.valueCache = {}, this.pendingRequest = 0, this.pending = {}, this.invalid = {}, this.reset();
                var n, i = this.groups = {};
                e.each(this.settings.groups, function(t, n) {
                    "string" == typeof n && (n = n.split(/\s/)), e.each(n, function(e, n) {
                        i[n] = t
                    })
                }), n = this.settings.rules, e.each(n, function(t, i) {
                    n[t] = e.validator.normalizeRule(i)
                }), e(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox']", "focusin focusout keyup", t).validateDelegate("select, option, [type='radio'], [type='checkbox']", "click", t), this.settings.invalidHandler && e(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler), e(this.currentForm).find("[required], [data-rule-required], .required").attr("aria-required", "true")
            },
            form: function() {
                return this.checkForm(), e.extend(this.submitted, this.errorMap), this.invalid = e.extend({}, this.errorMap), this.valid() || e(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid()
            },
            checkForm: function() {
                this.prepareForm();
                for (var e = 0, t = this.currentElements = this.elements(); t[e]; e++) this.check(t[e]);
                return this.valid()
            },
            element: function(t) {
                var n = this.clean(t),
                    i = this.validationTargetFor(n),
                    r = !0;
                return this.lastElement = i, void 0 === i ? delete this.invalid[n.name] : (this.prepareElement(i), this.currentElements = e(i), r = this.check(i) !== !1, r ? delete this.invalid[i.name] : this.invalid[i.name] = !0), e(t).attr("aria-invalid", !r), this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), r
            },
            showErrors: function(t) {
                if (t) {
                    e.extend(this.errorMap, t), this.errorList = [];
                    for (var n in t) this.errorList.push({
                        message: t[n],
                        element: this.findByName(n)[0]
                    });
                    this.successList = e.grep(this.successList, function(e) {
                        return !(e.name in t)
                    })
                }
                this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors()
            },
            resetForm: function() {
                e.fn.resetForm && e(this.currentForm).resetForm(), this.submitted = {}, this.lastElement = null, this.prepareForm(), this.hideErrors(), this.elements().removeClass(this.settings.errorClass).removeData("previousValue").removeAttr("aria-invalid")
            },
            numberOfInvalids: function() {
                return this.objectLength(this.invalid)
            },
            objectLength: function(e) {
                var t, n = 0;
                for (t in e) n++;
                return n
            },
            hideErrors: function() {
                this.hideThese(this.toHide)
            },
            hideThese: function(e) {
                e.not(this.containers).text(""), this.addWrapper(e).hide()
            },
            valid: function() {
                return 0 === this.size()
            },
            size: function() {
                return this.errorList.length
            },
            focusInvalid: function() {
                if (this.settings.focusInvalid) try {
                    e(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus().trigger("focusin")
                } catch (t) {}
            },
            findLastActive: function() {
                var t = this.lastActive;
                return t && 1 === e.grep(this.errorList, function(e) {
                    return e.element.name === t.name
                }).length && t
            },
            elements: function() {
                var t = this,
                    n = {};
                return e(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled], [readonly]").not(this.settings.ignore).filter(function() {
                    return !this.name && t.settings.debug && window.console && console.error("%o has no name assigned", this), this.name in n || !t.objectLength(e(this).rules()) ? !1 : (n[this.name] = !0, !0)
                })
            },
            clean: function(t) {
                return e(t)[0]
            },
            errors: function() {
                var t = this.settings.errorClass.split(" ").join(".");
                return e(this.settings.errorElement + "." + t, this.errorContext)
            },
            reset: function() {
                this.successList = [], this.errorList = [], this.errorMap = {}, this.toShow = e([]), this.toHide = e([]), this.currentElements = e([])
            },
            prepareForm: function() {
                this.reset(), this.toHide = this.errors().add(this.containers)
            },
            prepareElement: function(e) {
                this.reset(), this.toHide = this.errorsFor(e)
            },
            elementValue: function(t) {
                var n, i = e(t),
                    r = t.type;
                return "radio" === r || "checkbox" === r ? e("input[name='" + t.name + "']:checked").val() : "number" === r && "undefined" != typeof t.validity ? t.validity.badInput ? !1 : i.val() : (n = i.val(), "string" == typeof n ? n.replace(/\r/g, "") : n)
            },
            check: function(t) {
                t = this.validationTargetFor(this.clean(t));
                var n, i, r, o = e(t).rules(),
                    s = e.map(o, function(e, t) {
                        return t
                    }).length,
                    a = !1,
                    l = this.elementValue(t);
                for (i in o) {
                    r = {
                        method: i,
                        parameters: o[i]
                    };
                    try {
                        if (n = e.validator.methods[i].call(this, l, t, r.parameters), "dependency-mismatch" === n && 1 === s) {
                            a = !0;
                            continue
                        }
                        if (a = !1, "pending" === n) return void(this.toHide = this.toHide.not(this.errorsFor(t)));
                        if (!n) return this.formatAndAdd(t, r), !1
                    } catch (c) {
                        throw this.settings.debug && window.console && console.log("Exception occurred when checking element " + t.id + ", check the '" + r.method + "' method.", c), c
                    }
                }
                return a ? void 0 : (this.objectLength(o) && this.successList.push(t), !0)
            },
            customDataMessage: function(t, n) {
                return e(t).data("msg" + n.charAt(0).toUpperCase() + n.substring(1).toLowerCase()) || e(t).data("msg")
            },
            customMessage: function(e, t) {
                var n = this.settings.messages[e];
                return n && (n.constructor === String ? n : n[t])
            },
            findDefined: function() {
                for (var e = 0; e < arguments.length; e++)
                    if (void 0 !== arguments[e]) return arguments[e]
            },
            defaultMessage: function(t, n) {
                return this.findDefined(this.customMessage(t.name, n), this.customDataMessage(t, n), !this.settings.ignoreTitle && t.title || void 0, e.validator.messages[n], "<strong>Warning: No message defined for " + t.name + "</strong>")
            },
            formatAndAdd: function(t, n) {
                var i = this.defaultMessage(t, n.method),
                    r = /\$?\{(\d+)\}/g;
                "function" == typeof i ? i = i.call(this, n.parameters, t) : r.test(i) && (i = e.validator.format(i.replace(r, "{$1}"), n.parameters)), this.errorList.push({
                    message: i,
                    element: t,
                    method: n.method
                }), this.errorMap[t.name] = i, this.submitted[t.name] = i
            },
            addWrapper: function(e) {
                return this.settings.wrapper && (e = e.add(e.parent(this.settings.wrapper))), e
            },
            defaultShowErrors: function() {
                var e, t, n;
                for (e = 0; this.errorList[e]; e++) n = this.errorList[e], this.settings.highlight && this.settings.highlight.call(this, n.element, this.settings.errorClass, this.settings.validClass), this.showLabel(n.element, n.message);
                if (this.errorList.length && (this.toShow = this.toShow.add(this.containers)), this.settings.success)
                    for (e = 0; this.successList[e]; e++) this.showLabel(this.successList[e]);
                if (this.settings.unhighlight)
                    for (e = 0, t = this.validElements(); t[e]; e++) this.settings.unhighlight.call(this, t[e], this.settings.errorClass, this.settings.validClass);
                this.toHide = this.toHide.not(this.toShow), this.hideErrors(), this.addWrapper(this.toShow).show()
            },
            validElements: function() {
                return this.currentElements.not(this.invalidElements())
            },
            invalidElements: function() {
                return e(this.errorList).map(function() {
                    return this.element
                })
            },
            showLabel: function(t, n) {
                var i, r, o, s = this.errorsFor(t),
                    a = this.idOrName(t),
                    l = e(t).attr("aria-describedby");
                s.length ? (s.removeClass(this.settings.validClass).addClass(this.settings.errorClass), s.html(n)) : (s = e("<" + this.settings.errorElement + ">").attr("id", a + "-error").addClass(this.settings.errorClass).html(n || ""), i = s, this.settings.wrapper && (i = s.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.length ? this.labelContainer.append(i) : this.settings.errorPlacement ? this.settings.errorPlacement(i, e(t)) : i.insertAfter(t), s.is("label") ? s.attr("for", a) : 0 === s.parents("label[for='" + a + "']").length && (o = s.attr("id").replace(/(:|\.|\[|\])/g, "\\$1"), l ? l.match(new RegExp("\\b" + o + "\\b")) || (l += " " + o) : l = o, e(t).attr("aria-describedby", l), r = this.groups[t.name], r && e.each(this.groups, function(t, n) {
                    n === r && e("[name='" + t + "']", this.currentForm).attr("aria-describedby", s.attr("id"))
                }))), !n && this.settings.success && (s.text(""), "string" == typeof this.settings.success ? s.addClass(this.settings.success) : this.settings.success(s, t)), this.toShow = this.toShow.add(s)
            },
            errorsFor: function(t) {
                var n = this.idOrName(t),
                    i = e(t).attr("aria-describedby"),
                    r = "label[for='" + n + "'], label[for='" + n + "'] *";
                return i && (r = r + ", #" + i.replace(/\s+/g, ", #")), this.errors().filter(r)
            },
            idOrName: function(e) {
                return this.groups[e.name] || (this.checkable(e) ? e.name : e.id || e.name)
            },
            validationTargetFor: function(t) {
                return this.checkable(t) && (t = this.findByName(t.name)), e(t).not(this.settings.ignore)[0]
            },
            checkable: function(e) {
                return /radio|checkbox/i.test(e.type)
            },
            findByName: function(t) {
                return e(this.currentForm).find("[name='" + t + "']")
            },
            getLength: function(t, n) {
                switch (n.nodeName.toLowerCase()) {
                    case "select":
                        return e("option:selected", n).length;
                    case "input":
                        if (this.checkable(n)) return this.findByName(n.name).filter(":checked").length
                }
                return t.length
            },
            depend: function(e, t) {
                return this.dependTypes[typeof e] ? this.dependTypes[typeof e](e, t) : !0
            },
            dependTypes: {
                "boolean": function(e) {
                    return e
                },
                string: function(t, n) {
                    return !!e(t, n.form).length
                },
                "function": function(e, t) {
                    return e(t)
                }
            },
            optional: function(t) {
                var n = this.elementValue(t);
                return !e.validator.methods.required.call(this, n, t) && "dependency-mismatch"
            },
            startRequest: function(e) {
                this.pending[e.name] || (this.pendingRequest++, this.pending[e.name] = !0)
            },
            stopRequest: function(t, n) {
                this.pendingRequest--, this.pendingRequest < 0 && (this.pendingRequest = 0), delete this.pending[t.name], n && 0 === this.pendingRequest && this.formSubmitted && this.form() ? (e(this.currentForm).submit(), this.formSubmitted = !1) : !n && 0 === this.pendingRequest && this.formSubmitted && (e(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1)
            },
            previousValue: function(t) {
                return e.data(t, "previousValue") || e.data(t, "previousValue", {
                    old: null,
                    valid: !0,
                    message: this.defaultMessage(t, "remote")
                })
            }
        },
        classRuleSettings: {
            required: {
                required: !0
            },
            email: {
                email: !0
            },
            url: {
                url: !0
            },
            date: {
                date: !0
            },
            dateISO: {
                dateISO: !0
            },
            number: {
                number: !0
            },
            digits: {
                digits: !0
            },
            creditcard: {
                creditcard: !0
            }
        },
        addClassRules: function(t, n) {
            t.constructor === String ? this.classRuleSettings[t] = n : e.extend(this.classRuleSettings, t)
        },
        classRules: function(t) {
            var n = {},
                i = e(t).attr("class");
            return i && e.each(i.split(" "), function() {
                this in e.validator.classRuleSettings && e.extend(n, e.validator.classRuleSettings[this])
            }), n
        },
        attributeRules: function(t) {
            var n, i, r = {},
                o = e(t),
                s = t.getAttribute("type");
            for (n in e.validator.methods) "required" === n ? (i = t.getAttribute(n), "" === i && (i = !0), i = !!i) : i = o.attr(n), /min|max/.test(n) && (null === s || /number|range|text/.test(s)) && (i = Number(i)), i || 0 === i ? r[n] = i : s === n && "range" !== s && (r[n] = !0);
            return r.maxlength && /-1|2147483647|524288/.test(r.maxlength) && delete r.maxlength, r
        },
        dataRules: function(t) {
            var n, i, r = {},
                o = e(t);
            for (n in e.validator.methods) i = o.data("rule" + n.charAt(0).toUpperCase() + n.substring(1).toLowerCase()), void 0 !== i && (r[n] = i);
            return r
        },
        staticRules: function(t) {
            var n = {},
                i = e.data(t.form, "validator");
            return i.settings.rules && (n = e.validator.normalizeRule(i.settings.rules[t.name]) || {}), n
        },
        normalizeRules: function(t, n) {
            return e.each(t, function(i, r) {
                if (r === !1) return void delete t[i];
                if (r.param || r.depends) {
                    var o = !0;
                    switch (typeof r.depends) {
                        case "string":
                            o = !!e(r.depends, n.form).length;
                            break;
                        case "function":
                            o = r.depends.call(n, n)
                    }
                    o ? t[i] = void 0 !== r.param ? r.param : !0 : delete t[i]
                }
            }), e.each(t, function(i, r) {
                t[i] = e.isFunction(r) ? r(n) : r
            }), e.each(["minlength", "maxlength"], function() {
                t[this] && (t[this] = Number(t[this]))
            }), e.each(["rangelength", "range"], function() {
                var n;
                t[this] && (e.isArray(t[this]) ? t[this] = [Number(t[this][0]), Number(t[this][1])] : "string" == typeof t[this] && (n = t[this].replace(/[\[\]]/g, "").split(/[\s,]+/), t[this] = [Number(n[0]), Number(n[1])]))
            }), e.validator.autoCreateRanges && (null != t.min && null != t.max && (t.range = [t.min, t.max], delete t.min, delete t.max), null != t.minlength && null != t.maxlength && (t.rangelength = [t.minlength, t.maxlength], delete t.minlength, delete t.maxlength)), t
        },
        normalizeRule: function(t) {
            if ("string" == typeof t) {
                var n = {};
                e.each(t.split(/\s/), function() {
                    n[this] = !0
                }), t = n
            }
            return t
        },
        addMethod: function(t, n, i) {
            e.validator.methods[t] = n, e.validator.messages[t] = void 0 !== i ? i : e.validator.messages[t], n.length < 3 && e.validator.addClassRules(t, e.validator.normalizeRule(t))
        },
        methods: {
            required: function(t, n, i) {
                if (!this.depend(i, n)) return "dependency-mismatch";
                if ("select" === n.nodeName.toLowerCase()) {
                    var r = e(n).val();
                    return r && r.length > 0
                }
                return this.checkable(n) ? this.getLength(t, n) > 0 : e.trim(t).length > 0
            },
            email: function(e, t) {
                return this.optional(t) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(e)
            },
            url: function(e, t) {
                return this.optional(t) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(e)
            },
            date: function(e, t) {
                return this.optional(t) || !/Invalid|NaN/.test(new Date(e).toString())
            },
            dateISO: function(e, t) {
                return this.optional(t) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(e)
            },
            number: function(e, t) {
                return this.optional(t) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(e)
            },
            digits: function(e, t) {
                return this.optional(t) || /^\d+$/.test(e)
            },
            creditcard: function(e, t) {
                if (this.optional(t)) return "dependency-mismatch";
                if (/[^0-9 \-]+/.test(e)) return !1;
                var n, i, r = 0,
                    o = 0,
                    s = !1;
                if (e = e.replace(/\D/g, ""), e.length < 13 || e.length > 19) return !1;
                for (n = e.length - 1; n >= 0; n--) i = e.charAt(n), o = parseInt(i, 10), s && (o *= 2) > 9 && (o -= 9), r += o, s = !s;
                return r % 10 === 0
            },
            minlength: function(t, n, i) {
                var r = e.isArray(t) ? t.length : this.getLength(t, n);
                return this.optional(n) || r >= i
            },
            maxlength: function(t, n, i) {
                var r = e.isArray(t) ? t.length : this.getLength(t, n);
                return this.optional(n) || i >= r
            },
            rangelength: function(t, n, i) {
                var r = e.isArray(t) ? t.length : this.getLength(t, n);
                return this.optional(n) || r >= i[0] && r <= i[1]
            },
            min: function(e, t, n) {
                return this.optional(t) || e >= n
            },
            max: function(e, t, n) {
                return this.optional(t) || n >= e
            },
            range: function(e, t, n) {
                return this.optional(t) || e >= n[0] && e <= n[1]
            },
            equalTo: function(t, n, i) {
                var r = e(i);
                return this.settings.onfocusout && r.unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
                    e(n).valid()
                }), t === r.val()
            },
            remote: function(t, n, i) {
                if (this.optional(n)) return "dependency-mismatch";
                var r, o, s = this.previousValue(n);
                return this.settings.messages[n.name] || (this.settings.messages[n.name] = {}), s.originalMessage = this.settings.messages[n.name].remote, this.settings.messages[n.name].remote = s.message, i = "string" == typeof i && {
                    url: i
                } || i, s.old === t ? s.valid : (s.old = t, r = this, this.startRequest(n), o = {}, o[n.name] = t, e.ajax(e.extend(!0, {
                    url: i,
                    mode: "abort",
                    port: "validate" + n.name,
                    dataType: "json",
                    data: o,
                    context: r.currentForm,
                    success: function(i) {
                        var o, a, l, c = i === !0 || "true" === i;
                        r.settings.messages[n.name].remote = s.originalMessage, c ? (l = r.formSubmitted, r.prepareElement(n), r.formSubmitted = l, r.successList.push(n), delete r.invalid[n.name], r.showErrors()) : (o = {}, a = i || r.defaultMessage(n, "remote"), o[n.name] = s.message = e.isFunction(a) ? a(t) : a, r.invalid[n.name] = !0, r.showErrors(o)), s.valid = c, r.stopRequest(n, c)
                    }
                }, i)), "pending")
            }
        }
    }), e.format = function() {
        throw "$.format has been deprecated. Please use $.validator.format instead."
    };
    var t, n = {};
    e.ajaxPrefilter ? e.ajaxPrefilter(function(e, t, i) {
        var r = e.port;
        "abort" === e.mode && (n[r] && n[r].abort(), n[r] = i)
    }) : (t = e.ajax, e.ajax = function(i) {
        var r = ("mode" in i ? i : e.ajaxSettings).mode,
            o = ("port" in i ? i : e.ajaxSettings).port;
        return "abort" === r ? (n[o] && n[o].abort(), n[o] = t.apply(this, arguments), n[o]) : t.apply(this, arguments)
    }), e.extend(e.fn, {
        validateDelegate: function(t, n, i) {
            return this.bind(n, function(n) {
                var r = e(n.target);
                return r.is(t) ? i.apply(r, arguments) : void 0
            })
        }
    })
}), ! function(e) {
    function t() {}

    function n(e) {
        function n(t) {
            t.prototype.option || (t.prototype.option = function(t) {
                e.isPlainObject(t) && (this.options = e.extend(!0, this.options, t))
            })
        }

        function r(t, n) {
            e.fn[t] = function(r) {
                if ("string" == typeof r) {
                    for (var s = i.call(arguments, 1), a = 0, l = this.length; l > a; a++) {
                        var c = this[a],
                            u = e.data(c, t);
                        if (u)
                            if (e.isFunction(u[r]) && "_" !== r.charAt(0)) {
                                var d = u[r].apply(u, s);
                                if (void 0 !== d) return d
                            } else o("no such method '" + r + "' for " + t + " instance");
                        else o("cannot call methods on " + t + " prior to initialization; attempted to call '" + r + "'")
                    }
                    return this
                }
                return this.each(function() {
                    var i = e.data(this, t);
                    i ? (i.option(r), i._init()) : (i = new n(this, r), e.data(this, t, i))
                })
            }
        }
        if (e) {
            var o = "undefined" == typeof console ? t : function(e) {
                console.error(e)
            };
            return e.bridget = function(e, t) {
                n(t), r(e, t)
            }, e.bridget
        }
    }
    var i = Array.prototype.slice;
    "function" == typeof define && define.amd ? define("jquery-bridget/jquery.bridget", ["jquery"], n) : n(e.jQuery)
}(window),
function(e) {
    function t(t) {
        var n = e.event;
        return n.target = n.target || n.srcElement || t, n
    }
    var n = document.documentElement,
        i = function() {};
    n.addEventListener ? i = function(e, t, n) {
        e.addEventListener(t, n, !1)
    } : n.attachEvent && (i = function(e, n, i) {
        e[n + i] = i.handleEvent ? function() {
            var n = t(e);
            i.handleEvent.call(i, n)
        } : function() {
            var n = t(e);
            i.call(e, n)
        }, e.attachEvent("on" + n, e[n + i])
    });
    var r = function() {};
    n.removeEventListener ? r = function(e, t, n) {
        e.removeEventListener(t, n, !1)
    } : n.detachEvent && (r = function(e, t, n) {
        e.detachEvent("on" + t, e[t + n]);
        try {
            delete e[t + n]
        } catch (i) {
            e[t + n] = void 0
        }
    });
    var o = {
        bind: i,
        unbind: r
    };
    "function" == typeof define && define.amd ? define("eventie/eventie", o) : "object" == typeof exports ? module.exports = o : e.eventie = o
}(this),
function(e) {
    function t(e) {
        "function" == typeof e && (t.isReady ? e() : o.push(e))
    }

    function n(e) {
        var n = "readystatechange" === e.type && "complete" !== r.readyState;
        if (!t.isReady && !n) {
            t.isReady = !0;
            for (var i = 0, s = o.length; s > i; i++) {
                var a = o[i];
                a()
            }
        }
    }

    function i(i) {
        return i.bind(r, "DOMContentLoaded", n), i.bind(r, "readystatechange", n), i.bind(e, "load", n), t
    }
    var r = e.document,
        o = [];
    t.isReady = !1, "function" == typeof define && define.amd ? (t.isReady = "function" == typeof requirejs, define("doc-ready/doc-ready", ["eventie/eventie"], i)) : e.docReady = i(e.eventie)
}(this),
function() {
    function e() {}

    function t(e, t) {
        for (var n = e.length; n--;)
            if (e[n].listener === t) return n;
        return -1
    }

    function n(e) {
        return function() {
            return this[e].apply(this, arguments)
        }
    }
    var i = e.prototype,
        r = this,
        o = r.EventEmitter;
    i.getListeners = function(e) {
        var t, n, i = this._getEvents();
        if (e instanceof RegExp) {
            t = {};
            for (n in i) i.hasOwnProperty(n) && e.test(n) && (t[n] = i[n])
        } else t = i[e] || (i[e] = []);
        return t
    }, i.flattenListeners = function(e) {
        var t, n = [];
        for (t = 0; t < e.length; t += 1) n.push(e[t].listener);
        return n
    }, i.getListenersAsObject = function(e) {
        var t, n = this.getListeners(e);
        return n instanceof Array && (t = {}, t[e] = n), t || n
    }, i.addListener = function(e, n) {
        var i, r = this.getListenersAsObject(e),
            o = "object" == typeof n;
        for (i in r) r.hasOwnProperty(i) && -1 === t(r[i], n) && r[i].push(o ? n : {
            listener: n,
            once: !1
        });
        return this
    }, i.on = n("addListener"), i.addOnceListener = function(e, t) {
        return this.addListener(e, {
            listener: t,
            once: !0
        })
    }, i.once = n("addOnceListener"), i.defineEvent = function(e) {
        return this.getListeners(e), this
    }, i.defineEvents = function(e) {
        for (var t = 0; t < e.length; t += 1) this.defineEvent(e[t]);
        return this
    }, i.removeListener = function(e, n) {
        var i, r, o = this.getListenersAsObject(e);
        for (r in o) o.hasOwnProperty(r) && (i = t(o[r], n), -1 !== i && o[r].splice(i, 1));
        return this
    }, i.off = n("removeListener"), i.addListeners = function(e, t) {
        return this.manipulateListeners(!1, e, t)
    }, i.removeListeners = function(e, t) {
        return this.manipulateListeners(!0, e, t)
    }, i.manipulateListeners = function(e, t, n) {
        var i, r, o = e ? this.removeListener : this.addListener,
            s = e ? this.removeListeners : this.addListeners;
        if ("object" != typeof t || t instanceof RegExp)
            for (i = n.length; i--;) o.call(this, t, n[i]);
        else
            for (i in t) t.hasOwnProperty(i) && (r = t[i]) && ("function" == typeof r ? o.call(this, i, r) : s.call(this, i, r));
        return this
    }, i.removeEvent = function(e) {
        var t, n = typeof e,
            i = this._getEvents();
        if ("string" === n) delete i[e];
        else if (e instanceof RegExp)
            for (t in i) i.hasOwnProperty(t) && e.test(t) && delete i[t];
        else delete this._events;
        return this
    }, i.removeAllListeners = n("removeEvent"), i.emitEvent = function(e, t) {
        var n, i, r, o, s = this.getListenersAsObject(e);
        for (r in s)
            if (s.hasOwnProperty(r))
                for (i = s[r].length; i--;) n = s[r][i], n.once === !0 && this.removeListener(e, n.listener), o = n.listener.apply(this, t || []), o === this._getOnceReturnValue() && this.removeListener(e, n.listener);
        return this
    }, i.trigger = n("emitEvent"), i.emit = function(e) {
        var t = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(e, t)
    }, i.setOnceReturnValue = function(e) {
        return this._onceReturnValue = e, this
    }, i._getOnceReturnValue = function() {
        return this.hasOwnProperty("_onceReturnValue") ? this._onceReturnValue : !0
    }, i._getEvents = function() {
        return this._events || (this._events = {})
    }, e.noConflict = function() {
        return r.EventEmitter = o, e
    }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function() {
        return e
    }) : "object" == typeof module && module.exports ? module.exports = e : this.EventEmitter = e
}.call(this),
    function(e) {
        function t(e) {
            if (e) {
                if ("string" == typeof i[e]) return e;
                e = e.charAt(0).toUpperCase() + e.slice(1);
                for (var t, r = 0, o = n.length; o > r; r++)
                    if (t = n[r] + e, "string" == typeof i[t]) return t
            }
        }
        var n = "Webkit Moz ms Ms O".split(" "),
            i = document.documentElement.style;
        "function" == typeof define && define.amd ? define("get-style-property/get-style-property", [], function() {
            return t
        }) : "object" == typeof exports ? module.exports = t : e.getStyleProperty = t
    }(window),
    function(e) {
        function t(e) {
            var t = parseFloat(e),
                n = -1 === e.indexOf("%") && !isNaN(t);
            return n && t
        }

        function n() {
            for (var e = {
                    width: 0,
                    height: 0,
                    innerWidth: 0,
                    innerHeight: 0,
                    outerWidth: 0,
                    outerHeight: 0
                }, t = 0, n = s.length; n > t; t++) {
                var i = s[t];
                e[i] = 0
            }
            return e
        }

        function i(e) {
            function i(e) {
                if ("string" == typeof e && (e = document.querySelector(e)), e && "object" == typeof e && e.nodeType) {
                    var i = o(e);
                    if ("none" === i.display) return n();
                    var r = {};
                    r.width = e.offsetWidth, r.height = e.offsetHeight;
                    for (var u = r.isBorderBox = !(!c || !i[c] || "border-box" !== i[c]), d = 0, p = s.length; p > d; d++) {
                        var h = s[d],
                            f = i[h];
                        f = a(e, f);
                        var g = parseFloat(f);
                        r[h] = isNaN(g) ? 0 : g
                    }
                    var m = r.paddingLeft + r.paddingRight,
                        v = r.paddingTop + r.paddingBottom,
                        y = r.marginLeft + r.marginRight,
                        b = r.marginTop + r.marginBottom,
                        x = r.borderLeftWidth + r.borderRightWidth,
                        w = r.borderTopWidth + r.borderBottomWidth,
                        C = u && l,
                        S = t(i.width);
                    S !== !1 && (r.width = S + (C ? 0 : m + x));
                    var T = t(i.height);
                    return T !== !1 && (r.height = T + (C ? 0 : v + w)), r.innerWidth = r.width - (m + x), r.innerHeight = r.height - (v + w), r.outerWidth = r.width + y, r.outerHeight = r.height + b, r
                }
            }

            function a(e, t) {
                if (r || -1 === t.indexOf("%")) return t;
                var n = e.style,
                    i = n.left,
                    o = e.runtimeStyle,
                    s = o && o.left;
                return s && (o.left = e.currentStyle.left), n.left = t, t = n.pixelLeft, n.left = i, s && (o.left = s), t
            }
            var l, c = e("boxSizing");
            return function() {
                if (c) {
                    var e = document.createElement("div");
                    e.style.width = "200px", e.style.padding = "1px 2px 3px 4px", e.style.borderStyle = "solid", e.style.borderWidth = "1px 2px 3px 4px", e.style[c] = "border-box";
                    var n = document.body || document.documentElement;
                    n.appendChild(e);
                    var i = o(e);
                    l = 200 === t(i.width), n.removeChild(e)
                }
            }(), i
        }
        var r = e.getComputedStyle,
            o = r ? function(e) {
                return r(e, null)
            } : function(e) {
                return e.currentStyle
            },
            s = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"];
        "function" == typeof define && define.amd ? define("get-size/get-size", ["get-style-property/get-style-property"], i) : "object" == typeof exports ? module.exports = i(require("get-style-property")) : e.getSize = i(e.getStyleProperty)
    }(window),
    function(e, t) {
        function n(e, t) {
            return e[a](t)
        }

        function i(e) {
            if (!e.parentNode) {
                var t = document.createDocumentFragment();
                t.appendChild(e)
            }
        }

        function r(e, t) {
            i(e);
            for (var n = e.parentNode.querySelectorAll(t), r = 0, o = n.length; o > r; r++)
                if (n[r] === e) return !0;
            return !1
        }

        function o(e, t) {
            return i(e), n(e, t)
        }
        var s, a = function() {
            if (t.matchesSelector) return "matchesSelector";
            for (var e = ["webkit", "moz", "ms", "o"], n = 0, i = e.length; i > n; n++) {
                var r = e[n],
                    o = r + "MatchesSelector";
                if (t[o]) return o
            }
        }();
        if (a) {
            var l = document.createElement("div"),
                c = n(l, "div");
            s = c ? n : o
        } else s = r;
        "function" == typeof define && define.amd ? define("matches-selector/matches-selector", [], function() {
            return s
        }) : window.matchesSelector = s
    }(this, Element.prototype),
    function(e) {
        function t(e, t) {
            for (var n in t) e[n] = t[n];
            return e
        }

        function n(e) {
            for (var t in e) return !1;
            return t = null, !0
        }

        function i(e) {
            return e.replace(/([A-Z])/g, function(e) {
                return "-" + e.toLowerCase()
            })
        }

        function r(e, r, o) {
            function a(e, t) {
                e && (this.element = e, this.layout = t, this.position = {
                    x: 0,
                    y: 0
                }, this._create())
            }
            var l = o("transition"),
                c = o("transform"),
                u = l && c,
                d = !!o("perspective"),
                p = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "otransitionend",
                    transition: "transitionend"
                }[l],
                h = ["transform", "transition", "transitionDuration", "transitionProperty"],
                f = function() {
                    for (var e = {}, t = 0, n = h.length; n > t; t++) {
                        var i = h[t],
                            r = o(i);
                        r && r !== i && (e[i] = r)
                    }
                    return e
                }();
            t(a.prototype, e.prototype), a.prototype._create = function() {
                this._transn = {
                    ingProperties: {},
                    clean: {},
                    onEnd: {}
                }, this.css({
                    position: "absolute"
                })
            }, a.prototype.handleEvent = function(e) {
                var t = "on" + e.type;
                this[t] && this[t](e)
            }, a.prototype.getSize = function() {
                this.size = r(this.element)
            }, a.prototype.css = function(e) {
                var t = this.element.style;
                for (var n in e) {
                    var i = f[n] || n;
                    t[i] = e[n]
                }
            }, a.prototype.getPosition = function() {
                var e = s(this.element),
                    t = this.layout.options,
                    n = t.isOriginLeft,
                    i = t.isOriginTop,
                    r = parseInt(e[n ? "left" : "right"], 10),
                    o = parseInt(e[i ? "top" : "bottom"], 10);
                r = isNaN(r) ? 0 : r, o = isNaN(o) ? 0 : o;
                var a = this.layout.size;
                r -= n ? a.paddingLeft : a.paddingRight, o -= i ? a.paddingTop : a.paddingBottom, this.position.x = r, this.position.y = o
            }, a.prototype.layoutPosition = function() {
                var e = this.layout.size,
                    t = this.layout.options,
                    n = {};
                t.isOriginLeft ? (n.left = this.position.x + e.paddingLeft + "px", n.right = "") : (n.right = this.position.x + e.paddingRight + "px", n.left = ""), t.isOriginTop ? (n.top = this.position.y + e.paddingTop + "px", n.bottom = "") : (n.bottom = this.position.y + e.paddingBottom + "px", n.top = ""), this.css(n), this.emitEvent("layout", [this])
            };
            var g = d ? function(e, t) {
                return "translate3d(" + e + "px, " + t + "px, 0)"
            } : function(e, t) {
                return "translate(" + e + "px, " + t + "px)"
            };
            a.prototype._transitionTo = function(e, t) {
                this.getPosition();
                var n = this.position.x,
                    i = this.position.y,
                    r = parseInt(e, 10),
                    o = parseInt(t, 10),
                    s = r === this.position.x && o === this.position.y;
                if (this.setPosition(e, t), s && !this.isTransitioning) return void this.layoutPosition();
                var a = e - n,
                    l = t - i,
                    c = {},
                    u = this.layout.options;
                a = u.isOriginLeft ? a : -a, l = u.isOriginTop ? l : -l, c.transform = g(a, l), this.transition({
                    to: c,
                    onTransitionEnd: {
                        transform: this.layoutPosition
                    },
                    isCleaning: !0
                })
            }, a.prototype.goTo = function(e, t) {
                this.setPosition(e, t), this.layoutPosition()
            }, a.prototype.moveTo = u ? a.prototype._transitionTo : a.prototype.goTo, a.prototype.setPosition = function(e, t) {
                this.position.x = parseInt(e, 10), this.position.y = parseInt(t, 10)
            }, a.prototype._nonTransition = function(e) {
                this.css(e.to), e.isCleaning && this._removeStyles(e.to);
                for (var t in e.onTransitionEnd) e.onTransitionEnd[t].call(this)
            }, a.prototype._transition = function(e) {
                if (!parseFloat(this.layout.options.transitionDuration)) return void this._nonTransition(e);
                var t = this._transn;
                for (var n in e.onTransitionEnd) t.onEnd[n] = e.onTransitionEnd[n];
                for (n in e.to) t.ingProperties[n] = !0, e.isCleaning && (t.clean[n] = !0);
                if (e.from) {
                    this.css(e.from);
                    var i = this.element.offsetHeight;
                    i = null
                }
                this.enableTransition(e.to), this.css(e.to), this.isTransitioning = !0
            };
            var m = c && i(c) + ",opacity";
            a.prototype.enableTransition = function() {
                this.isTransitioning || (this.css({
                    transitionProperty: m,
                    transitionDuration: this.layout.options.transitionDuration
                }), this.element.addEventListener(p, this, !1))
            }, a.prototype.transition = a.prototype[l ? "_transition" : "_nonTransition"], a.prototype.onwebkitTransitionEnd = function(e) {
                this.ontransitionend(e)
            }, a.prototype.onotransitionend = function(e) {
                this.ontransitionend(e)
            };
            var v = {
                "-webkit-transform": "transform",
                "-moz-transform": "transform",
                "-o-transform": "transform"
            };
            a.prototype.ontransitionend = function(e) {
                if (e.target === this.element) {
                    var t = this._transn,
                        i = v[e.propertyName] || e.propertyName;
                    if (delete t.ingProperties[i], n(t.ingProperties) && this.disableTransition(), i in t.clean && (this.element.style[e.propertyName] = "", delete t.clean[i]), i in t.onEnd) {
                        var r = t.onEnd[i];
                        r.call(this), delete t.onEnd[i]
                    }
                    this.emitEvent("transitionEnd", [this])
                }
            }, a.prototype.disableTransition = function() {
                this.removeTransitionStyles(), this.element.removeEventListener(p, this, !1), this.isTransitioning = !1
            }, a.prototype._removeStyles = function(e) {
                var t = {};
                for (var n in e) t[n] = "";
                this.css(t)
            };
            var y = {
                transitionProperty: "",
                transitionDuration: ""
            };
            return a.prototype.removeTransitionStyles = function() {
                this.css(y)
            }, a.prototype.removeElem = function() {
                this.element.parentNode.removeChild(this.element), this.emitEvent("remove", [this])
            }, a.prototype.remove = function() {
                if (!l || !parseFloat(this.layout.options.transitionDuration)) return void this.removeElem();
                var e = this;
                this.on("transitionEnd", function() {
                    return e.removeElem(), !0
                }), this.hide()
            }, a.prototype.reveal = function() {
                delete this.isHidden, this.css({
                    display: ""
                });
                var e = this.layout.options;
                this.transition({
                    from: e.hiddenStyle,
                    to: e.visibleStyle,
                    isCleaning: !0
                })
            }, a.prototype.hide = function() {
                this.isHidden = !0, this.css({
                    display: ""
                });
                var e = this.layout.options;
                this.transition({
                    from: e.visibleStyle,
                    to: e.hiddenStyle,
                    isCleaning: !0,
                    onTransitionEnd: {
                        opacity: function() {
                            this.isHidden && this.css({
                                display: "none"
                            })
                        }
                    }
                })
            }, a.prototype.destroy = function() {
                this.css({
                    position: "",
                    left: "",
                    right: "",
                    top: "",
                    bottom: "",
                    transition: "",
                    transform: ""
                })
            }, a
        }
        var o = e.getComputedStyle,
            s = o ? function(e) {
                return o(e, null)
            } : function(e) {
                return e.currentStyle
            };
        "function" == typeof define && define.amd ? define("outlayer/item", ["eventEmitter/EventEmitter", "get-size/get-size", "get-style-property/get-style-property"], r) : (e.Outlayer = {}, e.Outlayer.Item = r(e.EventEmitter, e.getSize, e.getStyleProperty))
    }(window),
    function(e) {
        function t(e, t) {
            for (var n in t) e[n] = t[n];
            return e
        }

        function n(e) {
            return "[object Array]" === d.call(e)
        }

        function i(e) {
            var t = [];
            if (n(e)) t = e;
            else if (e && "number" == typeof e.length)
                for (var i = 0, r = e.length; r > i; i++) t.push(e[i]);
            else t.push(e);
            return t
        }

        function r(e, t) {
            var n = h(t, e); - 1 !== n && t.splice(n, 1)
        }

        function o(e) {
            return e.replace(/(.)([A-Z])/g, function(e, t, n) {
                return t + "-" + n
            }).toLowerCase()
        }

        function s(n, s, d, h, f, g) {
            function m(e, n) {
                if ("string" == typeof e && (e = a.querySelector(e)), !e || !p(e)) return void(l && l.error("Bad " + this.constructor.namespace + " element: " + e));
                this.element = e, this.options = t({}, this.constructor.defaults), this.option(n);
                var i = ++v;
                this.element.outlayerGUID = i, y[i] = this, this._create(), this.options.isInitLayout && this.layout()
            }
            var v = 0,
                y = {};
            return m.namespace = "outlayer", m.Item = g, m.defaults = {
                containerStyle: {
                    position: "relative"
                },
                isInitLayout: !0,
                isOriginLeft: !0,
                isOriginTop: !0,
                isResizeBound: !0,
                isResizingContainer: !0,
                transitionDuration: "0.4s",
                hiddenStyle: {
                    opacity: 0,
                    transform: "scale(0.001)"
                },
                visibleStyle: {
                    opacity: 1,
                    transform: "scale(1)"
                }
            }, t(m.prototype, d.prototype), m.prototype.option = function(e) {
                t(this.options, e)
            }, m.prototype._create = function() {
                this.reloadItems(), this.stamps = [], this.stamp(this.options.stamp), t(this.element.style, this.options.containerStyle), this.options.isResizeBound && this.bindResize()
            }, m.prototype.reloadItems = function() {
                this.items = this._itemize(this.element.children)
            }, m.prototype._itemize = function(e) {
                for (var t = this._filterFindItemElements(e), n = this.constructor.Item, i = [], r = 0, o = t.length; o > r; r++) {
                    var s = t[r],
                        a = new n(s, this);
                    i.push(a)
                }
                return i
            }, m.prototype._filterFindItemElements = function(e) {
                e = i(e);
                for (var t = this.options.itemSelector, n = [], r = 0, o = e.length; o > r; r++) {
                    var s = e[r];
                    if (p(s))
                        if (t) {
                            f(s, t) && n.push(s);
                            for (var a = s.querySelectorAll(t), l = 0, c = a.length; c > l; l++) n.push(a[l])
                        } else n.push(s)
                }
                return n
            }, m.prototype.getItemElements = function() {
                for (var e = [], t = 0, n = this.items.length; n > t; t++) e.push(this.items[t].element);
                return e
            }, m.prototype.layout = function() {
                this._resetLayout(), this._manageStamps();
                var e = void 0 !== this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited;
                this.layoutItems(this.items, e), this._isLayoutInited = !0
            }, m.prototype._init = m.prototype.layout, m.prototype._resetLayout = function() {
                this.getSize()
            }, m.prototype.getSize = function() {
                this.size = h(this.element)
            }, m.prototype._getMeasurement = function(e, t) {
                var n, i = this.options[e];
                i ? ("string" == typeof i ? n = this.element.querySelector(i) : p(i) && (n = i), this[e] = n ? h(n)[t] : i) : this[e] = 0
            }, m.prototype.layoutItems = function(e, t) {
                e = this._getItemsForLayout(e), this._layoutItems(e, t), this._postLayout()
            }, m.prototype._getItemsForLayout = function(e) {
                for (var t = [], n = 0, i = e.length; i > n; n++) {
                    var r = e[n];
                    r.isIgnored || t.push(r)
                }
                return t
            }, m.prototype._layoutItems = function(e, t) {
                function n() {
                    i.emitEvent("layoutComplete", [i, e])
                }
                var i = this;
                if (!e || !e.length) return void n();
                this._itemsOn(e, "layout", n);
                for (var r = [], o = 0, s = e.length; s > o; o++) {
                    var a = e[o],
                        l = this._getItemLayoutPosition(a);
                    l.item = a, l.isInstant = t || a.isLayoutInstant, r.push(l)
                }
                this._processLayoutQueue(r)
            }, m.prototype._getItemLayoutPosition = function() {
                return {
                    x: 0,
                    y: 0
                }
            }, m.prototype._processLayoutQueue = function(e) {
                for (var t = 0, n = e.length; n > t; t++) {
                    var i = e[t];
                    this._positionItem(i.item, i.x, i.y, i.isInstant)
                }
            }, m.prototype._positionItem = function(e, t, n, i) {
                i ? e.goTo(t, n) : e.moveTo(t, n)
            }, m.prototype._postLayout = function() {
                this.resizeContainer()
            }, m.prototype.resizeContainer = function() {
                if (this.options.isResizingContainer) {
                    var e = this._getContainerSize();
                    e && (this._setContainerMeasure(e.width, !0), this._setContainerMeasure(e.height, !1))
                }
            }, m.prototype._getContainerSize = u, m.prototype._setContainerMeasure = function(e, t) {
                if (void 0 !== e) {
                    var n = this.size;
                    n.isBorderBox && (e += t ? n.paddingLeft + n.paddingRight + n.borderLeftWidth + n.borderRightWidth : n.paddingBottom + n.paddingTop + n.borderTopWidth + n.borderBottomWidth), e = Math.max(e, 0), this.element.style[t ? "width" : "height"] = e + "px"
                }
            }, m.prototype._itemsOn = function(e, t, n) {
                function i() {
                    return r++, r === o && n.call(s), !0
                }
                for (var r = 0, o = e.length, s = this, a = 0, l = e.length; l > a; a++) {
                    var c = e[a];
                    c.on(t, i)
                }
            }, m.prototype.ignore = function(e) {
                var t = this.getItem(e);
                t && (t.isIgnored = !0)
            }, m.prototype.unignore = function(e) {
                var t = this.getItem(e);
                t && delete t.isIgnored
            }, m.prototype.stamp = function(e) {
                if (e = this._find(e)) {
                    this.stamps = this.stamps.concat(e);
                    for (var t = 0, n = e.length; n > t; t++) {
                        var i = e[t];
                        this.ignore(i)
                    }
                }
            }, m.prototype.unstamp = function(e) {
                if (e = this._find(e))
                    for (var t = 0, n = e.length; n > t; t++) {
                        var i = e[t];
                        r(i, this.stamps), this.unignore(i)
                    }
            }, m.prototype._find = function(e) {
                return e ? ("string" == typeof e && (e = this.element.querySelectorAll(e)), e = i(e)) : void 0
            }, m.prototype._manageStamps = function() {
                if (this.stamps && this.stamps.length) {
                    this._getBoundingRect();
                    for (var e = 0, t = this.stamps.length; t > e; e++) {
                        var n = this.stamps[e];
                        this._manageStamp(n)
                    }
                }
            }, m.prototype._getBoundingRect = function() {
                var e = this.element.getBoundingClientRect(),
                    t = this.size;
                this._boundingRect = {
                    left: e.left + t.paddingLeft + t.borderLeftWidth,
                    top: e.top + t.paddingTop + t.borderTopWidth,
                    right: e.right - (t.paddingRight + t.borderRightWidth),
                    bottom: e.bottom - (t.paddingBottom + t.borderBottomWidth)
                }
            }, m.prototype._manageStamp = u, m.prototype._getElementOffset = function(e) {
                var t = e.getBoundingClientRect(),
                    n = this._boundingRect,
                    i = h(e),
                    r = {
                        left: t.left - n.left - i.marginLeft,
                        top: t.top - n.top - i.marginTop,
                        right: n.right - t.right - i.marginRight,
                        bottom: n.bottom - t.bottom - i.marginBottom
                    };
                return r
            }, m.prototype.handleEvent = function(e) {
                var t = "on" + e.type;
                this[t] && this[t](e)
            }, m.prototype.bindResize = function() {
                this.isResizeBound || (n.bind(e, "resize", this), this.isResizeBound = !0)
            }, m.prototype.unbindResize = function() {
                this.isResizeBound && n.unbind(e, "resize", this), this.isResizeBound = !1
            }, m.prototype.onresize = function() {
                function e() {
                    t.resize(), delete t.resizeTimeout
                }
                this.resizeTimeout && clearTimeout(this.resizeTimeout);
                var t = this;
                this.resizeTimeout = setTimeout(e, 100)
            }, m.prototype.resize = function() {
                this.isResizeBound && this.needsResizeLayout() && this.layout()
            }, m.prototype.needsResizeLayout = function() {
                var e = h(this.element),
                    t = this.size && e;
                return t && e.innerWidth !== this.size.innerWidth
            }, m.prototype.addItems = function(e) {
                var t = this._itemize(e);
                return t.length && (this.items = this.items.concat(t)), t
            }, m.prototype.appended = function(e) {
                var t = this.addItems(e);
                t.length && (this.layoutItems(t, !0), this.reveal(t))
            }, m.prototype.prepended = function(e) {
                var t = this._itemize(e);
                if (t.length) {
                    var n = this.items.slice(0);
                    this.items = t.concat(n), this._resetLayout(), this._manageStamps(), this.layoutItems(t, !0), this.reveal(t), this.layoutItems(n)
                }
            }, m.prototype.reveal = function(e) {
                var t = e && e.length;
                if (t)
                    for (var n = 0; t > n; n++) {
                        var i = e[n];
                        i.reveal()
                    }
            }, m.prototype.hide = function(e) {
                var t = e && e.length;
                if (t)
                    for (var n = 0; t > n; n++) {
                        var i = e[n];
                        i.hide()
                    }
            }, m.prototype.getItem = function(e) {
                for (var t = 0, n = this.items.length; n > t; t++) {
                    var i = this.items[t];
                    if (i.element === e) return i
                }
            }, m.prototype.getItems = function(e) {
                if (e && e.length) {
                    for (var t = [], n = 0, i = e.length; i > n; n++) {
                        var r = e[n],
                            o = this.getItem(r);
                        o && t.push(o)
                    }
                    return t
                }
            }, m.prototype.remove = function(e) {
                e = i(e);
                var t = this.getItems(e);
                if (t && t.length) {
                    this._itemsOn(t, "remove", function() {
                        this.emitEvent("removeComplete", [this, t])
                    });
                    for (var n = 0, o = t.length; o > n; n++) {
                        var s = t[n];
                        s.remove(), r(s, this.items)
                    }
                }
            }, m.prototype.destroy = function() {
                var e = this.element.style;
                e.height = "", e.position = "", e.width = "";
                for (var t = 0, n = this.items.length; n > t; t++) {
                    var i = this.items[t];
                    i.destroy()
                }
                this.unbindResize(), delete this.element.outlayerGUID, c && c.removeData(this.element, this.constructor.namespace)
            }, m.data = function(e) {
                var t = e && e.outlayerGUID;
                return t && y[t]
            }, m.create = function(e, n) {
                function i() {
                    m.apply(this, arguments)
                }
                return Object.create ? i.prototype = Object.create(m.prototype) : t(i.prototype, m.prototype), i.prototype.constructor = i, i.defaults = t({}, m.defaults), t(i.defaults, n), i.prototype.settings = {}, i.namespace = e, i.data = m.data, i.Item = function() {
                    g.apply(this, arguments)
                }, i.Item.prototype = new g, s(function() {
                    for (var t = o(e), n = a.querySelectorAll(".js-" + t), r = "data-" + t + "-options", s = 0, u = n.length; u > s; s++) {
                        var d, p = n[s],
                            h = p.getAttribute(r);
                        try {
                            d = h && JSON.parse(h)
                        } catch (f) {
                            l && l.error("Error parsing " + r + " on " + p.nodeName.toLowerCase() + (p.id ? "#" + p.id : "") + ": " + f);
                            continue
                        }
                        var g = new i(p, d);
                        c && c.data(p, e, g)
                    }
                }), c && c.bridget && c.bridget(e, i), i
            }, m.Item = g, m
        }
        var a = e.document,
            l = e.console,
            c = e.jQuery,
            u = function() {},
            d = Object.prototype.toString,
            p = "object" == typeof HTMLElement ? function(e) {
                return e instanceof HTMLElement
            } : function(e) {
                return e && "object" == typeof e && 1 === e.nodeType && "string" == typeof e.nodeName
            },
            h = Array.prototype.indexOf ? function(e, t) {
                return e.indexOf(t)
            } : function(e, t) {
                for (var n = 0, i = e.length; i > n; n++)
                    if (e[n] === t) return n;
                return -1
            };
        "function" == typeof define && define.amd ? define("outlayer/outlayer", ["eventie/eventie", "doc-ready/doc-ready", "eventEmitter/EventEmitter", "get-size/get-size", "matches-selector/matches-selector", "./item"], s) : e.Outlayer = s(e.eventie, e.docReady, e.EventEmitter, e.getSize, e.matchesSelector, e.Outlayer.Item)
    }(window),
    function(e) {
        function t(e, t) {
            var i = e.create("masonry");
            return i.prototype._resetLayout = function() {
                this.getSize(), this._getMeasurement("columnWidth", "outerWidth"), this._getMeasurement("gutter", "outerWidth"), this.measureColumns();
                var e = this.cols;
                for (this.colYs = []; e--;) this.colYs.push(0);
                this.maxY = 0
            }, i.prototype.measureColumns = function() {
                if (this.getContainerWidth(), !this.columnWidth) {
                    var e = this.items[0],
                        n = e && e.element;
                    this.columnWidth = n && t(n).outerWidth || this.containerWidth
                }
                this.columnWidth += this.gutter, this.cols = Math.floor((this.containerWidth + this.gutter) / this.columnWidth), this.cols = Math.max(this.cols, 1)
            }, i.prototype.getContainerWidth = function() {
                var e = this.options.isFitWidth ? this.element.parentNode : this.element,
                    n = t(e);
                this.containerWidth = n && n.innerWidth
            }, i.prototype._getItemLayoutPosition = function(e) {
                e.getSize();
                var t = e.size.outerWidth % this.columnWidth,
                    i = t && 1 > t ? "round" : "ceil",
                    r = Math[i](e.size.outerWidth / this.columnWidth);
                r = Math.min(r, this.cols);
                for (var o = this._getColGroup(r), s = Math.min.apply(Math, o), a = n(o, s), l = {
                        x: this.columnWidth * a,
                        y: s
                    }, c = s + e.size.outerHeight, u = this.cols + 1 - o.length, d = 0; u > d; d++) this.colYs[a + d] = c;
                return l
            }, i.prototype._getColGroup = function(e) {
                if (2 > e) return this.colYs;
                for (var t = [], n = this.cols + 1 - e, i = 0; n > i; i++) {
                    var r = this.colYs.slice(i, i + e);
                    t[i] = Math.max.apply(Math, r)
                }
                return t
            }, i.prototype._manageStamp = function(e) {
                var n = t(e),
                    i = this._getElementOffset(e),
                    r = this.options.isOriginLeft ? i.left : i.right,
                    o = r + n.outerWidth,
                    s = Math.floor(r / this.columnWidth);
                s = Math.max(0, s);
                var a = Math.floor(o / this.columnWidth);
                a -= o % this.columnWidth ? 0 : 1, a = Math.min(this.cols - 1, a);
                for (var l = (this.options.isOriginTop ? i.top : i.bottom) + n.outerHeight, c = s; a >= c; c++) this.colYs[c] = Math.max(l, this.colYs[c])
            }, i.prototype._getContainerSize = function() {
                this.maxY = Math.max.apply(Math, this.colYs);
                var e = {
                    height: this.maxY
                };
                return this.options.isFitWidth && (e.width = this._getContainerFitWidth()), e
            }, i.prototype._getContainerFitWidth = function() {
                for (var e = 0, t = this.cols; --t && 0 === this.colYs[t];) e++;
                return (this.cols - e) * this.columnWidth - this.gutter
            }, i.prototype.needsResizeLayout = function() {
                var e = this.containerWidth;
                return this.getContainerWidth(), e !== this.containerWidth
            }, i
        }
        var n = Array.prototype.indexOf ? function(e, t) {
            return e.indexOf(t)
        } : function(e, t) {
            for (var n = 0, i = e.length; i > n; n++) {
                var r = e[n];
                if (r === t) return n
            }
            return -1
        };
        "function" == typeof define && define.amd ? define(["outlayer/outlayer", "get-size/get-size"], t) : e.Masonry = t(e.Outlayer, e.getSize)
    }(window),
    function(e) {
        "function" == typeof define && define.amd ? define(e) : window.purl = e()
    }(function() {
        function e(e, t) {
            for (var n = decodeURI(e), i = g[t ? "strict" : "loose"].exec(n), r = {
                    attr: {},
                    param: {},
                    seg: {}
                }, s = 14; s--;) r.attr[h[s]] = i[s] || "";
            return r.param.query = o(r.attr.query), r.param.fragment = o(r.attr.fragment), r.seg.path = r.attr.path.replace(/^\/+|\/+$/g, "").split("/"), r.seg.fragment = r.attr.fragment.replace(/^\/+|\/+$/g, "").split("/"), r.attr.base = r.attr.host ? (r.attr.protocol ? r.attr.protocol + "://" + r.attr.host : r.attr.host) + (r.attr.port ? ":" + r.attr.port : "") : "", r
        }

        function t(e) {
            var t = e.tagName;
            return "undefined" != typeof t ? p[t.toLowerCase()] : t
        }

        function n(e, t) {
            if (0 === e[t].length) return e[t] = {};
            var n = {};
            for (var i in e[t]) n[i] = e[t][i];
            return e[t] = n, n
        }

        function i(e, t, r, o) {
            var s = e.shift();
            if (s) {
                var a = t[r] = t[r] || [];
                "]" == s ? c(a) ? "" !== o && a.push(o) : "object" == typeof a ? a[u(a).length] = o : a = t[r] = [t[r], o] : ~s.indexOf("]") ? (s = s.substr(0, s.length - 1), !m.test(s) && c(a) && (a = n(t, r)), i(e, a, s, o)) : (!m.test(s) && c(a) && (a = n(t, r)), i(e, a, s, o))
            } else c(t[r]) ? t[r].push(o) : "object" == typeof t[r] ? t[r] = o : "undefined" == typeof t[r] ? t[r] = o : t[r] = [t[r], o]
        }

        function r(e, t, n) {
            if (~t.indexOf("]")) {
                var r = t.split("[");
                i(r, e, "base", n)
            } else {
                if (!m.test(t) && c(e.base)) {
                    var o = {};
                    for (var a in e.base) o[a] = e.base[a];
                    e.base = o
                }
                "" !== t && s(e.base, t, n)
            }
            return e
        }

        function o(e) {
            return l(String(e).split(/&|;/), function(e, t) {
                try {
                    t = decodeURIComponent(t.replace(/\+/g, " "))
                } catch (n) {}
                var i = t.indexOf("="),
                    o = a(t),
                    s = t.substr(0, o || i),
                    l = t.substr(o || i, t.length);
                return l = l.substr(l.indexOf("=") + 1, l.length), "" === s && (s = t, l = ""), r(e, s, l)
            }, {
                base: {}
            }).base
        }

        function s(e, t, n) {
            var i = e[t];
            "undefined" == typeof i ? e[t] = n : c(i) ? i.push(n) : e[t] = [i, n]
        }

        function a(e) {
            for (var t, n, i = e.length, r = 0; i > r; ++r)
                if (n = e[r], "]" == n && (t = !1), "[" == n && (t = !0), "=" == n && !t) return r
        }

        function l(e, t) {
            for (var n = 0, i = e.length >> 0, r = arguments[2]; i > n;) n in e && (r = t.call(void 0, r, e[n], n, e)), ++n;
            return r
        }

        function c(e) {
            return "[object Array]" === Object.prototype.toString.call(e)
        }

        function u(e) {
            var t = [];
            for (var n in e) e.hasOwnProperty(n) && t.push(n);
            return t
        }

        function d(t, n) {
            return 1 === arguments.length && t === !0 && (n = !0, t = void 0), n = n || !1, t = t || window.location.toString(), {
                data: e(t, n),
                attr: function(e) {
                    return e = f[e] || e, "undefined" != typeof e ? this.data.attr[e] : this.data.attr
                },
                param: function(e) {
                    return "undefined" != typeof e ? this.data.param.query[e] : this.data.param.query
                },
                fparam: function(e) {
                    return "undefined" != typeof e ? this.data.param.fragment[e] : this.data.param.fragment
                },
                segment: function(e) {
                    return "undefined" == typeof e ? this.data.seg.path : (e = 0 > e ? this.data.seg.path.length + e : e - 1, this.data.seg.path[e])
                },
                fsegment: function(e) {
                    return "undefined" == typeof e ? this.data.seg.fragment : (e = 0 > e ? this.data.seg.fragment.length + e : e - 1, this.data.seg.fragment[e])
                }
            }
        }
        var p = {
                a: "href",
                img: "src",
                form: "action",
                base: "href",
                script: "src",
                iframe: "src",
                link: "href",
                embed: "src",
                object: "data"
            },
            h = ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "fragment"],
            f = {
                anchor: "fragment"
            },
            g = {
                strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
            },
            m = /^[0-9]+$/;
        return d.jQuery = function(e) {
            null != e && (e.fn.url = function(n) {
                var i = "";
                return this.length && (i = e(this).attr(t(this[0])) || ""), d(i, n)
            }, e.url = d)
        }, d.jQuery(window.jQuery), d
    }), window.console || (window.console = {}), window.console.log || (window.console.log = function() {});
var NAMESPACE = NAMESPACE || {};
NAMESPACE.lang = $("body").attr("data-lang"), NAMESPACE.searchParameters = {
        globalLat: $.cookie("bLat") || $("#map-canvas").attr("data-defaultlat"),
        globalLng: $.cookie("bLng") || $("#map-canvas").attr("data-defaultlng"),
        nextPage: null,
        total: "",
        path: $.url().attr("path"),
        kws: $.url().param("kws") || "",
        catIds: null,
        minPrice: null,
        maxPrice: null,
        dist: null,
        order: null,
        lastItemId: null
    }, NAMESPACE.addMoreCounter = 0, NAMESPACE.loadingGif = $("<img/>", {
        src: "/images/gifs/loading.gif",
        "class": "loading-gif",
        id: "js-loading-gif"
    }),
    function(e) {
        "use strict";
        var t = $("body");
        e.UTILS = {
            slideClose: function(e) {
                e.on("touchstart click", function(e) {
                    e.stopPropagation(), e.preventDefault();
                    var t = $(this).attr("data-target");
                    $(t).slideUp()
                })
            },
            triggerModal: function(e) {
                e.on("click", function(n) {
                    n.preventDefault();
                    var i = $(this).attr("href"),
                        r = $(i);
                    t.hasClass("veiled") ? r.hasClass("active") ? (r.removeClass("active"), t.removeClass("veiled")) : ($(".dropdown-near-you.over-modal").removeClass("over-modal"), $(".js-btn-two-states.pressed").removeClass("pressed"), $(".js-modal-content.active").removeClass("active"), r.addClass("active"), e.addClass("pressed")) : (r.addClass("active"), t.addClass("veiled"))
                })
            },
            closeModal: function(e) {
                e.on("click", function(e) {
                    e.preventDefault(), $(".js-modal-content.active").removeClass("active"), t.removeClass("veiled")
                })
            },
            initializeMasonry: function() {
                var e = $(".container-masonry");
                e.length > 0 && (e.masonry({
                    transitionDuration: 0,
                    isFitWidth: !0,
                    stamp: ".card-slider",
                    itemSelector: ".js-masonry-item",
                    columnWidth: 220,
                    gutter: 20,
                    visibleStyle: {
                        opacity: 1
                    },
                    hiddenStyle: {
                        opacity: 0
                    }
                }), e.masonry("reloadItems").masonry("layout"))
            },
            getMoreCards: function(e, t) {
                var n, i = [];
                n = void 0 !== t ? t : $(".container-masonry");
                for (var r = 0, o = e.items.length; o > r; r++) i.push(Handlebars.templates.card(e.items[r]));
                n.append(i).masonry("reloadItems").masonry("layout")
            },
            removeProducts: function() {
                $(".card-product").remove()
            }
        }
    }(NAMESPACE),
    function(e) {
        "use strict";
        e.ADDMORE = {
            getLastProductPosition: function(e) {
                return {
                    position: parseInt($(".card-product:last-child").css("top")),
                    distance: parseInt(e)
                }
            },
            increaseAddMoreCounter: function() {
                e.addMoreCounter += 1
            },
            resetAddMoreCounter: function() {
                e.addMoreCounter = 0
            },
            updateDistanceNumber: function(e) {
                $("#js-near-you-distance-number").text(e)
            },
            checkInitialBreakpoint: function(t) {
                0 === e.addMoreCounter && $(window).scroll(function() {
                    $(this).scrollTop() < t && $("#js-near-you-distance-number").text($("#js-near-you-distance-number").attr("data-distance"))
                })
            },
            addDistanceBreakpoint: function(t, n) {
                $(window).scroll(function() {
                    $(this).scrollTop() > t && e.ADDMORE.updateDistanceNumber(n)
                })
            },
            isLastPage: function(t, n) {
                -1 !== t ? (e.searchParameters.nextPage = t, n.removeClass("hidden")) : (n.off("click"), n.on("click", function(e) {
                    e.preventDefault()
                }))
            }
        }
    }(NAMESPACE),
    function(e) {
        "use strict";
        e.UTILS.initializeMasonry(), $(".js-btn-two-states").on("click", function(e) {
            e.preventDefault(), $(this).toggleClass("pressed")
        }), $(".modal-veil").on("touchstart click", function(e) {
            e.preventDefault(), e.stopPropagation(), $("body").removeClass("veiled"), $(".js-btn-two-states.pressed").removeClass("pressed"), $(".js-modal-content.active").removeClass("active"), $("#js-dropdown-near-you-btn.over-modal").removeClass("over-modal"), $("#js-send-the-app-modal").hasClass("message-sent") && $("#js-send-the-app-modal").removeClass("message-sent")
        }), e.UTILS.closeModal($("#js-send-the-app-close")), $("#js-scroll-top").on("touchstart click", function(e) {
            e.preventDefault(), e.stopPropagation(), $("html, body").animate({
                scrollTop: 0
            }, 500)
        }), $(window).scroll(function() {
            $(this).scrollTop() > 1500 ? $("#js-scroll-top").addClass("active") : ($("#js-scroll-top").removeClass("active"), $(this).scrollTop() > 300 ? $("#js-dropdown-near-you-btn").removeClass("hidden") : $("#js-homepage-banner").is(":visible") && $("#js-dropdown-near-you-btn").addClass("hidden")), $(".more-products-btn.has-infinite.infinite").not("hidden").length > 0 && ($.fn.scrollBottom = function() {
                return $(document).height() - this.scrollTop() - this.height()
            }, $(window).scrollBottom() < 2400 && 0 === $("#js-loading-gif").length && $(".more-products-btn").trigger("click"))
        })
    }(NAMESPACE),
    function(e) {
        "use strict";
        e.UTILS.triggerModal($("#js-detail-chat-send-message")), $(".js-modal-chat-change").on("click", function(e) {
            e.preventDefault();
            var t = $(this),
                n = $(t.attr("href")),
                i = $(t.attr("data-parent"));
            n.removeClass("hidden"), i.addClass("hidden")
        })
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t() {
            var e = $("#detail-map-big"),
                t = e.attr("data-lat"),
                r = e.attr("data-lng"),
                o = e.attr("data-radius"),
                s = o > 0,
                a = new L.LatLngBounds(new L.LatLng(-85.0511, -180), new L.LatLng(85.0511, 180)),
                l = 3,
                c = 21,
                u = L.icon({
                    iconUrl: "../../images/icons/map_pointer.png",
                    iconSize: [60, 60],
                    iconAnchor: [30, 60]
                }),
                d = L.map("detail-map-big").setView([t, r], 15);
            if (n = L.tileLayer(i + "/{z}/{x}/{y}.png", {
                    minZoom: l,
                    maxZoom: c,
                    bounds: a,
                    attribution: "<a href='https://www.mapbox.com/about/maps/' target='_blank'>&copy; Mapbox</a> <a href='https://openstreetmap.org/about/' target='_blank'>&copy; OpenStreetMap</a>"
                }).addTo(d), s) {
                var p = L.circle([t, r], 650, {
                    color: "#333",
                    opacity: .15,
                    fillColor: "#333",
                    stroke: !1
                });
                d.addLayer(p)
            } else L.marker([t, r], {
                icon: u
            }).addTo(d)
        }
        e.UTILS.triggerModal($("#card-product-detail-map"));
        var n, i = "http://apimaps.wallapop.com/mapbox-studio-osm-bright";
        $("#detail-map-big").length > 0 && $("#card-product-detail-map").on("click", function(e) {
            e.preventDefault(), $(this).off(e), t()
        })
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t() {
            $("#js-send-the-app-modal").addClass("message-sent")
        }
        e.UTILS.triggerModal($("#dropdown-main-search-btn")), e.UTILS.triggerModal($("#js-send-the-app-btn")), $("#js-send-the-app-btn").on("click", function(e) {
            $("#js-send-the-app-modal").hasClass("centered") && $("#js-send-the-app-modal").removeClass("centered")
        }), $("#js-form-send-the-app").submit(function(e) {
            e.preventDefault(), $.ajax({
                type: "POST",
                url: "/sendTheApp",
                data: $(this).serialize(),
                success: function(e) {}
            })
        }), $("#js-form-send-the-app").validate({
            rules: {
                sendTheApp: {
                    email: !0,
                    required: !0
                }
            },
            submitHandler: function() {
                t()
            }
        }), $("#js-send-the-app-submit").on("touchstart click", function(e) {
            e.preventDefault(), e.stopPropagation(), $("#js-form-send-the-app").submit()
        }), $("#main-search-input").on("click", function(e) {
            $(".js-modal-content.active").length > 0 && ($(".js-modal-content.active").removeClass("active"), $("body").removeClass("veiled"))
        })
    }(NAMESPACE), window.fbAsyncInit = function() {
        FB.init({
            appId: 0xeb5b7d8cc252,
            cookie: !0,
            xfbml: !0,
            version: "v2.2"
        }), FB.getLoginStatus(function(e) {
            statusChangeCallback(e)
        })
    },
    function(e, t, n) {
        var i, r = e.getElementsByTagName(t)[0];
        e.getElementById(n) || (i = e.createElement(t), i.id = n, i.src = "//connect.facebook.net/en_US/sdk.js", r.parentNode.insertBefore(i, r))
    }(document, "script", "facebook-jssdk"),
    function(e) {
        "use strict";

        function t() {
            return 1 == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)
        }
        if (t()) {
            var n = $("body");
            $(document).on("focus", "input", function(e) {
                n.addClass("fixfixed")
            }).on("blur", "input", function(e) {
                n.removeClass("fixfixed")
            })
        }
        $("#js-not-available-send-the-app").on("click", function(e) {
            e.preventDefault(), $("#js-send-the-app-btn").click()
        }), $(".js-more-products").on("touchstart click", function(t) {
            t.stopPropagation(), t.preventDefault();
            var n = e.searchParameters,
                i = $(this),
                r = {
                    kws: n.kws,
                    _p: 1,
                    catIds: n.catIds,
                    lat: n.globalLat,
                    lng: n.globalLng,
                    minPrice: n.minPrice,
                    maxPrice: n.maxPrice,
                    order: n.order,
                    dist: n.dist
                },
                o = $(i.attr("data-href"));
            i.addClass("infinite"), null !== n.nextPage && (r._p = n.nextPage), r.lat = n.globalLat || i.attr("data-latitude"), r.lng = n.globalLng || i.attr("data-longitude"), r.searchNextPage = i.attr("data-searchNextPage"), $.ajax({
                data: r,
                url: "/rest/items",
                type: "get",
                beforeSend: function() {
                    i.addClass("hidden"), e.loadingGif.insertBefore(i.closest(".more-products-section"))
                },
                success: function(t) {
                    var n = e.ADDMORE.getLastProductPosition(t.distanceFromYou);
                    e.ADDMORE.checkInitialBreakpoint(n.position), e.ADDMORE.increaseAddMoreCounter(), e.ADDMORE.addDistanceBreakpoint(n.position, n.distance), e.ADDMORE.isLastPage(t.nextPage, i), i.attr("data-searchNextPage", t.searchNextPage), $("#js-loading-gif").remove(), e.UTILS.getMoreCards(t, o)
                }
            })
        }), $("#js-homepage-banner .js-close").on("touchstart click", function(e) {
            e.stopPropagation(), e.preventDefault(), $("#js-dropdown-near-you-btn").hasClass("hidden") && $("#js-dropdown-near-you-btn").removeClass("hidden"), $.cookie("hideBanner", !0, {
                expires: 30,
                domain: ".wallapop.com",
                path: "/"
            }), $($(this).attr("data-target")).slideUp()
        });
        var i = $("#js-dropdown-near-you-btn");
        i.length > 0 && i.on("click", function(e) {
            e.preventDefault();
            var t = $(this);
            t.hasClass("pressed") ? (ga("send", "event", "nearYouMap", "maps"), t.addClass("over-modal")) : t.removeClass("over-modal")
        }), i.length > 0 && e.UTILS.triggerModal(i), $(".search-glass.search-glass").on("touchstart click", function(e) {
            e.preventDefault(), e.stopPropagation(), "" === $("#main-search-input").val() ? $("#main-search-input").focus() : $("#js-main-search-form").submit()
        }), $.cookie("hideCookieMessage") !== !0 && $.cookie("hideCookieMessage", !0, {
            expires: 365,
            domain: ".wallapop.com",
            path: "/"
        }), $("#js-message-cookies .js-close").on("touchstart click", function(e) {
            e.stopPropagation(), e.preventDefault(), $($(this).attr("data-target")).slideUp()
        }), Handlebars.registerHelper("compare", function(e, t, n) {
            if (arguments.length < 3) throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
            var i = n.hash.operator || "==",
                r = {
                    "==": function(e, t) {
                        return e == t
                    },
                    "===": function(e, t) {
                        return e === t
                    },
                    "!=": function(e, t) {
                        return e != t
                    },
                    "<": function(e, t) {
                        return t > e
                    },
                    ">": function(e, t) {
                        return e > t
                    },
                    "<=": function(e, t) {
                        return t >= e
                    },
                    ">=": function(e, t) {
                        return e >= t
                    },
                    "typeof": function(e, t) {
                        return typeof e == t
                    }
                };
            if (!r[i]) throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + i);
            var o = r[i](e, t);
            return o ? n.fn(this) : n.inverse(this)
        })
    }(NAMESPACE),
    function(e) {
        "use strict";
        $("#js-more-products-list").on("touchstart click", function(t) {
            t.preventDefault(), t.stopPropagation();
            var n = (e.searchParameters, $(this)),
                i = {
                    path: e.searchParameters.path,
                    total: e.searchParameters.total,
                    _p: 1,
                    lastItemId: e.searchParameters.lastItemId
                };
            n.addClass("infinite"), null === i.lastItemId && (i.lastItemId = n.attr("data-lastItemId")), null !== e.searchParameters.nextPage && (i._p = e.searchParameters.nextPage), i.total = e.searchParameters.total || n.attr("data-total"), $.ajax({
                data: i,
                url: "/rest/seoitems",
                type: "get",
                beforeSend: function() {
                    n.addClass("hidden"), e.loadingGif.insertBefore($(".more-products-section"))
                },
                success: function(t) {
                    console.log("Request: " + i), console.log("Response: " + t), e.searchParameters.lastItemId = t.lastItemId, -1 !== t.nextPage ? (e.searchParameters.nextPage = t.nextPage, e.searchParameters.total = t.total, n.removeClass("hidden")) : (n.off("click"), n.on("click", function(e) {
                        e.preventDefault()
                    })), $("#js-loading-gif").remove(), e.UTILS.getMoreCards(t)
                }
            })
        })
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t() {
            "" !== window.location.hash && ($("#js-sidebar-filters-form").deserialize(window.location.hash.substring(1)), $("#js-sidebar-filters-reset").removeClass("disabled"), i())
        }

        function n() {
            var e = window.location.href,
                t = e.indexOf("#");
            t > 0 && (window.location = e.substring(0, t))
        }

        function i() {
            var t = $("#js-sidebar-filters-form").serialize();
            e.ADDMORE.resetAddMoreCounter(), $(".container-masonry").addClass("veiled-cards"), $(".js-more-products").addClass("hidden").removeClass("infinite"), $(".js-more-products").length && $(".js-more-products").attr("data-searchNextPage", ""), $.ajax({
                data: t,
                url: "/rest/items",
                type: "get",
                success: function(n) {
                    if (window.location.hash = t, $("#js-loading-gif").remove(), e.UTILS.removeProducts(), null !== n.noResultsDescription) {
                        if ($(".container-main-error").length <= 0) {
                            var i = '<div class="container-main-error js-masonry-item"><img class="main-error-img" src="' + n.noResultsImg + '" alt=""><p class="main-error-title">' + n.noResultsTitle + '</p><p class="main-error-description">' + n.noResultsDescription + "</p></div>";
                            $(".container-masonry").append(i).masonry("reloadItems").masonry("layout")
                        }
                    } else $(".container-main-error").remove(), e.UTILS.getMoreCards(n), $(".js-more-products").removeClass("hidden");
                    e.ADDMORE.isLastPage(n.nextPage, $("#js-more-products")), $(".container-masonry").removeClass("veiled-cards"), $("#js-sidebar-filters-reset").removeClass("disabled"), $("#js-sidebar-filters-submit").addClass("disabled");
                    var r = $("#js-sidebar-filters-categories").find("input:checked").map(function() {
                        return this.value
                    }).get();
                    e.searchParameters.catIds = r.join(","), e.searchParameters.minPrice = $("#js-sidebar-filters-minPrice").val(), e.searchParameters.maxPrice = $("#js-sidebar-filters-maxPrice").val(), e.searchParameters.dist = $("#js-sidebar-filters-distance").find("input:checked").val(), e.searchParameters.order = $("#js-sidebar-filters-order").find("input:checked").val(), e.searchParameters.nextPage = n.nextPage, $(".js-more-products").length && $(".js-more-products").attr("data-searchNextPage", n.searchNextPage)
                }
            })
        }
        t(), $("#js-sidebar-filters-reset").on("touchstart click", function(t) {
            if (t.preventDefault(), t.stopPropagation(), !$(this).hasClass("disabled")) {
                n(), $("#js-sidebar-filters-categories").find("input").prop("checked", !1), $("#js-sidebar-filters-distance").find(".input-default").prop("checked", !0), $("#js-sidebar-filters-order").find(".input-default").prop("checked", !0), $(".sidebar-filter-price").removeClass("error").val(""), $("#priceRange-error").length > 0 && $("#priceRange-error").remove();
                var i = $("#js-sidebar-filters-form").serialize();
                e.ADDMORE.resetAddMoreCounter(), $(".container-masonry").addClass("veiled-cards"), $(this).addClass("disabled"), $("#js-sidebar-filters-submit").addClass("disabled"), $.ajax({
                    data: i,
                    url: "/rest/items",
                    type: "get",
                    success: function(t) {
                        $(".container-main-error").remove(), $("#js-loading-gif").remove(), e.UTILS.removeProducts(), e.UTILS.getMoreCards(t), e.ADDMORE.isLastPage(t.nextPage, $("#js-more-products")), $(".container-masonry").removeClass("veiled-cards")
                    }
                })
            }
        });
        var r = {
            es: "Mín tiene que ser más grande que Máx.",
            mx: "Mín tiene que ser más grande que Máx.",
            br: "O Max tem de ser maior do que o min.",
            gb: "Min can't be bigger than max.",
            us: "Min can't be bigger than max.",
            fr: "Min ne peut pas être supérieur à max."
        };
        $.validator.addMethod("greaterThan", function(e, t) {
            var n = $("#" + $(t).data("linked"));
            return this.settings.onfocusout && n.off(".validate-greaterThan").on("blur.validate-greaterThan", function() {
                $(t).valid()
            }), "" !== e && "" !== n.val() ? parseInt(e) > parseInt(n.val()) : !0
        }, r[e.lang]), $.validator.addClassRules({
            max: {
                greaterThan: !0
            }
        }), $("#js-sidebar-filters-form").validate({
            lang: $("body").attr("data-lang"),
            submitHandler: function(e) {
                i()
            },
            rules: {
                minPrice: {
                    number: !0,
                    onfocusout: !1,
                    min: 0
                },
                maxPrice: {
                    number: !0,
                    greaterThan: !0,
                    onfocusout: !1,
                    min: 0
                }
            },
            groups: {
                priceRange: "minPrice maxPrice"
            },
            errorPlacement: function(e, t) {
                "maxPrice" === t.attr("name") || "minPrice" === t.attr("name") ? e.insertAfter("#js-sidebar-filters-maxPrice") : e.insertAfter(t)
            }
        }), $("#js-sidebar-filters-submit").on("touchstart click", function(e) {
            e.preventDefault(), e.stopPropagation(), $(this).hasClass("disabled") || $("#js-sidebar-filters-form").submit()
        }), $("#js-sidebar-filters-form").on("change", function(e) {
            $("#js-sidebar-filters-submit").removeClass("disabled")
        })
    }(NAMESPACE),
    function(e) {
        "use strict";
        var t = $("#js-card-slider-main").bxSlider({
            mode: "fade",
            adaptiveHeight: !0,
            prevSelector: "#js-card-slider-prev",
            nextSelector: "#js-card-slider-next",
            nextText: "",
            prevText: "",
            touchEnabled: !1,
            pagerCustom: "#js-card-slider-pager"
        });
        $("#js-card-slider-prev").on("click", function(e) {
            e.stopPropagation(), e.preventDefault(), t.goToPrevSlide()
        }), $("#js-card-slider-next").on("click", function(e) {
            e.stopPropagation(), e.preventDefault(), t.goToNextSlide()
        })
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t(e, t) {
            f.geocode({
                latLng: e
            }, function(e) {
                e && e.length > 0 ? t(e) : console.error("Geocoder has failed")
            })
        }

        function n(e) {
            if (0 !== e.length) {
                var t = e;
                v.globalLat = t.lat, v.globalLng = t.lng;
                var n = new google.maps.LatLngBounds;
                ({
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                });
                n.extend(t), p.setPosition(t), d.fitBounds(n), d.setZoom(15)
            }
        }

        function i(e, t) {
            var n = document.createElement("li"),
                i = document.createElement("span"),
                r = document.createElement("span"),
                a = document.createTextNode(e.description),
                c = function() {
                    l(), o(e.description), s(e.placeId)
                };
            return n.setAttribute("data-result-index", t), i.setAttribute("class", "pac-icon pac-icon-marker"), n.appendChild(i), r.setAttribute("class", "pac-address"), r.appendChild(a), n.appendChild(r), $(n).on("mousedown", c), n
        }

        function r(e) {
            l();
            for (var t = 0; t < e.length; t++) $(g).append(i(e[t], t));
            $(g).append('<span class="powered-logo"><img src="https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3.png"/></span>')
        }

        function o(e) {
            $(m).val(e)
        }

        function s(e) {
            var t = {
                    serviceUrl: "/maps/place",
                    geocodingQueryParams: {},
                    reverseQueryParams: {}
                },
                i = {
                    placeId: e,
                    apiKey: "AIzaSyCwbqhPH-_1Zyh9hAYi6GDwiyk1we41DZ4"
                };
            $.getJSON(t.serviceUrl, i, function(e) {
                "OK" == e.status ? n(e.result.geometry.location) : console.log("Error de geolocalización")
            })
        }

        function a(e) {
            var t = {
                    serviceUrl: "/maps/places",
                    geocodingQueryParams: {},
                    reverseQueryParams: {}
                },
                n = {
                    query: e,
                    apiKey: "AIzaSyCwbqhPH-_1Zyh9hAYi6GDwiyk1we41DZ4",
                    lat: v.globalLat,
                    lng: v.globalLng
                };
            $.getJSON(t.serviceUrl, n, function(e) {
                e.length ? r(e) : console.log("Error de geolocalización")
            })
        }

        function l() {
            $(g).empty()
        }

        function c() {
            function n() {
                p.setAnimation(google.maps.Animation.BOUNCE)
            }

            function i() {
                p.setAnimation(null)
            }
            m = $("#pac-input"), g = $("ul.places-list"), f = new google.maps.Geocoder, h = void 0 !== $.cookie("currentLat") && void 0 !== $.cookie("currentLng") ? new google.maps.LatLng($.cookie("currentLat"), $.cookie("currentLng")) : new google.maps.LatLng(v.globalLat, v.globalLng), google.maps.visualRefresh = !0;
            var r = {
                zoom: 15,
                center: h,
                disableDefaultUI: !0
            };
            d = new google.maps.Map(document.getElementById("map-canvas"), r);
            new google.maps.MarkerImage("../../images/icons/map_pointer.png", null, null, null, new google.maps.Size(21, 30));
            p = new google.maps.Marker({
                map: d,
                draggable: !0,
                icon: {
                    url: "../../images/icons/map_pointer.png",
                    scaledSize: new google.maps.Size(60, 60)
                }
            }), google.maps.event.addListener(p, "mouseover", n), google.maps.event.addListener(p, "mouseout", i), google.maps.event.addListener(p, "dragend", function() {
                var e = p.getPosition();
                t(e, function(e) {
                    $(m).val(e[0].formatted_address)
                }), v.globalLat = e.lat(), v.globalLng = e.lng(), d.panTo(e)
            }), google.maps.event.addListener(d, "click", function(e) {
                var n = e.latLng;
                t(n, function(e) {
                    $(m).val(e[0].formatted_address)
                }), v.globalLat = n.lat(), v.globalLng = n.lng(), d.panTo(n), p.setPosition(n)
            }), d.setCenter(h), t(h, function(e) {
                $(m).blur();
                var t = e[0].formatted_address;
                $(m).val(t)
            }), $(m).on("keyup", function() {
                $(this).val().length > y ? a($(this).val()) : l()
            }), $(m).on("blur", l), void 0 !== $.cookie("bLat") && void 0 !== $.cookie("bLng") || (navigator.geolocation ? navigator.geolocation.getCurrentPosition(function(n) {
                var i = new google.maps.LatLng(n.coords.latitude, n.coords.longitude);
                t(i, function(e) {
                    $(m).val(e[0].formatted_address), $.cookie("posName", e[0].formatted_address, {
                        expires: 30,
                        domain: ".wallapop.com",
                        path: "/"
                    })
                }), $("body").addClass("veiled-cards"), v.globalLat = i.lat(), v.globalLng = i.lng(), d.setCenter(i), p.setPosition(i), d.setZoom(14), $.cookie("bLat", v.globalLat, {
                    expires: 30,
                    domain: ".wallapop.com",
                    path: "/"
                }), $.cookie("bLng", v.globalLng, {
                    expires: 30,
                    domain: ".wallapop.com",
                    path: "/"
                });
                var r = {
                    kws: v.kws,
                    categoryId: "",
                    selectionId: "",
                    collectionId: "",
                    _p: 0,
                    lat: v.globalLat,
                    lng: v.globalLng,
                    salePriceSegments: "",
                    distanceSegments: "",
                    orderBy: "",
                    orderType: "",
                    resultType: ""
                };
                $.ajax({
                    data: r,
                    url: "/rest/items",
                    type: "get",
                    beforeSend: function() {
                        $("body").addClass("veiled-cards")
                    },
                    success: function(t) {
                        v.nextPage = t.nextPage, e.UTILS.removeProducts(), e.UTILS.getMoreCards(t), $("body").removeClass("veiled-cards")
                    }
                })
            }, function() {
                u(!0)
            }) : ($("#js-mylocation-button").remove(), u(!1))), p.setPosition(h)
        }

        function u(e) {
            e ? console.log("Error en geolocalización") : console.log("El navegador no soporta geolocalización")
        }
        var d, p, h, f, g, m, v = e.searchParameters,
            y = 2;
        $("#js-map-confirm-position").on("touchstart click", function(t) {
            t.stopPropagation(), t.preventDefault();
            var n;
            $("#js-sidebar-filters-form").length > 0 ? ($("#js-sidebar-lat").val(v.globalLat), $("#js-sidebar-lng").val(v.globalLng), n = $("#js-sidebar-filters-form").serialize()) : n = {
                kws: v.kws,
                categoryId: "",
                selectionId: "",
                collectionId: "",
                _p: 0,
                lat: v.globalLat,
                lng: v.globalLng,
                salePriceSegments: "",
                distanceSegments: "",
                orderBy: "",
                orderType: "",
                resultType: ""
            }, $.cookie("currentLat", v.globalLat), $.cookie("currentLng", v.globalLng), $.cookie("currentPosName", $("#pac-input").val()), e.ADDMORE.resetAddMoreCounter(), $(".container-masonry").addClass("veiled-cards"), $.ajax({
                data: n,
                url: "/rest/items",
                type: "get",
                beforeSend: function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 500), $(".js-more-products").addClass("hidden")
                },
                success: function(t) {
                    if (e.UTILS.removeProducts(), null !== t.noResultsDescription) {
                        if ($(".container-main-error").length <= 0) {
                            var n = '<div class="container-main-error js-masonry-item"><img class="main-error-img" src="' + t.noResultsImg + '" alt=""><p class="main-error-title">' + t.noResultsTitle + '</p><p class="main-error-description">' + t.noResultsDescription + "</p></div>";
                            $(".container-masonry").append(n).masonry("reloadItems").masonry("layout"), $(".container-masonry").css("height", "auto"), $(".sidebar-filters").css("position", "relative"), $(".main-sidebar").css("position", "relative")
                        }
                        $(".js-more-products").addClass("hidden").removeClass("infinite")
                    } else $(".container-main-error").remove(), $(".js-more-products").removeClass("hidden"), e.UTILS.getMoreCards(t);
                    var i = $("#js-dropdown-near-you-btn"),
                        r = $("#js-near-you-distance-number");
                    v.nexstPage = t.nextPage, e.ADDMORE.isLastPage(t.nextPage, $("#js-more-products")), $("#js-near-you-location").text($("#pac-input").val()), null != t.distanceFromYou && (r.attr("data-distance", t.distanceFromYou), r.text(t.distanceFromYou), i.css("width", $("#js-near-you-full-text").innerWidth() + 73), i.css("margin-left", -(($("#js-near-you-full-text").innerWidth() + 73) / 2))), $(".container-masonry").removeClass("veiled-cards")
                }
            }), $("#js-dropdown-near-you-btn").trigger("click")
        }), $("#map-canvas").length > 0 && $("#js-dropdown-near-you-btn").on("click", function(e) {
            e.preventDefault(), $(this).off(e), c()
        }), $("#js-mylocation-button").on("click", function(e) {
            e.preventDefault(), navigator.geolocation.getCurrentPosition(function(e) {
                var n = new google.maps.LatLng(e.coords.latitude, e.coords.longitude);
                t(n, function(e) {
                    $("#pac-input").val(e[0].formatted_address), $.cookie("posName", e[0].formatted_address, {
                        expires: 30,
                        domain: ".wallapop.com",
                        path: "/"
                    })
                }), v.globalLat = n.lat(), v.globalLng = n.lng(), d.setCenter(n), p.setPosition(n), d.setZoom(15)
            })
        })
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t() {
            var e = $("#profile-map"),
                t = e.attr("data-lat"),
                n = e.attr("data-lng"),
                i = e.attr("data-radius"),
                s = i > 0,
                a = new L.LatLngBounds(new L.LatLng(-85.0511, -180), new L.LatLng(85.0511, 180)),
                l = 3,
                c = 21,
                u = L.icon({
                    iconUrl: "../../images/icons/map_pointer.png",
                    iconSize: [60, 60],
                    iconAnchor: [30, 60]
                }),
                d = L.map("profile-map", {
                    zoomControl: !1
                }).setView([t, n], 14),
                p = d.getSize().divideBy(2),
                h = p.subtract([350, 0]),
                f = d.containerPointToLatLng(h);
            if (d.panTo(f), r = L.tileLayer(o + "/{z}/{x}/{y}.png", {
                    minZoom: l,
                    maxZoom: c,
                    bounds: a,
                    attribution: "<a href='https://www.mapbox.com/about/maps/' target='_blank'>&copy; Mapbox</a> <a href='https://openstreetmap.org/about/' target='_blank'>&copy; OpenStreetMap</a>"
                }).addTo(d), s) {
                var g = L.circle([t, n], 650, {
                    color: "#333",
                    opacity: .15,
                    fillColor: "#333",
                    stroke: !1
                });
                d.addLayer(g)
            } else L.marker([t, n], {
                icon: u
            }).addTo(d)
        }

        function n() {
            var e = $("#js-profile-map-holder-container"),
                t = $("html").width(),
                n = (t - 1180) / 2;
            40 > n && (n = 40), e.css("left", n)
        }

        function i() {
            document.addEventListener("DOMContentLoaded", t, !1), n()
        }
        var r, o = "http://apimaps.wallapop.com/mapbox-studio-osm-bright";
        $("#profile-map").length > 0 && i()
    }(NAMESPACE),
    function(e) {
        "use strict";

        function t(e) {
            $(".more-reviews-container").before(e)
        }

        function n(n) {
            var i = $(n),
                r = i.attr("data-total"),
                o = i.attr("data-nextPage"),
                s = i.attr("data-userId"),
                a = [],
                l = {
                    _p: o,
                    userId: s,
                    total: r
                };
            $.ajax({
                data: l,
                url: "/rest/userreviews",
                type: "get",
                beforeSend: function() {
                    i.addClass("hidden"), e.loadingGif.insertBefore($(".more-reviews-container"))
                },
                success: function(e) {
                    -1 !== e.nextPage && (i.attr("data-nextPage", e.nextPage), i.removeClass("hidden"));
                    for (var n = 0, r = e.reviews.length; r > n; n++) {
                        var o = e.reviews[n];
                        o.activeStars = [], o.inactiveStars = [];
                        for (var s = 0, l = o.numStars; l > s; s++) o.activeStars.push(s);
                        for (var s = 0, l = 5 - o.activeStars.length; l > s; s++) o.inactiveStars.push(s);
                        a.push(Handlebars.templates.review(o))
                    }
                    $("#js-loading-gif").remove(), t(a)
                }
            })
        }
        $("#js-profile-buttons a").on("touchstart click", function(t) {
            function i() {
                $(".js-profile-products.active").removeClass("active"), s.addClass("active")
            }

            function r() {
                return "true" === l
            }

            function o(n, i, r, o) {
                t.stopPropagation(), t.preventDefault();
                var s = (e.searchParameters, $(n), $(r.attr("data-more-products")).find(".js-more-products-profile")),
                    a = s.attr("data-action"),
                    l = $("#js-profile-buttons").attr("data-userid"),
                    u = s.attr("data-nextPage"),
                    d = s.attr("data-total"),
                    p = {
                        statuses: a,
                        userId: l,
                        total: d
                    };
                void 0 !== u && (p._p = u), $.ajax({
                    data: p,
                    url: "/rest/useritems",
                    type: "get",
                    beforeSend: function() {
                        s.addClass("hidden"), c.addClass("veiled-cards")
                    },
                    success: function(t) {
                        -1 !== t.nextPage && s.removeClass("hidden"), s.attr("data-nextPage", t.nextPage), r.removeClass("hidden"), e.UTILS.getMoreCards(t, r), i.removeClass("loaded"), i.addClass("hidden"), r.addClass("loaded"), c.removeClass("veiled-cards"), o.removeClass("waiting")
                    }
                })
            }
            t.stopPropagation(), t.preventDefault();
            var s = $(this),
                a = s.attr("data-target"),
                l = s.attr("data-loaded"),
                c = (s.attr("data-action"), $("body")),
                u = $(".more-products-section").not(".hidden"),
                d = $(s.attr("data-addmore"));
            if (u.addClass("hidden"), d.removeClass("hidden"), $("#" + a).hasClass("empty") ? $("#js-container-no-content").removeClass("hidden") : $("#js-container-no-content").addClass("hidden"), !s.hasClass("active") && !s.hasClass("waiting")) {
                var p = $(".js-profile-container-holder.loaded"),
                    h = $("#" + a);
                i();
                var f = $(".js-profile-products").not(".active");
                f.addClass("waiting"), r() ? (p.addClass("hidden"), p.removeClass("loaded"), h.addClass("loaded"), h.removeClass("hidden"), f.removeClass("waiting"), "js-container-reviews" !== a && h.masonry("reloadItems").masonry("layout")) : ("js-container-reviews" === a ? (n($("#js-more-reviews")), h.removeClass("hidden"), p.removeClass("loaded"), p.addClass("hidden"), h.addClass("loaded"), f.removeClass("waiting")) : o(s, p, h, f), s.attr("data-loaded", "true"))
            }
        }), $(".js-more-products-profile").on("click", function(t) {
            t.preventDefault(), t.stopPropagation();
            var n = (e.searchParameters, $(this)),
                i = n.attr("data-action"),
                r = $("#js-profile-buttons").attr("data-userid"),
                o = n.attr("data-total"),
                s = $(n.attr("href")),
                a = n.attr("data-nextPage"),
                l = {
                    _p: 1,
                    statuses: i,
                    userId: r,
                    total: o
                };
            void 0 !== a && (l._p = a), $.ajax({
                data: l,
                url: "/rest/useritems",
                type: "get",
                beforeSend: function() {
                    n.addClass("hidden"), e.loadingGif.insertBefore(n.closest(".more-products-section"))
                },
                success: function(t) {
                    -1 !== t.nextPage && (n.attr("data-nextPage", t.nextPage), n.removeClass("hidden")), n.attr("data-nextPage", t.nextPage), $("#js-loading-gif").remove(), e.UTILS.getMoreCards(t, s)
                }
            })
        }), $("#js-more-reviews").on("click", function(e) {
            e.preventDefault(), n(this)
        })
    }(NAMESPACE), this.Handlebars = this.Handlebars || {}, this.Handlebars.templates = this.Handlebars.templates || {}, this.Handlebars.templates.card = Handlebars.template({
        1: function(e, t, n, i) {
            return '                <div class="status-icon">\n                    <img src="/images/icons/item_sold.png"/>\n                </div>\n'
        },
        3: function(e, t, n, i) {
            var r, o = "";
            return r = t["if"].call(e, null != e ? e.reserved : e, {
                name: "if",
                hash: {},
                fn: this.program(4, i),
                inverse: this.noop,
                data: i
            }), null != r && (o += r), o
        },
        4: function(e, t, n, i) {
            return '                    <div class="status-icon">\n                        <img src="/images/icons/item_reserved.png"/>\n                    </div>\n'
        },
        6: function(e, t, n, i) {
            var r, o = "function",
                s = t.helperMissing,
                a = this.escapeExpression;
            return '            <span class="product-info-price">' + a((r = null != (r = t.price || (null != e ? e.price : e)) ? r : s, typeof r === o ? r.call(e, {
                name: "price",
                hash: {},
                data: i
            }) : r)) + "</span>\n"
        },
        8: function(e, t, n, i) {
            var r, o, s = "function",
                a = t.helperMissing,
                l = this.escapeExpression,
                c = '            <a href="/item/' + l((o = null != (o = t.url || (null != e ? e.url : e)) ? o : a, typeof o === s ? o.call(e, {
                    name: "url",
                    hash: {},
                    data: i
                }) : o)) + '" target="_blank" class="product-info-title">';
            return o = null != (o = t.title || (null != e ? e.title : e)) ? o : a, r = typeof o === s ? o.call(e, {
                name: "title",
                hash: {},
                data: i
            }) : o, null != r && (c += r), c + "</a>\n"
        },
        10: function(e, t, n, i) {
            var r, o, s = "function",
                a = t.helperMissing,
                l = this.lambda,
                c = this.escapeExpression,
                u = '            <a href="';
            return o = null != (o = t.categoryUrl || (null != e ? e.categoryUrl : e)) ? o : a, r = typeof o === s ? o.call(e, {
                name: "categoryUrl",
                hash: {},
                data: i
            }) : o, null != r && (u += r), u + '" class="product-info-category">' + c(l(null != (r = null != e ? e.category : e) ? r.title : r, e)) + "</a>\n"
        },
        12: function(e, t, n, i) {
            var r, o = this.lambda,
                s = this.escapeExpression,
                a = '        <a href="' + s(o(null != (r = null != e ? e.sellerUser : e) ? r.url : r, e)) + '">\n            <div class="card-product-seller-info clearfix">\n                <div class="card-product-seller-avatar-holder" style="background-image: url(\'' + s(o(null != (r = null != (r = null != e ? e.sellerUser : e) ? r.image : r) ? r.smallURL : r, e)) + '\')"></div>\n                <span class="seller-name">';
            return r = o(null != (r = null != e ? e.sellerUser : e) ? r.microName : r, e), null != r && (a += r), a + '</span>\n                <span class="seller-products">' + s(o(null != (r = null != (r = null != e ? e.sellerUser : e) ? r.statsUser : r) ? r.prodsSellingCount : r, e)) + "</span>\n            </div>\n        </a>\n"
        },
        compiler: [6, ">= 2.0.0-beta.1"],
        main: function(e, t, n, i) {
            var r, o, s = "function",
                a = t.helperMissing,
                l = this.escapeExpression,
                c = this.lambda,
                u = '<div class="card js-masonry-item card-product animated-hover">\n    <a href="/item/' + l((o = null != (o = t.url || (null != e ? e.url : e)) ? o : a,
                    typeof o === s ? o.call(e, {
                        name: "url",
                        hash: {},
                        data: i
                    }) : o)) + '" target="_blank">\n        <div class="card-product-image-holder" style="background-color: #' + l(c(null != (r = null != e ? e.mainImage : e) ? r.averageHexColor : r, e)) + "; padding-bottom: " + l(c(null != (r = null != e ? e.mainImage : e) ? r.mobileScaledRatio : r, e)) + '%;">\n            <img class="card-product-image" src="';
            return r = c(null != (r = null != e ? e.mainImage : e) ? r.smallURL : r, e), null != r && (u += r), u += '" alt="', o = null != (o = t.title || (null != e ? e.title : e)) ? o : a, r = typeof o === s ? o.call(e, {
                name: "title",
                hash: {},
                data: i
            }) : o, null != r && (u += r), u += '" title="', o = null != (o = t.title || (null != e ? e.title : e)) ? o : a, r = typeof o === s ? o.call(e, {
                name: "title",
                hash: {},
                data: i
            }) : o, null != r && (u += r), u += '" />\n', r = t["if"].call(e, null != e ? e.sold : e, {
                name: "if",
                hash: {},
                fn: this.program(1, i),
                inverse: this.program(3, i),
                data: i
            }), null != r && (u += r), u += '        </div>\n    </a>\n    <div class="card-product-product-info">\n', r = t["if"].call(e, null != e ? e.price : e, {
                name: "if",
                hash: {},
                fn: this.program(6, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), r = t["if"].call(e, null != e ? e.title : e, {
                name: "if",
                hash: {},
                fn: this.program(8, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), r = t["if"].call(e, null != e ? e.category : e, {
                name: "if",
                hash: {},
                fn: this.program(10, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), u += "    </div>\n", r = t["if"].call(e, null != e ? e.sellerUser : e, {
                name: "if",
                hash: {},
                fn: this.program(12, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), u + "</div>\n"
        },
        useData: !0
    }), this.Handlebars.templates.review = Handlebars.template({
        1: function(e, t, n, i) {
            return '                    <i class="ico-star_highlighted_web active"></i>\n'
        },
        3: function(e, t, n, i) {
            return '                    <i class="ico-star_highlighted_web"></i>\n'
        },
        5: function(e, t, n, i) {
            var r, o = "function",
                s = t.helperMissing,
                a = this.escapeExpression;
            return '            <p class="card-review-description">"' + a((r = null != (r = t.comments || (null != e ? e.comments : e)) ? r : s, typeof r === o ? r.call(e, {
                name: "comments",
                hash: {},
                data: i
            }) : r)) + '"</p>\n'
        },
        compiler: [6, ">= 2.0.0-beta.1"],
        main: function(e, t, n, i) {
            var r, o, s = this.lambda,
                a = this.escapeExpression,
                l = "function",
                c = t.helperMissing,
                u = '<a href="' + a(s(null != (r = null != e ? e.user : e) ? r.url : r, e)) + '">\n    <div class="card-review clearfix">\n        <div class="card-review-avatar" style="background-image: url(' + a(s(null != (r = null != (r = null != e ? e.user : e) ? r.image : r) ? r.smallURL : r, e)) + ');"></div>\n        <div class="card-review-info">\n            <span class="card-review-date">' + a((o = null != (o = t.creationDate || (null != e ? e.creationDate : e)) ? o : c, typeof o === l ? o.call(e, {
                    name: "creationDate",
                    hash: {},
                    data: i
                }) : o)) + '</span>\n            <p class="card-review-user-name">' + a(s(null != (r = null != e ? e.user : e) ? r.microName : r, e)) + '</p>\n            <div class="card-review-stars">\n';
            return r = t.each.call(e, null != e ? e.activeStars : e, {
                name: "each",
                hash: {},
                fn: this.program(1, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), r = t.each.call(e, null != e ? e.inactiveStars : e, {
                name: "each",
                hash: {},
                fn: this.program(3, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), u += '            </div>\n            <p class="card-review-product-name card-review-type-' + a((o = null != (o = t.type || (null != e ? e.type : e)) ? o : c, typeof o === l ? o.call(e, {
                name: "type",
                hash: {},
                data: i
            }) : o)) + '">' + a((o = null != (o = t.reviewText || (null != e ? e.reviewText : e)) ? o : c, typeof o === l ? o.call(e, {
                name: "reviewText",
                hash: {},
                data: i
            }) : o)) + "</p>\n", r = t["if"].call(e, null != e ? e.comments : e, {
                name: "if",
                hash: {},
                fn: this.program(5, i),
                inverse: this.noop,
                data: i
            }), null != r && (u += r), u + "        </div>\n    </div>\n</a>"
        },
        useData: !0
    });

