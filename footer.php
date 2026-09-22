  </main>
  <section class="cta"><div class="wrap cta-inner"><div><p class="eyebrow">West Vancouver mold help</p><h2>Not sure what you are dealing with?</h2><p>Call to explain what you have noticed, or use the request form and include the location of the concern.</p></div><a class="button phone-button" href="tel:+16048003900"><span>Speak with us</span>(604) 800-3900</a></div></section>
  <footer class="site-footer"><div class="wrap footer-grid">
    <div>
      <a class="footer-logo" href="/"><img src="/image/west-vancouver-mold-logo.svg" alt="" width="64" height="64"><strong>West Vancouver Mold</strong></a>
      <p>Focused mold inspection, testing and remediation support for homes, strata properties and businesses across West Vancouver.</p>
      <div class="footer-certificates"><img src="/image/IICRCLogo-certificate.webp" alt="IICRC Certified"><img src="/image/VRCALogo-certificate.webp" alt="VRCA Certificate"><span class="canadian">🇨🇦 Proudly Canadian</span></div>
    </div>
    <div><strong class="footer-heading">Services</strong><div class="footer-links"><?php foreach (service_pages() as $url => $label): ?><a href="/<?= e($url) ?>"><?= e($label) ?></a><?php endforeach; ?></div></div>
    <div><strong class="footer-heading">Areas</strong><div class="footer-links"><?php foreach (service_areas() as $area): ?><a href="/#service-areas"><?= e($area) ?></a><?php endforeach; ?></div></div>
    <div><strong class="footer-heading">Company</strong><div class="footer-links"><a href="/about">About</a><a href="/contact">Contact</a><a href="/sitemap.xml">Sitemap</a><a href="/llms.txt">LLMs.txt</a></div><p><a href="tel:+16048003900"><strong>(604) 800-3900</strong></a></p></div>
  </div><div class="wrap copyright"><span>© <?= date('Y') ?> West Vancouver Mold Services. All rights reserved.</span><span>Design and develop by <a href="https://webpulse.ca/" target="_blank" rel="noopener">webpulse.ca</a></span></div></footer>
  <a class="mobile-call" href="tel:+16048003900"><span>Call now</span><strong>(604) 800-3900</strong></a>
  <?php if ($recaptcha_site_key !== ''): ?><script src="https://www.google.com/recaptcha/api.js?render=<?= rawurlencode($recaptcha_site_key) ?>" async defer></script><?php endif; ?>
  <script>
  var menuToggle=document.querySelector('.menu-toggle');
  var mainNavigation=document.getElementById('main-navigation');
  if(menuToggle&&mainNavigation){menuToggle.addEventListener('click',function(){var open=mainNavigation.classList.toggle('open');menuToggle.setAttribute('aria-expanded',open?'true':'false');menuToggle.textContent=open?'×':'☰';});}
  document.querySelectorAll('.lead-form').forEach(function(form){
    form.addEventListener('submit',function(event){
      var key=document.body.dataset.recaptchaSiteKey;
      if(!key||typeof grecaptcha==='undefined'){return;}
      if(form.dataset.verified==='1'){return;}
      event.preventDefault();
      var button=form.querySelector('button[type="submit"]');
      button.disabled=true;button.textContent='Sending…';
      grecaptcha.ready(function(){grecaptcha.execute(key,{action:'lead_form'}).then(function(token){form.querySelector('[name="recaptcha_token"]').value=token;form.dataset.verified='1';form.submit();}).catch(function(){button.disabled=false;button.textContent='Request an assessment →';});});
    });
  });
  document.addEventListener('click',function(event){document.querySelectorAll('.nav-menu[open]').forEach(function(menu){if(!menu.contains(event.target)){menu.removeAttribute('open');}});});
  </script>
</body>
</html>
