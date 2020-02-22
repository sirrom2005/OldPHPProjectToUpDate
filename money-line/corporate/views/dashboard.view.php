<?php defined('RAXANPDI') || die(); ?>

<div id="dashboard" class="left rtb r12 dashboard_" align="center">
    <h3>Dashboard</h3>
    <div class="applets" style="margin-top:-10px; background-color:#E3E3E3;border-top:1px solid #A00000;">
        <div class="applet" style="overflow:auto; height:423px; padding-top:2px;">
            <a href="app/{code}/" target="iviewer"><img src="app/{code}/views/images/icon.png" width="48" height="48" alt="{name} - {description} " /><br />{name}</a>
        </div>
    </div>
    <br />
</div>
<div id="doc-libs" style="margin-left:160px">
    <div class="main-banner" style="text-align:right">
        <h2 class="bottom">Corporate <span style="color:maroon">Moneyline</span></h2>
    </div>
    <h3 id="doc-lib-title" class="bottom">Documentation</h3>
    <div id="msgbox" class="flashmsg"></div>
    <div id="doc-lib-records" class="tpm" style="width:99%;margin-top:20px">
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="{folder}">
                    <td>
                        <div class="tpm ltm">
                            <div class="column"><img src="views/images/{image}" width="16" alt="{Title}" align="middle" /></div>
                            <div class="column"><a href="download.php?id={id}">{Title}</a><br />{Description} - <a class="quiet" href="download.php?id={id}">Download</a></div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="tpb" style="position:relative;">
                        <div class="right c1 ltb" style="position:relative;padding-left:5px;margin:2px 0 0 5px"><a href="#refresh" class="file-refresh" title="Refresh list"><img src="views/images/arrow_refresh.png" width="16" alt="Refresh list" /></a></div>
                        <div class="right c2">
                            <select id="pagesize" name="pagesize">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="70">70</option>
                            </select>
                        </div>
                        <div id="pager" class="right rtm" style="margin-top:2px;text-align:right;font-style:normal" ><a class="hlf-pad" href="#{VALUE}">{VALUE}</a></div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div id="applet-viewer" class="hide" style="margin-left:160px">
    <h3 id="applet-title" class="bottom"></h3>
    <iframe id="iviewer" name="iviewer" src="" width="98%" frameborder="0"></iframe>
</div>
<script type="text/javascript">
 <!--
    // auto resize iframe
    setInterval("resizeIFrame('iviewer')",800)
    function resizeIFrame(frameId){
        var h,frame, doc, fStyle;
        frame = document.getElementById(frameId);
        doc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document;
        if (!doc || !doc.body) return;
        fStyle = (frame.style) ? frame.style : frame;
        h = doc.body.scrollHeight ;
        if (h < 300) h = 300;
        if (!$.browser.safari) {
            h = h + 30;
        }
        fStyle.height = h + (frame.style ? 'px' : '');
    }
 -->
</script>
