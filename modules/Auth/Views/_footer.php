</div>
<footer id="is-footer-copyright-group">
  <div id="footer" class="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="copyright">
            <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank"> Privacy
              Policy |</a>
            <a href="<?php echo base_url('disclaimer'); ?>" target="_blank">Disclaimer |</a>
            <a href="http://holoog.com" target="_blank">Website By Holoog</a>
          </div>
        </div>
        <div class="col-md-8">
          <div class="store-app clearfix">

          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="menu-footer">
            <p class="heading-footer" style="color: white;">
              Follow Us
            </p>
            <div class="social-icon">
              <?php if ($facebook) { ?>
              <a href="<?php echo $facebook; ?>" target="_blank" class=" fa fa-facebook"></a>
              <?php } ?>
              <?php if ($instagram) { ?>
              <a href="<?php echo $instagram; ?>" target="_blank" class=" fa fa-instagram"></a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/shop.js"></script>
<!-- Return to Top -->
<div class="totop">
  <i class="fa fa-chevron-up"></i>
</div>
<!--End of Tawk.to Script-->
<script type="text/javascript">
$('.totop').tottTop({
  scrollTop: 100
});

$(document).on('ready', function() {
  $("#element").introLoader({
    animation: {
      name: 'gifLoader',
      options: {
        ease: "easeInOutCirc",
        style: 'light',
        delayBefore: 500,
        delayAfter: 0,
        exitTime: 300
      }
    }
  });
});
</script>
</body>

</html>