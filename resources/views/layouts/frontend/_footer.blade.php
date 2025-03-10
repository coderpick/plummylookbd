<footer class="footer spad">
    <div class="container">
        <div class="whatsapp">
            <a href="https://wa.me/{{ (isset($contact) && $contact->phone != null)? $contact->phone : '' }}" target="_blank" title="Start Chat ">
                <img src="{{ asset('frontend/img/whatsapp.png') }}" alt="WhatsAppChat">
            </a>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        @if(isset($link) && $link->footer_logo != null)
                            <a href="{{ route('home') }}"><img style="max-width: 190px" src="{{ asset($link->footer_logo) }}" alt="Logo"></a>
                        @else
                            <a href="{{ route('home') }}"><img style="max-width: 190px" src="{{ asset((isset($link) && $link->logo != null)? $link->logo : 'uploads/default_logo.png') }}" alt="Logo"></a>
                        @endif
                    </div>
                    <ul>
                        <li><i class="icofont-location-pin"></i> {{ (isset($contact) && $contact->address != null)? $contact->address : ' ' }}</li>
                        <li><i class="icofont-phone"></i> {{ (isset($contact) && $contact->phone != null)? $contact->phone : ' ' }}</li>
                        <li><i class="icofont-ui-email"></i> {{ (isset($contact) && $contact->email != null)? $contact->email : ' ' }}</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="{{ route('account') }}">My Account</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    </ul>

                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="{{ route('subscribe.us') }}" method="post">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your mail">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        @isset($link->facebook)
                            <a target="_blank" href="{{ $link->facebook }}"><i class="fa fa-facebook"></i></a>
                        @endisset
                        @isset($link->twitter)
                            <a target="_blank" href="{{ $link->twitter }}"><i class="fa fa-twitter"></i></a>
                        @endisset
                        @isset($link->pinterest)
                            <a target="_blank" href="{{ $link->pinterest }}"><i class="fa fa-instagram"></i></a>
                        @endisset
                        @isset($link->linkedin)
                            <a target="_blank" href="{{ $link->linkedin }}"><i class="fa fa-linkedin"></i></a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="">
            <div class="footer__copyright">
                <div class="footer__copyright__text"><p class="text-secondary"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All Right Reserved <a class="text-white" target="_blank" href="http://www.peoplentech.net" >PeopleNTech Software</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
            </div>
        </div>
    </div>
</footer>
