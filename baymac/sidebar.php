        <div class="gadget">
          <h2 class="star"><span>Plans &amp; Coverage</span></h2>
          <div class="clr"></div>
          <ul class="sb_menu">
            
            <li><a href="plans.php"><strong>Baymac Plans </strong></a></li>
            <li><a href="quote.php"><strong>Get A Quote</strong></a></li>
            <li><a href="faq.php"><strong>FAQ</strong></a></li>
            </ul>
        </div>
        <div class="gadget">
          <h2 class="star"><span>More Information</span></h2>
          <div class="clr"></div>
          <ul class="ex_menu">
             
            <li><a href="brochures.php">Brochures</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="partners.php">Partners</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <?php if($objCore->getSessionInfo()->isLoggedIn()) { ?>
            <li><a href="inc/corecontroller.php?logoutaction=1">Logout</a></li>
            <?php } else { ?>
           
            
            <?php } ?>
          </ul>
        </div>
