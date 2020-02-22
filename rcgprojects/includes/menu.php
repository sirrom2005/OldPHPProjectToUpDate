<TABLE height=236 width=200 align=center border=0>
  <TBODY>
    <TR>
      <TD height=5></TD>
    </TR>
    <TR>
      <TD height="29" align="<?php echo ( $_GET['action'] == 'home' || $_GET['action'] == NULL )? "right" : "left"?>" class=side_bar_border ><A class="<?php echo ( $_GET['action'] == 'home' )? "sel_side_bar_link" : "side_bar_links"?>" href="index.php?action=home">.:: 
        Home</A></TD>
    </TR>
    <TR>
      <TD height="33" align="<?php echo ( $_GET['section'] == 'about' )? "right" : "left"?>" class=side_bar_border ><A class="<?php echo ( $_GET['action'] == 'about' )? "sel_side_bar_link" : "side_bar_links"?>" 
            href="index.php?action=info&section=about">.:: About 
        Us</A></TD>
    </TR>
    <TR>
      <TD height="33" align="<?php echo ( $_GET['action'] == 'services' )? "right" : "left"?>" class=side_bar_border ><A class="<?php echo ( $_GET['action'] == 'services' )? "sel_side_bar_link" : "side_bar_links"?>"
            href="index.php?action=services">.:: 
        Services</A></TD>
    </TR>
    <TR>
      <TD height="32" align="<?php echo ( $_GET['action'] == 'projects' || $_GET['action'] == 'view_project' )? "right" : "left"?>" class=side_bar_border ><A class="<?php echo ( $_GET['action'] == 'projects' )? "sel_side_bar_link" : "side_bar_links"?>"
            href="index.php?action=projects">.:: 
        Projects</A></TD>
    </TR>
    <!--TR>
      <TD class=side_bar_border align="<?php echo ( $_GET['action'] == 'prospects' || $_GET['action'] == 'view_prospects' )? "right" : "left"?>" ><A class="<?php echo ( $_GET['action'] == 'prospects' )? "sel_side_bar_link" : "side_bar_links"?>"
            href="index.php?action=prospects">.:: 
        Prospects</A></TD>
    </TR-->
    <TR>
      <TD height="28" align="<?php echo ( $_GET['action'] == 'contact' )? "right" : "left"?>" class=side_bar_border ><A class="<?php echo ( $_GET['action'] == 'contact' )? "sel_side_bar_link" : "side_bar_links"?>"
            href="index.php?action=contact">.:: Contact Us </A></TD>
    </TR>
    <TR>
      <TD height=33><a class="<?php echo ( $_GET['action'] == 'career' )? "sel_side_bar_link" : "side_bar_links"?>"
            href="index.php?action=info&section=career">.:: Career</a></TD>
    </TR>
    <TR>
      <TD height=23></TD>
    </TR>
  </TBODY>
</TABLE>
