 <footer class="footer">
  <div class="container footer__container">
   <div class="footer__wrap">
    <div class="footer__brand">
     <a href="<?= home_url(); ?>" class="footer__logo">
      <img class="footer__logo-img" src="<?php echo get_theme_mod('logo_footer', get_template_directory_uri() . '/assets/img/logo-footer.svg'); ?>" alt="Логотип Гудвин">
     </a>
     <p class="footer__description">ПОСТАВКА ПРОМЫШЛЕННОГО ОБОРУДОВАНИЯ</p>
     <div class="footer__contact">
      <a class="footer__phone link" href="tel:+78124480810">+7(812) 448-08-10</a>
      <button class="btn footer__callback footer__btn">Перезвоните мне</button>
     </div>
    </div>
    <div class="footer__menu">
     <ul class="footer__list list-reset">
      <li class="footer__item"><a class="footer__link link"
        href="/stanki-dla-br-proizvodstva-rvd">ОБОРУДОВАНИЕ ДЛЯ ПРОИЗВОДСТВА РВД</a></li>
      <li class="footer__item"><a class="footer__link link" href="/rukava-vysokogo-davleniya">РУКАВА И
        ШЛАНГИ ВЫСОКОГО ДАВЛЕНИЯ</a></li>
      <li class="footer__item"><a class="footer__link link" href="/fitingi-i-mufty-2">ФИТИНГИ И МУФТЫ</a>
      </li>
      <li class="footer__item"><a class="footer__link link" href="/silovaa-br-elektronika">СИЛОВАЯ
        ЭЛЕКТРОНИКА</a></li>
      <li class="footer__item"><a class="footer__link link" href="/gates">РЕМНИ</a></li>
     </ul>
     <ul class="footer__list footer__right list-reset">
      <li class="footer__item"><a class="footer__link link" href="/o-kompanii">О КОМПАНИИ</a></li>
      <li class="footer__item"><a class="footer__link link" href="/kontakty">КОНТАКТЫ</a></li>
      <li class="footer__item"><a class="footer__link link" href="/usloviya-postavki">УСЛОВИЯ ПОСТАВКИ</a>
      </li>
      <li class="footer__item"><a class="footer__link link" href="/contact">ЗАДАТЬ ВОПРОС</a></li>
     </ul>
    </div>
   </div>
   <p class="footer__copyright">© Гудвин Групп 2025</p>
  </div>
 </footer>
 <?php wp_footer(); ?>
 </body>

 </html>
