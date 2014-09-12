(function () {
    var traceFn = function() {console.log.apply(console, ["f5less -"].concat(Array.prototype.slice.call(arguments, 0)))},
        dummyFn = function() {},
        messageParser = /^(\S+)\s?([\s\S]*)/; // [\s\S] is an hack to compensate for dotall absence;

    var log = dummyFn,
        ws, reconnectEnabled, cfg;

    var defaultCfg = {
        host: "localhost",
        port: 9999,
        thebuilder: "/f5less",
        reconnectDelay: 1000,

        reloadDelay: 0,

        triggersCSSReload: function(filename) {return endsWith(filename, ".css")},
        triggersPageReload: function(filename) {
            return endsWith(filename, ".js", ".html", ".htm")
        },

        getWsPath: function() {return "ws://" + cfg.host + ":" + cfg.port + cfg.thebuilder}
    };

    var handlers = {
        reload: function(filename) {
            setTimeout(function() {
                if (cfg.triggersPageReload(filename))
                    window.location.reload();
                else if (cfg.triggersCSSReload(filename))
                    f5less.reloadCSS();
            }, cfg.reloadDelay);
        }
    };


    function run() {
        if (wsIsActive()) return;

        log("Connecting to", cfg.getWsPath());
        ws = new WebSocket(cfg.getWsPath());
        ws.onopen = wsOpened;
        ws.onclose = wsClosed;
        ws.onmessage = dispatch;
    }

    function dispatch(e) {
        var match = messageParser.exec(e.data),
            message = match[1],
            data = null;

        log("Received message '"+message+"' with payload '"+match[2]+"'");

        try {
            data = match[2] === "" ? null : JSON.parse('{"payload":'+match[2]+"}");
        } catch (e) {
            log("Invalid data: " + e);
            throw e;
        }

        handlers[message].apply(this, data.payload);
    }

    function wsOpened() {
        log("Connection opened");
    }

    function wsClosed() {
        log("Connection closed");

        if (reconnectEnabled) {
            log("Trying to reconnect in", Math.round(cfg.reconnectDelay/1000), "seconds");
            setTimeout(run, cfg.reconnectDelay);
        }
    }

    function wsIsActive() {
        return ws && ws.readyState !== WebSocket.CLOSED && ws.readyState !== WebSocket.CLOSING;
    }

    function extend(obj, ext) {
        for(var k in ext) {
            if (obj[k] === undefined)
                obj[k] = ext[k];
        }
        return obj;
    }

    function endsWith(str, end) {
        if (arguments.length === 2)
            return end && str.indexOf(end, str.length - end.length) !== -1;
        else
            return endsWith(str, end) ||
                endsWith.apply(this, [str].concat(Array.prototype.slice.call(arguments, 2)));
    }

    window.f5less = {
        connect: function (customCfg) {
            customCfg = customCfg ? customCfg : {};
            cfg = extend(customCfg, defaultCfg);
            reconnectEnabled = true;
            run();
        },

        disconnect: function() {
            reconnectEnabled = false;
            ws.close();
        },

        reloadCSS: function() {
            log("Reloading all css");
            var els = document.querySelectorAll("link[rel='stylesheet']");
            var reloadQuery = "reload="+new Date().getTime();
            for (var i = 0; i < els.length; i++) {
                log("Reloading",els[i]);
                var oldHref = els[i].href;
                var newHref = oldHref.replace(/reload=\d+/, reloadQuery);
                if (newHref === oldHref)
                    newHref += (newHref.indexOf("?") === -1 ? "?" : "&") + reloadQuery;
                els[i].href = newHref;
            }
        },

        strEndsWith: endsWith,

        handlers: handlers,

        enableTrace: function () { log = traceFn },
        disableTrace: function() { log = dummyFn }
    }
})();