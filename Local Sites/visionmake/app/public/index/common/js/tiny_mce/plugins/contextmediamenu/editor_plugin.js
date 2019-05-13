/*

	ContextMediaMenu Plugin - by Takuto kimura <takuto@may.jp>
	2015/2/21

    メディアファイルを選択したときのコンテキストメニューを表示します

*/

(function() {
    var a = tinymce.dom.Event,
        c = tinymce.each,
        b = tinymce.DOM;
    tinymce.create("tinymce.plugins.ContextMediaMenu", {
        init: function(f) {
            var i = this,
                g, d, j, e;
            i.editor = f;
            d = f.settings.contextmenu_never_use_native;
            i.onContextMenu = new tinymce.util.Dispatcher(this);
            e = function(k) {
                h(f, k)
            };
            g = f.onContextMenu.add(function(k, l) {
                if ((j !== 0 ? j : l.ctrlKey) && !d) {
                    return;
                }
                
                if (l.target.nodeName != "IMG" && l.target.nodeName != "A") {
                    return;
                }
                
                a.cancel(l);
                if (l.target.nodeName == "IMG") {
                    k.selection.select(l.target)
                }
                i._getMenu(k).showMenu(l.clientX || l.pageX, l.clientY || l.pageY);
                a.add(k.getDoc(), "click", e);
                k.nodeChanged()
            });
            f.onRemove.add(function() {
                if (i._menu) {
                    i._menu.removeAll()
                }
            });

            function h(k, l) {
                j = 0;
                if (l && l.button == 2) {
                    j = l.ctrlKey;
                    return
                }
                if (i._menu) {
                    i._menu.removeAll();
                    i._menu.destroy();
                    a.remove(k.getDoc(), "click", e);
                    i._menu = null
                }
            }
            f.onMouseDown.add(h);
            f.onKeyDown.add(h);
            f.onKeyDown.add(function(k, l) {
                if (l.shiftKey && !l.ctrlKey && !l.altKey && l.keyCode === 121) {
                    a.cancel(l);
                    g(k, l)
                }
            })
        },
        getInfo: function() {
            return {
                longname: "ContextMediaMenu",
                author: "Moxiecode Systems AB",
                authorurl: "http://tinymce.moxiecode.com",
                infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/contextmediamenu",
                version: tinymce.majorVersion + "." + tinymce.minorVersion
            }
        },
        _getMenu: function(e) {
            var g = this,
                d = g._menu,
                j = e.selection,
                f = j.isCollapsed(),
                h = j.getNode() || e.getBody(),
                i, k;
            if (d) {
                d.removeAll();
                d.destroy()
            }
            k = b.getPos(e.getContentAreaContainer());
            d = e.controlManager.createDropMenu("contextmenu", {
                offset_x: k.x + e.getParam("contextmenu_offset_x", 0),
                offset_y: k.y + e.getParam("contextmenu_offset_y", 0),
                constrain: 1,
                keyboard_focus: true
            });
            g._menu = d;
            if ((h.nodeName == "A" && !e.dom.getAttrib(h, "name")) || !f) {
                d.add({
                    title: "advanced.link_desc",
                    icon: "link",
                    cmd: e.plugins.advlink ? "mceAdvLink" : "mceLink",
                    ui: true
                });
                d.add({
                    title: "advanced.unlink_desc",
                    icon: "unlink",
                    cmd: "UnLink"
                })
            }
            if (h.nodeName === 'IMG' && h.className.indexOf('mceItemMedia') !== -1) {
                d.addSeparator();
                d.add({title : 'media.edit', icon : 'media', cmd : 'mceMedia'});
            }
            else if(h.nodeName === 'IMG')
            {
                d.addSeparator();
                d.add({
                title: "advanced.image_desc",
                icon: "image",
                cmd: e.plugins.advimage ? "mceAdvImage" : "mceImage",
                ui: true
                });          
            }

            d.addSeparator();
            i = d.addMenu({
                title: "contextmenu.align"
            });
            i.add({
                title: "contextmenu.left",
                icon: "justifyleft",
                cmd: "JustifyLeft"
            });
            i.add({
                title: "contextmenu.center",
                icon: "justifycenter",
                cmd: "JustifyCenter"
            });
            i.add({
                title: "contextmenu.right",
                icon: "justifyright",
                cmd: "JustifyRight"
            });
            i.add({
                title: "contextmenu.full",
                icon: "justifyfull",
                cmd: "JustifyFull"
            });
            g.onContextMenu.dispatch(g, d, h, f);
            return d
        }
    });
    tinymce.PluginManager.add("contextmediamenu", tinymce.plugins.ContextMediaMenu)
})();