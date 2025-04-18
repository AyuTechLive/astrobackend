//     Underscore.js 1.7.0
//     http://underscorejs.org
//     (c) 2009-2014 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
//     Underscore may be freely distributed under the MIT license.
var _gChatStarted = false;
var _gChatMsgCount = 0;
var fc_anynumber = "";
var fc_anynumberword = "";
var fc_prevsentmsg = "";
var IsSummaryShown = false;
var _gSendChatCounter = 0;
var _gLocalChat = [];
var _gLocalChatWithId = [];
var _gchatRecordCounter = 0;


INDXDBJS.createTableOperations(false);
function nl2br(str) {
    return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
}



function checkEachCharacter(word) {
    var NumericRegx = new RegExp('^[0-9]+$');
    var numericWord = "";
    if (typeof word == "string" || typeof word == "numeric") {
        var charMessage = word.split("");
        charMessage.forEach(function (e) {
            if (NumericRegx.test(e) && !isNaN(e)) {
                numericWord += e;
                fc_anynumber += e;
            }
            if (fc_anynumber.length > 0) {
                fc_anynumberword += e;
            }
        });
        if (numericWord.length > 0) {
            if (checkMessageAllowed(numericWord)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return true;
        }
    }
    else {
        return false;
    }
}

function checkMessageValidation(message) {
    fc_anynumber = "";
    fc_anynumberword = "";
    //split on space
    var _msgValid = true;
    if (message.indexOf(" ") > 0) {
        var spaceMessage = message.split(" ");
        for (var i = 0; i < spaceMessage.length; i++) {
            var e = spaceMessage[i];
            if (checkMessageAllowed(e)) {
                //check whole word if matched
                if (!checkEachCharacter(e)) {
                    //console.log("checkMessageValidation() => checkEachCharacter():: returned false " + e);
                    _msgValid = false;
                    break;
                }
            }
            else {
                //console.log("checkMessageAllowed():: returned false " + e);
                _msgValid = false;
                break;
            }
        }

        if (fc_anynumber.length > 0) {
            if (!checkMessageAllowed(fc_anynumber)) {
                _msgValid = false;
            }
        }
    }
    else {
        if (checkMessageAllowed(message)) {
            if (!checkEachCharacter(message)) {
                _msgValid = false;
            }
            else {
                _msgValid = true;
            }
        }
        else {
            _msgValid = false;
        }
    }
    return _msgValid;
}


function checkMessageAllowed(message) {
    //console.log("\n#####Processing Each Word: ",message);
    if (message.indexOf("http://") > 0 || message.indexOf("https://") > 0 || message.indexOf("ftp://") > 0 || message.indexOf("file://") > 0 || message.indexOf("www") > 0 || message.indexOf(".com") > 0) {
        //alert('Sorry, You are not allowed to share URLs or Email Ids!!');        
        return false;
    }
    else if (message.match(/[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+/)) {
        //console.log("checkMessageAllowed():: returned false == domain Sorry, You are not allowed to share URLs!!");
        return false;
    }
    else if (message.indexOf(" ") < 0 && (message.indexOf(".") > 0 && message.lastIndexOf(".") < message.length - 1)) {
        //console.log("checkMessageAllowed():: returned false == domain Sorry, You are not allowed to share URLs!!");
        return false;
    }

    else if (message.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        //alert('Sorry, You are not allowed to share Email Ids!!');        
        return false;
    }
    else if ((message.match(/^\d{9}$/) || message.match(/^\d{10}$/) || message.match(/^\d{11}$/) || message.match(/^\d{12}$/) || message.match(/^\d{13}$/) || message.match(/^\d{14}$/) || message.match(/^\d{15}$/))) {
        //alert('Sorry, You are not allowed to share Mobile Numbers!!');
        if (!isNaN(fc_anynumberword)) {           
            return false;
        }
        else {
            return true;
        }
    }
    else {
        if ((message.indexOf("@") > 0 && message.indexOf(".") > 1) && message.indexOf(" ") < 0) {
            //alert('Sorry, You are not allowed to share Email Ids!!');
            return false;
        }
        else {
            return true;
        }
    }
}

function ValidateChatMessageReject(msg,callback) {
    var count = 1000 - msg.length;
    if (msg.length == 0) {
        callback("REQUIRED");
    }
    else if (count < 0) {
        callback("CHARACTERS_LIMIT_EXCEEDED");
    }
    else {
        var a = checkMessageValidation(msg);
        if (a) {            
            var num_matches = msg.match(/(\d+)/);
            var msftoVal = "";
            if (fc_prevsentmsg != "") {
                if (num_matches) {
                    msftoVal = fc_prevsentmsg + msg;
                    var b = checkMessageValidation(msftoVal);
                    if (!b) {
                        callback("EMAIL_MOBILE_URL_NOT_ALLOWED");
                    }
                    else {
                        fc_prevsentmsg = "";
                        callback("ALLOWED");
                    }
                }
                else {
                    fc_prevsentmsg = "";
                    callback("ALLOWED");
                }
            }
            else {
                if (num_matches) {
                    fc_prevsentmsg += num_matches[0];
                }
                callback("ALLOWED");
            }
        }
        else {
            callback("EMAIL_MOBILE_URL_NOT_ALLOWED");
        }
    }
}



/*
 Replace message if any mobile number , email, domain, url matched
 */
var xRepeat = "x";
var xRepeatCount = 10;

function TrimStr(x) {
    return x.replace(/^\s+|\s+$/gm, '');
}

var IsDOB = function (value) {
    var dobArray = null;
    try {
        var isDateFormat = Date.parse(value);
        if (isNaN(isDateFormat)) {
            if (value.indexOf('/') > 0) {
                dobArray = value.split('/');
            }
            else if (value.indexOf('-') > 0) {
                dobArray = value.split('-');
            }
            else if (value.match(/^\d{8}$/)) {
                return true;
            }
            var dateF1 = "";//yyyy/mm/dd
            var dateF2 = "";//mm/dd/yyyy
            var dateF3 = "";//dd/mm/yyyy
            if (dobArray instanceof Array && dobArray.length > 0) {
                if (dobArray.length == 3) {
                    dateF1 = TrimStr(dobArray[0]) + "/" + TrimStr(dobArray[1]) + "/" + TrimStr(dobArray[2]);
                    dateF2 = TrimStr(dobArray[1]) + "/" + TrimStr(dobArray[0]) + "/" + TrimStr(dobArray[2]);
                    dateF3 = TrimStr(dobArray[2]) + "/" + TrimStr(dobArray[0]) + "/" + TrimStr(dobArray[1]);
                    if (isNaN(Date.parse(dateF1)) || isNaN(Date.parse(dateF2)) || isNaN(Date.parse(dateF3))) {
                        dateF1 = TrimStr(dobArray[0]) + "-" + TrimStr(dobArray[1]) + "-" + TrimStr(dobArray[2]);
                        dateF2 = TrimStr(dobArray[1]) + "-" + TrimStr(dobArray[0]) + "-" + TrimStr(dobArray[2]);
                        dateF3 = TrimStr(dobArray[2]) + "-" + TrimStr(dobArray[0]) + "-" + TrimStr(dobArray[1]);
                        if (isNaN(Date.parse(dateF1)) || isNaN(Date.parse(dateF2)) || isNaN(Date.parse(dateF3))) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
                else {
                    return false;
                }
            }
        }
        else {
            return true;
        }

    } catch (e) {

    }
    return false;
}



var ReplacePhoneNo = function (value) {
    var retValue = value;
    let matchPhoneNo = [];

    if (typeof retValue == "string") {
        matchPhoneNo = retValue.match(/(\+\d{1,3}\s?)?((\(\d{3}\)\s?)|(\d{3})(\s|-?))(\d{3}(\s|-?))(\d{4})(\s?(([E|e]xt[:|.|]?)|x|X)(\s?\d+))?/gm);
    }
    if (matchPhoneNo != null && matchPhoneNo instanceof Array && matchPhoneNo.length > 0) {

        matchPhoneNo.forEach(function (e) {
            var ecount = e.split("").length;
            if (ecount >= 10) {
                retValue = retValue.replace(e, xRepeat.repeat(ecount));
                //var replacedData = e.replace(/ /g, "").replace(/-/g, "").replace(/./g, "");
                //if (!isNaN(replacedData)) {

                //}
            }

        });
    }

    //retValue
    var otherMatchedCounts = [];
    if (typeof retValue == "string") {
        otherMatchedCounts = retValue.match(/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/);
    }
    if (otherMatchedCounts != null && otherMatchedCounts instanceof Array && otherMatchedCounts.length > 0) {
        otherMatchedCounts.forEach(function (e) {
            var ecount = e.split("").length;
            if (ecount >= 10) {
                retValue = retValue.replace(e, xRepeat.repeat(ecount));
                //var replacedData = e.replace(/ /g, "").replace(/-/g, "").replace(/./g, "");
                //if (!isNaN(replacedData)) {

                //}
            }

        });
    }

    return retValue;
}

function ReplacePhoneNumberIfNotDOB(e) {
    if (!IsDOB(e)) {
        var replacedData = e.replace(/ /g, "").replace(/-/g, "").replace(/\./g, "").replace(/\(/g, "").replace(/\)/g, "").replace(/\+/g, "");
        if (replacedData.length >= 10) {
            if (/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/.test(e)) {
                //alert('Sorry, You are not allowed to share Mobile Numbers!!');
                if ((replacedData.match(/^\d{10}$/) || replacedData.match(/^\d{11}$/) || replacedData.match(/^\d{12}$/) || replacedData.match(/^\d{13}$/) || replacedData.match(/^\d{14}$/))) {
                    e = ReplacePhoneNo(e);
                }
            }
            else if (e.match(/(\d+)/) && (e.match(/^\d{10}$/) || e.match(/^\d{11}$/) || e.match(/^\d{12}$/) || e.match(/^\d{13}$/) || e.match(/^\d{14}$/))) {
                e = ReplacePhoneNo(e);
            }
            else {

                if (replacedData.length >= 10) {
                    e = ReplacePhoneNo(e);
                }
            }
        }
    }

    return e;
}


function ValidateChatMessage(message, callback) {
    var retMessage = "";
    //split on space
    var msg = "";
    var msgObj = null;
    

    var count = 1000 - message.length;
    if (message.length == 0) {
        callback("__REQUIRED__");
    }
    else if (count < 0) {
        callback("__CHARACTERS_LIMIT_EXCEEDED__");
    }
    else {
        var isNewLine = /(\r\n|\n|\r)/.exec(message);
        if (isNewLine) {
            msgObj = message.split('\n');
        }
        else {

            msgObj = [message];
        }
        if (msgObj != null) {
            msgObj.forEach(function (e) {

                //verify complete sentence for phone number and dob
                e = ReplacePhoneNumberIfNotDOB(e);

                //verify each word in a sentence
                if (e.indexOf(" ") > 0) {
                    var spaceMessage = e.split(" ");
                    for (var i = 0; i < spaceMessage.length; i++) {
                        var e = spaceMessage[i];
                        msg = checkReplaceMessage(e);
                        retMessage += " " + msg;
                    }
                }
                else {
                    retMessage += " " + checkReplaceMessage(e);
                }
                if (isNewLine)
                    retMessage += "\n";
            });
            if (retMessage.length > 0) {
                callback(retMessage);
            }
            else {
                callback(message);
            }
        }
        else {
            callback(message);
        }
       
    }
    
}


function checkReplaceMessage(message) {

    var retVal = message;

    if (message.indexOf(" ") < 0) {
        //means no space just a complete word
        //check if it is already replaced do nothing then
        var replacedX = message.match(/x/g);
        if (replacedX instanceof Array && replacedX.length >= xRepeatCount) {
            return message;
        }
    }
    //console.log("\n#####Processing Each Word: ",message);
    if (message.indexOf("http://") > 0 || message.indexOf("https://") > 0 || message.indexOf("ftp://") > 0 || message.indexOf("file://") > 0 || message.indexOf("www") > 0 || message.indexOf(".com") > 0 || message.indexOf(".co") > 0) {
        //alert('Sorry, You are not allowed to share URLs or Email Ids!!'); 
        retVal = message.replace(message, xRepeat.repeat(xRepeatCount));

    }
    else if (message.match(/[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+/)) {
        //console.log("checkReplaceMessage():: returned false == domain Sorry, You are not allowed to share URLs!!");
        retVal = message.replace(message, xRepeat.repeat(xRepeatCount));
    }
    else if (message.match(/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/)) {
        //console.log("checkReplaceMessage():: returned false == domain Sorry, You are not allowed to share URLs!!");
        retVal = message.replace(message, xRepeat.repeat(xRepeatCount));
    }

    else if (message.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        //alert('Sorry, You are not allowed to share Email Ids!!');        
        retVal = message.replace(message, xRepeat.repeat(xRepeatCount));
    }

    else {
        if ((message.indexOf("@") > 0 && message.indexOf(".") > 1) && message.indexOf(" ") < 0) {
            //alert('Sorry, You are not allowed to share Email Ids!!');
            retVal = message.replace(message, xRepeat.repeat(xRepeatCount));
        }
        else {
            retVal = ReplacePhoneNumberIfNotDOB(message);
        }
    }

    return retVal;
}





(function () {
    var n = this,
        t = n._,
        r = Array.prototype,
        e = Object.prototype,
        u = Function.prototype,
        i = r.push,
        a = r.slice,
        o = r.concat,
        l = e.toString,
        c = e.hasOwnProperty,
        f = Array.isArray,
        s = Object.keys,
        p = u.bind,
        h = function (n) {
            return n instanceof h ? n : this instanceof h ? void (this._wrapped = n) : new h(n)
        };
    "undefined" != typeof exports ? ("undefined" != typeof module && module.exports && (exports = module.exports = h), exports._ = h) : n._ = h, h.VERSION = "1.7.0";
    var g = function (n, t, r) {
        if (t === void 0) return n;
        switch (null == r ? 3 : r) {
            case 1:
                return function (r) {
                    return n.call(t, r)
                };
            case 2:
                return function (r, e) {
                    return n.call(t, r, e)
                };
            case 3:
                return function (r, e, u) {
                    return n.call(t, r, e, u)
                };
            case 4:
                return function (r, e, u, i) {
                    return n.call(t, r, e, u, i)
                }
        }
        return function () {
            return n.apply(t, arguments)
        }
    };
    h.iteratee = function (n, t, r) {
        return null == n ? h.identity : h.isFunction(n) ? g(n, t, r) : h.isObject(n) ? h.matches(n) : h.property(n)
    }, h.each = h.forEach = function (n, t, r) {
        if (null == n) return n;
        t = g(t, r);
        var e, u = n.length;
        if (u === +u)
            for (e = 0; u > e; e++) t(n[e], e, n);
        else {
            var i = h.keys(n);
            for (e = 0, u = i.length; u > e; e++) t(n[i[e]], i[e], n)
        }
        return n
    }, h.map = h.collect = function (n, t, r) {
        if (null == n) return [];
        t = h.iteratee(t, r);
        for (var e, u = n.length !== +n.length && h.keys(n), i = (u || n).length, a = Array(i), o = 0; i > o; o++) e = u ? u[o] : o, a[o] = t(n[e], e, n);
        return a
    };
    var v = "Reduce of empty array with no initial value";
    h.reduce = h.foldl = h.inject = function (n, t, r, e) {
        null == n && (n = []), t = g(t, e, 4);
        var u, i = n.length !== +n.length && h.keys(n),
            a = (i || n).length,
            o = 0;
        if (arguments.length < 3) {
            if (!a) throw new TypeError(v);
            r = n[i ? i[o++] : o++]
        }
        for (; a > o; o++) u = i ? i[o] : o, r = t(r, n[u], u, n);
        return r
    }, h.reduceRight = h.foldr = function (n, t, r, e) {
        null == n && (n = []), t = g(t, e, 4);
        var u, i = n.length !== +n.length && h.keys(n),
            a = (i || n).length;
        if (arguments.length < 3) {
            if (!a) throw new TypeError(v);
            r = n[i ? i[--a] : --a]
        }
        for (; a--;) u = i ? i[a] : a, r = t(r, n[u], u, n);
        return r
    }, h.find = h.detect = function (n, t, r) {
        var e;
        return t = h.iteratee(t, r), h.some(n, function (n, r, u) {
            return t(n, r, u) ? (e = n, !0) : void 0
        }), e
    }, h.filter = h.select = function (n, t, r) {
        var e = [];
        return null == n ? e : (t = h.iteratee(t, r), h.each(n, function (n, r, u) {
            t(n, r, u) && e.push(n)
        }), e)
    }, h.reject = function (n, t, r) {
        return h.filter(n, h.negate(h.iteratee(t)), r)
    }, h.every = h.all = function (n, t, r) {
        if (null == n) return !0;
        t = h.iteratee(t, r);
        var e, u, i = n.length !== +n.length && h.keys(n),
            a = (i || n).length;
        for (e = 0; a > e; e++)
            if (u = i ? i[e] : e, !t(n[u], u, n)) return !1;
        return !0
    }, h.some = h.any = function (n, t, r) {
        if (null == n) return !1;
        t = h.iteratee(t, r);
        var e, u, i = n.length !== +n.length && h.keys(n),
            a = (i || n).length;
        for (e = 0; a > e; e++)
            if (u = i ? i[e] : e, t(n[u], u, n)) return !0;
        return !1
    }, h.contains = h.include = function (n, t) {
        return null == n ? !1 : (n.length !== +n.length && (n = h.values(n)), h.indexOf(n, t) >= 0)
    }, h.invoke = function (n, t) {
        var r = a.call(arguments, 2),
            e = h.isFunction(t);
        return h.map(n, function (n) {
            return (e ? t : n[t]).apply(n, r)
        })
    }, h.pluck = function (n, t) {
        return h.map(n, h.property(t))
    }, h.where = function (n, t) {
        return h.filter(n, h.matches(t))
    }, h.findWhere = function (n, t) {
        return h.find(n, h.matches(t))
    }, h.max = function (n, t, r) {
        var e, u, i = -1 / 0,
            a = -1 / 0;
        if (null == t && null != n) {
            n = n.length === +n.length ? n : h.values(n);
            for (var o = 0, l = n.length; l > o; o++) e = n[o], e > i && (i = e)
        } else t = h.iteratee(t, r), h.each(n, function (n, r, e) {
            u = t(n, r, e), (u > a || u === -1 / 0 && i === -1 / 0) && (i = n, a = u)
        });
        return i
    }, h.min = function (n, t, r) {
        var e, u, i = 1 / 0,
            a = 1 / 0;
        if (null == t && null != n) {
            n = n.length === +n.length ? n : h.values(n);
            for (var o = 0, l = n.length; l > o; o++) e = n[o], i > e && (i = e)
        } else t = h.iteratee(t, r), h.each(n, function (n, r, e) {
            u = t(n, r, e), (a > u || 1 / 0 === u && 1 / 0 === i) && (i = n, a = u)
        });
        return i
    }, h.shuffle = function (n) {
        for (var t, r = n && n.length === +n.length ? n : h.values(n), e = r.length, u = Array(e), i = 0; e > i; i++) t = h.random(0, i), t !== i && (u[i] = u[t]), u[t] = r[i];
        return u
    }, h.sample = function (n, t, r) {
        return null == t || r ? (n.length !== +n.length && (n = h.values(n)), n[h.random(n.length - 1)]) : h.shuffle(n).slice(0, Math.max(0, t))
    }, h.sortBy = function (n, t, r) {
        return t = h.iteratee(t, r), h.pluck(h.map(n, function (n, r, e) {
            return {
                value: n,
                index: r,
                criteria: t(n, r, e)
            }
        }).sort(function (n, t) {
            var r = n.criteria,
                e = t.criteria;
            if (r !== e) {
                if (r > e || r === void 0) return 1;
                if (e > r || e === void 0) return -1
            }
            return n.index - t.index
        }), "value")
    };
    var m = function (n) {
        return function (t, r, e) {
            var u = {};
            return r = h.iteratee(r, e), h.each(t, function (e, i) {
                var a = r(e, i, t);
                n(u, e, a)
            }), u
        }
    };
    h.groupBy = m(function (n, t, r) {
        h.has(n, r) ? n[r].push(t) : n[r] = [t]
    }), h.indexBy = m(function (n, t, r) {
        n[r] = t
    }), h.countBy = m(function (n, t, r) {
        h.has(n, r) ? n[r]++ : n[r] = 1
    }), h.sortedIndex = function (n, t, r, e) {
        r = h.iteratee(r, e, 1);
        for (var u = r(t), i = 0, a = n.length; a > i;) {
            var o = i + a >>> 1;
            r(n[o]) < u ? i = o + 1 : a = o
        }
        return i
    }, h.toArray = function (n) {
        return n ? h.isArray(n) ? a.call(n) : n.length === +n.length ? h.map(n, h.identity) : h.values(n) : []
    }, h.size = function (n) {
        return null == n ? 0 : n.length === +n.length ? n.length : h.keys(n).length
    }, h.partition = function (n, t, r) {
        t = h.iteratee(t, r);
        var e = [],
            u = [];
        return h.each(n, function (n, r, i) {
            (t(n, r, i) ? e : u).push(n)
        }), [e, u]
    }, h.first = h.head = h.take = function (n, t, r) {
        return null == n ? void 0 : null == t || r ? n[0] : 0 > t ? [] : a.call(n, 0, t)
    }, h.initial = function (n, t, r) {
        return a.call(n, 0, Math.max(0, n.length - (null == t || r ? 1 : t)))
    }, h.last = function (n, t, r) {
        return null == n ? void 0 : null == t || r ? n[n.length - 1] : a.call(n, Math.max(n.length - t, 0))
    }, h.rest = h.tail = h.drop = function (n, t, r) {
        return a.call(n, null == t || r ? 1 : t)
    }, h.compact = function (n) {
        return h.filter(n, h.identity)
    };
    var y = function (n, t, r, e) {
        if (t && h.every(n, h.isArray)) return o.apply(e, n);
        for (var u = 0, a = n.length; a > u; u++) {
            var l = n[u];
            h.isArray(l) || h.isArguments(l) ? t ? i.apply(e, l) : y(l, t, r, e) : r || e.push(l)
        }
        return e
    };
    h.flatten = function (n, t) {
        return y(n, t, !1, [])
    }, h.without = function (n) {
        return h.difference(n, a.call(arguments, 1))
    }, h.uniq = h.unique = function (n, t, r, e) {
        if (null == n) return [];
        h.isBoolean(t) || (e = r, r = t, t = !1), null != r && (r = h.iteratee(r, e));
        for (var u = [], i = [], a = 0, o = n.length; o > a; a++) {
            var l = n[a];
            if (t) a && i === l || u.push(l), i = l;
            else if (r) {
                var c = r(l, a, n);
                h.indexOf(i, c) < 0 && (i.push(c), u.push(l))
            } else h.indexOf(u, l) < 0 && u.push(l)
        }
        return u
    }, h.union = function () {
        return h.uniq(y(arguments, !0, !0, []))
    }, h.intersection = function (n) {
        if (null == n) return [];
        for (var t = [], r = arguments.length, e = 0, u = n.length; u > e; e++) {
            var i = n[e];
            if (!h.contains(t, i)) {
                for (var a = 1; r > a && h.contains(arguments[a], i); a++);
                a === r && t.push(i)
            }
        }
        return t
    }, h.difference = function (n) {
        var t = y(a.call(arguments, 1), !0, !0, []);
        return h.filter(n, function (n) {
            return !h.contains(t, n)
        })
    }, h.zip = function (n) {
        if (null == n) return [];
        for (var t = h.max(arguments, "length").length, r = Array(t), e = 0; t > e; e++) r[e] = h.pluck(arguments, e);
        return r
    }, h.object = function (n, t) {
        if (null == n) return {};
        for (var r = {}, e = 0, u = n.length; u > e; e++) t ? r[n[e]] = t[e] : r[n[e][0]] = n[e][1];
        return r
    }, h.indexOf = function (n, t, r) {
        if (null == n) return -1;
        var e = 0,
            u = n.length;
        if (r) {
            if ("number" != typeof r) return e = h.sortedIndex(n, t), n[e] === t ? e : -1;
            e = 0 > r ? Math.max(0, u + r) : r
        }
        for (; u > e; e++)
            if (n[e] === t) return e;
        return -1
    }, h.lastIndexOf = function (n, t, r) {
        if (null == n) return -1;
        var e = n.length;
        for ("number" == typeof r && (e = 0 > r ? e + r + 1 : Math.min(e, r + 1)); --e >= 0;)
            if (n[e] === t) return e;
        return -1
    }, h.range = function (n, t, r) {
        arguments.length <= 1 && (t = n || 0, n = 0), r = r || 1;
        for (var e = Math.max(Math.ceil((t - n) / r), 0), u = Array(e), i = 0; e > i; i++ , n += r) u[i] = n;
        return u
    };
    var d = function () { };
    h.bind = function (n, t) {
        var r, e;
        if (p && n.bind === p) return p.apply(n, a.call(arguments, 1));
        if (!h.isFunction(n)) throw new TypeError("Bind must be called on a function");
        return r = a.call(arguments, 2), e = function () {
            if (!(this instanceof e)) return n.apply(t, r.concat(a.call(arguments)));
            d.prototype = n.prototype;
            var u = new d;
            d.prototype = null;
            var i = n.apply(u, r.concat(a.call(arguments)));
            return h.isObject(i) ? i : u
        }
    }, h.partial = function (n) {
        var t = a.call(arguments, 1);
        return function () {
            for (var r = 0, e = t.slice(), u = 0, i = e.length; i > u; u++) e[u] === h && (e[u] = arguments[r++]);
            for (; r < arguments.length;) e.push(arguments[r++]);
            return n.apply(this, e)
        }
    }, h.bindAll = function (n) {
        var t, r, e = arguments.length;
        if (1 >= e) throw new Error("bindAll must be passed function names");
        for (t = 1; e > t; t++) r = arguments[t], n[r] = h.bind(n[r], n);
        return n
    }, h.memoize = function (n, t) {
        var r = function (e) {
            var u = r.cache,
                i = t ? t.apply(this, arguments) : e;
            return h.has(u, i) || (u[i] = n.apply(this, arguments)), u[i]
        };
        return r.cache = {}, r
    }, h.delay = function (n, t) {
        var r = a.call(arguments, 2);
        return setTimeout(function () {
            return n.apply(null, r)
        }, t)
    }, h.defer = function (n) {
        return h.delay.apply(h, [n, 1].concat(a.call(arguments, 1)))
    }, h.throttle = function (n, t, r) {
        var e, u, i, a = null,
            o = 0;
        r || (r = {});
        var l = function () {
            o = r.leading === !1 ? 0 : h.now(), a = null, i = n.apply(e, u), a || (e = u = null)
        };
        return function () {
            var c = h.now();
            o || r.leading !== !1 || (o = c);
            var f = t - (c - o);
            return e = this, u = arguments, 0 >= f || f > t ? (clearTimeout(a), a = null, o = c, i = n.apply(e, u), a || (e = u = null)) : a || r.trailing === !1 || (a = setTimeout(l, f)), i
        }
    }, h.debounce = function (n, t, r) {
        var e, u, i, a, o, l = function () {
            var c = h.now() - a;
            t > c && c > 0 ? e = setTimeout(l, t - c) : (e = null, r || (o = n.apply(i, u), e || (i = u = null)))
        };
        return function () {
            i = this, u = arguments, a = h.now();
            var c = r && !e;
            return e || (e = setTimeout(l, t)), c && (o = n.apply(i, u), i = u = null), o
        }
    }, h.wrap = function (n, t) {
        return h.partial(t, n)
    }, h.negate = function (n) {
        return function () {
            return !n.apply(this, arguments)
        }
    }, h.compose = function () {
        var n = arguments,
            t = n.length - 1;
        return function () {
            for (var r = t, e = n[t].apply(this, arguments); r--;) e = n[r].call(this, e);
            return e
        }
    }, h.after = function (n, t) {
        return function () {
            return --n < 1 ? t.apply(this, arguments) : void 0
        }
    }, h.before = function (n, t) {
        var r;
        return function () {
            return --n > 0 ? r = t.apply(this, arguments) : t = null, r
        }
    }, h.once = h.partial(h.before, 2), h.keys = function (n) {
        if (!h.isObject(n)) return [];
        if (s) return s(n);
        var t = [];
        for (var r in n) h.has(n, r) && t.push(r);
        return t
    }, h.values = function (n) {
        for (var t = h.keys(n), r = t.length, e = Array(r), u = 0; r > u; u++) e[u] = n[t[u]];
        return e
    }, h.pairs = function (n) {
        for (var t = h.keys(n), r = t.length, e = Array(r), u = 0; r > u; u++) e[u] = [t[u], n[t[u]]];
        return e
    }, h.invert = function (n) {
        for (var t = {}, r = h.keys(n), e = 0, u = r.length; u > e; e++) t[n[r[e]]] = r[e];
        return t
    }, h.functions = h.methods = function (n) {
        var t = [];
        for (var r in n) h.isFunction(n[r]) && t.push(r);
        return t.sort()
    }, h.extend = function (n) {
        if (!h.isObject(n)) return n;
        for (var t, r, e = 1, u = arguments.length; u > e; e++) {
            t = arguments[e];
            for (r in t) c.call(t, r) && (n[r] = t[r])
        }
        return n
    }, h.pick = function (n, t, r) {
        var e, u = {};
        if (null == n) return u;
        if (h.isFunction(t)) {
            t = g(t, r);
            for (e in n) {
                var i = n[e];
                t(i, e, n) && (u[e] = i)
            }
        } else {
            var l = o.apply([], a.call(arguments, 1));
            n = new Object(n);
            for (var c = 0, f = l.length; f > c; c++) e = l[c], e in n && (u[e] = n[e])
        }
        return u
    }, h.omit = function (n, t, r) {
        if (h.isFunction(t)) t = h.negate(t);
        else {
            var e = h.map(o.apply([], a.call(arguments, 1)), String);
            t = function (n, t) {
                return !h.contains(e, t)
            }
        }
        return h.pick(n, t, r)
    }, h.defaults = function (n) {
        if (!h.isObject(n)) return n;
        for (var t = 1, r = arguments.length; r > t; t++) {
            var e = arguments[t];
            for (var u in e) n[u] === void 0 && (n[u] = e[u])
        }
        return n
    }, h.clone = function (n) {
        return h.isObject(n) ? h.isArray(n) ? n.slice() : h.extend({}, n) : n
    }, h.tap = function (n, t) {
        return t(n), n
    };
    var b = function (n, t, r, e) {
        if (n === t) return 0 !== n || 1 / n === 1 / t;
        if (null == n || null == t) return n === t;
        n instanceof h && (n = n._wrapped), t instanceof h && (t = t._wrapped);
        var u = l.call(n);
        if (u !== l.call(t)) return !1;
        switch (u) {
            case "[object RegExp]":
            case "[object String]":
                return "" + n == "" + t;
            case "[object Number]":
                return +n !== +n ? +t !== +t : 0 === +n ? 1 / +n === 1 / t : +n === +t;
            case "[object Date]":
            case "[object Boolean]":
                return +n === +t
        }
        if ("object" != typeof n || "object" != typeof t) return !1;
        for (var i = r.length; i--;)
            if (r[i] === n) return e[i] === t;
        var a = n.constructor,
            o = t.constructor;
        if (a !== o && "constructor" in n && "constructor" in t && !(h.isFunction(a) && a instanceof a && h.isFunction(o) && o instanceof o)) return !1;
        r.push(n), e.push(t);
        var c, f;
        if ("[object Array]" === u) {
            if (c = n.length, f = c === t.length)
                for (; c-- && (f = b(n[c], t[c], r, e)););
        } else {
            var s, p = h.keys(n);
            if (c = p.length, f = h.keys(t).length === c)
                for (; c-- && (s = p[c], f = h.has(t, s) && b(n[s], t[s], r, e)););
        }
        return r.pop(), e.pop(), f
    };
    h.isEqual = function (n, t) {
        return b(n, t, [], [])
    }, h.isEmpty = function (n) {
        if (null == n) return !0;
        if (h.isArray(n) || h.isString(n) || h.isArguments(n)) return 0 === n.length;
        for (var t in n)
            if (h.has(n, t)) return !1;
        return !0
    }, h.isElement = function (n) {
        return !(!n || 1 !== n.nodeType)
    }, h.isArray = f || function (n) {
        return "[object Array]" === l.call(n)
    }, h.isObject = function (n) {
        var t = typeof n;
        return "function" === t || "object" === t && !!n
    }, h.each(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function (n) {
        h["is" + n] = function (t) {
            return l.call(t) === "[object " + n + "]"
        }
    }), h.isArguments(arguments) || (h.isArguments = function (n) {
        return h.has(n, "callee")
    }), "function" != typeof /./ && (h.isFunction = function (n) {
        return "function" == typeof n || !1
    }), h.isFinite = function (n) {
        return isFinite(n) && !isNaN(parseFloat(n))
    }, h.isNaN = function (n) {
        return h.isNumber(n) && n !== +n
    }, h.isBoolean = function (n) {
        return n === !0 || n === !1 || "[object Boolean]" === l.call(n)
    }, h.isNull = function (n) {
        return null === n
    }, h.isUndefined = function (n) {
        return n === void 0
    }, h.has = function (n, t) {
        return null != n && c.call(n, t)
    }, h.noConflict = function () {
        return n._ = t, this
    }, h.identity = function (n) {
        return n
    }, h.constant = function (n) {
        return function () {
            return n
        }
    }, h.noop = function () { }, h.property = function (n) {
        return function (t) {
            return t[n]
        }
    }, h.matches = function (n) {
        var t = h.pairs(n),
            r = t.length;
        return function (n) {
            if (null == n) return !r;
            n = new Object(n);
            for (var e = 0; r > e; e++) {
                var u = t[e],
                    i = u[0];
                if (u[1] !== n[i] || !(i in n)) return !1
            }
            return !0
        }
    }, h.times = function (n, t, r) {
        var e = Array(Math.max(0, n));
        t = g(t, r, 1);
        for (var u = 0; n > u; u++) e[u] = t(u);
        return e
    }, h.random = function (n, t) {
        return null == t && (t = n, n = 0), n + Math.floor(Math.random() * (t - n + 1))
    }, h.now = Date.now || function () {
        return (new Date).getTime()
    };
    var _ = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#x27;",
        "`": "&#x60;"
    },
        w = h.invert(_),
        j = function (n) {
            var t = function (t) {
                return n[t]
            },
                r = "(?:" + h.keys(n).join("|") + ")",
                e = RegExp(r),
                u = RegExp(r, "g");
            return function (n) {
                return n = null == n ? "" : "" + n, e.test(n) ? n.replace(u, t) : n
            }
        };
    h.escape = j(_), h.unescape = j(w), h.result = function (n, t) {
        if (null == n) return void 0;
        var r = n[t];
        return h.isFunction(r) ? n[t]() : r
    };
    var x = 0;
    h.uniqueId = function (n) {
        var t = ++x + "";
        return n ? n + t : t
    }, h.templateSettings = {
        evaluate: /<%([\s\S]+?)%>/g,
        interpolate: /<%=([\s\S]+?)%>/g,
        escape: /<%-([\s\S]+?)%>/g
    };
    var A = /(.)^/,
        k = {
            "'": "'",
            "\\": "\\",
            "\r": "r",
            "\n": "n",
            "\u2028": "u2028",
            "\u2029": "u2029"
        },
        O = /\\|'|\r|\n|\u2028|\u2029/g,
        F = function (n) {
            return "\\" + k[n]
        };
    h.template = function (n, t, r) {
        !t && r && (t = r), t = h.defaults({}, t, h.templateSettings);
        var e = RegExp([(t.escape || A).source, (t.interpolate || A).source, (t.evaluate || A).source].join("|") + "|$", "g"),
            u = 0,
            i = "__p+='";
        n.replace(e, function (t, r, e, a, o) {
            return i += n.slice(u, o).replace(O, F), u = o + t.length, r ? i += "'+\n((__t=(" + r + "))==null?'':_.escape(__t))+\n'" : e ? i += "'+\n((__t=(" + e + "))==null?'':__t)+\n'" : a && (i += "';\n" + a + "\n__p+='"), t
        }), i += "';\n", t.variable || (i = "with(obj||{}){\n" + i + "}\n"), i = "var __t,__p='',__j=Array.prototype.join," + "print=function(){__p+=__j.call(arguments,'');};\n" + i + "return __p;\n";
        try {
            var a = new Function(t.variable || "obj", "_", i)
        } catch (o) {
            throw o.source = i, o
        }
        var l = function (n) {
            return a.call(this, n, h)
        },
            c = t.variable || "obj";
        return l.source = "function(" + c + "){\n" + i + "}", l
    }, h.chain = function (n) {
        var t = h(n);
        return t._chain = !0, t
    };
    var E = function (n) {
        return this._chain ? h(n).chain() : n
    };
    h.mixin = function (n) {
        h.each(h.functions(n), function (t) {
            var r = h[t] = n[t];
            h.prototype[t] = function () {
                var n = [this._wrapped];
                return i.apply(n, arguments), E.call(this, r.apply(h, n))
            }
        })
    }, h.mixin(h), h.each(["pop", "push", "reverse", "shift", "sort", "splice", "unshift"], function (n) {
        var t = r[n];
        h.prototype[n] = function () {
            var r = this._wrapped;
            return t.apply(r, arguments), "shift" !== n && "splice" !== n || 0 !== r.length || delete r[0], E.call(this, r)
        }
    }), h.each(["concat", "join", "slice"], function (n) {
        var t = r[n];
        h.prototype[n] = function () {
            return E.call(this, t.apply(this._wrapped, arguments))
        }
    }), h.prototype.value = function () {
        return this._wrapped
    }, "function" == typeof define && define.amd && define("underscore", [], function () {
        return h
    })
}).call(this);

this["FirechatDefaultTemplates"] = this["FirechatDefaultTemplates"] || {};

this["FirechatDefaultTemplates"]["templates/layout-full.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div id=\'firechat\' class=\'full\'>\n<div id=\'firechat-header\' class=\'clearfix\'>\n<div class=\'clearfix\'></div>\n</div>\n<div id=\'firechat-tabs\' class=\'clearfix\'>\n<ul id=\'firechat-tab-list\' class=\'nav nav-tabs clearfix\'></ul>\n<div id=\'firechat-tab-content\' class=\'tab-content\'></div>\n</div><div id=\'firechat-footer\' class=\'clearfix\'></div>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/layout-popout.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div id=\'firechat\' class=\'full\'>\n<div id=\'firechat-tabs\' class=\'clearfix\'>\n<ul id=\'firechat-tab-list\' class=\'nav nav-tabs clearfix\'></ul>\n<div id=\'firechat-tab-content\' class=\'tab-content\'></div>\n</div>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/message-context-menu.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape,
        __j = Array.prototype.join;

    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {
        __p += '<div data-toggle=\'firechat-contextmenu\' class=\'contextmenu\' data-message-id=\'' + __e(id) + '\'>\n<ul>\n<li><a href=\'#!\' data-event=\'firechat-user-warn\'>Warn User</a></li>\n';
        if (allowKick) {
            ;
            __p += '\n<li><a href=\'#!\' data-event=\'firechat-user-kick\'>Kick User</a></li>\n';
        };
        __p += '\n<li><a href=\'#!\' data-event=\'firechat-user-suspend-hour\'>Suspend User (1 Hour)</a></li>\n<li><a href=\'#!\' data-event=\'firechat-user-suspend-day\'>Suspend User (1 Day)</a></li>\n<li><a href=\'#!\' data-event=\'firechat-message-delete\'>Delete Message</a></li>\n</ul>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/message.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape,
        __j = Array.prototype.join;

    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {

        var shareableItem = "";
        let isTitleExists = false;
        try {
            if (obj.hasOwnProperty("s") && typeof obj.s === "object" && obj.s != null) {
                shareableItem += '<div class="_shareable_item">';
                let pujaTitle = "";
                if (obj.s.hasOwnProperty("t") && typeof obj.s.t === "string" && obj.s.t != "") {
                    pujaTitle = obj.s.t;
                    isTitleExists = true;
                }

                if (obj.s.hasOwnProperty("img") && typeof obj.s.img === "string" && obj.s.img != "") {
                    shareableItem += '<div class="puja_image_container"><img src="' + obj.s.img + '" alt="' + pujaTitle + '" class="img-fluid"/></div>';
                }
                shareableItem += '<div class="_shareable_item_inner py-2 px-3">';
                if (pujaTitle != "") {
                    shareableItem += '<p class="puja-title font-14 font-weight-bold m-0">' + pujaTitle + '</p>';
                }
                if (obj.s.hasOwnProperty("p") && typeof obj.s.p === "object" && obj.s.img != null) {
                    shareableItem += '<p class="puja-price d-flex my-1">';
                    if (obj.s.p.hasOwnProperty("br") && typeof obj.s.p.br === "string" && parseFloat(obj.s.p.br) > 0) {
                        shareableItem += '<span class="font-weight-semi-bold d-flex mr-3"><del>' + currency + obj.s.p.br + '</del></span>';
                    }
                    if (obj.s.p.hasOwnProperty("cr") && typeof obj.s.p.cr === "string" && parseFloat(obj.s.p.cr) > 0) {
                        shareableItem += '<span class="font-weight-semi-bold d-flex color-red">' + currency + obj.s.p.cr + '</span>';
                    }
                    shareableItem += '</p>';
                    if (obj.s.p.hasOwnProperty("dt") && typeof obj.s.p.dt === "string" && obj.s.p.dt != "") {
                        shareableItem += '<span>' + obj.s.p.dt + '</span>';
                    }
                }
                let shareableLink = "";
                if (obj.s.hasOwnProperty("u") && typeof obj.s.u === "string" && obj.s.u != "") {
                    shareableLink = obj.s.u;
                }
                shareableItem += '</div>';
                if (shareableLink != "") {
                    shareableItem += '<p class="bg-white puja_share_link mb-0 text-center" style="color:#0000E1; font-size:11px;">';
                    if (obj.s.hasOwnProperty("bt") && typeof obj.s.bt === "string" && obj.s.bt != "") {
                        shareableItem += '<a class="d-flex align-items-center justify-content-center" style="color:#0000E1" href="' + shareableLink + '" target="_blank"><img src="https://cdn.anytimeastro.com/dashaspeaks/web/content/images/puja-share-btn.png" width="16" height="16" /> <span class="ml-1 d-flex" style="color:#0000E1">' + obj.s.bt + '</span></a>';
                    } else {
                        shareableItem += '<a class="d-flex align-items-center justify-content-center color-red" style="color:#0000E1" href="' + shareableLink + '" target="_blank"><img src="https://cdn.anytimeastro.com/dashaspeaks/web/content/images/puja-share-btn.png" width="16" height="16" /> <span class="ml-1 d-flex" style="color:#0000E1">' + shareableLink + '</span></a>';
                    }
                    shareableItem += '</p>';
                }
                shareableItem += '</div>';
            }
        } catch (e) {
            isTitleExists = false;
        }

        let _isShareableItem = "";
        replyType = "m";
        if (isTitleExists) {
            message = shareableItem;
            replyType = "s";
            _isShareableItem = "_isShareableItem";
        }

        __p += '<div class=\messageBox ><div class=\'position-relative message message-' + __e(type) + ' ' + _isShareableItem +' ';
        if (isSelfMessage) {
            ;
            __p += ' message-self ';
        };
        //__p += '\' data-message-id=\'' + __e(id) + '\' data-user-id=\'' + __e(userId) + '\' data-user-name=\'' + __e(name) + '\' data-class="firechat-message">\n<div class=\'clearfix\'>\n<label class=\'fourfifth\'>\n<strong class=\'name\' title=\'' + __e(name) + '\'>' + __e(name) + '</strong>\n<em>(' + __e(localtime) + ')</em>:\n'
        __p += '\' data-message-id=\'' + __e(id) + '\' data-user-id=\'' + __e(userId) + '\' data-user-name=\'' + __e(name) + '\' data-class="firechat-message">\n'
           /* + '</label>';*/
        //if (!disableActions || isSelfMessage) {

        //    __p += '<label class=\'fifth alignright\'>';

        //    if (!isSelfMessage) {
        //        // __p +='<a href=\'#!\' data-event=\'firechat-user-chat\' class=\'icon user-chat\' title=\'Invite to Private Chat\'>&nbsp;</a>';
        //        // __p +='<a href=\'#!\' data-event=\'firechat-user-mute-toggle\' class=\'icon user-mute\' title=\'Mute User\'>&nbsp;</a>';
        //    }

        //    if (isSelfMessage && message != "message deleted") {
        //        __p += '<a href="#!" data-event="firechat-delete-msg" data-event="firechat-message-delete" class="" title="delete-msg">&nbsp;</a>';
        //    }
        //    +'</label>\n';
        //};
        //__p += '</div>\n<div class=\'clearfix message-content\'>\n' + ((__t = (message)) == null ? '' : __t) + '\n</div>\n</div>\n<span>(' + __e(localtime) + ')</span>\n</div>';

         var str = "";
            str = `<div class="dropdown">
               <button class="chatrplybtn dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
  <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
</svg> </button>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
               <span class="dropdown-item" onclick="reply('${id}')" titile='Reply'> Reply </span>     
               </div></div> `;

        

        __p += ' ' + str + ' <div class=\'clearfix message-content ' + _isShareableItem +'\'>\n' + ((__t = (message)) == null ? '' : __t) + '\n</div>\n<span class=\'message-timestamp\'>' + __e(localtime) + '</span>\n</div>\n</div>';
    }

    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-alert.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n<h6>' + __e(message) + '</h6>\n<p class=\'clearfix\'>\n<button type=\'button\' class=\'btn quarter right close\'>Close</button>\n</p>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-create-room.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'clearfix\'>\n<h6>Give your chat room a name:</h6>\n<input data-input=\'firechat-room-name\' type=\'text\' placeholder=\'Room name...\' style=\'margin-bottom: 5px;\' maxlength=\'' + __e(maxLengthRoomName) + '\'>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-invitation.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n<h5>' + __e(fromUserName) + '</h5>\n<p>invited you to join</p>\n<h5>' + __e(toRoomName) + '</h5>\n<p class=\'clearfix\'>\n<button data-toggle=\'accept\' type=\'button\' class=\'btn\'>Accept</button>\n<button data-toggle=\'decline\' type=\'button\' class=\'btn\'>Decline</button>\n</p>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-client-invitation.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n \n<p>Waiting for psychic response</p>\n \n \n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-invite-private.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n<h6>Invite <strong>' + __e(userName) + '</strong> to ' + __e(roomName) + '?</h6>\n<p class=\'clearfix\'>\n<button data-toggle=\'accept\' type=\'button\' class=\'btn\'>Invite</button>\n<button data-toggle=\'decline\' type=\'button\' class=\'close btn\'>Cancel</button>\n</p>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-invite-reply.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape,
        __j = Array.prototype.join;

    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n<h5>' + __e(toUserName) + '</h5>\n<p>\n';
        if (status === 'accepted') {
            ;
            __p += ' accepted your invite. ';
        } else {
            ;
            __p += ' declined your invite. ';
        };
        __p += '\n</p>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt-user-mute.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div class=\'aligncenter clearfix\'>\n<h5>' + __e(userName) + '</h5>\n<p class=\'clearfix\'>\n<button data-toggle=\'accept\' type=\'button\' class=\'btn\'>Mute</button>\n<button data-toggle=\'decline\' type=\'button\' class=\'btn\'>Cancel</button>\n</p>\n</div>';
    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/prompt.html"] = function (obj) {
    if (obj.title != "Accepted") {
        obj || (obj = {});
        var __t, __p = '',
            __e = _.escape;
        with (obj) {
            __p += '<div class=\'prompt hidden\'>\n<div class=\'prompt-header\'>\n' + __e(title) + '\n<a href=\'#!\' class=\'close right\'>&#215;</a>\n</div>\n<div class=\'prompt-body clearfix\'>\n' + ((__t = (content)) == null ? '' : __t) + '\n</div>\n<div class=\'prompt-footer\'><button  id="promptOk"  type=\'button\' class=\'btn btn-primary firechat ok\'>Ok</button></div>\n</div>';
        }
        return __p
    }
};

this["FirechatDefaultTemplates"]["templates/tab-content.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<div id=\'' + __e(id) + '\' data-room-id=\'' + __e(id) + '\' class=\'tab-pane\'><div class=\'clearfix\'>\n<div id=\'firechat-messages' + __e(id) + '\' class=\'chat\'></div>\n</div>\n<div class=\'textarea-container\'>\n<div class=\'reply-message-container\'></div>\n<div class=\'paymentalert-container\'></div>\n<div class=\'actualpp-inline-container\'></div><div class=\'textarea-message-div d-flex clearfix\'>\n<label>Your message:</label>\n'
        __p += '<a href="#!" data-event="firechat-attachment-msg"  class="icon user-attachment-msg" title="Files with jpeg, pdf, jpg, mp4 and mp3 extension are supported">&nbsp;</a>'
        __p += '<textarea id=\'textarea' + __e(id) + '\' placeholder=\'' + getLanguageKeyString('CPP_Type_chat_Msg') +'\' onkeyup="manage(this)"></textarea>'
        __p += '<button value="' + getLanguageKeyString('CPP_Send') + '" disabled="disabled" id="sendMsg" class="colorblack  chat-btn firechat"><span class="d-none d-md-flex align-items-center justify-content-center font-18">' + getLanguageKeyString('CPP_Send') +'</span><span class="d-flex d-md-none"><img src="https://cdn.anytimeastro.com/dashaspeaks/web/content/anytimeastro/images/chat-send-icon.svg" width="32" height="30"/></span></button>\n</div>\n</div>\n<div></div></div>';


    }
    return __p
};

this["FirechatDefaultTemplates"]["templates/tab-menu-item.html"] = function (obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with (obj) {
        __p += '<li data-room-id=\'' + __e(id) + '\'>\n<a href=\'#' + __e(id) + '\' data-toggle=\'firechat-tab\' title=\'' + __e(name) + '\'>' + __e(name) + '</a>\n</li>';
    }
    return __p
};

(function ($) {

    // Shim for Function.bind(...) - (Required by IE < 9, FF < 4, SF < 6)
    if (!Function.prototype.bind) {
        Function.prototype.bind = function (oThis) {
            if (typeof this !== "function") {
                throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
            }

            var aArgs = Array.prototype.slice.call(arguments, 1),
                fToBind = this,
                fNOP = function () { },
                fBound = function () {
                    return fToBind.apply(this instanceof fNOP && oThis ? this : oThis,
                        aArgs.concat(Array.prototype.slice.call(arguments)));
                };

            fNOP.prototype = this.prototype;
            fBound.prototype = new fNOP();
            return fBound;
        };
    }

    // Shim for Object.keys(...) - (Required by IE < 9, FF < 4)
    Object.keys = Object.keys || function (oObj) {
        var result = [];
        for (var name in oObj) {
            if (oObj.hasOwnProperty(name)) {
                result.push(name);
            }
        }
        return result;
    };

})();

// Firechat is a simple, easily-extensible data layer for multi-user,
// multi-room chat, built entirely on [Firebase](https://firebase.google.com).
//
// The Firechat object is the primary conduit for all underlying data events.
// It exposes a number of methods for binding event listeners, creating,
// entering, or leaving chat rooms, initiating chats, sending messages,
// and moderator actions such as warning, kicking, or suspending users.
//
//     firechat.js 3.0.1
//     https://firebase.google.com
//     (c) 2016 Firebase
//     License: MIT

// Setup
// --------------
(function () {
    // Establish a reference to the `window` object, and save the previous value
    // of the `Firechat` variable.
    var root = this,
        previousFirechat = root.Firechat;

    function Firechat(firebaseRef, options) {

        // Cache the provided Database reference and the firebase.App instance
        this._firechatRef = firebaseRef;
        this._firebaseApp = firebaseRef.database.app;

        // User-specific instance variables.
        this._user = null;
        this._userId = null;
        this._userName = null;
        this._roleId = null;
        this._isModerator = false;

        // A unique id generated for each session.
        this._sessionId = null;

        // A mapping of event IDs to an array of callbacks.
        this._events = {};

        // A mapping of room IDs to a boolean indicating presence.
        this._rooms = {};

        // A mapping of operations to re-queue on disconnect.
        this._presenceBits = {};

        // Commonly-used Firebase references.
        this._userRef = null;
        this._messageRef = this._firechatRef.child('room-messages');
        this._roomRef = this._firechatRef.child('room-metadata');
        this._moderatorsRef = this._firechatRef.child('moderators');
        this._suspensionsRef = this._firechatRef.child('suspensions');
        //this._usersOnlineRef = this._firechatRef.child('user-names-online');
        this._usersset = this._firechatRef.child('users');

        // Setup and establish default options.
        this._options = options || {};

        // The number of historical messages to load per room.
        this._options.numMaxMessages = this._options.numMaxMessages || 50;
    }

    // Run Firechat in *noConflict* mode, returning the `Firechat` variable to
    // its previous owner, and returning a reference to the Firechat object.
    Firechat.noConflict = function noConflict() {
        root.Firechat = previousFirechat;
        return Firechat;
    };

    // Export the Firechat object as a global.
    root.Firechat = Firechat;

    // Firechat Internal Methods
    // --------------
    Firechat.prototype = {

        // Load the initial metadata for the user's account and set initial state.
        _loadUserMetadata: function (onComplete) {
            var self = this;

            // Update the user record with a default name on user's first visit.
            this._userRef.transaction(function (current) {
                if (!current || !current.id || !current.name) {
                //if (current != null && typeof (current === 'object') && (current.hasOwnProperty('id') || current.hasOwnProperty('name'))) {
                    return {
                        id: self._userId,
                        name: self._userName
                    };
                }
            }, function (error, committed, snapshot) {
                if (snapshot != null) {
                    self._user = snapshot.val();
                }
                //self._moderatorsRef.child(self._userId).once('value', function (snapshot) {
                //    self._isModerator = !!snapshot.val();
                //    root.setTimeout(onComplete, 0);
                //});
                root.setTimeout(onComplete, 0);
            });
        },

        // Initialize Firebase listeners and callbacks for the supported bindings.
        _setupDataEvents: function () {

            // Monitor connection state so we can requeue disconnect operations if need be.
            var connectedRef = this._firechatRef.root.child('.info/connected');
            connectedRef.on('value', function (snapshot) {
                if (snapshot.val() === true) {
                    // We're connected (or reconnected)! Set up our presence state.
                    for (var path in this._presenceBits) {
                        var op = this._presenceBits[path],
                            ref = op.ref;
                        ref.onDisconnect().set(op.offlineValue);
                        ref.set(op.onlineValue);
                    }
                }
            }, this);

            // Queue up a presence operation to remove the session when presence is lost
            //this._queuePresenceOperation(this._sessionRef, true, null);

            // Register our username in the public user listing.
            //var usernameRef = this._usersOnlineRef.child(this._userId);
            //var usernameSessionRef = usernameRef.child(this._sessionId);            
            //this._queuePresenceOperation(usernameSessionRef, {
            //    id: this._userId,
            //    name: this._userName
            //}, null);

            // Listen for state changes for the given user.
            this._userRef.on('value', this._onUpdateUser, this);

            // Listen for chat invitations from other users.
            this._userRef.child('invites').on('child_added', this._onFirechatInvite, this);

            // Listen for messages from moderators and adminstrators.
            this._userRef.child('notifications').on('child_added', this._onNotification, this);
        },

        // Append the new callback to our list of event handlers.
        _addEventCallback: function (eventId, callback) {
            this._events[eventId] = this._events[eventId] || [];
            this._events[eventId].push(callback);
        },

        // Retrieve the list of event handlers for a given event id.
        _getEventCallbacks: function (eventId) {
            if (this._events.hasOwnProperty(eventId)) {
                return this._events[eventId];
            }
            return [];
        },

        // Invoke each of the event handlers for a given event id with specified data.
        _invokeEventCallbacks: function (eventId) {
           
            var args = [],
                callbacks = this._getEventCallbacks(eventId);

            Array.prototype.push.apply(args, arguments);
            args = args.slice(1);

            for (var i = 0; i < callbacks.length; i += 1) {
                callbacks[i].apply(null, args);
            }
        },

        // Keep track of on-disconnect events so they can be requeued if we disconnect the reconnect.
        _queuePresenceOperation: function (ref, onlineValue, offlineValue) {
            ref.onDisconnect().set(offlineValue);
            ref.set(onlineValue);
            this._presenceBits[ref.toString()] = {
                ref: ref,
                onlineValue: onlineValue,
                offlineValue: offlineValue
            };
        },

        // Remove an on-disconnect event from firing upon future disconnect and reconnect.
        _removePresenceOperation: function (ref, value) {

            var path = ref.toString();
            ref.onDisconnect().cancel();
            ref.set(value);
            delete this._presenceBits[path];
        },

        // Event to monitor current user state.
        _onUpdateUser: function (snapshot) {

            this._user = snapshot.val();
            this._userName = this._user.name;
            this._invokeEventCallbacks('user-update', this._user);
        },

        // Event to monitor current auth + user state.
        _onAuthRequired: function () {
            this._invokeEventCallbacks('auth-required');
        },

        // Events to monitor room entry / exit and messages additional / removal.
        _onEnterRoom: function (room) {
            this._invokeEventCallbacks('room-enter', room);
        },
        _onNewMessage: function (roomId, snapshot, isSelfMsg) {
        
            var message = snapshot.val();
            message.id = snapshot.key;

            //newly added to handle posted message
            let isSelfMsgPosted = false;
            if (typeof isSelfMsg === 'boolean') {
                message.isSelfMsgPosted= isSelfMsgPosted = isSelfMsg || false;
            }
            //console.log("expert message" + message.id);
            this._invokeEventCallbacks('message-add', roomId, message);
           // GetmessagefromExpert(message);
            //alert("dd");
        },
        _onRemoveMessage: function (roomId, snapshot) {
            var messageId = snapshot.key;
            this._invokeEventCallbacks('message-remove', roomId, messageId);
        },
        _onLeaveRoom: function (roomId, endReason) {
            this._invokeEventCallbacks('room-exit', roomId, endReason);
        },

        // Event to listen for notifications from administrators and moderators.
        _onNotification: function (snapshot) {
            var notification = snapshot.val();
            if (!notification.read) {
                if (notification.notificationType !== 'suspension' || notification.data.suspendedUntil < new Date().getTime()) {
                    snapshot.ref.child('read').set(true);
                }
                this._invokeEventCallbacks('notification', notification);
            }
        },

        // Events to monitor chat invitations and invitation replies.
        _onFirechatInvite: function (snapshot) {
            var self = this,
                invite = snapshot.val();

            // Skip invites we've already responded to.
            if (invite.status) {
                return;
            }

            invite.id = invite.id || snapshot.key;
            self.getRoom(invite.roomId, function (room) {
                //invite.toRoomName = room.name;
                self._invokeEventCallbacks('room-invite', invite);
            });
        },

        _onFirechatInviteResponse: function (snapshot) {
            var self = this,
                invite = snapshot.val();
            if (invite != null) {
                invite.id = invite.id || snapshot.key;
                this._invokeEventCallbacks('room-invite-response', invite);
            }
        },

        _onInternalInviteResponse: function (snapshot) {
            var self = this,
                invite = snapshot.val();

            invite.id = invite.id || snapshot.key;
            this._invokeEventCallbacks('room-invite-response-internal', invite);
        }
    };

    // Firechat External Methods
    // --------------

    // Initialize the library and setup data listeners.
    Firechat.prototype.setUser = function (userId, userName, callback) {
        var self = this;

        self._firebaseApp.auth().onAuthStateChanged(function (user) {
            if (user) {
                self._userId = userId.toString();
                self._userName = userName.toString();
                self._userRef = self._firechatRef.child('users').child(self._userId);
                //self._sessionRef = self._userRef.child('sessions').push();
                //self._sessionId = self._sessionRef.key;

                self._loadUserMetadata(function () {
                    root.setTimeout(function () {
                        callback(self._user);
                        self._setupDataEvents();
                    }, 0);
                });
            } else {
                self.warn('Firechat requires an authenticated Firebase reference. Pass an authenticated reference before loading.');
            }
        });
    };

    // Resumes the previous session by automatically entering rooms.
    Firechat.prototype.resumeSession = function () {

        this._userRef.child('rooms').once('value', function (snapshot) {
            var rooms = snapshot.val();
            for (var roomId in rooms) {
                this.enterRoom(rooms[roomId].id);
            }
        }, /* onError */ function () { }, /* context */ this);
    };

    // Callback registration. Supports each of the following events:
    Firechat.prototype.on = function (eventType, cb) {
        this._addEventCallback(eventType, cb);
    };

    // Create and automatically enter a new chat room.
    Firechat.prototype.createRoom = function (roomName, roomType, callback) {
        var self = this,
            newRoomRef = this._roomRef.push();

        //self.enterRoom(newRoomRef.key);
        //callback(newRoomRef.key);
        var newRoom = {
            id: newRoomRef.key
        };
        ///*
        // ,
        //    name: roomName,
        //    type: roomType || 'public',
        //    createdByUserId: this._userId,
        //    createdAt: firebase.database.ServerValue.TIMESTAMP
        // */

        ////if (roomType === 'private') {
        ////    newRoom.authorizedUsers = {};
        ////    newRoom.authorizedUsers[this._userId] = true;
        ////}

        traceLog("Chat Room Id :", newRoomRef.key);
        if (typeof newRoomRef.key === 'string' && newRoomRef.key.length>0) {
            newRoomRef.set(newRoom, function (error) {
                if (!error) {
                    self.enterRoom(newRoomRef.key);
                }
                if (callback) {
                    callback(newRoomRef.key);
                }
            });
        }
        else {
            callback(null);
        }
    };

    // Enter a chat room.
    Firechat.prototype.enterRoom = function (roomId) {
        var self = this;
        self.getRoom(roomId, function (room) {
            //if (room != undefined || room != null) {
            //    var roomName = room.name;
            //}
            /*if (!roomId || !roomName) return;*/
            if (!roomId) return;

            // Skip if we're already in this room.
            if (self._rooms[roomId]) {
                return;
            }

            self._rooms[roomId] = true;

            if (self._user) {
                // Save entering this room to resume the session again later.

                self._userRef.child('rooms').child(roomId).set({
                    id: roomId
                });
                //,
                //name: roomName,
                //    active: true
                self._userRef.update({
                    ct: 0
                });

                //commented on 15 Feb - to ignore room users as told by prasoon sir
                // Set presence bit for the room and queue it for removal on disconnect.
                //var presenceRef = self._firechatRef.child('room-users').child(roomId).child(self._userId).child(self._sessionId);
                //self._queuePresenceOperation(presenceRef, {
                //    id: self._userId,
                //    name: self._userName
                //}, null);
            }

            // Invoke our callbacks before we start listening for new messages.
            //self._onEnterRoom({
            //    id: roomId,
            //    name: roomName
            //});
            self._onEnterRoom({
                id: roomId
            });
            // Setup message listeners
            //self._roomRef.child(roomId).once('value', function (snapshot) {
            //    self._messageRef.child(roomId).limitToLast(self._options.numMaxMessages).on('child_added', function (snapshot) {
            //        self._onNewMessage(roomId, snapshot);
            //    }, /* onCancel */ function () {
            //        // Turns out we don't have permission to access these messages.
            //        self.leaveRoom(roomId);
            //    }, /* context */ self);

            //    self._messageRef.child(roomId).limitToLast(self._options.numMaxMessages).on('child_removed', function (snapshot) {
            //        self._onRemoveMessage(roomId, snapshot);
            //    }, /* onCancel */ function () { }, /* context */ self);
            //}, /* onFailure */ function () { }, self);

            //room message listener - for expert
            self._messageRef.child(roomId).child("exp").on('child_added', function (snapshot) {
                self._onNewMessage(roomId, snapshot,false);
            }, /* onCancel */ function () {
                // Turns out we don't have permission to access these messages.
                self.leaveRoom(roomId);
            }, /* context */ self);

            ////room message listener - for customer
            //self._roomRef.child(roomId).child("cst").on('child_added', function (snapshot) {
            //    self._onNewMessage(roomId, snapshot);
            //}, /* onCancel */ function () {
            //    // Turns out we don't have permission to access these messages.
            //    self.leaveRoom(roomId);
            //}, /* context */ self);



            
            
        });
    };

    // Leave a chat room.
    Firechat.prototype.leaveRoom = function (roomId, endReason) {
        var _TimerToLeaveRoom = 0;
        var self = this,
            
            onLeaveRoom = function () {

            };
        //commented on 15 Feb - to ignore room users as told by prasoon sir
        /*var userRoomRef = self._firechatRef.child('room-users').child(roomId);*/

        firebase.database().ref("users/" + psychicId + "/invites").child(roomId).once("value", function (snapshot) {
            var invite = snapshot.val();
            if (invite !== null) {
                if (endReason == chatEndReason.customerHungUp && !invite.hasOwnProperty('status')) {

                    firebase.database().ref("users/" + psychicId + "/invites").child(roomId).update({
                        'isCancel': true
                    });
                    _TimerToLeaveRoom = 2 * 1000;
                }

            }
        });

        setTimeout(function () {
            // Remove listener for new messages to this room.
            self._messageRef.child(roomId).off();
            //case to clean or manage rooms etc
            try {

                //commented on: 6 Jan 2022 - to retain chat messages for api backup
                //self._messageRef.child(roomId).remove();

                //commented on 15 Feb - to ignore room users as told by prasoon sir
                //if (self._user) {
                //    var presenceRef = userRoomRef.child(self._userId).child(self._sessionId);

                //    // Remove presence bit for the room and cancel on-disconnect removal.
                //    self._removePresenceOperation(presenceRef, null);

                //    // Remove session bit for the room.
                //    self._userRef.child('rooms').child(roomId).remove();
                //}

                delete self._rooms[roomId];

                self._roomRef.child(roomId).update({ 'end-reason': endReason, 'status': 0 });

                // Invoke event callbacks for the room-exit event.
                self._onLeaveRoom(roomId, endReason);
            } catch (e) {
                console.log(e);
            }
            // Commented on 07 Dec 2022 Read/backup not required
            //self._messageRef.child(roomId).once('value', function (snapshot) {
            //    var roomMessages = snapshot.val();
            //    console.log("room-Messages", roomMessages);
            //    let data = roomMessages == null ? '' : Object.values(roomMessages);
            //    var key = roomId;
            //    var o = {};
            //    o[key] = data;
            //    var _BackupAllowed = false;
            //    if (roomMessages != null && _BackupAllowed) {
            //        var jsonContent = JSON.stringify(o)
            //        file = new Blob([jsonContent], { type: "octet/stream" });
            //        firebase.storage().ref().child('customers/' + self._user.id + '/' + psychicId + '/chats/' + roomId + ".json").put(file).then(function (snapshot) {
            //            //backup uploaded to server
            //            console.log("Chat (" + roomId + ") saved on storage.");
            //        });
            //    }

            //    //case to clean or manage rooms etc
            //    try {
                
            //        //commented on: 6 Jan 2022 - to retain chat messages for api backup
            //        //self._messageRef.child(roomId).remove();

            //        if (self._user) {
            //            var presenceRef = userRoomRef.child(self._userId).child(self._sessionId);

            //            // Remove presence bit for the room and cancel on-disconnect removal.
            //            self._removePresenceOperation(presenceRef, null);

            //            // Remove session bit for the room.
            //            self._userRef.child('rooms').child(roomId).remove();
            //        }

            //        delete self._rooms[roomId];

            //        self._roomRef.child(roomId).update({ 'end-reason': endReason, 'status': 0 });

            //        // Invoke event callbacks for the room-exit event.
            //        self._onLeaveRoom(roomId, endReason);
            //    } catch (e) {
            //        console.log(e);
            //    }
            //});
        }, _TimerToLeaveRoom);
    };

    Firechat.prototype.sendMessage = function (roomId, messageContent, messageOriginal, messageType, fileName, fileSize, fileUrl, cb) {
        var self = this;
        let sendername = self._userName;
        _gSendChatCounter++;
        sendername = (typeof customerprefname === 'string' && customerprefname.length > 0) ? customerprefname : self._userName;
        
        var newMessageRef;
        var shareableItem = null;

        var message = {
            m: messageContent,
            
        };
        let replyNodeId = $("#replyid").val();
        if (replyNodeId) {
            message.r = replyNodeId;
        }
        if (typeof fileName !== 'undefined') {
            if (fileName != null && fileName != undefined && fileName != '') {
                message.n = fileName;
                message.u = fileUrl;
                if (messageType.indexOf("image") >= 0 || messageType.indexOf("jpg") >= 0 || messageType.indexOf("jpeg") >= 0 || messageType.indexOf("png") >= 0) {
                    //for images
                    message.t = 4;
                }
                else if (messageType.indexOf("pdf") >= 0) {
                    //for pdf
                    message.t = 5;
                } else {
                    //for audio/video
                    message.t = 6;
                }

            }
        } else {
            if (typeof replyType ==="string" && replyType=="s" && message.hasOwnProperty('r') && typeof message.r === 'string') {
                message.t = 8;
            }
        }

        if (!self._user) {
            self._onAuthRequired();
            if (cb) {
                cb(new Error('Not authenticated or user not set!'));
            }
            return;
        } 
        

        //this timestamp is included in customerchat        
        lasCustomertMessageTimestamp = getUTCTicksForServerTimestamp();

        //added this timestamp in firebase
        message.ts = lasCustomertMessageTimestamp;

        var nodeid = "c" + _gSendChatCounter;
        newMessageRef = self._messageRef.child(roomId).child("cst").child(nodeid).set(message);

        message.isSelfMsgPosted = true;
        message.id = nodeid;

        
        LogChat(`firechat.js sendMessage() lasCustomertMessageTimestamp=${lasCustomertMessageTimestamp}`);

        this._invokeEventCallbacks('message-add', roomId, message);

        if (cb) {
            cb("message_sent_successfully");
        }
    };

    Firechat.prototype.deleteMessage = function (roomId, messageId, cb) {
        var self = this;

        self._messageRef.child(roomId).child(messageId).remove(cb);
    };

    // Mute or unmute a given user by id. This list will be stored internally and
    // all messages from the muted clients will be filtered client-side after
    // receipt of each new message.
    Firechat.prototype.toggleUserMute = function (userId, cb) {
        var self = this;

        if (!self._user) {
            self._onAuthRequired();
            if (cb) {
                cb(new Error('Not authenticated or user not set!'));
            }
            return;
        }

        self._userRef.child('muted').child(userId).transaction(function (isMuted) {
            return (isMuted) ? null : true;
        }, cb);
    };

    // Send a moderator notification to a specific user.
    Firechat.prototype.sendSuperuserNotification = function (userId, notificationType, data, cb) {
        var self = this,
            userNotificationsRef = self._firechatRef.child('users').child(userId).child('notifications');

        userNotificationsRef.push({
            fromUserId: self._userId,
            timestamp: firebase.database.ServerValue.TIMESTAMP,
            notificationType: notificationType,
            data: data || {}
        }, cb);
    };

    // Warn a user for violating the terms of service or being abusive.
    Firechat.prototype.warnUser = function (userId) {
        var self = this;
        self.sendSuperuserNotification(userId, 'warning');
    };

    // Suspend a user by putting the user into read-only mode for a period.
    Firechat.prototype.suspendUser = function (userId, timeLengthSeconds, cb) {
        var self = this,
            suspendedUntil = new Date().getTime() + 1000 * timeLengthSeconds;

        self._suspensionsRef.child(userId).set(suspendedUntil, function (error) {
            if (error && cb) {
                return cb(error);
            } else {
                self.sendSuperuserNotification(userId, 'suspension', {
                    suspendedUntil: suspendedUntil
                });
                return cb(null);
            }
        });
    };

    // Invite a user to a specific chat room.
    //Code to add Fields in Invites Node by ITL
    Firechat.prototype.inviteUser = function (userId, roomId, walletBalance, expertCharge, expertUSDCharge, overridePrice, targetele, prefId, totalSecondsForSession, callback) {
        var _UsdRate = 0;
        var _OverridePrice = false;
        var _TargSource = "";
        //debugger;

        try {

            console.log(`inviteUser called ${roomId} totalseconds: ${totalSecondsForSession}`);

            if (!isNaN(expertUSDCharge) && typeof overridePrice === 'boolean' && typeof targetele === 'string') {
          
                if (overridePrice == true && parseFloat(expertUSDCharge) > 0) {
                    _UsdRate = parseFloat(expertUSDCharge);
                    _OverridePrice = overridePrice;
                    _TargSource = targetele;
                }
            }
        } catch (err) {

        }
        
        var self = this;

        if (!self._user) {
            if (_FB_AUTH_USER_ADDED_ != null) {
                if (typeof chat != 'undefined' && _FB_AUTH_USER_ADDED_ != null) {
                    self._user = _FB_AUTH_USER_ADDED_;
                    self._userId = gloggedInUserid;
                    self._userName = CustomerIntakeFormName;
                    chat.setUser(gloggedInUserid, CustomerIntakeFormName);
                    //$('#user-name').text(username);
                    //$("#hdnUserId").val(user.uid)
                    //$('#user-info').show();
                    //$("#psychicid").val(psychicId);
                }
            }
            else {
                self._onAuthRequired();
                return;
            }
        }

        var sendInvite = function () {       
                try {

                
                    var userRef = self._firechatRef.child('users').child(userId);

                    let customerName = "";
                    if (typeof customerprefname === 'string' && customerprefname.length > 0) {
                        customerName = customerprefname;
                    }
                    else if (typeof username !== 'undefined' && username != "" && username.length > 0) {
                        customerName = username;
                    }

                    if (customerName != "" && typeof customerName !== 'undefined' && customerName.length > 0) {
                        if (self._userName.indexOf("XXXX") > 0) {
                            self._userName = customerName;
                        }
                    }

                    var inviteRef = userRef.child('invites').child(roomId).once('value', function (snapshot) {
                        var inviteNode = snapshot.val();
                        if (inviteNode == null || typeof (inviteNode) === 'undefined') {
                            //means invite node does not exist
                            //create invite node object for expert
                            let invitesnode = {};
                            invitesnode = {
                                id: roomId,
                                fromUserId: self._userId,
                                fromUserName: customerName,
                                roomId: roomId,
                                walletAmt: walletBalance,
                                expCharge: expertCharge,
                                expertUSDCharge: _UsdRate,
                                overridePrice: _OverridePrice,
                                TarSource: _TargSource,
                                prefId: prefId,
                                timeStamp: firebase.database.ServerValue.TIMESTAMP,
                                clientEndTime: 0,
                                ct: totalSecondsForSession,
                                cv:"1.0.2"
                            };

                            userRef.child("invites").child(roomId).set(invitesnode, function () {
                                //means invite node created
                                // Handle listen unauth / failure in case we're kicked.
                                //console.log(`invite created: expertid= ${userId}  room id=${roomId}`);
                                userRef.child("invites").child(roomId).on('value', self._onFirechatInviteResponse, function () { }, self);
                                callback(roomId);
                            });

                        }
                        else {
                            //console.log(`room_already_exists: expertid= ${userId}  room id=${roomId}`);
                            callback("room_already_exists");
                            //remove listener
                            inviteRef.off();
                        }
                    });

                    //// Handle listen unauth / failure in case we're kicked.
                    //inviteRef.on('value', self._onFirechatInviteResponse, function () { }, self);

                    //if (callback) {
                    //    // callback(inviteRef.key);


                    //    userRef.transaction(function (user) {
                    //        if (user && !user.invites) {
                    //            user.invites = {};
                    //            user.invites[roomId] = {
                    //                id: roomId,
                    //                fromUserId: self._userId,
                    //                fromUserName: customerName,
                    //                roomId: roomId,
                    //                walletAmt: walletBalance,
                    //                expCharge: expertCharge,
                    //                expertUSDCharge: _UsdRate,
                    //                overridePrice: _OverridePrice,
                    //                TarSource: _TargSource,
                    //                prefId: prefId,
                    //                timeStamp: firebase.database.ServerValue.TIMESTAMP,
                    //                clientEndTime:0
                    //            };

                    //            // Handle listen unauth / failure in case we're kicked.
                    //            inviteRef.on('value', self._onFirechatInviteResponse, function () { }, self);

                    //            callback(inviteRef.key);
                    //        }

                    //        return user;
                    //    });
                    //    //callback(inviteRef.key);
                    //}
                    //else {
                    //    // Handle listen unauth / failure in case we're kicked.
                    //    inviteRef.on('value', self._onFirechatInviteResponse, function () { }, self);
                    //}

                    //// Handle listen unauth / failure in case we're kicked.
                    //inviteRef.on('value', self._onFirechatInviteResponse, function () { }, self);
                } catch (e) {
                    console.log("Exception raised in invite: ", e);
                }
            };
            

        

        self.getRoom(roomId, function (room) {
            if (typeof (roomId) === 'string') {
                sendInvite();
            }
        });
    };

    Firechat.prototype.acceptInvite = function (inviteId, cb) {
        var self = this;

        self._userRef.child('invites').child(inviteId).once('value', function (snapshot) {
            var invite = snapshot.val();
            if (invite === null && cb) {
                return cb(new Error('acceptInvite(' + inviteId + '): invalid invite id'));
            } else {
                self.enterRoom(invite.roomId);
                self._userRef.child('invites').child(inviteId).update({
                    'status': 'accepted',
                    'toUserName': self._userName
                }, cb);
                self._roomRef.child(invite.roomId).update({ 'status': 1 }, cb);
                self._userRef.child('invites').child(inviteId).once('value', function (snapshot) {
                    self._onInternalInviteResponse(snapshot);
                });
            }
        }, self);
    };

    Firechat.prototype.declineInvite = function (inviteId, cb) {
        var self = this;
        self._userRef.child('invites').child(inviteId).once('value', function (response) {
            if (response.val() != null) {
                updates = {
                    'status': 'declined',
                    'toUserName': self._userName
                };
                self._userRef.child('invites').child(inviteId).update(updates, cb);
                self._userRef.child('invites').child(inviteId).once('value', function (snapshot) {
                    self._onInternalInviteResponse(snapshot);

                });
            }
        })
    };

    // Miscellaneous helper methods.
    Firechat.prototype.getRoom = function (roomId, callback) {
        this._roomRef.child(roomId).once('value', function (snapshot) {
            callback(snapshot.val());
        });
    };

    Firechat.prototype.userIsModerator = function () {
        return this._isModerator;
    };

    Firechat.prototype.warn = function (msg) {
        if (console) {
            msg = 'Firechat Warning: ' + msg;
            if (typeof console.warn === 'function') {
                console.warn(msg);
            } else if (typeof console.log === 'function') {
                console.log(msg);
            }
        }
    };
})();

(function ($) {


    if (!$ || (parseInt($().jquery.replace(/\./g, ""), 10) < 170)) {
        throw new Error("jQuery 1.7 or later required!");
    }

    var root = this,
        previousFirechatUI = root.FirechatUI;

    root.FirechatUI = FirechatUI;

    if (!self.FirechatDefaultTemplates) {
        throw new Error("Unable to find chat templates!");
    }

    function FirechatUI(firebaseRef, el, options) {
        var self = this;

        if (!firebaseRef) {
            throw new Error('FirechatUI: Missing required argument `firebaseRef`');
        }

        if (!el) {
            throw new Error('FirechatUI: Missing required argument `el`');
        }

        options = options || {};
        this._options = options;

        this._el = el;
        this._user = null;
        this._chat = new Firechat(firebaseRef, options);

        // A list of rooms to enter once we've made room for them (once we've hit the max room limit).
        this._roomQueue = [];

        // Define some constants regarding maximum lengths, client-enforced.
        this.maxLengthUsername = 15;
        this.maxLengthUsernameDisplay = 15;
        this.maxLengthRoomName = 24;
        this.maxLengthMessage = 5120;
        this.maxUserSearchResults = 100;

        // Define some useful regexes.
        this.urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;
        this.pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

        this._renderLayout();

        // Grab shortcuts to commonly used jQuery elements.
        this.$wrapper = $('#firechat');
        this.$tabList = $('#firechat-tab-list');
        this.$tabContent = $('#firechat-tab-content');
        this.$messages = {};

        // Rate limit messages from a given user with some defaults.
        this.$rateLimit = {
            limitCount: 10, // max number of events
            limitInterval: 10000, // max interval for above count in milliseconds
            limitWaitTime: 30000, // wait time if a user hits the wait limit
            history: {}
        };

        // Setup UI bindings for chat controls.
        this._bindUIEvents();

        // Setup bindings to internal methods
        this._bindDataEvents();
    }

    // Run FirechatUI in *noConflict* mode, returning the `FirechatUI` variable to
    // its previous owner, and returning a reference to the FirechatUI object.
    FirechatUI.noConflict = function noConflict() {
        root.FirechatUI = previousFirechatUI;
        return FirechatUI;
    };

    FirechatUI.prototype = {
        isremovetab:true,
        _bindUIEvents: function () {
            // Chat-specific custom interactions and functionality.
            this._bindForHeightChange();
            this._bindForUserMuting();
            this._bindForChatInvites();

            // Generic, non-chat-specific interactive elements.
            this._setupTabs();
            this._bindTextInputFieldLimits();
        },

        _bindDataEvents: function () {
            this._chat.on('user-update', this._onUpdateUser.bind(this));

            // Bind events for new messages, enter / leaving rooms, and user metadata.
            this._chat.on('room-enter', this._onEnterRoom.bind(this));
            this._chat.on('room-exit', this._onLeaveRoom.bind(this));
            this._chat.on('message-add', this._onNewMessage.bind(this));
            this._chat.on('message-remove', this._onRemoveMessage.bind(this));

            // Bind events related to chat invitations.
            this._chat.on('room-invite-response', this._onChatInviteResponse.bind(this));

            // Binds events related to admin or moderator notifications.
            this._chat.on('notification', this._onNotification.bind(this));
        },

        _renderLayout: function () {
            var template = FirechatDefaultTemplates["templates/layout-full.html"];
            $(this._el).html(template({
                maxLengthUsername: this.maxLengthUsername
            }));
        },

        _onUpdateUser: function (user) {
            // Update our current user state and render latest user name.
            this._user = user;

            // Update our interface to reflect which users are muted or not.
            var mutedUsers = this._user.muted || {};
            $('[data-event="firechat-user-mute-toggle"]').each(function (i, el) {
                var userId = $(this).closest('[data-user-id]').data('user-id');
                $(this).toggleClass('red', !!mutedUsers[userId]);
            });

            // Ensure that all messages from muted users are removed.
            for (var userId in mutedUsers) {
                $('.message[data-user-id="' + userId + '"]').fadeOut();
            }
        },

        _onEnterRoom: function (room) {
            this.attachTab(room.id, room.name);
        },

        _onLeaveRoom: function (roomId, endReason) {
            if (this.isremovetab==true) {
                this.removeTab(roomId);
            }

            // Auto-enter rooms in the queue
            if ((this._roomQueue.length > 0)) {
                this._chat.enterRoom(this._roomQueue.shift(roomId));
            }
        },


        _onNewMessage: function (roomId, message) {
            this.showMessage(roomId, message);
            GetmessagefromExpert(message, roomId);
        },

        _onRemoveMessage: function (roomId, messageId) {
            this.removeMessage(roomId, messageId);
        },

        _onChatInviteResponse: function (invitation) {
            
            if (!invitation.status) return;

            var self = this,
                template = FirechatDefaultTemplates["templates/prompt-invite-reply.html"],
                $prompt;

            if (invitation.status && invitation.status === 'accepted') {
                $prompt = this.prompt('Accepted', template(invitation));
                this._chat.getRoom(invitation.roomId, function (room) {
                    //self.attachTab(invitation.roomId, room.name);
                    self.attachTab(invitation.roomId, "");
                });
            } else {
                $prompt = this.prompt('Declined', template(invitation));
            }

            $prompt.find('a.close').click(function () {
                $prompt.remove();
                return false;
            });
            $prompt.find('button.ok').click(function () {
                $prompt.remove();
                return false;
            });
        },

        // Events related to admin or moderator notifications.
        _onNotification: function (notification) {
            if (notification.notificationType === 'warning') {
                this.renderAlertPrompt('Warning', 'You are being warned for inappropriate messaging. Further violation may result in temporary or permanent ban of service.');
            } else if (notification.notificationType === 'suspension') {
                var suspendedUntil = notification.data.suspendedUntil,
                    secondsLeft = Math.round((suspendedUntil - new Date().getTime()) / 1000),
                    timeLeft = '';

                if (secondsLeft > 0) {
                    if (secondsLeft > 2 * 3600) {
                        var hours = Math.floor(secondsLeft / 3600);
                        timeLeft = hours + ' hours, ';
                        secondsLeft -= 3600 * hours;
                    }
                    timeLeft += Math.floor(secondsLeft / 60) + ' minutes';
                    this.renderAlertPrompt('Suspended', 'A moderator has suspended you for violating site rules. You cannot send messages for another ' + timeLeft + '.');
                }
            }
        }
    };

    /**
     * Initialize an authenticated session with a user id and name.
     * This method assumes that the underlying Firebase reference has
     * already been authenticated.
     */
    FirechatUI.prototype.setUser = function (userId, userName) {
        var self = this;

        // Initialize data events
        self._chat.setUser(userId, userName, function (user) {
            self._user = user;

            if (self._chat.userIsModerator()) {
                self._bindSuperuserUIEvents();
            }

            self._chat.resumeSession();
        });
    };

    /**
     * Exposes internal chat bindings via this external interface.
     */
    FirechatUI.prototype.on = function (eventType, cb) {
        var self = this;

        this._chat.on(eventType, cb);
    };

    /**
     * Binds a custom context menu to messages for superusers to warn or ban
     * users for violating terms of service.
     */
    FirechatUI.prototype._bindSuperuserUIEvents = function () {
        var self = this,
            parseMessageVars = function (event) {
                var $this = $(this),
                    messageId = $this.closest('[data-message-id]').data('message-id'),
                    userId = $('[data-message-id="' + messageId + '"]').closest('[data-user-id]').data('user-id'),
                    roomId = $('[data-message-id="' + messageId + '"]').closest('[data-room-id]').data('room-id');

                return {
                    messageId: messageId,
                    userId: userId,
                    roomId: roomId
                };
            },
            clearMessageContextMenus = function () {
                // Remove any context menus currently showing.
                $('[data-toggle="firechat-contextmenu"]').each(function () {
                    $(this).remove();
                });

                // Remove any messages currently highlighted.
                $('#firechat .message.highlighted').each(function () {
                    $(this).removeClass('highlighted');
                });
            },
            showMessageContextMenu = function (event) {
                var $this = $(this),
                    $message = $this.closest('[data-message-id]'),
                    template = FirechatDefaultTemplates["templates/message-context-menu.html"],
                    messageVars = parseMessageVars.call(this, event),
                    $template;

                event.preventDefault();

                // Clear existing menus.
                clearMessageContextMenus();

                // Highlight the relevant message.
                $this.addClass('highlighted');

                self._chat.getRoom(messageVars.roomId, function (room) {
                    // Show the context menu.
                    $template = $(template({
                        id: $message.data('message-id')
                    }));
                    $template.css({
                        left: event.clientX,
                        top: event.clientY
                    }).appendTo(self.$wrapper);
                });
            };

        // Handle dismissal of message context menus (any non-right-click click event).
        $(document).bind('click', {
            self: this
        }, function (event) {
            if (!event.button || event.button != 2) {
                clearMessageContextMenus();
            }
        });
        // Handle display of message context menus (via right-click on a message).
        $(document).delegate('[data-class="firechat-message"]', 'contextmenu', showMessageContextMenu);

        // Handle click of the 'Warn User' contextmenu item.
        $(document).delegate('[data-event="firechat-user-warn"]', 'click', function (event) {
            var messageVars = parseMessageVars.call(this, event);
            self._chat.warnUser(messageVars.userId);
        });

        // Handle click of the 'Suspend User (1 Hour)' contextmenu item.
        $(document).delegate('[data-event="firechat-user-suspend-hour"]', 'click', function (event) {
            var messageVars = parseMessageVars.call(this, event);
            self._chat.suspendUser(messageVars.userId, /* 1 Hour = 3600s */ 60 * 60);
        });

        // Handle click of the 'Suspend User (1 Day)' contextmenu item.
        $(document).delegate('[data-event="firechat-user-suspend-day"]', 'click', function (event) {
            var messageVars = parseMessageVars.call(this, event);
            self._chat.suspendUser(messageVars.userId, /* 1 Day = 86400s */ 24 * 60 * 60);
        });

        // Handle click of the 'Delete Message' contextmenu item.
        $(document).delegate('[data-event="firechat-message-delete"]', 'click', function (event) {
            var messageVars = parseMessageVars.call(this, event);
            self._chat.deleteMessage(messageVars.roomId, messageVars.messageId);
        });
    };

    /**
     * Binds to height changes in the surrounding div.
     */
    FirechatUI.prototype._bindForHeightChange = function () {
        var self = this,
            $el = $(this._el),
            lastHeight = null;

        setInterval(function () {
            var height = $el.height();
            if (height != lastHeight) {
                lastHeight = height;
                $('.chat').each(function (i, el) {

                });
            }
        }, 500);
    };

    /**
     * Binds user mute toggles and removes all messages for a given user upon mute.
     */
    FirechatUI.prototype._bindForUserMuting = function () {
        var self = this;
        $(document).delegate('[data-event="firechat-user-mute-toggle"]', 'click', function (event) {
            var $this = $(this),
                userId = $this.closest('[data-user-id]').data('user-id'),
                userName = $this.closest('[data-user-name]').data('user-name'),
                isMuted = $this.hasClass('red'),
                template = FirechatDefaultTemplates["templates/prompt-user-mute.html"];

            event.preventDefault();

            // Require user confirmation for muting.
            if (!isMuted) {
                var $prompt = self.prompt('Mute User?', template({
                    userName: userName
                }));

                $prompt.find('a.close').first().click(function () {
                    $prompt.remove();
                    return false;
                });

                $prompt.find('[data-toggle=decline]').first().click(function () {
                    $prompt.remove();
                    return false;
                });

                $prompt.find('[data-toggle=accept]').first().click(function () {
                    self._chat.toggleUserMute(userId);
                    $prompt.remove();
                    return false;
                });
            } else {
                self._chat.toggleUserMute(userId);
            }
        });
    };

    /**
     * Binds to elements with the data-event='firechat-user-(private)-invite' and
     * handles invitations as well as room creation and entering.
     */
    FirechatUI.prototype._bindForChatInvites = function () {
        var self = this,
            renderInvitePrompt = function (event) {
                var $this = $(this),
                    userId = $this.closest('[data-user-id]').data('user-id'),
                    roomId = $this.closest('[data-room-id]').data('room-id'),
                    userName = $this.closest('[data-user-name]').data('user-name'),
                    template = FirechatDefaultTemplates["templates/prompt-invite-private.html"],
                    $prompt;

                self._chat.getRoom(roomId, function (room) {
                    $prompt = self.prompt('Invite', template({
                        userName: userName,
                        roomName: ""/*room.name*/
                    }));

                    $prompt.find('a.close').click(function () {
                        $prompt.remove();
                        return false;
                    });

                    $prompt.find('[data-toggle=decline]').click(function () {
                        $prompt.remove();
                        return false;
                    });

                    $prompt.find('[data-toggle=accept]').first().click(function () {
                        $prompt.remove();
                        self._chat.inviteUser(userId, roomId, ""/*room.name*/);
                        return false;
                    });
                    return false;
                });
                return false;
            },
            renderPrivateInvitePrompt = function (event) {
                var $this = $(this),
                    userId = $this.closest('[data-user-id]').data('user-id'),
                    userName = $this.closest('[data-user-name]').data('user-name'),
                    template = FirechatDefaultTemplates["templates/prompt-invite-private.html"],
                    $prompt;

                if (userId && userName) {
                    $prompt = self.prompt('Private Invite', template({
                        userName: userName,
                        roomName: 'Private Chat'
                    }));

                    $prompt.find('a.close').click(function () {
                        $prompt.remove();
                        return false;
                    });

                    $prompt.find('[data-toggle=decline]').click(function () {
                        $prompt.remove();
                        return false;
                    });

                    $prompt.find('[data-toggle=accept]').first().click(function () {
                        $prompt.remove();
                        var roomName = 'Private Chat';
                        self._chat.createRoom(roomName, 'private', function (roomId) {
                            if (roomId == null) {
                                return false;
                            }
                            else {
                                self._chat.inviteUser(userId, roomId, roomName);
                            }
                        });
                        return false;
                    });
                }
                return false;
            };

        $(document).delegate('[data-event="firechat-user-chat"]', 'click', renderPrivateInvitePrompt);
        $(document).delegate('[data-event="firechat-user-invite"]', 'click', renderInvitePrompt);
    };

    /**
     * A stripped-down version of bootstrap-tab.js.
     *
     * Original bootstrap-tab.js Copyright 2012 Twitter, Inc.,licensed under the Apache v2.0
     */
    FirechatUI.prototype._setupTabs = function () {
        var self = this,
            show = function ($el) {
                var $this = $el,
                    $ul = $this.closest('ul:not(.firechat-dropdown-menu)'),
                    selector = $this.attr('data-target'),
                    previous = $ul.find('.active:last a')[0],
                    $target,
                    e;

                if (!selector) {
                    selector = $this.attr('href');
                    selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '');
                }

                if ($this.parent('li').hasClass('active')) return;

                e = $.Event('show', {
                    relatedTarget: previous
                });

                $this.trigger(e);

                if (e.isDefaultPrevented()) return;

                $target = $(selector);

                activate($this.parent('li'), $ul);
                activate($target, $target.parent(), function () {
                    $this.trigger({
                        type: 'shown',
                        relatedTarget: previous
                    });
                });
            },
            activate = function (element, container, callback) {
                var $active = container.find('> .active'),
                    transition = callback && $.support.transition && $active.hasClass('fade');

                function next() {
                    $active
                        .removeClass('active')
                        .find('> .firechat-dropdown-menu > .active')
                        .removeClass('active');

                    element.addClass('active');

                    if (transition) {
                        element.addClass('in');
                    } else {
                        element.removeClass('fade');
                    }

                    if (element.parent('.firechat-dropdown-menu')) {
                        element.closest('li.firechat-dropdown').addClass('active');
                    }

                    if (callback) {
                        callback();
                    }
                }

                if (transition) {
                    $active.one($.support.transition.end, next);
                } else {
                    next();
                }

                $active.removeClass('in');
            };

        $(document).delegate('[data-toggle="firechat-tab"]', 'click', function (event) {
            event.preventDefault();
            show($(this));
        });
    };

    /**
     * A stripped-down version of bootstrap-dropdown.js.
     *
     * Original bootstrap-dropdown.js Copyright 2012 Twitter, Inc., licensed under the Apache v2.0
     */
    FirechatUI.prototype._setupDropdowns = function () {
        var self = this,
            toggle = '[data-toggle=firechat-dropdown]',
            toggleDropdown = function (event) {
                var $this = $(this),
                    $parent = getParent($this),
                    isActive = $parent.hasClass('open');

                if ($this.is('.disabled, :disabled')) return;

                clearMenus();

                if (!isActive) {
                    $parent.toggleClass('open');
                }

                $this.focus();

                return false;
            },
            clearMenus = function () {
                $('[data-toggle=firechat-dropdown]').each(function () {
                    getParent($(this)).removeClass('open');
                });
            },
            getParent = function ($this) {
                var selector = $this.attr('data-target'),
                    $parent;

                if (!selector) {
                    selector = $this.attr('href');
                    selector = selector && /#/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '');
                }

                $parent = selector && (selector !== '#') && $(selector);

                if (!$parent || !$parent.length) $parent = $this.parent();

                return $parent;
            };

        $(document)
            .bind('click', clearMenus)
            .delegate('.firechat-dropdown-menu', 'click', function (event) {
                event.stopPropagation();
            })
            .delegate('[data-toggle=firechat-dropdown]', 'click', toggleDropdown);
    };

    /**
     * Binds to any text input fields with data-provide='limit' and
     * data-counter='<selector>', and upon value change updates the selector
     * content to reflect the number of characters remaining, as the 'maxlength'
     * attribute less the current value length.
     */
    FirechatUI.prototype._bindTextInputFieldLimits = function () {
        $('body').delegate('input[data-provide="limit"], textarea[data-provide="limit"]', 'keyup', function (event) {
            var $this = $(this),
                $target = $($this.data('counter')),
                limit = $this.attr('maxlength'),
                count = $this.val().length;

            $target.html(Math.max(0, limit - count));
        });
    };

    /**
     * Given a title and message content, show an alert prompt to the user.
     *
     * @param    {string}    title
     * @param    {string}    message
     */
    FirechatUI.prototype.renderAlertPrompt = function (title, message) {
        var template = FirechatDefaultTemplates["templates/prompt-alert.html"],
            $prompt = this.prompt(title, template({
                message: message
            }));

        $prompt.find('.close').click(function () {
            $prompt.remove();
            return false;
        });
        return;
    };

    /**
     * Toggle input field s if we want limit / unlimit input fields.
     */
    FirechatUI.prototype.toggleInputs = function (isEnabled) {
        $('#firechat-tab-content textarea').each(function () {
            var $this = $(this);
            if (isEnabled) {
                $(this).val('');
            } else {
                $(this).val('You have exceeded the message limit, please wait before sending.');
            }
            $this.prop('disabled', !isEnabled);
        });
        $('#firechat-input-name').prop('disabled', !isEnabled);
    };

    /**
     * Given a room id and name, attach the tab to the interface and setup events.
     *
     * @param    {string}    roomId
     * @param    {string}    roomName
     */
    FirechatUI.prototype.attachTab = function (roomId, roomName) {
        var self = this;

        // If this tab already exists, give it focus.
        if (this.$messages[roomId]) {
            this.focusTab(roomId);
            return;
        }

        //,
        //name: roomName
        var room = {
            id: roomId
        },

            cparseMessageVars = function (event) {
                var $this = $(this),
                    messageId = $this.closest('[data-message-id]').data('message-id'),
                    userId = $('[data-message-id="' + messageId + '"]').closest('[data-user-id]').data('user-id'),
                    roomId = $('[data-message-id="' + messageId + '"]').closest('[data-room-id]').data('room-id');

                return {
                    messageId: messageId,
                    userId: userId,
                    roomId: roomId
                };
            };


        // Populate and render the tab content template.
        var tabTemplate = FirechatDefaultTemplates["templates/tab-content.html"];
        var $tabContent = $(tabTemplate(room));
        this.$tabContent.prepend($tabContent);
        var $messages = $('#firechat-messages' + roomId);

        // Keep a reference to the message listing for later use.
        this.$messages[roomId] = $messages;

        // Attach on-enter event to textarea.
        //Code to validate Message send by Client by ITL
        var $textarea = $tabContent.find('textarea').first();
        
        $textarea.bind('keydown', function (e) {
            var message = self.trimWithEllipsis($textarea.val(), self.maxLengthMessage);
            var messageOriginal = "";// message;
            if ((e.which === 13) && (message !== '')) {
                $textarea.val('');
                //document.getElementById('sendMsg').disabled = true;

                ValidateChatMessage(message, function (res) {
                    if (res == "__CHARACTERS_LIMIT_EXCEEDED__") {
                        // alert('Sorry, You have exceeded the maximum character limit!! Only 1000 Characters allowed');
                        alertify.set('notifier', 'position', 'bottom-right');
                        alertify.notify('<div><p>Important!</p><span> Sorry, You have exceeded the maximum character limit!! Only 1000 Characters allowed.</span></div>', 'error', function () { });
                    }
                    //else if (res == "EMAIL_MOBILE_URL_NOT_ALLOWED") {
                    //    //alert("Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers!!");
                    //    alertify.set('notifier', 'position', 'bottom-right');
                    //    alertify.notify('<div><p>Important!</p><span> Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers.</span></div>', 'error', function () { });
                    //}
                    else if (res == "__REQUIRED__") {
                        //alert("Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers!!");
                        alertify.set('notifier', 'position', 'bottom-right');
                        alertify.notify('<div><p>Important!</p><span> Please type a message.</span></div>', 'error', function () { });
                    }
                    else {
                        //ALLOWED
                        if (res.indexOf("__") < 0) {
                            self._chat.sendMessage(roomId, res, messageOriginal );
                            updateTypingStatusOnFirebase(0);
                     

                            //(CB)
                            try {
                                e.preventDefault();
                                $textarea[0].val('');
                            } catch (e) {

                            }
                        }
                        //if (res.indexOf("__") <0) {
                        //    self._chat.sendMessage(roomId, res);
                        //}
                    }
                });
                
            }
        });

        $('#sendMsg').click(function () {
       
            var message = self.trimWithEllipsis($textarea.val(), self.maxLengthMessage);
            var messageOriginal = "";// message;
            $textarea.val('');
            var bt = document.getElementById('sendMsg');
            bt.disabled = true;
            _gChatStarted = true;
            //document.getElementById('sendMsg').disabled = true;
            ValidateChatMessage(message, function (res) {
                if (res == "__CHARACTERS_LIMIT_EXCEEDED__") {
                   // alert('Sorry, You have exceeded the maximum character limit!! Only 1000 Characters allowed');
                    alertify.set('notifier', 'position', 'bottom-right');
                    alertify.notify('<div><p>Important!</p><span> Sorry, You have exceeded the maximum character limit!! Only 1000 Characters allowed.</span></div>', 'error', function () { });
                }
                else if (res == "__REQUIRED__") {
                    //alert("Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers!!");
                    alertify.set('notifier', 'position', 'bottom-right');
                    alertify.notify('<div><p>Important!</p><span> Please type a message.</span></div>', 'error', function () { });
                }
                //else if (res == "EMAIL_MOBILE_URL_NOT_ALLOWED") {
                //    //alert("Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers!!");
                //    alertify.set('notifier', 'position', 'bottom-right');
                //    alertify.notify('<div><p>Important!</p><span> Sorry, You are not allowed to share any URLs, Email Ids or Contact Numbers.</span></div>', 'error', function () { });
                //}
                else {
                    //ALLOWED
                    if (res.indexOf("__") < 0) {
                                              
                        self._chat.sendMessage(roomId, res, messageOriginal);
                        updateTypingStatusOnFirebase(0);
                      
                    }
                    /*self._chat.sendMessage(roomId, message);*/
                }
            });
            
        })
        //custom event handler
        $(document.body).on('click', ".user-delete-msg", function () {
            var messageVars = cparseMessageVars.call(this, event);
            self._chat.deleteMessage(messageVars.roomId, messageVars.messageId);
            self._chat.sendMessage(messageVars.roomId, "message deleted");
        });
        //Code to Check File Type and Size by ITL
        $("input[type=file]").change(function () {
            var fileInput = $(this)[0];
            var file = fileInput.files[0];
            $(fileInput).val("");
            if (typeof file === 'undefined') {
                return;
            }
            _gChatStarted = true;
            var isFileValid = function (file) {
                if (typeof file !== 'undefined') {
                    var supportedFileTypes = ["image/jpeg", "image/jpg", "image/png", "application/pdf", "audio/mp3", "audio/mp4", "audio/mpeg"];
                    if (!supportedFileTypes.includes(file.type)) {
                        alert("You can only upload file with jpeg, jpg, png, pdf, mp3, mp4 or mpeg extension.");
                        return false;
                    }

                    const maxFileSizeInMb = 5;
                    const maxFileSize = 1024 * 1024 * maxFileSizeInMb;
                    if (file.size >= maxFileSize) {
                        alert("File is too big. Please select a file less than " + maxFileSizeInMb + "mb.");
                        return false;
                    }

                    return true;
                }
                else {
                    alert("Invalid File or File not available to upload.");
                    return false;
                }
            };

            var createGuid = function () {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            };

            var createKey = function () {
                return "-" + btoa(createGuid()).substr(0, 18);
            }
            //Code to upload Attachment and Chat Messages in Firebase Storage by ITL
            if (isFileValid(file)) {
                
                var fileurlname = file.name.replace(/ /g, "_");
                fileurlname = fileurlname.replace("(", "_");
                fileurlname = fileurlname.replace(")", "_");
				//console.log("Attachment to upload - " + fileurlname);
                let sendFlag = true;
                var uploadTask = firebase.storage().ref().child('customers/' + self._user.id + '/' + psychicId + '/chat-attachments/' + createKey() + '/' + fileurlname).put(file);
                uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, function (snapshot) {
                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    $('#ChatAttachmentProgressModal').modal('show');
                    $('#chatDocProgress').attr('aria-valuenow', progress).css('width', progress + '%');
                    switch (snapshot.state) {
                        case firebase.storage.TaskState.RUNNING:
                            break;
                    }
                }, function (error) {
                    alert(error);
                }, function () {
                    uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                        //console.log("Attachment (" + fileurlname + ") uploaded - " + downloadURL.toString());
                        $('#ChatAttachmentProgressModal').modal('hide');
                        $('#chatDocProgress').attr('aria-valuenow', 0).css('width', 0 + '%');

                        if (sendFlag == true) {
                            self._chat.sendMessage(Object.keys(self._user.rooms)[0], null,null, file.type, fileurlname, file.size, downloadURL.toString(), function () {
                                sendFlag = false;
                                
                            });
                        }
                    });
                });
            }
        });

        // Populate and render the tab menu template.
        var tabListTemplate = FirechatDefaultTemplates["templates/tab-menu-item.html"];
        var $tab = $(tabListTemplate(room));
        this.$tabList.prepend($tab);

        // Attach on-shown event to move tab to front and scroll to bottom.
        $tab.bind('shown', function (event) {
            $messages.scrollTop($messages[0].scrollHeight);
        });

        // Dynamically update the width of each tab based upon the number open.
        var tabs = this.$tabList.children('li');
        var tabWidth = Math.floor($('#firechat-tab-list').width() / tabs.length);
        this.$tabList.children('li').css('width', tabWidth);

        // Sort each item in the user list alphabetically on click of the dropdown.
        $('#firechat-btn-room-user-list-' + roomId).bind('click', function () {
            self.sortListLexicographically('#firechat-room-user-list-' + roomId);
            return false;
        });

        // Automatically select the new tab.
        this.focusTab(roomId);
    };

    /**
     * Given a room id, focus the given tab.
     *
     * @param    {string}    roomId
     */
    FirechatUI.prototype.focusTab = function (roomId) {
        if (this.$messages[roomId]) {
            var $tabLink = this.$tabList.find('[data-room-id=' + roomId + ']').find('a');
            if ($tabLink.length) {
                $tabLink.first().trigger('click');
            }
        }
    };

    /**
     * Given a room id, remove the tab and all child elements from the interface.
     *
     * @param    {string}    roomId
     */
    FirechatUI.prototype.removeTab = function (roomId) {
        delete this.$messages[roomId];

        // Remove the inner tab content.
        this.$tabContent.find('[data-room-id=' + roomId + ']').remove();

        // Remove the tab from the navigation menu.
        this.$tabList.find('[data-room-id=' + roomId + ']').remove();

        // Dynamically update the width of each tab based upon the number open.
        var tabs = this.$tabList.children('li');
        var tabWidth = Math.floor($('#firechat-tab-list').width() / tabs.length);
        this.$tabList.children('li').css('width', tabWidth);

        // Automatically select the next tab if there is one.
        this.$tabList.find('[data-toggle="firechat-tab"]').first().trigger('click');
    };

    /**
     * Render a new message in the specified chat room.
     *
     * @param    {string}    roomId
     * @param    {string}    message
     */
    FirechatUI.prototype.showMessage = function (roomId, rawMessage) {
        var self = this;
        _gChatStarted = true;
        _gChatMsgCount++;
        let _hasFileObject = false;
        // Setup defaults
        let expertname = ExpertDisplayNameForSession;// rawMessage.name;
     
        //13 Feb 2023
        //expected to receive shorten keys for firebase messages

        //console.log(`showMessage Message: for Room ID=== ${roomId}`, rawMessage);

        //construct new message format for firebase exchange
        let fileName = "";
        let fileUrl = "";
        let fileType = 0;
        let fileTypeName = "";
        let postedMessage = "";
        let postedMessageId = "";
        let postedByUserId = 0;
        let shareableItem = null;
        let rtid = "";

        if (typeof (rawMessage) === 'object') {
            if (rawMessage.hasOwnProperty('id') && typeof rawMessage.id === 'string') {
                postedMessageId = rawMessage.id;
            }

            if (rawMessage.hasOwnProperty('m') && typeof rawMessage.m === 'string') {
                postedMessage = rawMessage.m;
            }

            if (rawMessage.hasOwnProperty('isSelfMsgPosted') && typeof rawMessage.isSelfMsgPosted === 'boolean') {
                let customerId = 0;
                if (typeof gloggedInUserid === 'number' && !isNaN(gloggedInUserid) && parseInt(gloggedInUserid) > 0) {
                    customerId = parseInt(gloggedInUserid);
                }
                else {
                    customerId = self._user.id;
                }
                postedByUserId = (rawMessage.isSelfMsgPosted) ? customerId : psychicId;
            }


            if (rawMessage.hasOwnProperty('s') && typeof rawMessage.s === 'object') {
                shareableItem = rawMessage.s;
            }
            if (rawMessage.hasOwnProperty('r') && typeof rawMessage.r === 'string') {
                rtid = rawMessage.r;
            }

            if (rawMessage.hasOwnProperty('n') && typeof rawMessage.n === 'string') {
                if (rawMessage.n != null && rawMessage.n != undefined && rawMessage.n != '') {
                    fileName = rawMessage.n;
                    fileUrl = rawMessage.u;
                    if (rawMessage.hasOwnProperty('t') && typeof (rawMessage.t) === 'number') {
                        fileType = parseInt(rawMessage.t);
                        if (fileType == 2 || fileType == 3 || fileType == 4) {
                            //for images
                            fileTypeName = "image/jpg";
                        }
                        else if (fileType == 5) {
                            //for pdf
                            fileTypeName = "application/pdf";
                        }
                        else if (fileType == 6) {
                            //for audio/video
                            fileTypeName = "audio/mpeg";
                        }
                        else if (fileType == 8) {
                            //for audio/video
                            fileTypeName = "offer/puja";
                            if (rtid != "") {
                                fileTypeName = "default";
                            }
                            
                        }
                        else {
                            //for audio/video
                            fileTypeName = "default";
                        }
                    }


                }
            }
            else {
                if (rawMessage.hasOwnProperty('t') && typeof (rawMessage.t) === 'number') {
                    fileType = parseInt(rawMessage.t);
                    if (fileType == 8) {
                        //for audio/video
                        fileTypeName = "offer/puja";
                        if (rtid != "") {
                            fileTypeName = "default";
                        }
                    }
                    else {
                        //for audio/video
                        fileTypeName = "default";
                    }
                }
            }



            _gLocalChatWithId.push(rawMessage);
           // GetmessagefromExpert(rawMessage, postedMessageId);
        }
        
        //this timestamp is included in customerchat
        let msgTimeStamp = getServerUTCTimestamp();
        lastMessageTimestamp = msgTimeStamp;
        LogChat(`firechat.js showMessage() msgTimeStamp=${msgTimeStamp}`);
        var message = {
            id: postedMessageId,
            localtime: moment(msgTimeStamp).format("YYYY-MM-DD HH:mm:ss"),
            timestamp: msgTimeStamp,
            message: postedMessage || '',
            userId: postedByUserId,
            name: ExpertDisplayNameForSession,
            type: fileTypeName || 'default',
            isSelfMessage: (self._user && postedByUserId == self._user.id),
            disableActions: (!self._user || postedByUserId == self._user.id)
        };

        if (!(self._user && postedByUserId == self._user.id)) {
            //set expert last message time
            lasExpertMessageTimestamp = getUTCTicksForServerTimestamp();
        }
        if (fileName != "" && fileUrl != "") {
            if (fileName != null && fileName != undefined && fileName != '' && typeof (fileUrl) === 'string') {
                message.fileName = fileName;
                //message.fileSize = rawMessage.fileSize;
                message.fileUrl = fileUrl;
                _hasFileObject = true;
            }
        }

        if (shareableItem != null && typeof shareableItem === 'object') {
            message.s = shareableItem;
        }

        if (typeof rtid === 'string' && rtid!="") {
            message.rtid= rtid;
        }

        // While other data is escaped in the Underscore.js templates, escape and
        // process the message content here to add additional functionality (add links).
        // Also trim the message length to some client-defined maximum.
        var messageConstructed = '';
        message.message = _.map(message.message.split(' '), function (token) {
            if (self.urlPattern.test(token) || self.pseudoUrlPattern.test(token)) {
                return self.linkify(encodeURI(token));
            } else {
                return _.escape(token);
            }
        }).join(' ');

        if (_hasFileObject) {
            if (message.fileUrl != null && message.fileUrl != undefined && message.fileUrl != '') {
                message.message = self.linkify(message.fileUrl, message.fileName);
            }
        }

        //var str = message.fileName;
        //message.message = str.link(rawMessage);

        //newly added to replace new line characters to br tags
        var isNewLine = /(\r\n|\n|\r)/.exec(message.message);
        message.message = (isNewLine) ? nl2br(self.trimWithEllipsis(message.message, self.maxLengthMessage)) : self.trimWithEllipsis(message.message, self.maxLengthMessage);

        // Populate and render the message template.
        var template = FirechatDefaultTemplates["templates/message.html"];

        //console.log("indexdb message",message);
        SetChatMessageList(message, message.timestamp);
        var $message = $(template(message));
        var $messages = self.$messages[roomId];
        if ($messages) {

            var scrollToBottom = false;
            if ($messages.scrollTop() / ($messages[0].scrollHeight - $messages[0].offsetHeight) >= 0.95) {
                // Pinned to bottom
                scrollToBottom = true;
            } else if ($messages[0].scrollHeight <= $messages.height()) {
                // Haven't added the scrollbar yet
                scrollToBottom = true;
            }
            
            $messages.append($message);

            if (scrollToBottom) {
                $messages.scrollTop($messages[0].scrollHeight);
            }
        }
    };

    function SetChatMessageList(message, timestamp) { 
        _gchatRecordCounter++;
        if (typeof message === 'object') {
            let msg = {
                userId: message.userId.toString(),
                message: message.message,
                type: message.type,
                name: message.name,
                timestamp: timestamp
            };

            if (message.hasOwnProperty('fileName') && message.hasOwnProperty('fileUrl')) {
               // msg.fileSize = message.fileSize;
                msg.fileName = message.fileName;
                msg.fileUrl = message.fileUrl;
            }

            if (message.hasOwnProperty('s') && typeof message.s==='object') {
                // msg.fileSize = message.fileSize;
                msg.s = message.s;
            }

            if (message.hasOwnProperty('rtid') && typeof message.rtid === 'string') {
                // msg.fileSize = message.fileSize;
                msg.rtid = message.rtid;
            }

            if (message.hasOwnProperty('id') && typeof message.id === 'string') {
                // msg.fileSize = message.fileSize;
                msg.messageID = message.id;
            }
            
            // messageOriginal: message.message,
            if (msg.message.indexOf('<br>') > 0) {
                msg.message = msg.message.replaceAll('<br>', '\n');
                //msg.messageOriginal = msg.message;
            }
            _gLocalChat.push(msg);

            LogChat(`SetChatMessageList() Msg Counter=${_gchatRecordCounter}`, msg);

            //add id for indexed db
            let clonedMsg = JSON.parse(JSON.stringify(msg));
            clonedMsg["id"] = _gchatRecordCounter;
            INDXDBJS.InsertData(clonedMsg);
        }
    }
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');  
    }
    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    /**
     * Remove a message by id.
     *
     * @param    {string}    roomId
     * @param    {string}    messageId
     */
    FirechatUI.prototype.removeMessage = function (roomId, messageId) {
        $('.message[data-message-id="' + messageId + '"]').remove();
    };

    /**
     * Given a selector for a list element, sort the items alphabetically.
     *
     * @param    {string}    selector
     */
    FirechatUI.prototype.sortListLexicographically = function (selector) {
        $(selector).children("li").sort(function (a, b) {
            var upA = $(a).text().toUpperCase();
            var upB = $(b).text().toUpperCase();
            return (upA < upB) ? -1 : (upA > upB) ? 1 : 0;
        }).appendTo(selector);
    };

    /**
     * Remove leading and trailing whitespace from a string and shrink it, with
     * added ellipsis, if it exceeds a specified length.
     *
     * @param    {string}    str
     * @param    {number}    length
     * @return   {string}
     */
    FirechatUI.prototype.trimWithEllipsis = function (str, length) {
        str = str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        return (length && str.length <= length) ? str : str.substring(0, length) + '...';
    };

    /**
     * Given a timestamp, format it in the form hh:mm am/pm. Defaults to now
     * if the timestamp is undefined.
     *
     * @param    {Number}    timestamp
     * @param    {string}    date
     */
    FirechatUI.prototype.formatTime = function (timestamp) {
        var date = (timestamp) ? new Date(timestamp) : new Date(),
            hours = date.getHours() || 12,
            minutes = '' + date.getMinutes(),
            seconds = '' + date.getSeconds(),
            ampm = (date.getHours() >= 12) ? 'PM' : 'AM';

        hours = (hours > 12) ? hours - 12 : hours;
        minutes = (minutes.length < 2) ? '0' + minutes : minutes;
        seconds = (seconds.length < 2) ? '0' + seconds : seconds;
        return '' + hours + ':' + minutes + ':' + seconds +' '+ ampm;
    };

    /**
     * Inner method to launch a prompt given a specific title and HTML content.
     * @param    {string}    title
     * @param    {string}    content
     */
    FirechatUI.prototype.prompt = function (title, content) {
        var template = FirechatDefaultTemplates["templates/prompt.html"],
            $prompt;

        //Modify for Poup Show on 10-02-2020
        $prompt = $(template({
            title: title,
            content: content
        })).css({

            //top: this.$wrapper.position().top + ((0.333 * this.$wrapper.height() - 270)),
            //left: this.$wrapper.position().left + (0.125 * this.$wrapper.width() * 2),
            //width: 0.75 * 100 * 8 - 133
            top: this.$wrapper.position().top + ((0.333 * this.$wrapper.height() - 270)),
            left: this.$wrapper.position().left + (0.125 * this.$wrapper.width() * 2),
            width: 0.75 * 100 * 8 - 133

        });

        this.$wrapper.append($prompt.removeClass('hidden'));
        return $prompt;
    };

    // see http://stackoverflow.com/questions/37684/how-to-replace-plain-urls-with-links
    FirechatUI.prototype.linkify = function (str, FileName) {
        var self = this;
        return str
            .replace(self.urlPattern, '<a target="_blank" href="$&" title=' + FileName + ' class="icon-attachment"><span>' + FileName + '</span></a>')
            .replace(self.pseudoUrlPattern, '$1<a target="_blank" href="http://$2">click here to</a>');
    };
})(jQuery);