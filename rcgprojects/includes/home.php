<?php 
	$featuePro = $siteObj->getFeaturedProject();
?>
<style type="text/css">
<!--
.style6 {	font-size: 14px;
	font-family: Verdana;
	font-weight: bold;
}
.style7 {color: #E6E6E6}
-->
</style>

<title>Reliance Consulting Group Limited .:: Construction .:: Jamaica .:: Project Management .:: Development .:: Hotel</title><TABLE height=403 cellSpacing=0 cellPadding=0 width=400 border=0>
  <TBODY>
    <TR>
      <TD height=7></TD>
  </tr>
    <TR>
      <TD height=25><span class="style6"><span class="blue_text">Company   </span> <span class="green_text">Overview</span></span></TD>
    </TR>
    <TR>
      <TD class="text" vAlign=top height=90>
       Reliance Consulting Group Ltd. (RCG) is a next-generation consulting firm that   provides project management and other <a href="index.php?action=services">professional services</a>. Founded in 2004,   our firm serves clients in the hospitality, commercial, residential and media industries. Our<a href="index.php?action=info&amp;section=team"> directors</a> have over 35 years of collective experience in the   construction and development industry...
		<!--Incorporated in 1922, RCG Construction Company builds 
        roads, tunnels, bridges, airports and other infrastructure-related 
        projects used by millions of people. In addition, RCG produces sand, 
        gravel, ready-mix and asphalt concrete and other construction 
        materials. Unusual among large contractors, RCG handles both large 
        and mall jobs through its two operating divisions, Heavy 
        Construction Division and Branch Division. ...--> 
		<A style="FONT-SIZE: 9px; COLOR:blue" href="index.php?action=info&section=about">read more</A>. </TD>
    </TR>
    <TR>
      <TD height=17 valign="middle"><span class="style6"><span class="blue_text">The </span> <span class="green_text">Team</span></span></TD>
    </TR>
    <TR>
      <TD class="text" vAlign=top height=95>
	  The strength and growth of Reliance Consulting Group Limited lies in the quality   and depth of our talented and experienced team. Our<a href="http://rcgprojects.com/index.php?action=info&amp;section=team"> team</a> consists of hardworking   individuals who are experienced in all aspects of the <a href="index.php?action=services">construction</a> and   development <a href="index.php?action=projects">industry</a>. The know-how of...
	  <!--Our Team which consists of 12 hard working individuals who 
        all knows and respects the importance of team work in order to get 
        the job done everytime. The experience of each individual allows RCG 
        to deliver quality, on time work time and time again.... --><A 
            style="FONT-SIZE: 9px; COLOR: blue" 
            href="index.php?action=info&section=team">read more.</A> </TD>
    </TR>
    <TR>
      <TD width=395 height="145"><TABLE height=134 cellSpacing=0 cellPadding=0 width=398 border=0 id="f1">
        <TBODY>
          <TR>
            <TD width=30 height="134" >&nbsp;</TD>
            <TD>
			<TABLE  cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
                <TR>
                  <TD height="100"><A 
                        href="index.php?action=view_project&id=<?=$featuePro[0]['id'] ?>">
						<IMG height=96 src="images/projects/<?=$featuePro[0]['image']?>" width=156 class="imgborder"></A></TD>
                  <TD>
				  <A href="index.php?action=view_project&id=<?=$featuePro[1]['id'] ?>">
				  <IMG height=96 src="images/projects/<?=$featuePro[1]['image']?>" width=156 class="imgborder"></A></TD>
                </TR>
                <TR>
                  <TD height="18" style="FONT-SIZE:8pt"><?=$featuePro[0]['title']?></TD>
				  <TD style="FONT-SIZE:8pt"><?=$featuePro[1]['title']?></TD>
                </TR>
              </TBODY>
            </TABLE></TD>
          </TR>
        </TBODY>
      </TABLE></TD>
    </TR>
  </TBODY>
</TABLE>
